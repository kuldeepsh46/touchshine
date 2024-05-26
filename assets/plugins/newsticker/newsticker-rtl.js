jQuery(document).ready(function($) {
	$('#newsticker1').breakingNews();
	//$('#newsTicker2').data('breakingNews').next();
	$('#newsticker2').breakingNews({
		direction: 'ltr'
	});
	$('#newsticker3').breakingNews({
		effect: 'slide-right'
	});
	$('#newsticker4').breakingNews({
		effect: 'typography'
	});
	$('#newsticker5').breakingNews({
		effect: 'fade',
	});
	$('#newsticker6').breakingNews({
		effect: 'slide-down',
		height: 50,
		fontSize: '18px'
	});
	$('#newsticker7').breakingNews({
		effect: 'slide-up'
	});
	$('#newsticker8').breakingNews({
		effect: 'typography',
		direction: 'ltr',
	});
	$('#newsticker9').breakingNews({
		effect: 'slide-left'
	});
	$('#newsticker10').breakingNews();
	$('#newsticker11').breakingNews({
		position: 'fixed-bottom',
		borderWidth: 3,
		height: 50,
	});
	$('#newsticker12').breakingNews();
});