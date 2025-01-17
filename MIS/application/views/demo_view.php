<style>
	body { 
		background: #D4F1F9;
		margin: 20px;
	}
	.ring1 { 
		position: absolute;
		left: 50%;
		user-select: none;
		background-image: url(/media/images/Ring1.jpg);
		background-size: 1000px 1000px;
		width: 1000px;
		height: 1000px;
		transform: translateX(-50%);
		border-radius: 50%;
	}
	.ring2 { 
		position: absolute;
		left: 50%;
		user-select: none;
		background-image: url(/media/images/Ring2.jpg);
		background-size: 812px 812px;
		width: 812px;
		height: 812px;
		margin-top: 96px;
		margin-left: 8px;
		transform: translateX(-50%);
		border-radius: 50%;
		cursor: pointer;
	}
</style>

<div style="height:850px">
	<div class="ring1"></div>
	<div class="ring2"></div>
</div>

<script src="/media/JavaScript/jquery-3.3.1.min.js"></script>
<script>
	var rotate = 0;
	var startX = 0;
	var startY = 0;
	var left = $('.ring2').offset().left;

	$('.ring2').on('mousedown', function (mousedown) {
		startX = mousedown.clientX;
		startY = mousedown.clientY;

		$(document).on('mousemove', function (mouse) {
			var x = (mouse.clientX - startX) / 5;
			var y = (mouse.clientY - startY) / 5;

			if (mouse.clientY + scrollY > 520) x *= -1;
			if (mouse.clientX - left < 410) y *= -1;

			rotate += x + y;
			if (Math.abs(rotate) > 359) rotate = 0;

			$('.ring2').css('transform', `translateX(-50%) rotate(${rotate}deg)`);

			startX = mouse.clientX;
			startY = mouse.clientY;
		});
	});

	$(document).on('mouseup', function () {
		$(document).off('mousemove');
	});
</script>