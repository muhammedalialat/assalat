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
 * City
 */
class City extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * Days with praying times in a city
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\Salatday>
     * @cascade remove
     */
    protected $salatdays = null;

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
        $this->salatdays = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Salatday
     *
     * @param \Alat\Assalat\Domain\Model\Salatday $salatday
     * @return void
     */
    public function addSalatday(\Alat\Assalat\Domain\Model\Salatday $salatday)
    {
        $this->salatdays->attach($salatday);
    }

    /**
     * Removes a Salatday
     *
     * @param \Alat\Assalat\Domain\Model\Salatday $salatdayToRemove The Salatday to be removed
     * @return void
     */
    public function removeSalatday(\Alat\Assalat\Domain\Model\Salatday $salatdayToRemove)
    {
        $this->salatdays->detach($salatdayToRemove);
    }

    /**
     * Returns the salatdays
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\Salatday> $salatdays
     */
    public function getSalatdays()
    {
        return $this->salatdays;
    }

    /**
     * Sets the salatdays
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\Salatday> $salatdays
     * @return void
     */
    public function setSalatdays(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $salatdays)
    {
        $this->salatdays = $salatdays;
    }
}
