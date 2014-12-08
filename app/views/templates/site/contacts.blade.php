<?
/**
 * TITLE: Страница контактов
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())


@section('style')
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
                </section>
                <div class="clearfix"></div>
            </div>
        </section>

        <section class="gray-section">
            <div class="container_12">
                <div class="grid_6 grid_m12">

                    {{ $page->block('top_left') }}

                </div>
                <div class="grid_6 grid_m12 mobile-top-lmar">

                    {{ $page->block('top_right') }}

                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <section class="us-section over-hidden">
            <div class="container_12 contact-block">
                <div class="grid_12 grid_m12">

                    {{ $page->block('address') }}

                    <div id="map" class="contact-map"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>

@stop


@section('footer')
    @parent
@stop


@section('scripts')
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA4Q5VgK-858jgeSbJKHbclop_XIJs3lXs&sensor=true">
        </script>

        <script>

            var google_map = (function(){

                var style = [
                    {
                        "featureType": "landscape",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 65
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 51
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 30
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 40
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.province",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "lightness": -25
                            },
                            {
                                "saturation": -100
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "hue": "#ffff00"
                            },
                            {
                                "lightness": -25
                            },
                            {
                                "saturation": -97
                            }
                        ]
                    }
                ];

                function initialize() {
                    var map_center = new google.maps.LatLng({{ $page->block('coordinates') }});

                    var mapOptions = {
                        center: map_center,
                        zoom: 17,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        //draggable: false, zoomControl: false,
                        scrollwheel: false,
                        //disableDoubleClickZoom: true,
                        styles: style
                    };
                    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

                    var iconBase = '{{URL::to("theme/img/svg/")}}';

                    var marker = new google.maps.Marker({
                      position: map_center,
                      map: map,
                      icon: iconBase + '/marker.svg'
                    });

                    //var myLatlng = new google.maps.LatLng(47.2248231, 39.7273844);
                }
                google.maps.event.addDomListener(window, 'load', initialize);

            })();

        </script>

@stop
