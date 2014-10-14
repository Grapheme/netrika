<?
/**
 * TITLE: Страница проектов
 */
?>
@extends(Helper::layout())

<?
$solutions = Dic::valuesBySlug('solutions');
$solutions = DicVal::extracts($solutions, true);
#Helper::ta($solutions);

$projects = Dic::valuesBySlug('projects', function($query){
    #$query->orderBy('order', 'asc');
    $query->orderBy('updated_at', 'desc');
    $query->orderBy('created_at', 'desc');
});
$projects = DicVal::extracts($projects, true);
#Helper::ta($projects);

$array = array();
foreach ($projects as $project) {
    $array[$project->solution_id][$project->id] = $project;
}

$images_ids = Dic::makeLists($projects, false, 'mainpage_image');
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
                <section class="title-content min-pad">
                    <div class="grid_9">
                        <h1>
                            @if (isset($page->seo) && @is_object($page->seo) && $page->seo->h1 != '')
                                {{ $page->seo->h1 }}
                            @else
                                {{ $page->name }}
                            @endif
                        </h1>
                    </div>
                    <div class="clearfix"></div>
                    <ul class="prj-ul js-filters">

                        <li class="grid_3">
                            <a href="#" data-filter="all"><i class="us-icon icon-prjall"></i>
                                <span class="text">Все</span>
                                <span class="amount js-amount"></span>
                            </a>

                        @if (count($solutions))
                        @foreach ($solutions as $solution)
                        <?
                        if (!@$array[$solution->id])
                            continue;
                        ?>
                            <li class="grid_3">
                                <a href="#" data-filter="{{ $solution->slug }}" class="type-{{ $solution->slug }}"><i class="us-icon icon-{{ $solution->slug }}"></i>
                                    <span class="text">{{ $solution->name }}</span>
                                    <span class="amount js-amount"></span>
                                </a>
                        @endforeach
                        @endif

                    </ul>
                <div class="clearfix"></div>
                </section>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="projects projects-white js-filter-blocks">
            <div class="container_12">
                @if (count($projects))
                @foreach ($projects as $project)
                <?
                $image = @$images[$project->mainpage_image] ?: new Photo;
                ?>
                    <div class="grid_4 solution-block type-{{ $solutions[$project->solution_id]->slug }} js-hover" data-filter="{{ $solutions[$project->solution_id]->slug }}">
                        <div class="background" style="background-image: url({{ $image->full() }})"></div>
                        <a href="{{ URL::route('project-one', $project->slug) }}" class="project-link"></a>
                        <div class="hover-circle js-circle"></div>
                        <div class="prj-content">
                            <div class="title"><i class="us-icon icon-{{ $solutions[$project->solution_id]->slug }}"></i> {{ $solutions[$project->solution_id]->name }}</div>
                            <div class="desc">
                                {{ $project->name }}
                            </div>
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
            $('.js-filters').simple_filter('.js-filter-blocks', 'all');
        </script>
@stop
