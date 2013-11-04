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
          if($('#video-quicksearch-results',context).length > 0){
            $('#video-quicksearch-results',context).isotope({
              masonry: { 
                  columnWidth: 256,
                  gutterWidth: 20
              }
            });
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

        $('#video-quicksearch-results').isotope({
          filter: '.search-result'
        });

        $('#show-all-videos').show();
      }

    }
  };

  // modified Isotope methods for gutters in masonry
  $.Isotope.prototype._getMasonryGutterColumns = function() {
    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
        containerWidth = this.element.width();
  
    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
                  // or use the size of the first item
                  this.$filteredAtoms.outerWidth(true) ||
                  // if there's no items, use size of container
                  containerWidth;

    this.masonry.columnWidth += gutter;

    this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
    this.masonry.cols = Math.max( this.masonry.cols, 1 );
  };

  $.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getMasonryGutterColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
  };

  $.Isotope.prototype._masonryResizeChanged = function() {
    var prevSegments = this.masonry.cols;
    // update cols/rows
    this._getMasonryGutterColumns();
    // return if updated cols/rows is not equal to previous
    return ( this.masonry.cols !== prevSegments );
  };  

})(jQuery, Drupal, this, this.document);
