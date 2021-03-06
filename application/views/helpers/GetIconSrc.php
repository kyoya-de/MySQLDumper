<?php
/**
 * This file is part of MySQLDumper released under the GNU/GPL 2 license
 * http://www.mysqldumper.net
 *
 * @package         MySQLDumper
 * @subpackage      View_Helpers
 * @version         SVN: $Rev$
 * @author          $Author$
 */

/**
 * Get img source
 *
 * @package         MySQLDumper
 * @subpackage      View_Helpers
 */
class Msd_View_Helper_GetIconSrc  extends Zend_View_Helper_Abstract
{
    /**
     * Get path of an image
     *
     * @param string $name
     * @param int    $size
     *
     * @return string
     */
    public function getIconSrc($name, $size='')
    {
        static $baseUrl = false;
        if (!$baseUrl) {
            $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        }
        $icons = self::_getIconFilenames();
        if (!isset($icons[$name])) {
            throw new Msd_Exception(
                'GetIconSrc: unknown icon \''.$name . '\' requested'
            );
        }
        $config = Msd_Registry::getConfig();
        $img = $baseUrl.'/%s/%s';
        if ($size>'') {
            $img = $baseUrl.'/%s/%sx%s/%s';
            $ret = sprintf(
                $img,
                $config->getParam('paths.iconPath'),
                $size,
                $size,
                $icons[$name]
            );
        } else {
            $ret = sprintf(
                $img, $config->getParam('paths.iconPath'), $icons[$name]
            );
        }
        return $ret;
    }

    /**
     * Get default values from defaultConfig.ini
     *
     * @return object
     */
    private function _getIconFilenames ()
    {
        static $icons = false;
        if (!$icons) {
            $config = Msd_Registry::getConfig();
            $file = realpath(
                APPLICATION_PATH . '/../public/'
                . $config->getParam('paths.iconPath') . '/icon.ini'
            );
            $iconsIni = new Zend_Config_Ini($file, 'icons');
            $icons = $iconsIni->toArray();
            unset($iconsIni);
        }
        return $icons;
    }

}
