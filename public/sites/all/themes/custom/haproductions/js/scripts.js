(function ($, Drupal) {

  Drupal.behaviors.haproductions = {
    attach: function(context, settings) {
    	$('#site-theme',context).bind('click',function(e){
    		e.preventDefault();
    		$body = $('body');
    		if($body.hasClass('light')){
    			$body.removeClass('light').addClass('dark');
    		}
    		else{
    			$body.removeClass('dark').addClass('light');
    		}
    	});
    }
  };

})(jQuery, Drupal);
