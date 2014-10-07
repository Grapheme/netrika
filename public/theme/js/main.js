$.fn.main_slider = function(dots_class) {
	var parent = $(this),
		slides = parent.find('.js-main-slide'),
		active_id = 0,
		change_time = 5000,
		auto_stop = false,
		auto_timeout = false,
		click_timeout = false,
		dots_list = $(dots_class);

	$(document).on('click', dots_class + ' li', function(){
		go($(this).index());
		auto_stop = true;
		clearTimeout(auto_timeout);
		clearTimeout(click_timeout);

		click_timeout = setTimeout(function(){
			auto_stop = false;
			auto(change_time);
		}, change_time * 2);
	});

	function init() {
		var max = 0;
		slides.each(function(){
			dots_list.append('<li>');
			var height = $(this).outerHeight(true);
			if(height > max) {
				max = height;
			}
		});
		parent.css('height', max);

		go(0);
		setTimeout(function(){
			auto(change_time);
		}, change_time);
	}

	function go(id) {
		slides.eq(id).addClass('active')
			.siblings().removeClass('active');

		dots_list.find('li').eq(id).addClass('active')
			.siblings().removeClass('active');

		active_id = id;
	}

	function auto(time) {
		if(auto_stop) return;

		var new_id = active_id + 1;
		if(new_id == slides.length) {
			new_id = 0;
		}

		go(new_id);
		auto_timeout = setTimeout(function(){
			auto(time);
		}, time);
	}

	$(window).on('load', init);
}

$.fn.simple_tabs = function() {
	var parent = $(this),
		links = parent.find('.js-simple-link'),
		tabs = parent.find('.js-simple-tab');

	$(document).on('click', '.js-simple-link', function(){
		go($(this).index());
	});

	function init() {
		go(0);
	}

	function go(id) {
		tabs.eq(id).show()
			.siblings().hide();

		links.eq(id).addClass('active')
			.siblings().removeClass('active');
	}

	init();
}

$.fn.line_slider = function() {
	var parent = $(this),
		list = parent.find('.js-ls-list'),
		items = list.find('.js-ls-item'),
		controls = parent.find('.js-ls-controls'),
		measure,
		step,
		max_left,
		min_left = 0,
		left_arrow = controls.find('.js-ls-control[data-direction="<"]'),
		right_arrow = controls.find('.js-ls-control[data-direction=">"]'),
		slider_position = 0;

	if(items.length <= 4) {
		controls.hide();
		return;
	}

	$(document).on('click', '.js-ls-control', function(){
		var dir = $(this).attr('data-direction');
		go(dir);

		return false;
	});

	function init() {
		if(items.length <= 8) {
			measure = 1;
		} else {
			measure = 2;
		}

		left_arrow.addClass('disable');


		item_width = items.last().outerWidth(true);
		step = item_width * 4;
		var new_width = item_width * items.length / measure;
		list.css('width', new_width);
	}

	function go(dir) {
		var new_step = step;
		if(dir == '>') new_step = new_step * (-1);
		var new_left = slider_position + new_step;
		slider_position = new_left;

		var transform_str = transform('translateX(' + new_left + 'px)') + ' width: ' + list.width() + 'px;';
		list.attr('style', transform_str);
	}

	init();
}

//Карта
$.fn.smart_map = function(map_array) {
	var parent = $(this),
		map_block = parent.find('.js-map-block'),
		map_desc = parent.find('.js-map-desc'),
		active_id = false;

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

	function init() {
		var map_html = '';

		$.each(map_array, function(index, value){
			var rad_width = value.radius * 11;
			var style_str = 	'margin-top: -' + rad_width/2 + 'px; '+
								'margin-left: -' + rad_width/2 + 'px; '+
								'width: ' + rad_width + 'px; '+
								'height: ' + rad_width + 'px; '+
								'border-radius: ' + rad_width + 'px; ';

			var str = 	'<a href="#" class="map-dot js-map-dot" style="top: ' + value.posY + 'px; left: ' + value.posX + 'px;" data-id="' + index + '">'+
	                        '<i class="map-rad" style="' + style_str + '"></i>'+
	                    '</a>';

	  		map_html += str;
		});

		map_block.html(map_html);
		map_desc.hide();
	}

	init();
}

//Дополнительное меню в хидере
$.fn.header_nav = function() {
	var parent = $(this),
		main_links = parent.find('.js-main-links'),
		optional_links = parent.find('.optional'),
		optional_width = optional_links.outerWidth(true),
		button = $('.js-menu-open');

	var transform_str = '';

	function setTransform() {
		main_links.attr('style', transform_str).addClass('active');
	}
	function resetTransform() {
		main_links.removeAttr('style').removeClass('active');
	}

	function init() {
		transform_str = transform('translateX(' + optional_width + 'px)');
		setTransform();

		setTimeout(function(){
			optional_links.addClass('animate');
			main_links.addClass('animate');
		}, 5);
	}

	function controlMenu() {
		if(button.hasClass('active')) {
			optional_links.removeClass('active');
			button.removeClass('active');
			setTransform();
		} else {
			optional_links.addClass('active');
			button.addClass('active');
			resetTransform()
		}
	}

	$(document).on('ready', init);

	$(document).on('click', '.menu-icon', function(){
		controlMenu();
	});
}

$('.main-nav').header_nav();

$.fn.canvas_draw = function(array) {

	if(isNaN(array[0])) return;

	var radiuses = [160, 120, 80];

	function draw_animate(i, perc, max_perc) {
		var canvas = document.getElementById('canvas-cir-' + i);
		var color_cont = $('.canvas-cirs .color-' + i).css('background-color');
		var context = canvas.getContext('2d');
		var centerX = canvas.width / 2;
		var centerY = canvas.height / 2;
		var new_perc = 1.5 + perc / 50;

		context.clearRect(0, 0, canvas.width, canvas.height);

		context.beginPath();
		context.arc(centerX, centerY, radiuses[i], 3.5 * Math.PI, new_perc * Math.PI, true);
		context.lineWidth = 20;
		context.strokeStyle = '#f5f5f5';
		context.stroke();

		context.beginPath();
		context.arc(centerX, centerY, radiuses[i], new_perc * Math.PI, 1.5 * Math.PI, true);
		context.lineWidth = 20;
		context.strokeStyle = color_cont;
		context.stroke();

		setTimeout(function(){
			if(perc != max_perc) {
				draw_animate(i, Number((perc + 0.5).toFixed(1)), max_perc);
			}
		}, 1);
	}
	
	var i = 0;
	for(i; i < 3; i++) {
		draw_animate(i, 0, array[i]);
	}
}

//Навигация по выбору направлений в блоке статистики
$.fn.indexStatNav = function(block_class, item_class) {
	var parent = $(this),
		slider_block = $(this).find('.js-slider-parent'),
		block = $(this).find(block_class),
		item = $(this).find(item_class),
		left_arrow = parent.find('.stat-control .js-prev'),
		right_arrow = parent.find('.stat-control .js-next'),
		new_width = 0,
		left_pos = 0,
		min_left = 0,
		max_left = item.last().outerWidth(true) * (5 - item.length);

	item.each(function(){
		new_width += $(this).outerWidth(true);
	});

	var arrow = {
		disable: function(arrow) {
			arrow.addClass('disable');
		},
		enable: function(arrow) {
			arrow.removeClass('disable');
		}
	}

	var slider = {
		go: function(direction) {
			var step = item.last().outerWidth(true),
				ifLeft = (direction == '<'),
				ifRight =  (direction == '>');

			if( ifRight ) {

				step = step * (-1);
				if(left_pos <= max_left) {
					return;
				}
				if(left_pos + step <= max_left) {
					arrow.disable(right_arrow);
				}
				arrow.enable(left_arrow);
			}

			if( ifLeft ) {

				if(left_pos >= min_left) {
					return;
				}
				if(left_pos + step >= min_left) {
					arrow.disable(left_arrow);
				}
				arrow.enable(right_arrow);
			}

			left_pos = left_pos + step;
			block.css('left', left_pos);
		}
	}

	right_arrow.on('click', function(){
		slider.go('>');
		return false;
	});
	left_arrow.on('click', function(){
		slider.go('<');
		return false;
	});

	function init() {
		slider_block.css('overflow', 'hidden');
		block.css({
			'width': new_width,
			'left': 0
		});
		arrow.disable(left_arrow);

		if(item.length <= 5) {
			left_arrow.css('opacity', 0);
			right_arrow.css('opacity', 0);
		}
	}

	init();
}

$.fn.statTabs = function(slider_class) {
	var parent = $(this),
		slider = $(slider_class),
		tab_link = slider.find('.js-tab-link'),
		tabs = parent.find('.js-stat-tab');

	tab_link.on('click', function(){
		go($(this).attr('data-type'));
		return false;
	});

	function go(data_type) {
		slider.find('.js-tab-link[data-type="' + data_type + '"]')
			.addClass('active')
			.siblings().removeClass('active');

		parent.find('.js-stat-tab[data-type="' + data_type + '"]')
			.show()
			.siblings().hide();

		removeParentClasses();
		parent.addClass('type-' + data_type);

		var perc_array = getPerc(data_type);
		$(document).canvas_draw(perc_array);
	}

	function getPerc(data_type) {
		var array = [];
		var i = 0;
		for( i; i < 3; i++ ) {
			var str = $('.js-stat-tab[data-type="' + data_type + '"] .js-perc').eq(i).text();
			var perc = parseInt(str);
			array[i] = perc;
		}
		
		return array;
	}

	function removeParentClasses() {
		var classList = parent.attr('class').split(/\s+/);
		$.each( classList, function(index, item){
		    if(item.slice(0, 5) == 'type-') {
		    	parent.removeClass(item);
		    }
		});
	}

	function setMinHeight() {
		var min = 0;
		tabs.each(function(){
			var height = $(this).outerHeight(true);
			if( height > min ) {
				min = height;
			}
		});



		parent.css( 'min-height', min + 20 );
	}

	function init() {
		setMinHeight();
		go(tab_link.first().attr('data-type'));
	}

	$(window).on('load', init);
}

$.fn.jshover = function(circ) {
	var element = $(this);
	var circle = $(this).find('.' + circ);

	function setCircle(e, elem) {
		var pos = {
			x: e.pageX - elem.offset().left,
			y: e.pageY - elem.offset().top
		}

		var width = elem.find('.' + circ).parent().innerWidth();

		if(pos.x > width) {
			pos.x = width;
		}

		circle.css({
			'top': pos.y,
			'left': pos.x
		});
	}

	element.on('mouseover', function(e){
		setCircle(e, $(this));
	});
}

$('.js-hover').jshover('js-circle');

function transform(transform_value) {
	var prefixes = ['-webkit-', '-ms-', ''];
	var str = '';

	$.each(prefixes, function(index, value){
			var new_str = value + 'transform: ' + transform_value + '; ';
			str += new_str;
	});

	return str;
}

