@extends(Helper::layout())


@section('style')
@stop


@section('content')

        <section class="title-block title-main">
            <div class="container_12">
                <div class="grid_12">
                    <section class="title-content max-pad">
                        <div class="grid_9 alpha">
                            <div class="main-slider js-main-slider">
                                <h1 class="js-main-slide">
                                    Разработка, внедрение, интеграция, поддержка
                                    и сопровождение комплексных IT-решений
                                    в государственном секторе
                                </h1>
                                <h1 class="js-main-slide">
                                    Заголовок 2
                                </h1>
                                <h1 class="js-main-slide">
                                    Заголовок 3
                                </h1>
                            </div>
                            <a href="#" class="title-btn">Скачать презентацию</a>
                        </div>
                        <div class="grid_3 omega">
                            <ul class="sol-dots js-ms-dots">
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </section>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="main-stat us-section">
            <div class="container_12 js-stat-parent">
                <div class="grid_4 stat-desc">
                    <div class="js-stat-tab" data-type="health">
                        <h1 class="title-link"><a href="#">N3. Здравоохранение</a></h1>
                        <p>
                            Комплексная интегрированная платформа N3.Здравоохранение предназначена для создания, модернизации и/или преобразования системы управления здравоохранением региона, соответствующей всем современным требованиям отрасли.
                            Система находится в промышленной эксплуатации более двух лет. Интеграционная платформа от компании «Нетрика» - оптимальное решение, которое позволит региону привести все данные в единый вид при взаимодействии различных медицинских информационных систем регионального и федерального уровней.
                        </p>
                    </div>
                    <div class="js-stat-tab" data-type="education">
                        <h1 class="title-link"><a href="#">N2. Образование</a></h1>
                        <p>
                            Комплексная интегрированная платформа N3.Здравоохранение предназначена для создания, модернизации и/или преобразования системы управления здравоохранением региона, соответствующей всем современным требованиям отрасли.
                        </p>
                    </div>
                </div>
                <div class="grid_4 canvas-cirs">
                    <canvas id="canvas-cir-0" width="360" height="360"></canvas>
                    <canvas id="canvas-cir-1" width="360" height="360"></canvas>
                    <canvas id="canvas-cir-2" width="360" height="360"></canvas>
                    <i class="color-0"></i>
                    <i class="color-1"></i>
                    <i class="color-2"></i>
                </div>
                <div class="grid_4">
                    <ul class="stat-ul js-stat-tab" data-type="health">
                        <li>
                            <div class="title normal js-perc">62%</div>
                            <p>
                                экономии времени на ведении отчетности
                                в медецинских учереждениях
                            </p>

                        <li>
                            <div class="title light js-perc">43%</div>
                            <p>
                                экономии времени на ведении отчетности
                                в медецинских учереждениях
                            </p>

                        <li>
                            <div class="title lighter js-perc">54%</div>
                            <p>
                                экономии времени на ведении отчетности
                                в медецинских учереждениях
                            </p>
                    </ul>

                    <ul class="stat-ul js-stat-tab" data-type="education">
                        <li>
                            <div class="title normal js-perc">55%</div>
                            <p>
                                экономии времени на ведении отчетности
                                в медецинских учереждениях
                            </p>

                        <li>
                            <div class="title light js-perc">32%</div>
                            <p>
                                экономии времени на ведении отчетности
                                в медецинских учереждениях
                            </p>

                        <li>
                            <div class="title lighter js-perc">11%</div>
                            <p>
                                экономии времени на ведении отчетности
                                в медецинских учереждениях
                            </p>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <section class="stat-nav">
            <div class="container_12">
                <div class="grid_1 stat-control">
                    <a href="#" class="desc-icon prev js-prev"></a>
                </div>
                <div class="grid_10 js-slider-parent">
                    <div class="stat-items">
                        <a href="#" class="grid_2 stat-item js-tab-link active type-health" data-type="health">
                            <i class="sol-icon"></i><br>
                            <span>Здравоохранение</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-education" data-type="education">
                            <i class="sol-icon"></i><br>
                            <span>Образование</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-goverment" data-type="goverment">
                            <i class="sol-icon"></i><br>
                            <span>Открытое правительство</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-tourism" data-type="tourism">
                            <i class="sol-icon"></i><br>
                            <span>Туризм</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-law" data-type="law">
                            <i class="sol-icon"></i><br>
                            <span>Суды</span>
                        </a>
                        <a href="#" class="grid_2 stat-item js-tab-link type-portals" data-type="portals">
                            <i class="sol-icon"></i><br>
                            <span>Порталы</span>
                        </a>
                    </div>
                </div>
                <div class="grid_1 stat-control text-right">
                    <a href="#" class="desc-icon next js-next non-margin"></a>
                </div>
            </div>
        </section>

        <section class="projects">
            <div class="container_12">
                <div class="grid_4 solution-block type-portals js-hover">
                    <div class="background" style="background-image: url({{ asset(Config::get('site.theme_path').'/img/projects/images/portals.jpg') }})"></div>
                    <a href="#" class="project-link"></a>
                    <div class="hover-circle js-circle"></div>
                    <div class="prj-content">
                        <div class="title"><i class="us-icon icon-portals"></i> Порталы</div>
                        <div class="desc">
                            Автоматизация управления лечебно-диагностической деятельности СПб ГБУЗ
                        </div>
                    </div>
                </div>
                <div class="grid_4 solution-block type-health js-hover">
                    <div class="background" style="background-image: url({{ asset(Config::get('site.theme_path').'/img/projects/images/health.jpg') }})"></div>
                    <a href="#" class="project-link"></a>
                    <div class="hover-circle js-circle"></div>
                    <div class="prj-content">
                        <div class="title"><i class="us-icon icon-health"></i> Здравоохранение</div>
                        <div class="desc">
                            Региональный сегмент ЕГИСЗ <br>в Архангельске
                        </div>
                    </div>
                </div>
                <div class="grid_4 solution-block type-education js-hover">
                    <div class="background" style="background-image: url({{ asset(Config::get('site.theme_path').'/img/projects/images/education.jpg') }})"></div>
                    <a href="#" class="project-link"></a>
                    <div class="hover-circle js-circle"></div>
                    <div class="prj-content">
                        <div class="title"><i class="us-icon icon-education"></i> Образование</div>
                        <div class="desc">
                            Региональный фрагмент ЕГИСЗ <br>в Санкт-Петербурге
                        </div>
                    </div>
                </div>
                <div class="grid_4 solution-block type-auto js-hover">
                    <div class="background" style="background-image: url({{ asset(Config::get('site.theme_path').'/img/projects/images/auto.jpg') }})"></div>
                    <a href="#" class="project-link"></a>
                    <div class="hover-circle js-circle"></div>
                    <div class="prj-content">
                        <div class="title"><i class="us-icon icon-auto"></i> Автоматизация закупок</div>
                        <div class="desc">
                            Региональный сегмент ЕГИСЗ <br> в Архангельске
                        </div>
                    </div>
                </div>
                <div class="grid_4 solution-block type-tourism js-hover">
                    <div class="background" style="background-image: url({{ asset(Config::get('site.theme_path').'/img/projects/images/portals.jpg') }})"></div>
                    <a href="#" class="project-link"></a>
                    <div class="hover-circle js-circle"></div>
                    <div class="prj-content">
                        <div class="title"><i class="us-icon icon-tourism"></i> Туризм</div>
                        <div class="desc">
                            Автоматизация управления лечебно-диагностической деятельности СПб ГБУЗ
                        </div>
                    </div>
                </div>

                <div class="grid_4 type-all">
                    <a href="solutions.html" class="project-link">
                        <span>
                            <i class="lit-icon icon-projects"></i> Все проекты
                        </span>
                    </a>
                </div>

                <div class="clearfix"></div>
            </div>
        </section>

        <section class="map-container">
            <div class="container_12">
                <div class="map-block js-map-block">
                    <!-- <a href="#" class="map-dot active" style="top: 202px; left: 327px;">
                        <i class="map-rad"></i>
                    </a> -->
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

@stop


@section('footer')
    @parent
@stop


@section('scripts')
        <script>
            var map_array = [
                {
                    posX: 332,
                    posY: 202,
                    radius: 6,
                    name: "Санкт-Петербург",
                    items: [
                        "Администрация Санкт-Петербурга",
                        "Пресс-служба Администрации Санкт-Петербурга",
                        "СПб ГУП «АТС Смольного»",
                        "СПб ГУП «Управление информационных технологий и связи»",
                        "Региональный центр оценки качества образования и информационных технологий (РЦОКОиИТ)",
                        "Санкт-Петербургский информационно-аналитический центр",
                        "Санкт-Петербургский медицинский информационно-аналитический центр",
                        "Комитет по информатизации и связи Санкт-Петербурга",
                        "Комитет по здравоохранению Санкт-Петербурга",
                        "Комитет по образованию Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по транспортно-транзитной политике Санкт-Петербурга",
                        /*"Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",*/
                    ]
                },

                {
                    posX: 510,
                    posY: 299,
                    radius: 4,
                    name: "Челябинск",
                    items: [
                        "Администрация Челябинска",
                        "Пресс-служба Администрации Санкт-Петербурга",
                        "СПб ГУП «АТС Смольного»",
                        "СПб ГУП «Управление информационных технологий и связи»",
                        "Региональный центр оценки качества образования и информационных технологий (РЦОКОиИТ)",
                        "Санкт-Петербургский информационно-аналитический центр",
                        "Санкт-Петербургский медицинский информационно-аналитический центр",
                        "Комитет по информатизации и связи Санкт-Петербурга",
                        "Комитет по здравоохранению Санкт-Петербурга",
                        "Комитет по образованию Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по транспортно-транзитной политике Санкт-Петербурга"
                    ]
                },

                {
                    posX: 243,
                    posY: 250,
                    radius: 3,
                    name: "Псков",
                    items: [
                        "Администрация Пскова",
                        "Пресс-служба Администрации Санкт-Петербурга",
                        "СПб ГУП «АТС Смольного»",
                        "СПб ГУП «Управление информационных технологий и связи»",
                        "Региональный центр оценки качества образования и информационных технологий (РЦОКОиИТ)",
                        "Санкт-Петербургский информационно-аналитический центр",
                        "Санкт-Петербургский медицинский информационно-аналитический центр",
                        "Комитет по информатизации и связи Санкт-Петербурга",
                        "Комитет по здравоохранению Санкт-Петербурга",
                        "Комитет по образованию Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по транспортно-транзитной политике Санкт-Петербурга"
                    ]
                },

                {
                    posX: 100,
                    posY: 120,
                    radius: 3,
                    name: "Калининград",
                    items: [
                        "Администрация Пскова",
                        "Пресс-служба Администрации Санкт-Петербурга",
                        "СПб ГУП «АТС Смольного»",
                        "СПб ГУП «Управление информационных технологий и связи»",
                        "Региональный центр оценки качества образования и информационных технологий (РЦОКОиИТ)",
                        "Санкт-Петербургский информационно-аналитический центр",
                        "Санкт-Петербургский медицинский информационно-аналитический центр",
                        "Комитет по информатизации и связи Санкт-Петербурга",
                        "Комитет по здравоохранению Санкт-Петербурга",
                        "Комитет по образованию Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по транспортно-транзитной политике Санкт-Петербурга"
                    ]
                },

                {
                    posX: 1082,
                    posY: 496,
                    radius: 8,
                    name: "Хабаровск",
                    items: [
                        "Администрация Пскова",
                        "Пресс-служба Администрации Санкт-Петербурга",
                        "СПб ГУП «АТС Смольного»",
                        "СПб ГУП «Управление информационных технологий и связи»",
                        "Региональный центр оценки качества образования и информационных технологий (РЦОКОиИТ)",
                        "Санкт-Петербургский информационно-аналитический центр",
                        "Санкт-Петербургский медицинский информационно-аналитический центр",
                        "Комитет по информатизации и связи Санкт-Петербурга",
                        "Комитет по здравоохранению Санкт-Петербурга",
                        "Комитет по образованию Санкт-Петербурга",
                        "Комитет по вопросам законности, правопорядка и безопасности Санкт-Петербурга",
                        "Комитет по транспортно-транзитной политике Санкт-Петербурга"
                    ]
                },
            ];

            $('.map-container').smart_map(map_array);
            $('.js-stat-parent').statTabs('.js-slider-parent');
            $('.stat-nav').indexStatNav('.stat-items', '.stat-item');
            $('.js-main-slider').main_slider('.js-ms-dots');

        </script>
@stop
