(function($) {

	$(document).ready(function(){
		$('.radio-column').click(function(){
			$(this).find('input').prop('checked', true);
		})
	});

})(jQuery);