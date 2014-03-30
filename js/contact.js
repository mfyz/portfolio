$(function(){
	$('.type_hi input, .type_job input').change(selectType);

	$('#contact').submit(function(){
		error = false;

		if( $('#name').val().length > 1 ){
			$('.name .error').hide();
		}else{
			$('.name .error').show();
			error = true;
		}

		if( $('#email').val().length > 5 ){
			$('.email .error').hide();
		}else{
			$('.email .error').show();
			error = true;
		}

		if( $('#type_hi').attr('checked') || $('#type_job').attr('checked') ){
			$('.type .error').hide();
		}else{
			$('.type .error').show();
			error = true;
		}

		if( $('#message').val().length > 1 ){
			$('.message .error').hide();
		}else{
			$('.message .error').show();
			error = true;
		}

		if( error ){
			return false;
		}
	});
});

function selectType(){
	if( $('#type_hi').attr('checked') ){
		$('.type_hi').addClass('active');
		$('.type_job').removeClass('active');
	}else{
		$('.type_hi').removeClass('active');
		$('.type_job').addClass('active');
	}
}