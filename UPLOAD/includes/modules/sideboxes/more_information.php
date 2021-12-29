<?php
/**
 * more_information sidebox - displays list of links to additional pages on the site.  Must separately build those pages' content.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: more_information.php 730 2020-01-17 14:49:16Z webchills $
 */

// initialize
$more_information = array();

// test if links should display
  if (DEFINE_PAGE_2_STATUS <= 1) {
    $more_information[] = '<a href="' . zen_href_link(FILENAME_PAGE_2) . '">' . BOX_INFORMATION_PAGE_2 . '</a>';
  }
  if (DEFINE_PAGE_3_STATUS <= 1) {
    $more_information[] = '<a href="' . zen_href_link(FILENAME_PAGE_3) . '">' . BOX_INFORMATION_PAGE_3 . '</a>';
  }
  if (DEFINE_PAGE_4_STATUS <= 1) {
    $more_information[] = '<a href="' . zen_href_link(FILENAME_PAGE_4) . '">' . BOX_INFORMATION_PAGE_4 . '</a>';
  }

// insert additional links below to add to the more_information box
// Example:
//    $more_information[] = '<a href="' . zen_href_link(FILENAME_DEFAULT) . '">' . 'TESTING' . '</a>';


// only show if links are active
  if (sizeof($more_information) > 0) {
    require($template->get_template_dir('tpl_more_information.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_more_information.php');

    $title =  BOX_HEADING_MORE_INFORMATION;
    $title_link = false;
    require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
  }
