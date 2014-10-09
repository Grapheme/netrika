<?
/**
 * TITLE: О компании
 */
?>
@extends(Helper::layout())

<?
$clients = Dic::valuesBySlug('clients');
$clients = DicVal::extracts($clients, true);
#Helper::tad($clients);
$map_array = array();
foreach ($clients as $client) {
    $map_array[] = array(
        'posX' => $client->city_x,
        'posY' => $client->city_y,
        'radius' => $client->size,
        'name' => $client->name,
        'items' => explode("\n", $client->clients_list),
    );
}
?>

@section('style')
@stop


@section('content')

        <section class="title-block title-main">
            <div class="container_12">
                <div class="grid_12">
                    <section class="title-content max-pad">
                        <div class="grid_9 alpha">
                            <div class="main-slider js-main-slider">
                                @foreach ($slides as $slide)
                                    <?
                                    #$slide->text_slide = strip_tags($slide->text_slide, '<a>');
                                    ?>
                                    <div class="js-main-slide">
                                        {{ $slide->text_slide }}
                                    </div>
                                @endforeach
                            </div>
                            {{--<a href="#" class="title-btn">Скачать презентацию</a>--}}
                        </div>
                        <div class="grid_3 omega">
                            <ul class="sol-dots js-ms-dots">
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </section>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="main-stat us-section">
            <div class="container_12 js-stat-parent">
                <div class="grid_4 stat-desc">

                    @foreach ($solutions as $solution)
                    <div class="js-stat-tab" data-type="{{ $solution->slug }}">
                        <h1 class="title-link"><a href="#">{{ $solution->name }}</a></h1>
                        <p>
                            {{ $solution->describes_purpose_decision }}
                        </p>
                    </div>

                    @endforeach

                </div>
                <div class="grid_4 canvas-cirs">
                    <canvas id="canvas-cir-0" width="360" height="360"></canvas>
                    <canvas id="canvas-cir-1" width="360" height="360"></canvas>
                    <canvas id="canvas-cir-2" width="360" height="360"></canvas>
                    <i class="color-0"></i>
                    <i class="color-1"></i>
                    <i class="color-2"></i>
                </div>
                <div class="grid_4">

                    @foreach ($solutions as $solution)
                    <ul class="stat-ul js-stat-tab" data-type="{{ $solution->slug }}">
                        {{-- $solution->performance_indicators --}}
                        <?
                        $indicators = explode("\n", $solution->performance_indicators);
                        ?>
                        @if (count($indicators))
                            @foreach ($indicators as $indicator)
                                <?
                                $indicator = trim($indicator);
                                if ($indicator == '')
                                    continue;
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

                    @endforeach

                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <section class="stat-nav">
            <div class="container_12">
                <div class="grid_1 stat-control">
                    <a href="#" class="desc-icon prev js-prev"></a>
                </div>
                <div class="grid_10 js-slider-parent">
                    <div class="stat-items">

                        @foreach ($solutions as $solution)
                        <a href="#" class="grid_2 stat-item js-tab-link active type-{{ $solution->slug }}" data-type="{{ $solution->slug }}">
                            <i class="sol-icon"></i><br>
                            <span>{{ $solution->name }}</span>
                        </a>
                        @endforeach

                        @if (0)
                        <!--
                        <a href="#" class="grid_2 stat-item js-tab-link active type-health" data-type="health">
                            <i class="sol-icon"></i><br>
                            <span>Здравоохранение</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-education" data-type="education">
                            <i class="sol-icon"></i><br>
                            <span>Образование</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-goverment" data-type="goverment">
                            <i class="sol-icon"></i><br>
                            <span>Открытое правительство</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-tourism" data-type="tourism">
                            <i class="sol-icon"></i><br>
                            <span>Туризм</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-law" data-type="law">
                            <i class="sol-icon"></i><br>
                            <span>Суды</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-portals" data-type="portals">
                            <i class="sol-icon"></i><br>
                            <span>Порталы</span>
                        </a>
                        -->
                        @endif

                    </div>
                </div>
                <div class="grid_1 stat-control text-right">
                    <a href="#" class="desc-icon next js-next non-margin"></a>
                </div>
            </div>
        </section>

        <section class="projects">
            <div class="container_12">

                @foreach ($projects as $project)
                <?
                $solution = @$solutions[$project->solution_id];
                $image = @$images[$project->mainpage_image] ?: new Photo;
                ?>
                <div class="grid_4 solution-block type-{{ $solution->slug }} js-hover">
                    <div class="background" style="background-image: url(
                    {{-- asset(Config::get('site.theme_path').'/img/projects/images/portals.jpg') --}}
                    {{ $image->full() }}
                    )"></div>
                    <a href="#" class="project-link"></a>
                    <div class="hover-circle js-circle"></div>
                    <div class="prj-content">
                        <div class="title"><i class="us-icon icon-{{ $solution->slug }}"></i> {{ $solution->name }}</div>
                        <div class="desc">
                            {{ $project->name }}
                        </div>
                    </div>
                </div>

                @endforeach

                <div class="grid_4 type-all">
                    <a href="{{ URL::route('page', 'solutions') }}" class="project-link">
                        <span>
                            <i class="lit-icon icon-projects"></i> Все проекты
                        </span>
                    </a>
                </div>

                <div class="clearfix"></div>
            </div>
        </section>

        <section class="map-container">
            <div class="container_12">
                <div class="map-block js-map-block">
                    <!-- <a href="#" class="map-dot active" style="top: 202px; left: 327px;">
                        <i class="map-rad"></i>
                    </a> -->
                </div>
                <div class="map-desc js-map-desc">
                    <div class="desc-nav">
                        <a href="#" class="desc-icon prev js-map-control" data-direction="<"></a>
                        <a href="#" class="desc-icon next js-map-control" data-direction=">"></a>
                        <a href="#" class="desc-icon close fl-r js-desc-close"></a>
                    </div>
                    <div class="title js-desc-title"></div>
                    <ul class="map-items js-desc-items">
                    </ul>
                    <ul class="sol-dots js-list-dots">
                        <li class="active">
                        <li>
                    </ul>
                </div>
            </div>
        </section>

@stop


@section('footer')
    @parent
@stop


@section('scripts')
    <script>
        var map_array = {{ json_encode($map_array) }};

        $('.map-container').smart_map(map_array);
        $('.js-stat-parent').statTabs('.js-slider-parent');
        $('.stat-nav').indexStatNav('.stat-items', '.stat-item');
        $('.js-main-slider').main_slider('.js-ms-dots');

    </script>
@stop
