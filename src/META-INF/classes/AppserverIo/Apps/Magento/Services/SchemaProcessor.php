<?php

/**
 * AppserverIo\Apps\Magento\Services\SchemaProcessor
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
 * @link      https://github.com/appserver-io-apps/example
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Magento\Services;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\DBAL\Schema\SqliteSchemaManager;

/**
 * A singleton session bean implementation that handles the
 * schema data for Doctrine by using Doctrine ORM itself.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/example
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class SchemaProcessor extends AbstractPersistenceProcessor implements SchemaProcessorInterface
{

    /**
     * The name of the configuration key that contains the database name.
     *
     * @var string
     */
    const PARAM_DBNAME = 'dbname';

    /**
     * The system logger implementation.
     *
     * @var \AppserverIo\Logger\Logger
     * @Resource(lookup="php:global/log/System")
     */
    protected $systemLogger;

    /**
     * Example method that should be invoked after constructor.
     *
     * @return void
     * @PostConstruct
     */
    public function initialize()
    {
        $this->getInitialContext()->getSystemLogger()->info(
            sprintf('%s has successfully been invoked by @PostConstruct annotation', __METHOD__)
        );
    }

    /**
     * Return's the system logger instance.
     *
     * @return \AppserverIo\Logger\Logger The sytsem logger instance
     */
    public function getSystemLogger()
    {
        return $this->systemLogger;
    }

    /**
     * Create's the database itself.
     *
     * This quite seems to be a bit strange, because with all databases
     * other than SQLite, we need to remove the database name from the
     * connection parameters BEFORE connecting to the database, as
     * connection to a not existing database fails.
     *
     * @return void
     */
    public function createDatabase()
    {

        try {
            // clone the connection and load the database name
            $connection = clone $this->getEntityManager()->getConnection();
            $dbname = $connection->getDatabase();

            // remove the the database name
            $params = $connection->getParams();
            if (isset($params[SchemaProcessor::PARAM_DBNAME])) {
                unset($params[SchemaProcessor::PARAM_DBNAME]);
            }

            // create a new connection WITHOUT the database name
            $cn = DriverManager::getConnection($params);
            $sm = $cn->getDriver()->getSchemaManager($cn);

            // SQLite doesn't support database creation by a method
            if ($sm instanceof SqliteSchemaManager) {
                return;
            }

            // query whether or not the database already exists
            if (!in_array($dbname, $sm->listDatabases())) {
                $sm->createDatabase($dbname);
            }

        } catch (\Exception $e) {
            $this->getSystemLogger()->error($e->__toString());
        }
    }

    /**
     * Deletes the database schema and creates it new.
     *
     * Attention: All data will be lost if this method has been invoked.
     *
     * @return void
     */
    public function createSchema()
    {
        // load the entity manager and the schema tool
        $entityManager = $this->getEntityManager();
        $schemaTool = new SchemaTool($entityManager);

        // load the class definitions
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();

        // create or update the schema
        $schemaTool->updateSchema($classes);
    }
}
