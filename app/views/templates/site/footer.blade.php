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
                    <ul class="footer-list">
                        <li><a href="{{ URL::route('page', 'about') }}">О компании</a>
                        <li><a href="{{ URL::route('page', 'projects') }}">Проекты</a>
                        <li><a href="{{ URL::route('page', 'solutions') }}">Решения</a>
                        <li><a href="{{ URL::route('page', 'newslist') }}">Новости</a>
                        <li><a href="{{ URL::route('page', 'contacts') }}">Контакты</a>
                        <li><a href="{{ URL::route('page', 'sitemap') }}">Карта сайта</a>
                    </ul>
                </div>
                <div class="grid_4">
                    <ul class="footer-list">
                        <li>Санкт-Петербург, пер. Фуражный, д. 3
                        <li><a class="phone-link" href="tel:+78126408070">+7 (812) 640-80-70</a>
                        <li><a href="#">Контакты поддержки</a>
                        <li><i class="min-line"></i>
                        <li><a href="http://api.netrika.ru">api.netrika.ru</a>
                    </ul>
                </div>
                <div class="grid_4">
                    <form class="footer-search" action="">
                        <input type="text" class="search-input" placeholder="Поиск">
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
                                <li><a href="#">{{ $project->name }}</a>
                            @endforeach
                            </ul>
                        @endif
                    @endforeach

                </div>
                <div class="grid_12 footer-line"></div>
                <div class="grid_12">
                    <span>Официальный сайт компании Нетрика © 2014{{ date('Y') > 2014 ? '-'.date('Y') : '' }}</span>
                    <span class="copy-right">Разработка сайта: Нетрика при участии <a href="#">Func</a></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </footer>
