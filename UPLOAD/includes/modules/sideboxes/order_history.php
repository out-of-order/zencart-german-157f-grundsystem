<?php
/**
 * order_history sidebox - if enabled, shows customers' most recent orders
 *
 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: order_history.php 2022-01-11 16:00:16Z webchills $
 */

if (!zen_is_logged_in() || zen_in_guest_checkout()) {
    return;
}
// retrieve the last x products purchased
// @TODO - future enhancement could be to weight the results by frequency of times a product has been purchased
$sql = "SELECT op.products_id, max(date_purchased) as date_purchased
        FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p
        WHERE o.customers_id = " . (int)$_SESSION['customer_id'] . "
        AND o.orders_id = op.orders_id
        AND op.products_id = p.products_id
        AND p.products_status = 1
        GROUP BY products_id
        ORDER BY date_purchased desc, products_id
        LIMIT " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX;

$results = $db->Execute($sql);

if ($results->RecordCount() === 0) {
    return;
}

foreach($results as $result) {
    $customer_orders[] = [
        'id' => $result['products_id'],
        'name' => zen_get_products_name($result['products_id']),
    ];
}

require($template->get_template_dir('tpl_order_history.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_order_history.php');
$title = BOX_HEADING_CUSTOMER_ORDERS;
$title_link = false;
require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base, 'common') . '/' . $column_box_default);
