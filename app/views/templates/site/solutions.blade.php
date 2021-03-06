<?
/**
 * TITLE: Страница решений
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())

<?
$solutions = Dic::valuesBySlug('solutions');
$solutions = DicVal::extracts($solutions, true);
#Helper::ta($solutions);

/**
 * Компоненты решений
 */
$solution_components = Dic::valuesBySlug('solution_components', function($query){
    #$query->orderBy('order', 'asc');
    $query->orderBy('updated_at', 'desc');
    $query->orderBy('created_at', 'desc');
});
$solution_components = DicVal::extracts($solution_components, true);
$images_ids = array();
$images_svg = array();
foreach ($solution_components as $solution_component) {
    $images_ids[] = $solution_component->image_id;
}
if (count($images_ids)) {
    $images_svg = Upload::whereIn('id', $images_ids)->get();
    $images_svg = Dic::modifyKeys($images_svg, 'id');
    $images_svg = Dic::makeLists($images_svg, false, 'path', 'id');
}
#Helper::tad($solution_components);
#Helper::tad($images_svg);

$array = array();
foreach ($solution_components as $solution_component) {
    $array[$solution_component->solution_id][$solution_component->id] = $solution_component;
}

$images_ids = Dic::makeLists($solutions, false, 'mainpage_image');
#Helper::d($images_ids);
if (isset($images_ids) && is_array($images_ids) && count($images_ids)) {
    $images = Photo::whereIn('id', $images_ids)->get();
    if (count($images))
        $images = DicVal::extracts($images, true);
} else {
    $images = array();
}
#Helper::tad($images);

?>

@section('style')
@stop


@section('content')

        <section class="title-block title-main">
            <div class="container_12">
                <div class="grid_12">
                    <section class="title-content min-pad">
                        <div class="grid_9 grid_t12 grid_m12 alpha">
                            <h1>
                                @if (isset($page->seo) && @is_object($page->seo) && $page->seo->h1 != '')
                                    {{ $page->seo->h1 }}
                                @else
                                    {{ $page->name }}
                                @endif
                            </h1>
                        </div>
                        <div class="clearfix"></div>
                    </section>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="solutions">
            <div class="container_12">

                @if (count($solutions))
                @foreach ($solutions as $solution)
                <?
                $image = @$images[$solution->mainpage_image] ?: new Photo;
                ?>
                    <div class="solution type-{{ $solution->slug }} grid_m12">
                        <div class="solution-left solution-block" style="background-image: url({{ $image->full() }});">
                            <div class="hover-circle"></div>
                            <div class="solution-hover">
                                <div class="hover-content">
                                    <a href="{{ URL::route('solution-one', $solution->slug) }}" class="title-btn">Описание решения</a>
                                    <br>
                                    <a href="{{ URL::route('page', 'projects') }}#{{ $solution->slug }}"><i class="lit-icon icon-projects"></i> Все проекты</a>
                                </div>
                            </div>
                            <div class="prj-content">
                                <div class="title"><i class="us-icon icon-{{ $solution->slug }}"></i> {{ $solution->name }}</div>
                                <div class="text">
                                    {{ Helper::preview($solution->describes_purpose_decision, 25) }}
                                </div>
                            </div>
                        </div>
                        <div class="solution-right js-netrika-parent">
                            <h2>Компоненты решения</h2>
                            <div class="sol-comps js-netrika-slider">
                                <div class="comps-in js-slider-window">
                                    @if (@count($array[$solution->id]))
                                        <?
                                        $limit = 4;
                                        $list = array_chunk($array[$solution->id], $limit, 1);
                                        ?>
                                        @foreach ($list as $lst)
                                        <ul class="comps-ul js-slide">
                                        @foreach ($lst as $project)
                                            <li>
                                                <div class="title">
                                                    @if (isset($images_svg[$project->image_id]))
                                                    <div class="comp-svg-icon" style="background-image: url({{ @$images_svg[$project->image_id] }});" /></div>
                                                    @endif
                                                    <a href="{{ URL::route('solution-one', $solution->slug) }}#solutions">{{ $project->name }}</a>
                                                </div>
                                        @endforeach
                                        </ul>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <ul class="sol-dots js-netrika-dots">
                            </ul>
                        </div>
                    </div>
                @endforeach
                @endif
                <div class="clearfix"></div>
            </div>
        </section>

@stop


@section('footer')
    @parent
@stop


@section('scripts')
    <script>
        $('.solution').solutions_touch();
        $('.js-netrika-parent').netrika_slider();
    </script>
@stop
