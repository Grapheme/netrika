<?
/**
 * TITLE: Страница одного проекта
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::layout())


@section('style')
@stop


@section('content')

        <div class="type-{{ $solution->slug }}">

            <section class="title-block title-main">
                <div class="container_12">
                    <section class="title-content max-pad">
                        <div class="grid_8 grid_m12">
                            <h1>
                                {{ $project->name }}
                            </h1>
                            <div class="head-info">
                                <a href="{{ URL::route('page', 'projects') }}#{{ $solution->slug }}">
                                    <span class="head-type">
                                        <i class="us-icon icon-{{ $solution->slug }}"></i> <span>{{ $solution->name }}</span>
                                    </span>
                                </a>
                                @if ($project->link_to_project)
                                <?
                                $domain = parse_url($project->link_to_project);
                                ?>
                                    @if (@$domain['host'])
                                    <a href="{{ $project->link_to_project }}">{{ $domain['host'] }}</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="grid_3 grid_m12 prefix_1 head-nav">
                            <div class="prj-arrows">
                                @if (isset($prev_project) && is_object($prev_project) && $prev_project->id)
                                <a href="{{ URL::route('project-one', $prev_project->slug) }}" class="desc-icon prev"></a>
                                @endif
                                @if (isset($next_project) && is_object($next_project) && $next_project->id)
                                <a href="{{ URL::route('project-one', $next_project->slug) }}" class="desc-icon next"></a>
                                @endif
                            </div>

                            <a href="{{ URL::route('page', 'projects') }}#{{ $solution->slug }}"><i class="lit-icon icon-projects"></i> Все проекты</a>
                        </div>
                        <div class="clearfix"></div>
                    </section>
                    <div class="clearfix"></div>
                </div>
            </section>

            @if ($project->description_objectives || $project->description_tasks)
            <section class="us-section">
                <div class="container_12">
                    <div class="grid_12">
                        <h2>Цели и задачи</h2>
                        <div class="us-desc">
                            {{ $project->description_objectives }}
                        </div>
                    </div>

                    <?
                    $lines = explode("\n", $project->description_tasks);
                    $i = 0;
                    ?>
                    @if (count($lines))
                    <ul class="aims aims-light">
                        @foreach ($lines as $line)
                            <?
                            $line = trim($line);
                            if ($line == '')
                                continue;
                            @++$i;
                            ?>
                            <li>
                                <div class="aim" data-number="{{ $i }}">
                                    <div class="text">{{ $line }}</div>
                                </div>
                        @endforeach
                    </ul>
                    @endif

                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if ($project->description_results || $project->description_results_num)
            <section class="dark-section">
                <div class="container_12">
                    <div class="grid_12">
                        <h2>Результаты</h2>
                        <div class="us-desc">
                            {{ $project->description_results }}
                        </div>
                    </div>

                    <?
                    $lines = explode("\n", $project->description_results_num);
                    $i = 0;
                    ?>
                    @if (count($lines))
                    <ul class="aims aims-dark">
                        @foreach ($lines as $line)
                            <?
                            $line = trim($line);
                            if ($line == '')
                                continue;
                            @++$i;
                            ?>
                            <li>
                                <div class="aim" data-number="{{ $i }}">
                                    <div class="text">{{ $line }}</div>
                                </div>
                        @endforeach
                    </ul>
                    @endif

                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if ($project->description_advantages || $project->description_features)
            <section class="us-section">
                <div class="container_12">

                    <?
                    $lines = explode("\n", $project->description_advantages);
                    $i = 0;
                    ?>
                    @if (count($lines))
                    <div class="grid_6 grid_m12">
                        <h2>Преимущества</h2>
                        <ul class="bul-ul">
                            @foreach ($lines as $line)
                                <?
                                $line = trim($line);
                                if ($line == '')
                                    continue;
                                @++$i;
                                ?>
                                <li>{{ $line }}
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    @if ($project->description_features)
                    <div class="grid_6 grid_m12">
                        <h2 class="mobile-top-mar">Особенности</h2>

                        {{ $project->description_features }}
                    </div>
                    @endif

                    <div class="clearfix"></div>
                </div>
            </section>
            @endif


            <section class="dark-section">
                <div class="container_12">
                    <div class="grid_12">
                        <h2>Процесс</h2>
                    </div>
                    <div class="progress-slider">
                        <div class="ps-block ps-info">

                            {{ $project->description_process }}

                        </div><!--
                        @if (count($photos))
                        @foreach ($photos as $photo)
                        --><div class="ps-block">
                            <a class="ps-big fancybox" rel="gallery1" href="{{ $photo }}" style="background-image: url({{ $photo }})"></a>
                        </div><!--
                        @endforeach
                        @endif
                        -->

                        <!--<div class="ps-block">
                            <div class="ps-small">
                                <div class="ps-smallin" style="background-image: url(http://www.outputmagazine.com/_photos/620-2022-03-28-GC-Futurefashion.jpg)"></div>
                                <div class="ps-smallin" style="background-image: url(http://www.outputmagazine.com/_photos/620-2022-03-28-GC-Futurefashion.jpg)"></div>
                            </div>
                            <div class="ps-small slider-nav">
                                <a href="#" class="desc-icon prev"></a>
                                <a href="#" class="desc-icon next"></a>
                            </div>
                        -->
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>


            @if (isset($documents) && count($documents))
            <section class="us-section">
                <div class="container_12">
                    <div class="grid_12">
                        <h2>Нормативные документы</h2>
                        <div class="us-desc">
                            Решение разрабатывалось на основании и с учетом следующих федеральных и региональных нормативных документов:
                        </div>
                        <ul class="icons-ul columns-2">

                            @foreach ($documents as $document)
                                @if ($document->url_document)
                                <li class="li-file">
                                    <a href="{{ $document->url_document }}">
                                        {{ $document->description_document ?: $document->name }}
                                    </a>
                                @else
                                <li class="li-file-big">
                                    {{ $document->description_document ?: $document->name }}
                                @endif
                            @endforeach


                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>
            @endif


            @if (isset($projects) && count($projects))
            <section class="projects">
                <div class="container_12">

                    @foreach ($projects as $project)
                    <?
                    $image = @$images[$project->mainpage_image] ?: new Photo;
                    ?>
                    <div class="grid_4 grid_t6 grid_m12 solution-block js-hover">
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
                    @endforeach

                    <div class="grid_4 grid_t6 grid_m12 type-all">
                        <div class="solution-block type-all">
                            <a href="{{ URL::route('page', 'projects') }}#{{ $solution->slug }}" class="project-link">
                                <span>
                                    <i class="lit-icon icon-projects"></i> Все проекты
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

        </div>

@stop


@section('footer')
    @parent
@stop


@section('scripts')
<script>
    $(document).ready(function() {
        $(".fancybox").fancybox();
        $('.aims').setHeightOfMax('.aim');
    });
    var photos = {{ json_encode($photos) }};
</script>
@stop
