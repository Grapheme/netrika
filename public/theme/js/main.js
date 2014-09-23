$.fn.jshover = function(circ) {
	var element = $(this);
	var circle = $(this).find('.' + circ);

	function setCircle(e, elem) {
		var pos = {
			x: e.pageX - elem.offset().left,
			y: e.pageY - elem.offset().top
		}

		circle.css({
			'top': pos.y,
			'left': pos.x
		});

		console.log(element.offset());
	}

	element.on('mouseover', function(e){
		setCircle(e, $(this));
	});
}

$('.js-hover').jshover('js-circle');