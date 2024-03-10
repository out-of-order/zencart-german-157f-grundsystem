<?php
/**
 * Initializes non-database constants that were previously set in language modules,
 * overridable via site-specific /init_includes processing.  See
 * /includes/init_includes/dist-init_site_specific_non_db_settings.php.
 *
 * Note: These settings apply to both the storefront and the admin!
 * Zen Cart German Specific (158 code in 157)
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: init_non_db_settings.php 2023-10-21 09:06:39Z webchills $
 */
// -----
// If the site has provided a set of overrides for these base values, they will
// be used.
//
$site_specific_non_db_settings = [];
if (is_file(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'init_includes/init_site_specific_non_db_settings.php')) {
    require DIR_FS_CATALOG . DIR_WS_INCLUDES . 'init_includes/init_site_specific_non_db_settings.php';
}

$non_db_settings = [
    // -----
    // Storefront settings.
    //
    'CART_SHIPPING_METHOD_ZIP_REQUIRED' => 'true',  //- Either 'true' or 'false'.  Used by tpl_modules_shipping_estimator.php

    // Shared - Storefront and Admin 
    'TOPMOST_CATEGORY_PARENT_ID' => '0',

    // -----
    // Admin settings.
    //
    'MAX_DISPLAY_RESTRICT_ENTRIES' => 10,           //- Note, an integer value!.  Used by /admin/coupon_restrict.php
    'WARN_DATABASE_VERSION_PROBLEM' => 'true',      //- Either 'true' or 'false'.  Used by /admin/init_includes/init_errors.php
];
$non_db_settings = array_merge($non_db_settings, $site_specific_non_db_settings);

foreach ($non_db_settings as $key => $value) {
    zen_define_default($key, $value);
}
