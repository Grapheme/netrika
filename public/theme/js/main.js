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

