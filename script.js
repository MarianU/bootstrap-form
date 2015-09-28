$(function ()
{
	$('[data-toggle="tooltip"]').tooltip();
	$('.email-encoded').each(function(){$(this).html(atob($(this).html()));});
	$('form[name=contact]').submit(function(event){
		$('.has-error', this).removeClass('has-error');
		if($('[name=name]', this).val().length < 2)
		{
			$('[name=name]', this).parent().addClass('has-error');
			event.preventDefault();
		}
		if($('[name=message]', this).val().length < 5)
		{
			$('[name=message]', this).parent().addClass('has-error');
			event.preventDefault();
		}
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(!re.test($('[name=email]', this).val()))
		{
			$('[name=email]', this).parent().addClass('has-error');
			event.preventDefault();
		}
		focusInput();
	});
	focusInput();
});

function focusInput()
{
	var errorFields = $('.has-error input, .has-error textarea, .has-error select');
	if(errorFields.length > 0)
	{
		$(errorFields.get(0)).focus();
	}
	else
	{
		$($('input').get(0)).focus();
	}
}

