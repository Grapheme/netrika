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
	}

	init();
}

$('.stat-nav').indexStatNav('.stat-items', '.stat-item');

$.fn.statTabs = function(slider_class) {
	var parent = $(this),
		slider = $(slider_class),
		tab_link = slider.find('.js-tab-link');

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

	}

	function removeParentClasses() {
		var classList = parent.attr('class').split(/\s+/);
		$.each( classList, function(index, item){
		    if(item.slice(0, 5) == 'type-') {
		    	parent.removeClass(item);
		    }
		});
	}

	function init() {
		go(tab_link.first().attr('data-type'));
	}

	init();
}

$('.js-stat-parent').statTabs('.js-slider-parent');

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

$.fn.canvas_draw = function() {

	var array = [62, 43, 54];
	var radiuses = [160, 120, 80];
	var i = 0;
	for(i; i < 3; i++) {
		var canvas = document.getElementById('canvas-cir-' + i);
		var color_cont = $('.canvas-cirs .color-' + i).css('background-color');
		var context = canvas.getContext('2d');
		var centerX = canvas.width / 2;
		var centerY = canvas.height / 2;
		var perc = 1.5 + array[i] / 50;

		context.beginPath();
		context.arc(centerX, centerY, radiuses[i], 3.5 * Math.PI, perc * Math.PI, true);
		context.lineWidth = 20;
		context.strokeStyle = '#f5f5f5';
		context.stroke();

		context.beginPath();
		context.arc(centerX, centerY, radiuses[i], perc * Math.PI, 1.5 * Math.PI, true);
		context.lineWidth = 20;
		context.strokeStyle = color_cont;
		context.stroke();
	}
	
}

$('.js-hover').jshover('js-circle');

