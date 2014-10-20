<?
/**
 * TITLE: Страница решений
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
#Helper::ta($projects);

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
                        <div class="grid_9 alpha">
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
                    <div class="solution type-{{ $solution->slug }}">
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
                                    {{ Helper::preview($solution->describes_purpose_decision, 10) }}
                                </div>
                            </div>
                        </div>
                        <div class="solution-right">
                            <h2>Компоненты решения</h2>
                            <div class="sol-comps">
                                <div class="comps-in">
                                    @if (@count($array[$solution->id]))
                                    <ul class="comps-ul">
                                        @foreach ($array[$solution->id] as $project)
                                        <li>
                                            <div class="title">
                                                <a href="#">{{ $project->name }}</a>
                                            </div>

                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <ul class="sol-dots">
                                <li class="active"></li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                @endforeach
                @endif

            </div>
        </section>

@stop


@section('footer')
    @parent
@stop


@section('scripts')
@stop
