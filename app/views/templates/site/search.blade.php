<?
/**
 * TITLE: Страница результатов поиска
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

        <?
        $solutions = array();
        ?>
        <section class="title-block title-main">
            <div class="container_12">
                <section class="title-content min-pad">
                    <div class="grid_8">
                        <h1>
                            Результаты поиска
                        </h1>
                        <div class="search-word">Вы искали «{{ $q }}»</div>
                        <div class="search-results">Результатов: {{ $results_count  }}</div>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="search-parent">
            <div class="container_12 section-grid"><!--
                @if (@count($results['projects']['matches']))
                <?
                #$solutions_ids = array();
                $images_ids = array();
                foreach ($results['projects']['matches'] as $key => $match_data) {
                    $project = $dicvals[$key];
                    $images_ids[] = $project->mainpage_image;
                }
                $solutions = Dic::valuesBySlug('solutions');
                $solutions = DicVal::extracts($solutions, 1);
                #Helper::tad($solutions);
                $images = Photo::whereIn('id', $images_ids)->get();
                #Helper::tad($images);
                $temp = new Collection;
                foreach ($images as $image)
                    $temp[$image->id] = $image;
                $images = $temp;
                ?>
             --><section class="projects search-section">
                    <div class="grid_4">
                        <h2 class="non-top-margin">Проекты</h2>
                    </div>
                    <div class="clearfix"></div>
                    @foreach($results['projects']['matches'] as $key => $match_data)
                    <?
                    $project = $dicvals[$key];
                    #Helper::tad($project);
                    #$solution = DicVal::find($project->solution_id);
                    $solution = @$solutions[$project->solution_id];
                    $image = @$images[$project->mainpage_image] ?: new Photo;
                    ?>
                    <div class="grid_4">
                        <div class="solution-block type-{{ $solution->slug }} js-hover">
                            <div class="background" style="background-image: url('{{ $image->full() }}')"></div>
                            <a href="{{ URL::route('project-one', $project->slug) }}" class="project-link"></a>
                            <div class="hover-circle js-circle"></div>
                            <div class="prj-content">
                                <div class="title"><i class="us-icon icon-{{ $solution->slug }}"></i> {{ $solution->name }}</div>
                                <div class="desc">
                                    {{ $project->name }}
                                </div>
                            </div>
                        </div>
                        <div class="search-desc">
                            {{ @$excerpts['projects'][$project->id] }}
                        </div>
                    </div>
                    @endforeach
                </section><!--
                @endif

                @if (@count($results['solutions']['matches']))
             --><section class="search-solutions search-section">
                    <div class="grid_4">
                        <h2 class="non-top-margin">Решения</h2>
                    </div>
                    <div class="clearfix"></div>
                    @foreach($results['solutions']['matches'] as $key => $match_data)
                    <?
                    $solution = $dicvals[$key];
                    ?>
                    <div class="grid_4">
                        <div class="search-solution-item">
                            <a href="{{ URL::route('solution-one', $solution->slug) }}" class="type-{{ $solution->slug }} solution-head">
                                <i class="sol-icon"></i>
                                <span>{{ $solution->name }}</span>
                            </a>
                            <div class="search-desc">
                                {{ @$excerpts['solutions'][$solution->id] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </section><!--
                @endif


                @if (@count($results['news']['matches']))
             --><section class="search-news search-section">
                    <div class="grid_4">
                        <h2 class="non-top-margin">Новости</h2>
                    </div>
                    <div class="clearfix"></div>
                    @foreach($results['news']['matches'] as $key => $match_data)
                    <?
                    $new = $dicvals[$key];
                    ?>
                    <div class="grid_4">
                        <div class="news-item">
                            <div class="news-preview">
                                <span class="news-date">
                                    <span class="day">{{ $new->created_at->format('d') }}</span> / {{ $new->created_at->format('m') }} / {{ $new->created_at->format('Y') }}
                                </span>
                                <a href="{{ URL::route('news_full', $new->slug) }}" class="title">
                                    {{ $new->name }}
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="search-desc">
                            {{ @$excerpts['news'][$new->id] }}
                        </div>
                    </div>
                    @endforeach
                </section><!--
                @endif
             -->
                <div class="clearfix"></div>
            </div>

            @if (@count($results['pages']['matches']))
            <div class="search-links">
                <div class="container_12">
                    @foreach($results['pages']['matches'] as $key => $match_data)
                    <?
                    $page = $pages[$key];
                    #Helper::tad($page);
                    ?>
                    <div class="grid_4">
                        <h2 class="title-link"><a href="{{ URL::route('page', $page->slug) }}">{{ $page->name }}</a></h2>
                        <div class="search-desc">
                            {{ @$excerpts['pages'][$page->id] }}
                        </div>
                    </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </div>
            @endif

            @if (!@count($results['pages']['matches']) && !@count($results['solutions']['matches']) && !@count($results['news']['matches']) && !@count($results['projects']['matches']))
            <div class="container_12">
                <div class="grid_12">
                    <div class="no-found">
                        <div class="no-found-text">По запросу «{{ @$_GET['q'] }}» не найдено ни одного результата. Попробуйте использовать другие ключевые слова или введите другой запрос.</div>
                        <form class="no-found-input" method="GET" action="{{ URL::route('search') }}">
                            <input name="q" type="text" placeholder="Поиск">
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            @endif


        </section>



@stop


@section('footer')
    @parent
@stop


@section('scripts')
@stop
