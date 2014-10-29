<?
/**
 * TITLE: Страница вакансий
 */
?>
@extends(Helper::layout())

<?
/*
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
*/

$color = '#1dcba4';

$vacancies = Dic::valuesBySlug('vacancies');
$vacancies = DicVal::extracts($vacancies, true);
#Helper::tad($vacancies);

$devteam = $page->block('devteam');
$devteam = explode("\n", $devteam);
$temp = array();
foreach ($devteam as $dev) {
    $dev = trim($dev);
    if (!$dev || !strpos($dev, ' '))
        continue;
    list($percent, $lang) = explode(' ', $dev);
    $temp[] = array(
        'value' => (int)$percent,
        'color' => $color,
        'label' => $lang
    );
}
$devteam = $temp;
unset($temp);
?>

@section('style')
@stop


@section('content')

        <section class="title-block title-main">
            <div class="container_12">
                <section class="title-content min-pad">
                    <div class="grid_8 grid_t12 grid_m12">
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
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="gray-section">
            <div class="container_12">
                <div class="grid_9 grid_t12 grid_m12">
                    <div class="bold-desc min-mar">

                        {{ $page->block('intro') }}

                    </div>
                </div>
                <div class="clearfix"></div>

                {{ $page->block('summary') }}

            </div>
        </section>
        <section class="us-section">
            <div class="container_12">
                <div class="grid_6 grid_t12">
                    <h2>Команда разработки</h2>
                    <div class="clearfix"></div>
                    <div class="developer-group">
                        <div class="grid_4 grid_t6 alpha">
                            <canvas id="developers-canvas" width="320" height="320"></canvas>
                        </div>
                        <div class="grid_2 grid_t6 omega">
                            <div class="developer-type">
                                <ul class="developer-list">
                                    @foreach ($devteam as $dev)
                                    <li>{{ $dev['label'] }}
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid_6 grid_t12 grid_m12 js-netrika-parent tablet-top-lmar mobile-top-lmar">
                    <div class="alpha grid_3 grid_t9">
                        <h2>Технологии</h2>
                    </div>
                    <div class="omega grid_3 js-netrika-controls">
                        <a href="#" class="desc-icon prev js-netrika-control disable" data-direction="<"></a>
                        <a href="#" class="desc-icon next js-netrika-control" data-direction=">"></a>
                    </div>
                    <?
                    $technologies = $page->block('technologies');
                    $technologies = explode("\n", $technologies);
                    $limit = 4;
                    $list = array_chunk($technologies, $limit, 1);
                    ?>
                    <div class="grid_6 grid_t12 grid_m12 alpha omega js-netrika-slider">
                        <div class="js-slider-window">
                            @foreach ($list as $lst)
                            <ul class="aims aims-light aims-small js-slide"><!--
                            @foreach ($lst as $t => $technology)
                                --><li>
                                    <div class="aim" data-number="{{ ($t+1) }}">
                                        <div class="text">{{ $technology }}</div>
                                    </div>
                                </li><!--
                            @endforeach
                            --></ul>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </section>
        <section class="us-section non-top-pad">
            <div class="container_12">
                <div class="grid_12">
                    <h2>Информация</h2>
                    <div class="columns-2">

                        {{ $page->block('information') }}

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <section class="gray-section vacancy-block">
            <div class="container_12">
                <div class="grid_12">
                    <h2>Текущие вакансии <span class="h2-desc">({{ count($vacancies) }})</span></h2>
                    <div class="bold-desc">

                        {{ nl2br($page->block('desc')) }}

                    </div>
                    @if (count($vacancies))
                    <ul class="vacancy-list">
                        @foreach ($vacancies as $vacancy)
                        <li>
                            <a href="{{ $vacancy->link_to_vacancy }}">{{ $vacancy->name }}</a>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

@stop


@section('footer')
    @parent
@stop


@section('scripts')
    <script src="{{ URL::to('theme/js/vendor/chart.js') }}"></script>
    <script>
        $('.js-netrika-parent').netrika_slider();
        var ctx = document.getElementById("developers-canvas").getContext("2d");
        var data = {{ json_encode($devteam) }};
        var options = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke : true,

            //String - The colour of each segment stroke
            segmentStrokeColor : "#fff",

            //Number - The width of each segment stroke
            segmentStrokeWidth : 4,

            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout : 40, // This is 0 for Pie charts

            //Number - Amount of animation steps
            animationSteps : 1,

            //String - Animation easing effect
            animationEasing : "ease",

            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate : true,

            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale : false,

        }
        var myPieChart = new Chart(ctx).Pie(data, options);
    </script>
@stop
