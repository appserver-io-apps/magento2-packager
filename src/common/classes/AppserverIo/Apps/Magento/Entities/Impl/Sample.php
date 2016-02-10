<?php

/**
 * AppserverIo\Apps\Magento\Entities\Impl\Sample
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

namespace AppserverIo\Apps\Magento\Entities\Impl;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine entity that represents a sample.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/example
 * @link      http://www.appserver.io
 *
 * @ORM\Entity
 * @ORM\Table(name="sample")
 */
class Sample
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $sampleId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * Sets the value for the class member sampleId.
     *
     * @param integer $sampleId Holds the value for the class member sampleId
     *
     * @return void
     */
    public function setSampleId($sampleId)
    {
        $this->sampleId = $sampleId;
    }

    /**
     * Returns the value of the class member sampleId.
     *
     * @return integer|null Holds the value of the class member sampleId
     */
    public function getSampleId()
    {
        return $this->sampleId;
    }

    /**
     * Sets the value for the class member name.
     *
     * @param string $name Holds the value for the class member name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the value of the class member name.
     *
     * @return string Holds the value of the class member name
     */
    public function getName()
    {
        return $this->name;
    }
}
