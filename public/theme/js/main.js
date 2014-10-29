$.fn.solutionSelect = function(auto_select) {
	var parent = $(this);

	$(document).on('click', '.solution-line', function(){
		selectClick();
	});

	$(document).on('click', '.solution-list li', function(){
		set($(this).attr('data-value'));
	});

	function selectClick() {
		parent.toggleClass('open');
	}

	function close() {
		parent.removeClass('open');
	}

	function set(value) {
		var this_option = parent.find('[data-value="' + value + '"]');
		this_option.addClass('active')
			.siblings().removeClass('active');

		parent.find('.solution-line').text(this_option.text());
		$('input[name="solution_id"]').val(value);
		close();

		$.ajax({
			url: '/get-solution-components',
			data: {'solution_id': value},
			type: 'post',
		})
		.done(function(data) {
            var json = $.parseJSON(data);

            clearMSelect();

            if (json['items'].length) {
                $('.js-ajax-select-parent').find('.js-mSelect').show();
                $('.js-ajax-select-parent').find('.js-mSelect').mSelect(json);
            }
		})
		.fail(function(data){
			console.log(data);
		});
	}

	function clearMSelect() {
		$('.js-ajax-select-parent').find('.js-mSelect option').remove();
		$('.js-ajax-select-parent').find('.multiple-select').remove();
	}

	function init() {
		$('.js-ajax-select-parent').find('.js-mSelect').hide();
		if(auto_select) {
			set(auto_select);
		}
	}

	init();
}

$.fn.mSelect = function(json) {

	var select = $(this),
		select_text = select.attr('data-text'),
		styledSelect;

	var options = {};

	$(document).on('click', '.select-line, .select-btn', clickDialog);
	$(document).on('click', '.select-list li', function(){
		addElement($(this).attr('data-value'));
	});
	$(document).on('click', '.selected-list li', function(){
		removeElement($(this).attr('data-value'));
	});

	function gainOptions() {
		if(json) {
			$.each(json.items, function(index, value){
				options[value] = value;
				select.append('<option value="' + value + '">' + value);
			});

		} else {
			select.find('option').each(function(){
				var option = $(this);

				options[option.attr('value')] = option.text();
			});
		}
	}

	function setHTML() {
		gainOptions();

		var options_str = '';
		$.each(options, function(index, value){
			options_str += '<li data-value="' + index + '"><div>' + value + '</div>';
		});

		var str = '';
		str += '<div class="multiple-select"><span class="select-btn"></span>';
			str += '<div class="select-line">' + select_text + '</div>';
	        str += '<ul class="select-list">';
	        	str += options_str;
	        str += '</ul>';
	        str += '<ul class="selected-list">';
	        str += '</ul>';
        str += '</div>';

        select.parent().append(str);
        select.hide();
	}

	function clickDialog() {
		styledSelect.toggleClass('open');
	}

	function closeDialog() {
		styledSelect.removeClass('open');
	}

	function removeElement(value) {
		styledSelect.find('.selected-list li[data-value="' + value + '"]').remove();
		styledSelect.find('.select-list').append('<li data-value="' + value + '"><div>' + options[value] + '</div>');
		select.find('option[value="' + value + '"]').removeAttr('selected');
		if(styledSelect.find('.selected-list li').length == 0) {
			styledSelect.removeClass('selected');
		}
	}

	function addElement(value) {
		styledSelect.addClass('selected');
		styledSelect.find('.select-list li[data-value="' + value + '"]').remove();
		styledSelect.find('.selected-list').append('<li data-value="' + value + '">' + options[value]);
		select.find('option[value="' + value + '"]').attr('selected', 'selected');
		closeDialog();
	}

	function init() {
		setHTML();
		styledSelect = select.parent().find('.multiple-select');
		//$('.select-list').hide();
		//$('.selected-list').hide();
	}

	init();
}
//$('.js-mSelect').mSelect();

$.fn.PopUp = function() {
	var parent = $(this);
	var openFlag = false;

	//open('order-present');

	function open(name) {
		openFlag = true;
		$('html').css('overflow', 'hidden');
		var popup = $('.popups').find('[data-popup="' + name + '"]');
		var popus_cont = popup.parent();
		popus_cont.show();
		popup.addClass('active');

		setTimeout(function(){
			popus_cont.css('opacity', 1);
		}, 50);
	}

	function close() {
		openFlag = false;
		$('html').css('overflow', 'visible');
		var popup = $('.popups .popup.active');
		var popus_cont = popup.parent();
		popus_cont.css('opacity', 0);
		setTimeout(function(){
			popus_cont.hide();
			popup.removeClass('active');
		}, 200);
	}

	$(document).on('click', '.js-popup-open', function(){
		open($(this).attr('data-popup'));
		return false;
	});

	$(document).on('click', '.js-popup-close', function(){
		close();
		return false;
	});

	$(document).on('click', '.popup', function(e){
		e.stopPropagation();
	});

	$(document).on('click', function(){
		if(openFlag) {
			close();
		}
	});
}

$.fn.news_page = function() {
	var desc = $('.js-fotorama-desc');
    var fotorama_settings = {
        loop: true,
        arrows: false,
        nav: false,
        fit: 'contain'
    };
    var $fotoramaDiv = $('.js-news-fotorama').fotorama(fotorama_settings);
    var fotorama = $fotoramaDiv.data('fotorama');

    $('.fotorama').on('fotorama:show', function (e, fotorama, extra) {
			changeFrame(fotorama.activeIndex);
		}
	);

	$(document).on('click', '.js-fotorama-control', function(){
		fotorama.show($(this).attr('data-direction'));
		return false;
	});

	function setRelative() {
		var relative_height = $('.js-relative-in').outerHeight(true);
		var news_height = $('.js-news-one').outerHeight(true);

		if(relative_height > news_height) {
			$('.js-relative-in .js-one-relative').last().remove();
			setRelative();
		} else {
			$('.js-relative-news').addClass('active');
		}
	}

	function changeFrame(id) {
		desc.eq(id).show()
			.siblings().hide();
	}

    function init() {
    	desc.first()
    		.siblings().hide();

    	setRelative();
    }

    init();
}

$.fn.news_module = function(news_array, tags_object) {
	var first_news = {},
		other_news = [];

	var default_min_date = '1999-12-31',
		default_max_date = '2999-12-31';

	var step = 0;

	$(document).on('news::update', function(){
		newsUpdate();
	});

	$(document).on('click', '.js-tags li', function(){
		tagsClick($(this).attr('data-filter'));
	});

	$(document).on('click', '.js-apply-filter', function(){
		$(document).trigger('news::update');
		return false;
	});

	$(document).on('click', '.search-date', function(){
		$(this).find('input').trigger('focus');
	});

	var news_html = {
		getFirst: function(obj) {
			var out_obj = this.objOut(obj);
			var str = '';
			var first_part = '';
			var second_part = '';
			
			second_part += 	'<div class="grid_4 omega js-news-item">';
			if(!obj.image) {
				second_part += 	'<div class="news-date"><span class="day">' + out_obj.day + '</span> / ' + out_obj.month + ' / ' + out_obj.year + '</div>';
			}
			second_part +=		'<a href="' + obj.href + '" class="title">' + obj.title + '</a>'+
		                        '<ul class="tags-ul">' + out_obj.tag_list + '</ul>'+
		                    '</div>';

            first_part += 	'<div class="grid_4 alpha">';
			first_part += 	'<a href="' + obj.href + '" class="news-photo" style="background-image: url(' + obj.image + ');">';
			first_part += 			'<span class="news-date"><span class="day">' + out_obj.day + '</span> / ' + out_obj.month + ' / ' + out_obj.year + '</span>'+
		                        '</a>'+
		                    '</div>';

            if(obj.image) {
            	str += first_part;
            	str += second_part;
            } else {
            	str += second_part;
            	//str += first_part;
            }

            return str;
		},

		fillFirst: function(obj) {
			var str = this.getFirst(obj);
			$('.js-news-first').html(str);
		},

		fillNothing: function() {
			var str = '';
			str += '<div class="no-news">По выбранным критериям не найдено новостей. Попробуйте изменить параметры фильтра</div>';
			$('.js-news-first').html(str);
			$('.js-news-grid').html('');
		},

		getOther: function(obj) {

			var out_obj = this.objOut(obj);
			var date_str = '<span class="news-date"><span class="day">' + out_obj.day + '</span> / ' + out_obj.month + ' / ' + out_obj.year + '</span>';
			var img_str = '<a href="' + obj.href + '" class="news-photo" style="background-image: url(' + obj.image + ');">';

			var date_without_image = '';
			var date_with_image = '';

			if(!obj.image) {
				img_str = '';
				date_without_image = date_str;
			} else {
				date_with_image = date_str;
			}

			var str = '<div class="news-item js-news-item">'+
                        	img_str +
                            date_with_image +
                        '</a>'+
                        '<div class="news-preview">'+
                        	date_without_image +
                            '<a href="' + obj.href + '" class="title">' + obj.title + '</a>'+
                        '</div>'+
                        '<ul class="tags-ul">' + out_obj.tag_list + '</ul>'+
                        '<div class="clearfix"></div>'+
                    '</div>';

           	return str;
		},

		getAllOthers: function(allObj) {
			var parent = this;
			var grids = ['', '', ''];
			step = 0;
			$.each(allObj, function(index, value){
				grids[step] += parent.getOther(value);
				step++;
				if(step == 3) step = 0;
			});

			return grids;
		},

		fillGrids: function(obj) {
			var toGrids = this.getAllOthers(obj);
			var i = 0;
			for(i; i < 3; i++) {
				$('.js-news-grid').eq(i).html(toGrids[i]);
			}
		},

		objOut: function(obj) {
			var objDate = new Date(obj.date);

			var day = ("0" + objDate.getDate()).slice(-2);
            var month = ("0" + (objDate.getMonth() + 1)).slice(-2);

			var year = objDate.getFullYear();

			var tag_list = '';
			$.each(obj.tags, function(index, value){
				tag_list += '<li class="tag-' + value + '">' + tags_object[value];
			});

			return {
				day: day,
				month: month,
				year: year,
				tag_list: tag_list
			}
		}
	}

	function init() {
		var tags_str = '<li class="tag-all" data-filter="all">Все';
		$.each(tags_object, function(index, value){
			tags_str += '<li class="tag-' + index + '" data-filter="' + index + '">' + value;
		});
		$('.js-tags').html(tags_str);

		var init_settings = {
			tags: [], 
			date: [default_min_date, default_max_date]
		}

		setNews(init_settings);
	}

	function tagsClick(type) {
		if(type != 'all') {
			$('.js-tags li[data-filter="' + type + '"]').toggleClass('active');
			var all_active = true;
			$('.js-tags li').not('[data-filter=all]').each(function(){
				if(!$(this).hasClass('active')) {
					all_active = false;
				}
			});

			if(all_active) {
				$('.js-tags li[data-filter=all]').addClass('active');
			} else {
				$('.js-tags li[data-filter=all]').removeClass('active');
			}
		} else {
			$('.js-tags li').addClass('active');
		}
	}

	function newsUpdate() {
		tags_array = [];
		$('.js-tags li.active').each(function(){
			var tag = $(this).attr('data-filter');
			tags_array.push(tag);
		});

		var date_range = {
			min: $('.js-date-range .js-date-from').val(),
			max: $('.js-date-range .js-date-to').val(),
		}

		if(date_range.min == "") date_range.min = default_min_date;
		if(date_range.max == "") date_range.max = default_max_date;

		setNews({
			tags: tags_array,
			active_tags: tags_array,
			date: [date_range.min, date_range.max]
		});
	}

	function getNews(settings) {
		var ready_array = [];

		$.each(news_array, function(index, value){
            value.date = new Date(value.date);
			var news_date = value.date.getTime();
			var date = {
				min: new Date(settings.date[0]).getTime() - 1,
				max: new Date(settings.date[1]).getTime() + 1
			}
			if(news_date > date.min && news_date < date.max) {
				var toArray = true;
				$.each(settings.tags, function(tag_index, tag){
					if(!inArray(tag, value.tags)) {
						toArray = false;
					}
				});
				
				if(toArray) {
					ready_array.push(value);
				}
			}
		});

		return ready_array;
	}

	function sortNews(settings) {
		var noSortArray = getNews(settings);
		var sortArray = noSortArray.sort(function(a,b){
			return new Date(b.date) - new Date(a.date);
		});

		first_news = (sortArray.splice(0, 1))[0];
		other_news = sortArray;
	}

	function setNews(settings) {
		if(settings.active_tags == undefined) settings.active_tags = [];

		sortNews(settings);

		if(first_news == undefined){
			news_html.fillNothing();
			$('.js-news-all').hide();
			return;
		} else {
			$('.js-news-all').show();
		}

		news_html.fillFirst(first_news);
		news_html.fillGrids(other_news);

		$.each(settings.active_tags, function(index, value){
			$('.js-news-item .tag-' + value).addClass('active');
		});
	}

	init();
}

$.fn.simple_filter = function(block_parent, default_filter) {
	var parent = $(this),
		blocks = $(block_parent).find('[data-filter]'),
		links = '.js-filters [data-filter]';

	$(document).on('click', '.js-filters [data-filter]', function(){
		var filter = $(this).attr('data-filter');
		go(filter);

		return false;
	});

	function init() {
		var hash = window.location.hash.replace('#','');
		if(hash) {
			go(hash);
		} else {
			go(default_filter);
		}

		$(links).each(function(){
			var type = $(this).attr('data-filter');
			var amount = $(block_parent).find('[data-filter="' + type + '"]').length;
			if(type == 'all') amount = blocks.length;

			$(this).find('.js-amount').text(amount);
		});
	}

	function go(filter) {
		window.location.hash = '#' + filter;
		$('.js-filters [data-filter]').removeClass('active');
		$('.js-filters [data-filter="' + filter + '"]').addClass('active');

		if(filter == 'all') {
			blocks.show();
			return;
		}

		var toshow = $(block_parent).find('[data-filter="' + filter + '"]');

		blocks.hide();
		toshow.show();
	}

	init();
}

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

	$(window).on('resize', function(){
		setMinHeight();
	});

	function init() {
		setMinHeight();
		slides.each(function(){
			dots_list.append('<li>');
		});
		go(0);
		setTimeout(function(){
			auto(change_time);
		}, change_time);
	}

	function setMinHeight() {
		var max = 0;
		slides.each(function(){
			var height = $(this).outerHeight(true);
			if(height > max) {
				max = height;
			}
		});
		parent.css('height', max);
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
		//go(dir);

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

$.fn.solutions_touch = function() {
	var parent = $(this);
	if (Modernizr.touch) {
		parent.on('click', function(){
			var url = parent.find('.hover-content .title-btn').attr('href');
			window.location.href = url;
		});
	}
}

$.fn.netrika_slider = function() {
	$(this).each(function(){
		var parent = $(this);
		var slides_length = parent.find('.js-slide').length;
		var slider_window = parent.find('.js-slider-window');
		var arrows = parent.find('.js-netrika-control');
		var dot_container = parent.find('.js-netrika-dots');
		var dots;

		arrows.on('click', function(){
			if($(this).hasClass('disable')) return false;

			if($(this).attr('data-direction') == '>') {
				goto(active_slide + 1);
			} else {
				goto(active_slide - 1);
			}
			return false;
		});

		dot_container.on('click', '.js-netrika-dot', function(){
			goto($(this).index());
			$(this).addClass('active')
				.siblings().removeClass('active');
			return false;
		});

		var goto = function(id) {
			var step = parent.find('.js-netrika-slider').width();
			slider_window.attr('style', transform('translateX(' + (id * step *(-1)) + 'px)'));
			active_slide = id;
			setArrows();
		}

		var setArrows = function() {
			if(active_slide == 0) {
				arrows.first().addClass('disable');
			} else {
				arrows.first().removeClass('disable');
			}

			if(active_slide+1 == slides_length) {
				arrows.last().addClass('disable');
			} else {
				arrows.last().removeClass('disable');
			}
		}

		var init = function() {
			active_slide = 0;
			setArrows();
			if(slides_length <= 1) {
				arrows.hide();
			}

			if(dot_container.length && slides_length != 1) {
				for(var i = 0; i < slides_length; i++) {
					dot_container.append('<li class="js-netrika-dot"></li>');
				}
				parent.find('.js-netrika-dot').first().addClass('active');
			}
		}

		init();
	});
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

		if($(window).width() <= 768) {
			openDesc(0);
		}
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

		setTimeout(function(){
			$('.main-nav').addClass('loaded');
		}, 250);
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

	$(window).on('load', init);

	$(document).on('click', '.menu-icon', function(){
		controlMenu();
	});
}

$.fn.canvas_draw = function(array) {

	if(!array) {
		array = [];
		var i = 0;

		for(i; i < 3; i++) {
			array[i] = parseInt($('.main-stat .js-perc').eq(i).text());
		}

	} else

	if(isNaN(array[0])) {
		return;
	}

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
		max_left = $('.stat-items').width() - $('.js-slider-parent').width();

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
				//arrow.enable(left_arrow);
			}

			if( ifLeft ) {
				//arrow.enable(right_arrow);
			}

			left_pos = left_pos + step;
			block.css('left', left_pos);
			slider.setArrows(left_pos, item.last().outerWidth(true), ifLeft, ifRight);
		},

		goNext: function() {
			var next = $('.js-tab-link.active').next();
			if(next.length) {
				next.trigger('click');
			}
			var new_next = $('.js-tab-link.active').next();
			if(!new_next.length) {
				$('.js-stat-mobile-ctr').each(function(){
					$(this).find('a').last().addClass('disable');
				});
			} else {
				$('.js-stat-mobile-ctr').each(function(){
					$(this).find('a').last().removeClass('disable');
				});
			}

			$('.js-stat-mobile-ctr').each(function(){
				$(this).find('a').first().removeClass('disable');
			});
		},

		goPrev: function() {
			var prev = $('.js-tab-link.active').prev();
			if(prev.length) {
				prev.trigger('click');
			}
			var new_prev = $('.js-tab-link.active').prev();
			if(!new_prev.length) {
				$('.js-stat-mobile-ctr').each(function(){
					$(this).find('a').first().addClass('disable');
				});
			} else {
				$('.js-stat-mobile-ctr').each(function(){
					$(this).find('a').first().removeClass('disable');
				});
			}

			$('.js-stat-mobile-ctr').each(function(){
				$(this).find('a').last().removeClass('disable');
			});
		},

		setArrows: function(left_pos, step, ifLeft, ifRight) {
			var check_width = parseInt(parent.find('.stat-items').css('width')) - $('.js-slider-parent').width() - step;

			if(left_pos == 0) {
				arrow.disable(left_arrow);
			} else {
				arrow.enable(left_arrow);
			}
			if(check_width <= Math.abs(parseInt(parent.find('.stat-items').css('left'))) + step) {
				arrow.disable(right_arrow);
			}

			if(ifLeft) {
				arrow.enable(right_arrow);
			}
		}
	}

	right_arrow.on('click', function(){
		if($(this).hasClass('disable')) return false;
		slider.go('>');
		return false;
	});
	left_arrow.on('click', function(){
		if($(this).hasClass('disable')) return false;
		slider.go('<');
		return false;
	});

	$('.js-stat-mobile-ctr').on('click', 'a', function(){
		var dir = $(this).attr('data-direction');
		if(dir == '>') {
			slider.goNext();
		} else {
			slider.goPrev();
		}
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

	$(window).on('resize', setMinHeight);
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

$.fn.ext_url = function() {
	$(this).each(function(){
		var link = $(this);
		if(isExternal(link.attr('href'))) {
			link.addClass('ext-link').attr('target', '_blank');
		}
	});
}

$.fn.mobile_menu = function() {
	var menu = $(this);
	var opened = false;

	$('.js-menu-mobile-open').on('click', function(){
		menuToggle();
	});

	function menuToggle() {
		if(opened) {
			menuClose();
		} else {
			menuOpen();
		}
	}

	function menuOpen() {
		opened = true;
		menu.addClass('active');
		$('.js-menu-mobile-open').addClass('active');
	}

	function menuClose() {
		opened = false;
		menu.removeClass('active');
		$('.js-menu-mobile-open').removeClass('active');
	}
}

$.fn.setHeightOfMax = function(block) {
	var parent = $(this);
	var max = 0;
	var this_block = parent.find(block);

	this_block.each(function(){
		var height = $(this).outerHeight();
		if(height > max) {
			max = heigth;
		}
	});

	this_block.css('height', max);
}

$('.mobile-menu').mobile_menu();
$('a[href]').ext_url();
$('.js-hover').jshover('js-circle');
$('.main-nav').header_nav();
$('.popups').PopUp();
$('input[name=phone]').mask('(000) 000-0000');

function transform(transform_value) {
	var prefixes = ['-webkit-', '-ms-', ''];
	var str = '';

	$.each(prefixes, function(index, value){
		var new_str = value + 'transform: ' + transform_value + '; ';
		str += new_str;
	});

	return str;
}

function inArray(value, array) {
  return array.indexOf(value) > -1;
}

function isExternal(url) {
    var match = url.match(/^([^:\/?#]+:)?(?:\/\/([^\/?#]*))?([^?#]+)?(\?[^#]*)?(#.*)?/);
    if (url.slice(0,7) == 'mailto:' || url.slice(0, 4) == 'tel:') return false;
    if (typeof match[1] === "string" && match[1].length > 0 && match[1].toLowerCase() !== location.protocol) return true;
    if (typeof match[2] === "string" && match[2].length > 0 && match[2].replace(new RegExp(":("+{"http:":80,"https:":443}[location.protocol]+")?$"), "") !== location.host) return true;
    return false;
}



$(document).ready(function() {

    $(".popup.order-present form").validate({
        rules: {
            'solution_id': "required",
            'name': "required",
            'email': { required: true, email: true },
            'comment': "required",
        },
        messages: {
            'solution_id': "",
            'name': "",
            'email': "",
            'comment': "",
        },
        errorClass: "inp-error",
        submitHandler: function(form) {
            //console.log(form);
            sendOrderForm(form);
            return false;
        }
    });

    function sendOrderForm(form) {

        //console.log(form);

        var options = { target: null, type: $(form).attr('method'), dataType: 'json' };

        options.beforeSubmit = function(formData, jqForm, options){
            $(form).find('button').addClass('loading').attr('disabled', 'disabled');
            $(form).find('.error-msg').text('');
            //$('.error').text('').hide();
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
                $(form).find('button').addClass('success').text('Отправлено');
                $(form).find('.popup-body').slideUp(function(){
                    setTimeout(function(){ $('.popup .js-popup-close').trigger('click'); }, 3000);
                });

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
            $(form).find('button').removeAttr('disabled');
            $(form).find('.error-msg').text('Ошибка при отправке, попробуйте позднее');
        }

        options.complete = function(data, textStatus, jqXHR){
            $(form).find('button').removeClass('loading');
        }

        $(form).ajaxSubmit(options);
    }

});
