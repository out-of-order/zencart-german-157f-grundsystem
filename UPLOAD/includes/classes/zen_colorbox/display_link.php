<?php
/**
 * Zen Colorbox
 *
 * @author niestudio (daniel [dot] niestudio [at] gmail [dot] com)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: options.php 2012-04-30 niestudio $
 */
?>
  jQuery(function($) {
  // Link Information
  var displayLink = $('<?php echo $anchor; ?>');
  if (displayLink.length != 0) {
    var displayLinkUrl = displayLink.attr('href').match(/'(.*?)'/)[1];
    displayLink.attr({
      'href':'#'
    }).colorbox({
      'href':displayLinkUrl,
      width: '550px',
      onComplete: function(){
        $('#cboxLoadedContent').find('a[href*="window.close"]').closest('<?php echo $closenear; ?>').hide();
      }
    });
  }
});
