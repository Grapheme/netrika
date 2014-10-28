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
$vacancies = Dic::valuesBySlug('vacancies');
$vacancies = DicVal::extracts($vacancies, true);
#Helper::tad($vacancies);
?>

@section('style')
@stop


@section('content')

        <section class="title-block title-main">
            <div class="container_12">
                <section class="title-content min-pad">
                    <div class="grid_8">
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
                <div class="grid_9">
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
                <div class="grid_6">
                    <h2>Команда разработки</h2>
                    <div class="clearfix"></div>
                    <div class="developer-group">
                        <div class="grid_4 alpha">
                            <canvas id="developers-canvas" width="320" height="320"></canvas>
                        </div>
                        <div class="grid_2 omega">
                            <div class="developer-type">
                                <ul class="developer-list">
                                    <li>PHP
                                    <li>Python
                                    <li>C
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid_6 js-netrika-parent">
                    <div class="alpha grid_3">
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
                    $count = count($technologies);
                    $p = 0;
                    ?>
                    <div class="grid_6 alpha omega js-netrika-slider">
                        <div class="js-slider-window">
                            @foreach ($technologies as $t => $technology)
                                @if (!$p++ || $p % $limit == 1)
                            <ul class="aims aims-light aims-small js-slide"><!--
                                @endif

                                --><li>
                                    <div class="aim" data-number="{{ ($t+1) }}">
                                        <div class="text">{{ $technology }}</div>
                                    </div>
                                </li><!--

                                @if ($p % ($limit) == 0 || $p >= $count)
                            --></ul>
                                @endif
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
        var data = [
            {
                value: 34,
                color:"#1dcba4",
                label: "PHP"
            },
            {
                value: 31,
                color: "#60dabf",
                label: "Python"
            },
            {
                value: 24,
                color: "#8ee5d1",
                label: "C"
            }
        ];
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
