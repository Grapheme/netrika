<?php

return array(

    'fields' => function () {

        return array(
            'map' => array(
                'content' => '
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    Показать карту
</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <section class="map-container js-admin-map">
        <div class="container_12">
            <div class="map-block js-map-block">
            </div>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="position:fixed; top:10px; left:10px;">
                    Закрыть
                </button>
            </div>
    </section>
</div>
',

            ),
            'city_x' => array(
                'title' => 'Координата X',
                'type' => 'text',
                'others' => array(
                    'class' => 'js-admin-map-x',
                ),
            ),
            'city_y' => array(
                'title' => 'Координата Y',
                'type' => 'text',
                'others' => array(
                    'class' => 'js-admin-map-y',
                ),
            ),
            'size' => array(
                'title' => 'Размерность',
                'type' => 'select',
                'values' => array('3'=>'Малый', '4'=>'Средний', '6'=>'Большой', '8'=>'Мегаполис'),
                'default' => 4,
                'others' => array(
                    'class' => 'js-admin-map-radius',
                ),
            ),
            'clients_list' => array(
                'title' => 'Список клиентов (по одному на строку)',
                'type' => 'textarea',
            ),
            /*
            'gallery' => array(
                'title' => 'Изображения',
                'type' => 'gallery',
                'handler' => function($array, $element) {
                    return ExtForm::process('gallery', array(
                        'module'  => 'dicval_meta',
                        'unit_id' => $element->id,
                        'gallery' => $array,
                        'single'  => true,
                    ));
                }
            ),
            */
        );

    },


    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        return $menus;
    },


    'actions' => function($dic, $dicval) {
        /*
        ## Data from hook: before_index_view
        $dics = Config::get('temp.index_dics');
        $dic_documents = $dics['clients-institutions'];
        $counts = Config::get('temp.index_counts');
        return '
            <span class="block_ margin-bottom-5_">
                <a href="' . URL::route('entity.index', array('clients-institutions', 'filter[fields][client_id]' => $dicval->id)) . '" class="btn btn-default">
                    Учреждения (' . @(int)$counts[$dicval->id][$dic_documents->id] . ')
                </a>
            </span>
        ';
        */
    },

    'hooks' => array(

        'before_all' => function ($dic) {
        },

        'before_index' => function ($dic) {
        },

        'before_index_view' => function ($dic, $dicvals) {
            /*
            $dics_slugs = array(
                'clients-institutions',
            );
            $dics = Dic::whereIn('slug', $dics_slugs)->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            #Helper::tad($dics);
            Config::set('temp.index_dics', $dics);

            $dic_ids = Dic::makeLists($dics, false, 'id');
            #Helper::d($dic_ids);
            $dicval_ids = Dic::makeLists($dicvals, false, 'id');
            #Helper::d($dicval_ids);

            $counts = array();
            if (count($dic_ids) && count($dicval_ids))
                $counts = DicVal::counts_by_fields($dic_ids, array('client_id' => $dicval_ids));
            #Helper::dd($counts);
            Config::set('temp.index_counts', $counts);
            */
        },

        'before_create_edit' => function ($dic) {
        },
        'before_create' => function ($dic) {
        },
        'before_edit' => function ($dic, $dicval) {
        },
        'after_store' => function ($dic, $dicval) {
            Event::fire('dobavlen-klient', array(array('title'=>$dicval->name)));
        },
        'after_update' => function ($dic, $dicval) {
            Event::fire('otredaktirovan-klient', array(array('title'=>$dicval->name)));
        },
        'after_destroy' => function ($dic, $dicval) {
            Event::fire('udalen-proekt', array(array('title'=>$dicval->name)));
        },
        'before_store_update' => function ($dic) {
        },
        'before_store' => function ($dic) {
        },
        'before_update' => function ($dic, $dicval) {
        },

        'before_destroy' => function ($dic, $dicval) {
        },
    ),

    'seo' => false,

    /**
     * Собственные правила валидации данной формы.
     * Не забыть про поле name, которое по умолчанию должно быть обязательным!
     */
    'custom_validation' => <<<HTML
    var validation_rules = {
		'name': { required: true },
		'fields[city_x]': { required: true, min: 0, max: 1000 },
		'fields[city_y]': { required: true, min: 0, max: 600 },
		'fields[size]': { required: true },
		'fields[clients_list]': { required: true },
	};
	var validation_messages = {
		'name': { required: "Укажите название" },
	};
HTML
,

    'javascript' => <<<JS

$.fn.smart_map = function(map_array) {
    $(this).each(function(){
        var parent = $(this),
			map_block = parent.find('.js-map-block'),
			map_desc = parent.find('.js-map-desc'),
			active_id = false;

		if(parent.hasClass('js-admin-map')){
            $(document).on('click', '.js-map-dot', function(){
                return false;
            });

            $(document).on('click', '.js-map-block', function(e){
                admin_click(e);
            });

            $(document).on('input', '.js-admin-map-x, .js-admin-map-y', function(){
                admin_pos();
            });

            $(document).on('change', '.js-admin-map-radius', function(){
                admin_rad();
            });

        } else {
            $(document).on('click', '.js-map-dot', function(){
                var id = $(this).attr('data-id');
                openDesc(id);

                return false;
            });

            $(document).on('click', '.js-desc-close', function(){
                closeDesc();
                return false;
            });

            $(document).on('click', '.js-map-control', function(){
                goDesc($(this).attr('data-direction'));
                return false;
            });
        }

		function admin_click(e) {
            var x = e.pageX - map_block.offset().left;
            var y = e.pageY - map_block.offset().top;
            if(parent.find('.js-admin-dot').length) {
                parent.find('.js-admin-dot').css({
					'left': x,
					'top': y
				});
			} else {
                var dot_default = { radius: $('.js-admin-map-radius').val(),
									posY: y,
									posX: x };

				var str = dotStr(0, dot_default, true);
				parent.find('.js-map-block').append(str);
			}

            $('.js-admin-map-x').val(x);
            $('.js-admin-map-y').val(y);
        }

		function admin_pos() {
            var x = parseInt($('.js-admin-map-x').val());
            var y = parseInt($('.js-admin-map-y').val());

            parent.find('.js-admin-dot').css({
				'left': x,
				'top': y
			});
		}

		function admin_rad() {
            var x = parseInt($('.js-admin-map-x').val());
            var y = parseInt($('.js-admin-map-y').val());
            var radius = parseInt($('.js-admin-map-radius').val());

            parent.find('.js-admin-dot').remove();
            var dot_settings = { radius: parseInt($('.js-admin-map-radius').val()),
								posY: y,
								posX: x };

			var str = dotStr(0, dot_settings, true);
			parent.find('.js-map-block').append(str);
		}

		function goDesc(d) {
            var dir;
            if(d == '<') {
                dir = -1;
            } else {
                dir = 1;
            }

            var new_id = active_id + dir;

            if(new_id == -1) {
                new_id = map_array.length - 1;
            }
            if(new_id == map_array.length) {
                new_id = 0;
            }

            openDesc(new_id);
        }

		function openDesc(id) {
            var id_array = map_array[id];
			var items = id_array.items;
			var city = id_array.name;
			var posX = id_array.posX;
			var posY = id_array.posY;

			var items_str = '';
			$.each(items, function(index, value){
                items_str += '<li>' + value;
            });
			map_desc.find('.js-desc-title').text(city);
			map_desc.find('.js-desc-items').html(items_str);
			setTimeout(function(){
                map_desc.find('.js-desc-items').customScrollbar();
            }, 1);

			var map_block_x = map_block.width()/4 - posX;
			var map_block_y = map_block.height()/2 - posY;
			var transform_str = transform('translateX(' + map_block_x + 'px) translateY(' + map_block_y + 'px)');

			map_block.attr('style', transform_str);

			$('.js-map-dot[data-id=' + id + ']').addClass('active')
            .siblings().removeClass('active');

			map_desc.show();
			active_id = parseInt(id);
		}

		function closeDesc() {
            map_block.attr('style', transform('translateX(0px) translateY(0px)'));
            $('.js-map-dot').removeClass('active');
            map_desc.hide();
        }

		function dotStr(index, value, admin_dot) {
            var rad_width = value.radius * 11;
            var style_str = 	'margin-top: -' + rad_width/2 + 'px; '+
                'margin-left: -' + rad_width/2 + 'px; '+
                'width: ' + rad_width + 'px; '+
                'height: ' + rad_width + 'px; '+
                'border-radius: ' + rad_width + 'px; ';
            if(admin_dot) {
                var admin_class = ' js-admin-dot';
            } else {
                var admin_class = '';
            }

            var str = 	'<a href="#" class="map-dot js-map-dot' + admin_class + '" style="top: ' + value.posY + 'px; left: ' + value.posX + 'px;" data-id="' + index + '">'+
                '<i class="map-rad" style="' + style_str + '"></i>'+
                '</a>';

            return str;
        }

		function init(x, y, r) {
            var map_html = '';

            //if (typeof map_array != 'undefined' && map_array.length)
            //    mar_array = [{posX: x, posY: y, radius: r}]

            $.each(map_array, function(index, value){
                var str = dotStr(index, value, true);
                map_html += str;
            });

            map_block.html(map_html);
            map_desc.hide();

            if($(window).width() <= 768) {
                openDesc(0);
            }
        }

		init();
	});
}
$('.js-admin-map').smart_map([{
    posX: 200, posY: 200, radius: 8
}]);
JS
,

    'style' => '
#myModal {
    /*
    width: 1260px;
    height: 663px;
    margin: 0 auto;
    scroll: none;
    */
}
.map-container {
  /*overflow: hidden;*/
  z-index: 1;
}
.map-container .container_12 {
  position: relative;
  height: 663px;
}
.map-container .map-block {
  position: relative;
  margin: 0 auto;
  top: 2.5rem;
  /*width: 75rem;*/
  width: 1200px;
  /*height: 36.4375rem;*/
  height: 583px;
  background: url(/' . Config::get('site.theme_path') . '/img/svg/map.svg) no-repeat center center;
  background-size: 1081px auto;
  -webkit-transition: all 1s ease;
          transition: all 1s ease;

    background-color:#fff;
}
.map-container .map-dot {
  position: absolute;
  display: inline-block;
  width: 10px;
  height: 10px;
  margin-left: -0.34375rem;
  margin-top: -0.34375rem;
  border-radius: 0.6875rem;
  background: #1dcba4;
}
.map-container .map-dot .map-rad {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  background: #b1b1b1;
  opacity: .2;
}
.map-container .map-dot:hover .map-rad,
.map-container .map-dot.active .map-rad {
  background: #1dcba4;
}
.map-container .map-dot:hover .map-rad {
  -webkit-transition: all .75s ease;
          transition: all .75s ease;
  -webkit-animation: mappulse .75s infinite;
          animation: mappulse .75s infinite;
}
.map-container .map-desc {
  position: absolute;
  -moz-box-sizing: border-box;
       box-sizing: border-box;
  top: 0;
  right: 0;
  width: 50%;
  height: 100%;
  background: #fff;
  padding: 2.5rem 1.875rem 2.5rem 3.75rem;
}
.map-container .map-desc .desc-icon {
  margin-right: 1.25rem;
}
.map-container .map-desc .desc-icon:last-child {
  margin: 0;
}
.map-container .map-desc .title {
  text-transform: uppercase;
  font-size: 1.25em;
  margin-top: 2.1875rem;
}
.map-container .map-desc .map-items {
  margin: 0;
  padding: 0;
  list-style: none;
  margin-top: 2.1875rem;
  height: 70%;
}
.map-container .map-desc .map-items li {
  margin-bottom: 0.625rem;
  padding-right: 3.125rem;
  color: #7f8281;
}
.map-container .map-desc .sol-dots {
  position: absolute;
  bottom: 2.5rem;
}
',

);
