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
                <section class="title-content max-pad">
                    <div class="grid_8 grid_t12 grid_m12">

                        {{ $page->block('mission') }}

                    </div>
                    <div class="clearfix"></div>
                </section>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="about-russian">
            <div class="container_12">
                <div class="grid_12">

                    {{ $page->block('visual_title') }}

                </div>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="us-section benefits">
            <div class="container_12">

                {{ $page->block('visual_content') }}

                <div class="clearfix"></div>
            </div>
        </section>
        <section class="us-section non-top-pad">
            <div class="container_12">
                <div class="grid_12">
                    <h2>
                        {{ $page->block('geo_title') }}
                    </h2>
                </div>
                <div class="grid_9">
                    <div class="bold-desc">

                        {{ $page->block('geo_description') }}

                    </div>
                </div>
                <div class="grid_3 desc-lh">
                    <a href="{{ URL::route('page', 'projects') }}"><i class="lit-icon icon-projects"></i> Все проекты</a>
                </div>

                <div class="clearfix"></div>
            </div>
        </section>
        <section class="map-container">
            <div class="container_12">
                <div class="map-block js-map-block">
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
        <section class="gray-section">
            <div class="container_12">
                <div class="grid_12">

                    {{ $page->block('licences') }}

                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <section class="us-section">
            <div class="container_12">

                {{ $page->block('profile') }}

                <div class="clearfix"></div>
            </div>
        </section>
        <section class="gray-section">
            <div class="container_12">
                <div class="grid_12">
                    <h2 class="title-link"><a href="{{ URL::route('page', 'vacancy') }}">Вакансии</a></h2>
                </div>

                {{ $page->block('vacancy') }}

                <div class="clearfix"></div>

                {{ $page->block('summary') }}

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
        $('.stat-nav').indexStatNav('.stat-items', '.stat-item');
        $('.js-main-slider').main_slider('.js-ms-dots');

    </script>
@stop
