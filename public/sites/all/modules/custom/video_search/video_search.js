/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {


  Drupal.behaviors.video_search = {
    attach: function (context, settings) {
    	$('#video-quicksearch-form #edit-search',context).typeWatch({
    		callback: function(value) {
    			$('#video-quicksearch-form #edit-submit').mousedown();
    			$('#video-quicksearch-form #edit-search').prop('disabled',true);
    		},
    		captureLength: 3
    	});

		var $videos = $('.node-video.view-mode-search_result',context);

		if($videos.length > 0){
          if($('#video-quicksearch-results',context).length > 0){
            $('#video-quicksearch-results',context).masonry({ columnWidth: 256, gutter: 20});
          }
          else{
           $(context).masonry({ columnWidth: 256, gutter: 20});
          }
          
          $videos.each(function(){
            $slideshow = $('.field-name-field-images .field-items',this);
            $slideshow.cycle({
                log: false,
                slides: '.field-item',
              });

            $('.overlay',this).bind('click',function(){
              $('a',this)[0].click();
            });
          });
    	}

      $.fn.enable_search = function() {
      	$(this).prop('disabled',false);
      };

    }
  };


})(jQuery, Drupal, this, this.document);
