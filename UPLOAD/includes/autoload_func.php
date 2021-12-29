<?php
/**
 * File contains the autoloader loop
 * 
 * The autoloader loop takes the array from the auto_loaders directory
 * and uses this this to constuct the InitSysytem. 
 * see {@link http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem} for more details.
 *
 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: autoload_func.php 2021-11-29 21:25:16Z webchills $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$debugAutoload = false;
if (defined('DEBUG_AUTOLOAD') && DEBUG_AUTOLOAD == true) $debugAutoload = true;
if ($debugAutoload) print_r($initSystemList);
foreach ($initSystemList as $entry) {
    switch ($entry['type']) {
        case 'include':
            if ($entry['forceLoad']) {
                if ($debugAutoload) echo 'case "include": ' . $entry['filePath'] . "<br>\n";
                include $entry['filePath'];
            } else {
                if ($debugAutoload) echo 'case "include_once": ' . $entry['filePath'] . "<br>\n";
                include_once $entry['filePath'];
            }
            break;
        case 'require':
            if ($entry['forceLoad']) {
                if ($debugAutoload) echo 'case "require": ' . $entry['filePath'] . "<br>\n";
                require $entry['filePath'];
            } else {
                if ($debugAutoload) echo 'case "require_once": ' . $entry['filePath'] . "<br>\n";
                require_once $entry['filePath'];
            }
            break;
        case 'class':
            if ($debugAutoload) echo 'case "class": ' . $entry['class'] . "<br>\n";
            $objectName = $entry['object'];
            $className = $entry['class'];
            $$objectName = new $className();
            break;
        case 'sessionClass':
            if ($debugAutoload)  'case "sessionClass": ' . $entry['class'] . "<br>\n";
            $objectName = $entry['object'];
            $className = $entry['class'];
            if (!$entry['checkInstantiated'] || !isset($_SESSION[$objectName])) {
                $_SESSION[$objectName] = new $className();
            }
            break;
        case 'objectMethod':
            if ($debugAutoload) echo 'case "objectMethod": ' . '$entry[\'method\']=' . $entry['method'] . ', $entry[\'object\']=' . $entry['object'] . "<br>\n";
            $objectName = $entry['object'];
            $methodName = $entry['method'];
              if (isset($_SESSION[$objectName]) && is_object($_SESSION[$objectName])) {
                  $_SESSION[$objectName]->$methodName();
              } else {
                  ${$objectName}->$methodName();
              }
            break;
    }
}
