<?
/**
 * TITLE: Страница новостей
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
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

    $tbl_dicval = (new DicVal)->getTable();
    $tbl_fields = (new DicFieldVal)->getTable();
    $rand_tbl_alias = md5(rand(99999, 999999));
    #/*
    $query
        ->select($tbl_dicval . '.*')
        ->leftJoin($tbl_fields . ' AS ' . $rand_tbl_alias, function ($join) use ($tbl_dicval, $tbl_fields, $rand_tbl_alias) {
            $join
                ->on($rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
                ->where($rand_tbl_alias . '.key', '=', 'published_at')
            ;
        })
        ->addSelect($rand_tbl_alias . '.value AS ' . 'published_at')
        ->orderBy('published_at', 'DESC')
        ->where($rand_tbl_alias . '.value', '<=', date('Y-m-d')) /* в данный момент еще не сработал алиас AS published_at, поэтому приходится писать полное наименование поля, с префиксом таблицы */
        #->orderBy('created_at', 'DESC') /* default */
        ;
    #*/

    #$query->orderBy('created_at', 'desc');
    #/*
    $query->with(
        array('related_dicvals' => function($query) use ($rel_dics_ids){
            $query->whereIn('dic_id', $rel_dics_ids);
        })
    );
    #*/
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
        #'date' => $new->created_at->format('Y-m-d'),
        'date' => $new->published_at,
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
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
                    <div class="grid_4 grid_t6 grid_m12 head-form">
                        <div class="head-desc">Получайте последние новости</div>
                        <form id="subscribe" method="POST" action="{{ URL::route('add-email-listener') }}">
                            <input name="email" class="head-input" type="email" placeholder="email@email.com" required autocomplete="off">
                            <button type="submit" class="title-btn">Подписаться</button>
                            <span class="succeed-text"><!--Подписка оформлена--></span>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="us-section">
            <div class="container_12">
                <div class="grid_4 grid_t12 grid_m12 news-adp-filters">
                    <div class="grid_2 grid_t6 grid_m12 alpha news-search">
                        <form>
                            <div class="title">По тегам</div>
                            <ul class="tags-ul tags-hover js-tags">
                                <!-- <li class="tag-all" data-filter="all">Все
                                <li class="tag-auto" data-filter="auto">Автоматизация
                                <li class="tag-stat" data-filter="stat">Статистика
                                <li class="tag-event" data-filter="event">Выставки
                                <li class="tag-int" data-filter="int">Интеграция -->
                            </ul>
                            
                        </form>
                    </div>
                    <div class="grid_2 grid_t6 grid_m12 omega news-search js-date-range mobile-top-mar">
                        <div class="title">По дате</div>
                        <div class="search-date">
                            <input type="text" class="date-input js-date-from">
                        </div>
                        <div class="search-date">
                            <input type="text" class="date-input js-date-to">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="grid_2 alpha mobile-top-mar">
                        <button class="title-btn js-apply-filter">Применить</button>
                    </div>
                </div>
                <div class="grid_8 grid_t12 grid_m12 news-first js-news-first adp-top-mar">
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
        <section class="gray-section non-bot-pad js-news-all">
            <div class="container_12">
                <div class="grid_4 grid_t6 grid_m12 js-news-grid"><!--
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
                <div class="grid_4 grid_t6 grid_m12 js-news-grid">
                </div>
                <div class="grid_4 grid_t6 grid_m12 js-news-grid">
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
            var tags_object = {{ json_encode($tags_slug_name) }};

            var news_array = {{ json_encode($news) }};

            $(document).news_module(news_array, tags_object);

            var date_picker = (function(){
                var date_format = 'yy-mm-dd';

                $( ".js-date-from" ).datepicker({
                  defaultDate: "+1w",
                  changeMonth: false,
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
                  changeMonth: false,
                  numberOfMonths: 1,
                  dateFormat: date_format,
                  onClose: function( selectedDate ) {
                    $( ".js-date-from" ).datepicker( "option", "maxDate", selectedDate );
                  }
                });
            })();

            $('#subscribe').validate({
                errorClass: "inp-error",
                rules: {
                    email: { required: true, email: true }
                },
                messages: {
                    email: ''
                },
                submitHandler: function(form) {
                    sendSubscribeForm(form);
                    return false;
                }
            });

            function sendSubscribeForm(form) {

                //console.log(form);

                var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

                options.beforeSubmit = function(formData, jqForm, options){
                    $(form).find('button').addClass('loading');
                    //$('.error').text('').hide();
                    $('.succeed-text').text('');
                }

                options.success = function(response, status, xhr, jqForm){
                    //console.log(response);
                    //$('.success').hide().removeClass('hidden').slideDown();
                    //$(form).slideUp();

                    if (response.status) {
                        //$('.error').text('').hide();
                        //location.href = response.redirect;

                        //$('.response').text(response.responseText).slideDown();
                        //$(form).slideUp();

                        //$('.form-success').addClass('active');
                        $('.succeed-text').text(response.responseText);
                        $(form).find('button').removeClass('loading').addClass('success');

                        /*
                        setTimeout( function(){
                            $('.booking-form').removeClass('active');
                            $('.form-success').removeClass('active');
                        }, 2500);
                        */

                    } else {
                        //$('.response').text(response.responseText).show();
                    }

                }

                options.error = function(xhr, textStatus, errorThrown){
                    console.log(xhr);
                }

                options.complete = function(data, textStatus, jqXHR){
                    $(form).find('button').removeClass('loading');
                }

                $(form).ajaxSubmit(options);
            }


        </script>

@stop
