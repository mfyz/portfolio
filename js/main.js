$(function(){
	$(".no-selector").prettyPhoto({theme:'dark_rounded', modal:true, counter_separator_label: ' / '});

	$('.screenshot.link').css('cursor', 'pointer').click(function(){
		imagelist = $(this).attr('id');
		eval('$.prettyPhoto.open('+ imagelist +');');
	});
});
