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
 * CityController
 */
class CityController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
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

	public function initializeAction() {
		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$querySettings->setRespectEnableFields(FALSE);
		$this->countryRepository->setDefaultQuerySettings($querySettings);
		$this->stateRepository->setDefaultQuerySettings($querySettings);
		$this->cityRepository->setDefaultQuerySettings($querySettings);

	}

	public function initializeRepositories() {
		if (is_null($this->objectManager)) {
			$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		}
		if (is_null($this->countryRepository)) {
			/** @var $this->countryRepository Alat\Assalat\Domain\Repository\CountryRepository */
			$this->countryRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\CountryRepository');
		}
		if (is_null($this->stateRepository)) {
			/** @var $this->countryRepository Alat\Assalat\Domain\Repository\CountryRepository */
			$this->stateRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\StateRepository');
		}
		if (is_null($this->cityRepository)) {
			/** @var $this->countryRepository Alat\Assalat\Domain\Repository\CountryRepository */
			$this->cityRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\CityRepository');
		}
		if (is_null($this->persistenceManager)) {
			/** @var $this->countryRepository \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
			$this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		}
	}

	/**
	 * action flexform
	 *
	 * @return void
	 */
	public function flexformAction($config) {
		$this->initializeRepositories();

		$country = $this->countryRepository->findOneByNumber($config['row']['settings.country']);
		$state = $this->stateRepository->findOneByNumber($config['row']['settings.state']);

		if (empty($country) || empty($state)) {
			return;
		}

		if ($config['row']['settings.update'] == 1 || $state->getCities()->count() == 0) {
			$this->downloadCities($state);
			$this->persistenceManager->persistAll();
		}

		$optionList = array();
		$optionList[] = array(
			0 => 'Please select',
			1 => '0'
		);

		foreach ($state->getCities() as $city) {
			$optionList[] = array(
				0 => $city->getName(),
				1 => $city->getNumber()
			);
		}

		$config['items'] = array_merge($config['items'], $optionList);

		return $config;
	}

	public function downloadCities($state) {

		$citiesJson = file_get_contents(
			'https://namazvakitleri.diyanet.gov.tr/tr-TR/home/GetRegList?ChangeType=state&StateId='
			. $state->getNumber()
		);

		$citiesArray = json_decode($citiesJson);

		foreach($citiesArray->StateRegionList as $oneCity) {

				$name = ucwords(strtolower(trim($oneCity->IlceAdi)));
				$number = (int) $oneCity->IlceID;

				if ($this->cityRepository->countByNumber($number) > 0) {
					// TODO: Update instead
					continue;
				}

				$city = $this->objectManager->get('Alat\\Assalat\\Domain\\Model\\City');
				/* @var $country \Alat\Assalat\Domain\Model\Country */

				$city->setName($name);
				$city->setNumber($number);

				$state->addCity($city);
				$this->stateRepository->update($state);
		}
	}
}
