<?php
/**
 * Zen Cart German Specific
 
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: PageLoader.php 2021-12-25 08:14:24Z webchills $
 */

namespace Zencart\PageLoader;

class PageLoader
{
    public function __construct(array $installedPlugins, $mainPage, $fileSystem)
    {
        $this->installedPlugins = $installedPlugins;
        $this->mainPage = $mainPage;
        $this->fileSystem = $fileSystem;
    }
   
    public function findModulePageDirectory()
    {
        if (is_dir(DIR_WS_MODULES . 'pages/' . $this->mainPage)) {
            return DIR_WS_MODULES . 'pages/' . $this->mainPage;
        }
        foreach ($this->installedPlugins as $plugin) {
            $checkDir = 'zc_plugins/' . $plugin['unique_key'] . '/' . $plugin['version'] . '/';
            $checkDir .= 'catalog/includes/modules/pages/' . $this->mainPage;
            if (is_dir($checkDir)) return $checkDir;
        }
        return false;
    }

    function getTemplatePart($pageDirectory, $templatePart, $fileExtension = '.php')
    {
        $directoryArray = array();
        $directoryArray = $this->getTemplatePartFromDirectory($directoryArray, $pageDirectory, $templatePart,
                                                              $fileExtension);

        
        sort($directoryArray);
        return $directoryArray;
    }

    public function getTemplatePartFromDirectory($directoryArray, $pageDirectory, $templatePart, $fileExtension)
    {
        if ($dir = @dir($pageDirectory)) {
            while ($file = $dir->read()) {
                if (!is_dir($pageDirectory . $file)) {
                    if (substr($file, strrpos($file, '.')) == $fileExtension && preg_match($templatePart, $file)) {
                        $directoryArray[] = $pageDirectory . '/'. $file;
                    }
                }
            }
            $dir->close();
        }
        return $directoryArray;
    }

    function getTemplateDir($templateCode, $currentTemplate, $currentPage, $templateDir)
    {
        if ($this->fileSystem->fileExistsInDirectory($currentTemplate . $currentPage, $templateCode)) {
            return $currentTemplate . $currentPage . '/';
        }
        if ($this->fileSystem->fileExistsInDirectory(
            DIR_WS_TEMPLATES . 'template_default/' . $currentPage, preg_replace('/\//', '', $templateCode))) {
            return DIR_WS_TEMPLATES . 'template_default/' . $currentPage;
        }
        if ($this->fileSystem->fileExistsInDirectory(
            $currentTemplate . $templateDir, preg_replace('/\//', '', $templateCode))) {
            return $currentTemplate . $templateDir;
        }
        if ($tplPluginDir = $this->getTemplatePluginDir($templateCode, $currentTemplate, $currentPage, $templateDir)) {
            return $tplPluginDir;
        }
        return DIR_WS_TEMPLATES . 'template_default/' . $templateDir;
    }

    public function getTemplatePluginDir($templateCode)
    {
      
        return false;
    }

    public function getBodyCode($currentPage)
    {
        if (file_exists(DIR_WS_MODULES . 'pages/' . $currentPage . '/main_template_vars.php')) {
            $bodyCode = DIR_WS_MODULES . 'pages/' . $currentPage . '/main_template_vars.php';
            return $bodyCode;
        }
        $bodyCode = $this->getTemplateDir(
                'tpl_' . preg_replace('/.php/', '', $_GET['main_page']) . '_default.php', DIR_WS_TEMPLATE, $currentPage, 'templates') . '/tpl_' . $_GET['main_page'] . '_default.php';
        return $bodyCode;
    }
}