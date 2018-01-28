(function($){
	 $('#qtype').on('click', 'button', function(event){
	    var sel = $(this).data('title');
	    var tog = $(this).data('toggle');
	    $(this).siblings('input[type="hidden"]').prop('value', sel);
	    console.log($(this).siblings());
	    $(this).siblings('button').removeClass('active');
	    $(this).addClass('active');
	 });

	 $('#addoption').on( 'click', function(event) {
	 	event.preventDefault();
	 	var element = $('.option-input').first();
	 	var length = $('.option-input').length;
	 	var clone = element.clone();
	 	clone.find('input[type="checkbox"]').prop( 'checked', false).val( length );
	 	clone.find('textarea').prop('name', 'options['+ length +']').val('');
	 	clone.removeClass('option-0').addClass( "option-"+ length).appendTo('#qoption table tbody');
	 	//element.after(clone);

	 	//$('.option-input').clone().appendTo('#qoption table tbody').removeAttr('value');
	 });
	 $('#qoption').on('click', '.remove', function(event){
	 	event.preventDefault();
	 	var element = $(this).closest('.option-input');
	 	element.remove();
	 })
})(jQuery);