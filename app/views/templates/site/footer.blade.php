<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
$solutions = Dic::valuesBySlug('solutions');
$solutions = DicVal::extracts($solutions, true);
#Helper::ta($solutions);

$projects = Dic::valuesBySlug('projects', function($query){
    #$query->orderBy('order', 'asc');
    $query->orderBy('updated_at', 'desc');
    $query->orderBy('created_at', 'desc');
});
$projects = DicVal::extracts($projects, true);
#Helper::ta($projects);

$array = array();
foreach ($projects as $project) {
    $array[$project->solution_id][$project->id] = $project;
}
?>
        <footer class="main-footer">
            <div class="container_12">
                <div class="grid_4">

                    {{ Menu::placement('footer_menu') }}

                    @if (0)
                    <ul class="footer-list">
                        <li><a href="{{ URL::route('page', 'about') }}">О компании</a>
                        <li><a href="{{ URL::route('page', 'projects') }}">Проекты</a>
                        <li><a href="{{ URL::route('page', 'solutions') }}">Решения</a>
                        <li><a href="{{ URL::route('page', 'newslist') }}">Новости</a>
                        <li><a href="{{ URL::route('page', 'contacts') }}">Контакты</a>
                        <li><a href="{{ URL::route('page', 'sitemap') }}">Карта сайта</a>
                    </ul>
                    @endif

                </div>
                <div class="grid_4">
                    <ul class="footer-list">
                        <li>Санкт-Петербург, пер. Фуражный, д. 3
                        <li><a class="phone-link" href="tel:+78126408070">+7 (812) 640-80-70</a>
                        <li><a href="{{ URL::route('page', 'contacts') }}">Контакты поддержки</a>
                        <li><i class="min-line"></i>
                        <li><a href="http://api.netrika.ru">api.netrika.ru</a>
                    </ul>
                </div>
                <div class="grid_4">
                    <form class="footer-search" method="GET" action="{{ URL::route('search') }}">
                        <input type="text" class="search-input" name="q" placeholder="Поиск" value="{{ @$_GET['q'] }}">
                        <button class="search-btn" type="submit"></button>
                    </form>
                    <ul class="footer-soc">
                        <li><a href="#" class="hh-icon"></a>
                        <li><a href="#" class="in-icon"></a>
                    </ul>
                </div>
                <div class="grid_12 footer-line"></div>
                <div class="grid_4">

                    @foreach ($solutions as $solution)
                        <div class="footer-title">{{ $solution->name }}</div>
                        <?
                        $solution_projects = @$array[$solution->id];
                        ?>
                        @if (count($solution_projects))
                            <ul class="footer-list">
                            @foreach ($solution_projects as $project)
                                <li><a href="{{ URL::route('project-one', $project->slug) }}">{{ $project->name }}</a>
                            @endforeach
                            </ul>
                        @endif
                    @endforeach

                </div>
                <div class="grid_12 footer-line"></div>
                <div class="grid_12">
                    <span>Официальный сайт компании Нетрика © 2014{{ date('Y') > 2014 ? '-'.date('Y') : '' }}</span>
                    <span class="copy-right">Разработка сайта: Нетрика при участии <a href="http://funcfunc.ru">Func</a></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </footer>

        <section class="popups">
            <div class="popup order-present" data-popup="order-present">

                {{ Form::open(array('url' => URL::route('request-demo'), 'method' => 'POST')) }}

                <header class="popup-header">
                    <span class="title">Заказать демонстрацию</span>
                    <span class="popup-close js-popup-close"><span class="desc-icon close"></a></span>
                </header>
                <div class="popup-body">
                    {{ Form::hidden('solution_id', $solution->id) }}

                    <div class="input-wrp">
                        <input type="text" name="name" placeholder="Имя">
                    </div>
                    <div class="input-wrp">
                        <input type="text" name="org" placeholder="Организация">
                    </div>
                    <div class="input-wrp">
                        <input type="text" name="role" placeholder="Должность">
                    </div>
                    <div class="input-wrp">
                        <input type="text" name="email" placeholder="E-mail">
                    </div>
                    <div class="input-wrp">
                        <input type="text" name="phone" placeholder="Номер телефона">
                    </div>
                    <div class="input-wrp">
                        <div class="solution-select">
                            <span class="select-btn"></span>
                            <div class="solution-line">Выберите решение</div>
                            <ul class="solution-list">
                                <li data-value="1"><div>Что-то</div>
                                <li data-value="2"><div>Еще что-то</div>
                                <li data-value="3"><div>И еще</div>
                            </ul>
                        </div>
                    </div>
                    <div class="input-wrp js-ajax-select-parent">
                        <select multiple name="components[]" data-text="Выберите компоненты для демонстрации" class="js-mSelect">
                        </select>
                    </div>

                    <!-- @if (isset($components) && count($components))
                    <div class="input-wrp">
                        <select multiple name="components[]" data-text="Выберите компоненты для демонстрации" class="js-mSelect">
                        @foreach ($components as $component)
                            <option value="{{ $component->name }}">{{ $component->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    @endif -->

                    <div class="input-wrp">
                        <textarea name="comment" placeholder="Оставьте ваш комментарий *"></textarea>
                    </div>
                </div>
                <footer class="popup-footer">
                    <button class="title-btn">Заказать</button>
                    <span class="error-msg"></span>
                </footer>

                {{ Form::close() }}

            </div>
        </section>
