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
 * Salatday
 */
class Salatday extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * date
     *
     * @var \DateTime
     */
    protected $date = null;

    /**
     * dawn
     *
     * @var int
     */
    protected $dawn = 0;

    /**
     * sunrise
     *
     * @var int
     */
    protected $sunrise = 0;

    /**
     * noon
     *
     * @var int
     */
    protected $noon = 0;

    /**
     * afternoon
     *
     * @var int
     */
    protected $afternoon = 0;

    /**
     * sunset
     *
     * @var int
     */
    protected $sunset = 0;

    /**
     * dusk
     *
     * @var int
     */
    protected $dusk = 0;

    /**
     * Returns the date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     *
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Returns the dawn
     *
     * @return int $dawn
     */
    public function getDawn()
    {
        return $this->dawn;
    }

    /**
     * Returns the dawn
     *
     * @return string $dawn
     */
    public function getDawnTime()
    {
        return $this->getAsTime($this->dawn);
    }

    /**
     * Sets the dawn
     *
     * @param int $dawn
     * @return void
     */
    public function setDawn(int $dawn)
    {
        $this->dawn = $dawn;
    }

    /**
     * Returns the sunrise
     *
     * @return int $sunrise
     */
    public function getSunrise()
    {
        return $this->sunrise;
    }

    /**
     * Returns the sunrise
     *
     * @return string $sunrise
     */
    public function getSunriseTime()
    {
        return $this->getAsTime($this->sunrise);
    }

    /**
     * Sets the sunrise
     *
     * @param int $sunrise
     * @return void
     */
    public function setSunrise(int $sunrise)
    {
        $this->sunrise = $sunrise;
    }

    /**
     * Returns the noon
     *
     * @return int $noon
     */
    public function getNoon()
    {
        return $this->noon;
    }

    /**
     * Returns the noon
     *
     * @return string $noon
     */
    public function getNoonTime()
    {
        return $this->getAsTime($this->noon);
    }

    /**
     * Sets the noon
     *
     * @param int $noon
     * @return void
     */
    public function setNoon(int $noon)
    {
        $this->noon = $noon;
    }

    /**
     * Returns the afternoon
     *
     * @return int $afternoon
     */
    public function getAfternoon()
    {
        return $this->afternoon;
    }

    /**
     * Returns the afternoon
     *
     * @return string $afternoon
     */
    public function getAfternoonTime()
    {
        return $this->getAsTime($this->afternoon);
    }

    /**
     * Sets the afternoon
     *
     * @param int $afternoon
     * @return void
     */
    public function setAfternoon(int $afternoon)
    {
        $this->afternoon = $afternoon;
    }

    /**
     * Returns the sunset
     *
     * @return int $sunset
     */
    public function getSunset()
    {
        return $this->sunset;
    }

    /**
     * Returns the dusk
     *
     * @return string $dusk
     */
    public function getSunsetTime()
    {
        return $this->getAsTime($this->sunset);
    }

    /**
     * Sets the sunset
     *
     * @param int $sunset
     * @return void
     */
    public function setSunset(int $sunset)
    {
        $this->sunset = $sunset;
    }

    /**
     * Returns the dusk
     *
     * @return int $dusk
     */
    public function getDusk()
    {
        return $this->dusk;
    }

    /**
     * Returns the dusk
     *
     * @return string $dusk
     */
    public function getDuskTime()
    {
        return $this->getAsTime($this->dusk);
    }

    private function getAsTime($int) {
      $minutes = $int % 100;
      $hours = ($int - $minutes) / 100;

      return $hours . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
    }


    /**
     * Sets the dusk
     *
     * @param int $dusk
     * @return void
     */
    public function setDusk(int $dusk)
    {
        $this->dusk = $dusk;
    }
}
