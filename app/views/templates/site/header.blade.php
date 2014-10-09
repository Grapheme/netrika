<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
        <header class="main-header">
            <div class="container_12">
                <div class="grid_12">
                    <a href="{{ URL::route('mainpage') }}" class="logo"></a>
                    <nav class="main-nav">
                        <ul>
                            <li class="js-main-links">

                                {{-- Menu::draw('main_menu') --}}

                                <ul>
                                    <li><a href="{{ URL::route('page', 'about') }}"{{ Helper::isRoute('page', 'about', ' class="active"') }}>О компании</a>
                                    <li><a href="{{ URL::route('page', 'newslist') }}"{{ Helper::isRoute('page', 'newslist', ' class="active"') }}>Новости</a>
                                    <li><a href="{{ URL::route('page', 'solutions') }}"{{ Helper::isRoute('page', 'solutions', ' class="active"') }}>Решения</a>
                                    <li><a href="{{ URL::route('page', 'projects') }}"{{ Helper::isRoute('page', 'projects', ' class="active"') }}>Проекты</a>
                                    <li><a href="{{ URL::route('page', 'contacts') }}"{{ Helper::isRoute('page', 'contacts', ' class="active"') }}>Контакты</a>
                                </ul>

                            <li class="optional">
                                <ul>
                                    <li><a href="{{ URL::route('page', 'support') }}">Контакты поддержки</a>
                                    <li><a href="tel:">+7 (812) 640-80-70</a>
                                </ul>

                            <li class="menu-icon js-menu-open">
                                <span></span>
                        <ul>
                    </nav>
                </div>
                <div class="clearfix"></div>
            </div>
        </header>
