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

                {{ $page->block('technologies') }}

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
@stop
