<?php

/**
 * AppserverIo\Apps\Magento\Provisioning\Steps\PrepareDatabaseStep
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
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Magento\Provisioning\Steps;

use AppserverIo\Appserver\Provisioning\Steps\AbstractDatabaseStep;

/**
 * An step implementation that creates a database based on the specified datasource.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class PrepareDatabaseStep extends AbstractDatabaseStep
{

    /**
     * Executes the functionality for this step, in this case the execution of
     * the PHP script defined in the step configuration.
     *
     * @return void
     * @throws \Exception Is thrown if the script can't be executed
     * @see \AppserverIo\Appserver\Core\Provisioning\StepInterface::execute()
     */
    public function execute()
    {

        try {
            // log a message that provisioning starts
            $this->getApplication()->getInitialContext()->getSystemLogger()->info(
                'Now start to create database!'
            );

            // load the datasource node
            /** @var \AppserverIo\Appserver\Core\Api\Node\DatabaseNode $databaseNode */
            $databaseNode = $this->getDatasourceNode()->getDatabase();

            // load the connection data
            $user = $databaseNode->getUser();
            $db = $databaseNode->getDatabaseName();
            $host = $databaseNode->getDatabaseHost();
            $password = $databaseNode->getPassword();

            // create the connection
            $dbh = new \PDO(sprintf('mysql:host=%s', $host), 'root');

            // execute the statement
            $dbh->exec("CREATE DATABASE `$db`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$password';
                GRANT ALL ON `$db`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;");

            // log a message that provisioning has been successfull
            $this->getApplication()->getInitialContext()->getSystemLogger()->info(
                'Successfully created database!'
            );

        } catch (\Exception $e) {
            $this->getApplication()->getInitialContext()->getSystemLogger()->error($e->__toString());
        }
    }
}
