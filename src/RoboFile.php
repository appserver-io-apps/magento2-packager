<?php

/**
 * RoboFile.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2017 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io-apps/magento2-packager
 * @link      http://www.appserver.io
 */

use Robo\Tasks;

/**
 * Defines the available Magento 2 development tasks.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2017 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io-apps/magento2-packager
 * @link      http://www.appserver.io
 *
 * @SuppressWarnings(PHPMD)
 */
class RoboFile extends Tasks
{

    /**
     * Load the appserver.io base tasks.
     *
     * @var \AppserverIo\RoboTasks\Base\loadTasks
     */
    use AppserverIo\RoboTasks\Base\loadTasks;

    /**
     * The sync command implementation.
     *
     * @param string $src  The source directory
     * @param string $dest The destination directory
     *
     * @return void
     */
    public function sync($src, $dest)
    {
        $this->taskSync()->src($src)->dest($dest)->run();
    }

    /**
     * Deploy's the extension to it's target directory.
     *
     * @param string $src  The source directory
     * @param string $dest The destination directory
     *
     * @return void
     */
    public function deploy($src, $dest)
    {
        $this->taskCopyDir(array($src => $dest))->run();
    }
}
