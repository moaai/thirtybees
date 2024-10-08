<?php
/**
 * 2007-2016 PrestaShop
 *
 * thirty bees is an extension to the PrestaShop e-commerce software developed by PrestaShop SA
 * Copyright (C) 2017-2024 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.thirtybees.com for more information.
 *
 *  @author    thirty bees <contact@thirtybees.com>
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2017-2024 thirty bees
 *  @copyright 2007-2016 PrestaShop SA
 *  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  PrestaShop is an internationally registered trademark & property of PrestaShop SA
 */

/**
 * Class InstallControllerConsole
 */
class InstallControllerConsole
{
    /**
     * @param int $argc
     * @param string[] $argv
     *
     * @throws PrestaShopException
     * @throws PrestaShopDatabaseException
     * @throws PrestashopInstallerException
     */
    final public static function execute($argc, $argv)
    {
        // process command lines parameters
        $datas = new Datas();
        if (!($argc-1)) {
            $availableArguments = $datas->getArgs();
            echo 'Arguments available:'."\n";
            foreach ($availableArguments as $key => $arg) {
                $name = $arg['name'] ?? $key;
                echo '--'.$name."\t".($arg['help'] ?? '').(isset($arg['default']) ? "\t".'(Default: '.$arg['default'].')' : '')."\n";
            }
            exit;
        }

        $errors = $datas->getAndCheckArgs($argv);
        if ($datas->showLicense) {
            echo strip_tags(file_get_contents(_TB_INSTALL_PATH_.'theme/views/license_content.phtml'));
            exit;
        }

        if ($errors !== true) {
            if (count($errors)) {
                foreach ($errors as $error) {
                    echo $error."\n";
                }
            }
            exit;
        }

        // run installation process
        $process = new InstallControllerConsoleProcess($datas);
        $process->process();
    }

}
