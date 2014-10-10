<?
/**
 * TITLE: Страница новостей
 */
?>
@extends(Helper::layout())

<?

/**
 * Системные имена словарей для предзагрузки
 */
$rel_dics_slugs = array(
    'tags'
);
$rel_dics = Dic::whereIn('slug', $rel_dics_slugs)->get();
$rel_dics_ids = Dic::makeLists($rel_dics, false, 'id');
$rel_dics_id_slug = Dic::makeLists($rel_dics, false, 'slug', 'id');
#Helper::dd($rel_dics_ids);
#Helper::dd($rel_dics_id_slug);

$tags = Dic::valuesBySlug('tags');
#Helper::tad($tags);
$tags_slug_name = $tags->lists('name', 'slug');
natsort($tags_slug_name);

$newslist = Dic::valuesBySlug('newslist', function($query) use ($rel_dics_ids){
    $query->orderBy('created_at', 'desc');
    $query->with(
        array('related_dicvals' => function($query) use ($rel_dics_ids){
            $query->whereIn('dic_id', $rel_dics_ids);
        })
    );
});
#Helper::tad($newslist);
$newslist = DicVal::extracts($newslist, true);
#$newslist = DicVal::extracts_related($newslist, $rel_dics_id_slug, false);
#Helper::tad($newslist);

$images_ids = Dic::makeLists($newslist, false, 'image_id');
if (isset($images_ids) && is_array($images_ids) && count($images_ids)) {
    $images = Photo::whereIn('id', $images_ids)->get();
    if (count($images))
        $images = DicVal::extracts($images, true);
} else {
    $images = array();
}
#Helper::tad($images);

$news_ids = Dic::makeLists($newslist, false, 'id');
#Helper::d($news_ids);

$news = array();
foreach ($newslist as $new) {
    $news[] = array(
        'date' => $new->created_at->format('Y-m-d'),
        'title' => $new->name,
        'image' => @$images[$new->image_id] ? $images[$new->image_id]->full() : false,
        'href' => '/news/'.$new->slug,
        'tags' => $new->related_dicvals->lists('slug'),
    );
}
#Helper::tad($news);

#$news = News::orderBy('created_at', 'DESC')->get();
#Helper::tad($news);
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
                    <div class="grid_4 head-form">
                        <div class="head-desc">Получайте последние новости</div>
                        <form>
                            <input class="head-input" type="text" placeholder="email@email.com">
                            <button type="submit" class="title-btn">Подписаться</button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="us-section">
            <div class="container_12">
                <div class="grid_2 news-search">
                    <form>
                        <div class="title">По тегам</div>
                        <ul class="tags-ul tags-hover js-tags">
                            <!-- <li class="tag-all" data-filter="all">Все
                            <li class="tag-auto" data-filter="auto">Автоматизация
                            <li class="tag-stat" data-filter="stat">Статистика
                            <li class="tag-event" data-filter="event">Выставки
                            <li class="tag-int" data-filter="int">Интеграция -->
                        </ul>
                        <button class="title-btn js-apply-filter">Применить</button>
                    </form>
                </div>
                <div class="grid_2 news-search js-date-range">
                    <div class="title">По дате</div>
                    <div class="search-date">
                        <input type="text" class="date-input js-date-from">
                    </div>
                    <div class="search-date">
                        <input type="text" class="date-input js-date-to">
                    </div>
                </div>
                <div class="grid_8 news-first js-news-first">
                    <!-- <div class="grid_4 alpha">
                        <a href="news-one.html" class="news-photo" style="background-image: url(img/projects/images/news-photo.jpg);">
                            <span class="news-date"><span class="day">27</span> / 04 / 2014</span>
                        </a>
                    </div>
                    <div class="grid_4 omega">
                        <div class="title">
                            Модернизация официального портала Администрации Санкт-Петербурга продолжается
                        </div>
                        <ul class="tags-ul">
                            <li class="tag-auto active">Автоматизация
                            <li class="tag-stat">Статистика
                        </ul>
                    </div> -->
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <section class="gray-section non-bot-pad">
            <div class="container_12">
                <div class="grid_4 js-news-grid"><!--
                    <div class="news-item">
                        <a href="news-one.html" class="news-photo" style="background-image: url(img/projects/images/news-photo.jpg);">
                            <span class="news-date"><span class="day">27</span> / 04 / 2014</span>
                        </a>
                        <div class="news-preview">
                            <a href="news-one.html" class="title">
                                Почти 2000 образовательных учреждений Санкт-Петербурга могут создать свой типовой Интернет-сайт
                            </a>
                        </div>
                        <ul class="tags-ul">
                            <li class="tag-auto active">Автоматизация
                            <li class="tag-stat">Статистика
                            <li class="tag-event">Выставки
                            <li class="tag-int">Интеграция
                        </ul>
                    </div>
                    <div class="news-item">
                        <div class="news-preview">
                            <span class="news-date"><span class="day">27</span> / 04 / 2014</span>
                            <a href="news-one.html" class="title">
                                Почти 2000 образовательных учреждений Санкт-Петербурга могут создать свой типовой Интернет-сайт
                            </a>
                        </div>
                        <ul class="tags-ul">
                            <li class="tag-auto active">Автоматизация
                            <li class="tag-stat">Статистика
                        </ul>
                    </div> -->
                </div>
                <div class="grid_4 js-news-grid">
                </div>
                <div class="grid_4 js-news-grid">
                </div>
                <div class="clearfix"></div>
            </div>
        </section>


@stop


@section('footer')
    @parent
@stop


@section('scripts')
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script src="{{ asset(Config::get('site.theme_path').'/js/vendor/jquery.ui.datepicker-ru.js') }}"></script>
        <script>
            <!--
            var tags_object = {
                'auto': 'Автоматизация',
                'stat': 'Статистика',
                'event': 'Выставки',
                'int': 'Интеграция'
            };
            -->
            var tags_object = {{ json_encode($tags_slug_name) }};

            <!--
            var news_array = [
                {
                    date: new Date('2014-10-27'),
                    title: 'Почти 2000 образовательных учреждений Санкт-Петербурга могут создать свой типовой Интернет-сайт',
                    image: 'img/projects/images/news-photo.jpg',
                    href: 'news-one.html',
                    tags: [
                        'auto',
                        'event',
                        'int'
                    ]
                },

                {
                    date: new Date('2014-10-23'),
                    title: 'Почти 2000 образовательных учреждений Санкт-Петербурга могут создать свой типовой Интернет-сайт',
                    image: false,
                    href: 'news-one.html',
                    tags: [
                        'auto',
                    ]
                },

                {
                    date: new Date('2014-09-01'),
                    title: 'Почти 3000 образовательных учреждений Санкт-Петербурга могут создать свой типовой Интернет-сайт',
                    image: 'img/projects/images/auto.jpg',
                    href: 'news-one.html',
                    tags: [
                        'event',
                        'int'
                    ]
                },
            ];
            -->
            var news_array = {{ json_encode($news) }};

            $(document).news_module(news_array, tags_object);

            var date_picker = (function(){
                var date_format = 'yy-mm-dd';

                $( ".js-date-from" ).datepicker({
                  defaultDate: "+1w",
                  changeMonth: true,
                  numberOfMonths: 1,
                  dateFormat: date_format,
                  onClose: function( selectedDate ) {
                    /*var newDate = new Date(selectedDate);
                    var newDay = ("0" + newDate.getDate()).slice(-2);
                    var newMonth = ("0" + (newDate.getMonth() + 1)).slice(-2);
                    var newYear = newDate.getFullYear();
                    var parse_str = newDay + '. ' + newMonth + '. ' + newYear;
                    $( ".js-date-from" ).val(parse_str).attr('data-date', selectedDate);*/

                    $( ".js-date-to" ).datepicker( "option", "minDate", selectedDate );
                  }
                });
                $( ".js-date-to" ).datepicker({
                  defaultDate: "+1w",
                  changeMonth: true,
                  numberOfMonths: 1,
                  dateFormat: date_format,
                  onClose: function( selectedDate ) {
                    $( ".js-date-from" ).datepicker( "option", "maxDate", selectedDate );
                  }
                });
            })();
        </script>

@stop
