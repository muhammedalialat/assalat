<?php
namespace Alat\Assalat\Domain\Model;

/***
 *
 * This file is part of the "Assalat" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Muhammed Ali Alat <muhammedali@alat.de>, Alat
 *
 ***/

/**
 * State
 */
class State extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';

    /**
     * number
     *
     * @var int
     * @validate NotEmpty
     */
    protected $number = 0;

    /**
     * Cities in State
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\City>
     * @cascade remove
     */
    protected $cities = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->cities = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the number
     *
     * @return int $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the number
     *
     * @param int $number
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Adds a City
     *
     * @param \Alat\Assalat\Domain\Model\City $city
     * @return void
     */
    public function addCity(\Alat\Assalat\Domain\Model\City $city)
    {
        $this->cities->attach($city);
    }

    /**
     * Removes a City
     *
     * @param \Alat\Assalat\Domain\Model\City $cityToRemove The City to be removed
     * @return void
     */
    public function removeCity(\Alat\Assalat\Domain\Model\City $cityToRemove)
    {
        $this->cities->detach($cityToRemove);
    }

    /**
     * Returns the cities
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\City> $cities
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Sets the cities
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\City> $cities
     * @return void
     */
    public function setCities(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $cities)
    {
        $this->cities = $cities;
    }
}
