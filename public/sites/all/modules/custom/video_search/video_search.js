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

  		var $videos = $('.node-video.view-mode-search_result',context);

  		if($videos.length > 0){

          $videos.each(function(){
            var $slideshow = $('.field-name-field-images .field-items',this);
            $slideshow.cycle({
                log: false,
                slides: '.field-item'
              });

            $('.overlay',this).width($(this).width());

            $('.overlay',this).bind('click',function(){
              $('a',this)[0].click();
            });
          });

          $(window).resize(function(){
            $videos.each(function(){
              $('.overlay',this).width($(this).width());
            });
          });
    	}

      $('#search-videos').bind('click',function(e){
        e.preventDefault();
        if($('#edit-search').val() != ''){
          trigger_quicksearch();
        }
      });

      $('#show-all-videos').bind('click',function(){
        $('.node-video.view-mode-search_result').removeClass('search-result').removeClass('no-result');
        $('#video-quicksearch-results').isotope({
          filter: '*'
        });
        $('#video-quicksearch-form #edit-search').val('');
        $(this).hide();
        return false;
      });

      $('#video-quicksearch-form #edit-search').once(function(){
        if($(this).val() != ''){
          trigger_quicksearch();
        }
      });

      function trigger_quicksearch(){
        $('#video-quicksearch-form #edit-submit').mousedown();
        $('#video-quicksearch-form #edit-search').prop('disabled',true);
      }

      Drupal.ajax.prototype.commands.video_search_results = function(ajax,response,status){
        $('#video-quicksearch-form #edit-search').removeAttr('disabled').blur().focus();

        $videos = $('.node-video.view-mode-search_result');
        $videos.removeClass('search-result').addClass('no-result');
        $.each(response.data, function(key,value){
          $('#node-'+value).removeClass('no-result').addClass('search-result');
        });

        if($('.search-result').length){
          $('#show-all-videos').show();
        }
        else{
          $('#show-all-videos').click();
        }

      }

    }
  };

})(jQuery, Drupal, this, this.document);
