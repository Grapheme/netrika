<?
/**
 * TITLE: Страница одного решения
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@extends(Helper::layout())


<?
$solution4form = $solution;
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
                                {{ $solution->name }}
                            </h1>

                            @if ($solution->availability_demonstrate)
                            <a href="#" class="title-btn js-popup-open" data-popup="order-present">Заказать демонстрацию</a>
                            @endif

                        </div>
                        <div class="clearfix"></div>
                    </section>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

        <div class="type-{{ $solution->slug }}">
            <section class="main-stat">
                <div class="container_12">
                    <div class="grid_4 grid_t12 grid_m12 stat-desc">
                        <p>
                            {{ $solution->describes_purpose_decision }}
                        </p>
                    </div>
                    <div class="grid_4 grid_t6 grid_m12 canvas-cirs">
                        <canvas id="canvas-cir-0" width="360" height="360"></canvas>
                        <canvas id="canvas-cir-1" width="360" height="360"></canvas>
                        <canvas id="canvas-cir-2" width="360" height="360"></canvas>
                        <i class="color-0"></i>
                        <i class="color-1"></i>
                        <i class="color-2"></i>
                    </div>
                    <div class="grid_4 grid_t6 grid_m12 stat-right-block">
                        <ul class="stat-ul">
                        {{-- $solution->performance_indicators --}}
                        <?
                        $indicators = explode("\n", $solution->performance_indicators);
                        ?>
                        @if (count($indicators))
                            <?
                            $i = 0;
                            ?>
                            @foreach ($indicators as $indicator)
                                <?
                                $indicator = trim($indicator);
                                if ($indicator == '')
                                    continue;
                                ++$i;
                                if ($i > 3)
                                    break;
                                $data = explode(' ', $indicator, 2);
                                ?>
                                <li>
                                    <div class="title normal js-perc">
                                        {{ @trim($data[0]) }}
                                    </div>
                                    <p>
                                        {{ @trim($data[1]) }}
                                    </p>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>

            <?
            $target_audience = explode("\n", $solution->description_target_audience);
            ?>
            @if (count($target_audience) > 0)
            <section class="audience">
                <div class="container_12 js-netrika-parent">
                    <div class="grid_9 grid_m12">
                        <h2>Целевая аудитория</h2>
                    </div>
                    <div class="grid_3 grid_m12 js-netrika-controls">
                        <a href="#" class="desc-icon prev js-netrika-control disable" data-direction="<"></a>
                        <a href="#" class="desc-icon next js-netrika-control" data-direction=">"></a>
                    </div>
                    <div class="clearfix"></div>

                    @if (0)
                    <div class="aud-container js-netrika-slider">
                        <div class="js-slider-window">

                            <div class="js-slide aud-slide">
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>Организаторы здравоохранения в регионе</span>
                                    </div>
                                </div>
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>Организаторы здравоохранения в регионе</span>
                                    </div>
                                </div>
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>Организаторы здравоохранения в регионе</span>
                                    </div>
                                </div>
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>Организаторы здравоохранения в регионе</span>
                                    </div>
                                </div>
                            </div>

                            <div class="js-slide aud-slide">
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>Организаторы здравоохранения в регионе</span>
                                    </div>
                                </div>
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>Организаторы здравоохранения в регионе</span>
                                    </div>
                                </div>
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>Организаторы здравоохранения в регионе</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endif

                    <div class="aud-container js-netrika-slider mobile-top-mar">
                        <div class="js-slider-window">
                            <?
                            $limit = count($target_audience) > 8 ? 8 : 4;
                            $count = count($target_audience);
                            $p = 0;
                            #echo count($target_audience);
                            ?>
                            @foreach ($target_audience as $target)
                                <?
                                $target = trim($target);
                                if ($target == '')
                                    continue;
                                ?>
                                @if (!$p++ || $p % ($limit+1) == 0)
                            <div class="js-slide aud-slide">
                                @endif
                                <div class="aud-block">
                                    <div class="aud-text">
                                        <span>{{ $target}}</span>
                                    </div>
                                </div>
                                @if ($p % ($limit+1) == $limit || $p >= $count)
                            </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            @endif

            @if ($solution->identify_features_solution || $solution->image_schemes_work)
            <section class="us-section">
                <div class="container_12">
                    <div class="grid_12">

                        @if ($solution->identify_features_solution)
                        <h2>Возможности решения</h2>
                        <div class="columns-2">

                            {{ $solution->identify_features_solution }}

                        </div>
                        @endif

                        <?
                        $scheme = $solution->image_schemes_work;
                        $scheme = Photo::firstOrNew(array('id' => $scheme));
                        ?>

                        @if ($scheme->name != '')
                        <h2 class="mobile-top-lmar">Схема работы</h2>

                        <div class="scheme-image">
                            <img src="{{ $scheme->full() }}" alt="">
                        </div>
                        @endif

                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if ($solution->assignment_solution || $solution->description_advantages_solution || $solution->application_solution)
            <section class="gray-section mobile-hidden">
                <div class="container_12">
                    <div class="grid_12 js-st-parent">
                        <ul class="sol-tabs">

                            @if ($solution->assignment_solution)
                            <li class="js-simple-link">Назначение решения
                            @endif

                            @if ($solution->description_advantages_solution)
                            <li class="js-simple-link">Преимущества решения
                            @endif

                            @if ($solution->application_solution)
                            <li class="js-simple-link">Применение решения
                            @endif
                        </ul>
                        <div>

                            @if ($solution->assignment_solution)
                            <ul class="bul-ul columns-2 js-simple-tab">
                                <?
                                $lines = explode("\n", $solution->assignment_solution);
                                ?>
                                @foreach ($lines as $line)
                                <?
                                if (!trim($line))
                                    continue;
                                ?>
                                <li>
                                    {{ $line }}
                                @endforeach
                            </ul>
                            @endif

                            @if ($solution->description_advantages_solution)
                            <ul class="bul-ul columns-2 js-simple-tab">
                                <?
                                $lines = explode("\n", $solution->description_advantages_solution);
                                ?>
                                @foreach ($lines as $line)
                                <?
                                if (!trim($line))
                                    continue;
                                ?>
                                <li>
                                    {{ $line }}
                                @endforeach
                            </ul>
                            @endif

                            @if ($solution->application_solution)
                            <ul class="bul-ul columns-2 js-simple-tab">
                                <?
                                $lines = explode("\n", $solution->application_solution);
                                ?>
                                @foreach ($lines as $line)
                                <?
                                if (!trim($line))
                                    continue;
                                ?>
                                <li>
                                    {{ $line }}
                                @endforeach
                            </ul>
                            @endif

                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if ($solution->assignment_solution || $solution->description_advantages_solution || $solution->application_solution)
            <section class="gray-section only-mobile">
                <div class="container_12">
                    <div class="grid_12">

                            @if ($solution->assignment_solution)
                            <h2>Назначение решения</h2>
                            @endif

                            @if ($solution->assignment_solution)
                            <ul class="bul-ul columns-2">
                                <?
                                $lines = explode("\n", $solution->assignment_solution);
                                ?>
                                @foreach ($lines as $line)
                                <?
                                if (!trim($line))
                                    continue;
                                ?>
                                <li>
                                    {{ $line }}
                                @endforeach
                            </ul>
                            @endif

                            @if ($solution->description_advantages_solution)
                            <h2>Преимущества решения</h2>
                            @endif

                            @if ($solution->description_advantages_solution)
                            <ul class="bul-ul columns-2">
                                <?
                                $lines = explode("\n", $solution->description_advantages_solution);
                                ?>
                                @foreach ($lines as $line)
                                <?
                                if (!trim($line))
                                    continue;
                                ?>
                                <li>
                                    {{ $line }}
                                @endforeach
                            </ul>
                            @endif

                            @if ($solution->application_solution)
                            <h2>Применение решения</h2>
                            @endif

                            @if ($solution->application_solution)
                            <ul class="bul-ul columns-2">
                                <?
                                $lines = explode("\n", $solution->application_solution);
                                ?>
                                @foreach ($lines as $line)
                                <?
                                if (!trim($line))
                                    continue;
                                ?>
                                <li>
                                    {{ $line }}
                                @endforeach
                            </ul>
                            @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if (isset($components) && count($components))
            <a name="solutions"></a>
            <section class="us-section type-{{ $solution->slug }}">
                <div class="container_12">
                    <div class="grid_12">
                        <h2>Компоненты решения</h2>
                        <ul class="comps-ul columns-2">

                        @foreach ($components as $component)
                            <li><div class="title"><div class="comp-svg-icon" style="background-image: url({{ @$images_svg[$component->image_id] }});"></div><span>{{ $component->name }}</span></div>
                                <p class="text">
                                    {{ $component->description }}
                                </p>
                        @endforeach

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if ($solution->description_integration)
            <section class="gray-section over-hidden">
                <div class="container_12 netrika-block">
                    <div class="grid_12">
                        <h2>Интеграции</h2>

                        {{ $solution->description_integration }}

                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if ($solution->additional_features)
            <section class="us-section">
                <div class="container_12">
                    <div class="grid_12">
                        <h2>Дополнительные возможности</h2>


                        <ul class="bul-ul columns-2">
                        <?
                        $lines = explode("\n", $solution->additional_features);
                        ?>
                        @foreach ($lines as $line)
                        <?
                        if (!trim($line))
                            continue;
                        ?>
                        <li>
                            {{ $line }}
                        @endforeach
                        </ul>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>
            @endif

            @if (isset($documents) && count($documents))
            <section class="gray-section type-{{ $solution->slug }}">
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

            <section class="us-section download-block">
                <div class="container_12">
                    <div class="grid_12">

                        @if ($solution->availability_demonstrate)
                        <a href="#" class="title-btn js-popup-open" data-popup="order-present">Заказать демонстрацию</a>
                        @endif

                        <span class="fl-r">
                            @if ($solution->link_to_file_presentation)
                            <?
                            $file = Upload::firstOrNew(array('id' => $solution->link_to_file_presentation));
                            ?>
                                @if ($file->path)
                                <a href="{{ $file->path }}" target="_blank"><i class="lit-icon icon-download"></i> Скачать презентацию</a>
                                @endif
                            @endif

                            <a href="{{ URL::route('page', 'solutions') }}"><i class="lit-icon icon-projects"></i> Все решения</a>
                        </span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>

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

                    <div class="grid_4 grid_t6 grid_m12">
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
            $('.js-netrika-parent').netrika_slider();
            $('.js-st-parent').simple_tabs();
            $(document).canvas_draw();
            $(document).canvas_redraw();

            //$('.js-ls-parent').line_slider();
        </script>

@stop
