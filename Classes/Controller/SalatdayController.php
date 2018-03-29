<?php
namespace Alat\Assalat\Controller;

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
 * SalatdayController
 */
class SalatdayController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

  public static $salatTimes = [
    'date', 'dawn', 'sunrise', 'noon', 'afternoon', 'sunset', 'dusk'
  ];

  /**
	 * Persistence Manager
	 *
	 *@var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * Object Manager
	 *
	 *@var \TYPO3\CMS\Extbase\Object\ObjectManager
	 * @inject
	 */
	protected $objectManager;

	/**
	 * countryRepository
	 *
	 * @var \Alat\Assalat\Domain\Repository\CountryRepository
	 * @inject
	 */
	protected $countryRepository;

	/**
	 * countryRepository
	 *
	 * @var \Alat\Assalat\Domain\Repository\StateRepository
	 * @inject
	 */
	protected $stateRepository;

	/**
	 * countryRepository
	 *
	 * @var \Alat\Assalat\Domain\Repository\CityRepository
	 * @inject
	 */
	protected $cityRepository;

    /**
     * salatdayRepository
     *
     * @var \Alat\Assalat\Domain\Repository\SalatdayRepository
     * @inject
     */
    protected $salatdayRepository = null;

    public function initializeAction() {
  		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
  		$querySettings->setRespectStoragePage(FALSE);
  		$this->countryRepository->setDefaultQuerySettings($querySettings);
  		$this->stateRepository->setDefaultQuerySettings($querySettings);
  		$this->cityRepository->setDefaultQuerySettings($querySettings);
      $this->salatdayRepository->setDefaultQuerySettings($querySettings);
  	}

  	public function initializeRepositories() {
  		if (is_null($this->objectManager)) {
  			$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
  		}
  		if (is_null($this->countryRepository)) {
  			$this->countryRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\CountryRepository');
  		}
  		if (is_null($this->stateRepository)) {
  			$this->stateRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\StateRepository');
  		}
  		if (is_null($this->cityRepository)) {
  			$this->cityRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\CityRepository');
  		}
      if (is_null($this->salatdayRepository)) {
  			$this->salatdayRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\SalatdayRepository');
  		}
  		if (is_null($this->persistenceManager)) {
  			$this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
  		}
  	}

    /**
     * action list
     *
     * @return void
     */
    public function showAction()
    {
      $this->initializeRepositories();

      $city = $this->cityRepository->findOneByNumber($this->settings['city']);

      if (empty($city)) {
        return 'City not found.';
      }

#      \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->settings);


      $salatdays = $this->salatdayRepository->findDays($city, 1);

      if ($salatdays->count() == 0) {
        $this->downloadSalatTimes($city);
  	    $this->persistenceManager->persistAll();
      }

      $this->view->assign('salatday', $salatdays->getFirst());
    }

    /**
     * action list
     *
     * @return void
     */
    public function listMonthAction()
    {
      $this->initializeRepositories();

      $city = $this->cityRepository->findOneByNumber($this->settings['city']);

      if (empty($city)) {
        return 'City not found.';
      }

      $salatdays = $this->salatdayRepository->findDays($city, 30);

      if ($salatdays->count() < 30) {
        $this->downloadSalatTimes($city);
  	    $this->persistenceManager->persistAll();
      }

#      \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($salatdays);

      $this->view->assign('salatdays', $salatdays);
    }


    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
      $this->initializeRepositories();

      $city = $this->cityRepository->findOneByNumber($this->settings['city']);

      if (empty($city)) {
        return 'City not found.';
      }

      $salatdays = $this->salatdayRepository->findDays($city, 30);


      if ($salatdays->count() < 7) {
        $this->downloadSalatTimes($city);
  	    $this->persistenceManager->persistAll();
      }

      $this->view->assign('salatdays', $salatdays);
    }

    public function downloadSalatTimes($city) {

  		$salatTimesHtmlFile = file_get_contents(
        'https://namazvakitleri.diyanet.gov.tr/tr-TR/'
        . $city->getNumber()
      );

  		$domDocument = new \DOMDocument();
  		$domDocument->loadHTML($salatTimesHtmlFile);

  		$htmlTableBlock = $domDocument->getElementById('tab-1');
      $htmlTable = $htmlTableBlock->getElementsByTagName('table');

      foreach($htmlTable[0]->getElementsByTagName('tr') as $tableLine) {
        if ($tableLine->parentNode->tagName == 'tbody') {
          $columns = $tableLine->getElementsByTagName('td');

          $date = \DateTime::createFromFormat('d.m.Y', $columns[0]->nodeValue);

		$salatdayExists = $this->salatdayRepository->findDay($city, $date->format('Y-m-d'));

#      \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($salatdayExists);

		if (!empty($salatdayExists)) {
			continue;
		}

          $salatday = $this->objectManager->get('Alat\\Assalat\\Domain\\Model\\Salatday');

          $salatday->setDate($date);
          $salatday->setDawn($this->castStringTimeToInt($columns[1]->nodeValue));
          $salatday->setSunrise($this->castStringTimeToInt($columns[2]->nodeValue));
          $salatday->setNoon($this->castStringTimeToInt($columns[3]->nodeValue));
          $salatday->setAfternoon($this->castStringTimeToInt($columns[4]->nodeValue));
          $salatday->setSunset($this->castStringTimeToInt($columns[5]->nodeValue));
          $salatday->setDusk($this->castStringTimeToInt($columns[6]->nodeValue));

          $city->addSalatday($salatday);
        }
        $this->cityRepository->update($city);
      }

  	}

    private function castStringTimeToInt($time) {
      $timeArray = explode(':', $time);

      return (int) $timeArray[0] * 100 + (int) $timeArray[1];
    }

}
