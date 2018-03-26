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
 * Country
 */
class Country extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * States of Country
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\State>
     * @cascade remove
     */
    protected $states = null;

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
        $this->states = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a State
     *
     * @param \Alat\Assalat\Domain\Model\State $state
     * @return void
     */
    public function addState(\Alat\Assalat\Domain\Model\State $state)
    {
        $this->states->attach($state);
    }

    /**
     * Removes a State
     *
     * @param \Alat\Assalat\Domain\Model\State $stateToRemove The State to be removed
     * @return void
     */
    public function removeState(\Alat\Assalat\Domain\Model\State $stateToRemove)
    {
        $this->states->detach($stateToRemove);
    }

    /**
     * Returns the states
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\State> $states
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * Sets the states
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Alat\Assalat\Domain\Model\State> $states
     * @return void
     */
    public function setStates(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $states)
    {
        $this->states = $states;
    }
}
