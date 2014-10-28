<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
        <header class="main-header">
            <div class="container_12">
                <div class="grid_12">
                    <a href="{{ URL::route('mainpage') }}" class="logo"></a>
                    <nav class="main-nav mobile-hidden">
                        <ul>
                            <li class="js-main-links">

                                {{ Menu::placement('main_menu') }}

                            <li class="optional tablet-hidden">

                                {{ Menu::placement('additional_menu') }}

                            <li class="menu-icon js-menu-open tablet-hidden">
                                <span></span>
                        </ul>
                    </nav>
                </div>
                <div class="clearfix"></div>
            </div>
        </header>
