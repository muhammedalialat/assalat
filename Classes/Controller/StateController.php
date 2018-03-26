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
 * StateController
 */
class StateController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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

	public function initializeAction() {
		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$querySettings->setRespectEnableFields(FALSE);
		$this->countryRepository->setDefaultQuerySettings($querySettings);
		$this->stateRepository->setDefaultQuerySettings($querySettings);
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

		$country = $this->countryRepository->findOneByNumber($config['row']['settings.country'][0]);

		if (empty($country)) {
			return;
		}

		if ($config['row']['settings.update'] == 1 || $country->getStates()->count() == 0) {
			$this->downloadStates($country);
			$this->persistenceManager->persistAll();
		}

		$optionList = array();
		$optionList[] = array(
			0 => 'Please select',
			1 => '0'
		);

		foreach ($country->getStates() as $state) {
			$optionList[] = array(
				0 => $state->getName(),
				1 => $state->getNumber()
			);
		}

		$config['items'] = array_merge($config['items'], $optionList);

		return $config;
	}

	public function downloadStates($country) {

		$statesJson = file_get_contents(
			'https://namazvakitleri.diyanet.gov.tr/tr-TR/home/GetRegList?ChangeType=country&CountryId='
			. $country->getNumber()
		);

		$statesArray = json_decode($statesJson);

		foreach($statesArray->StateList as $oneState) {

				$name = ucwords(strtolower(trim($oneState->SehirAdi)));
				$number = (int) $oneState->SehirID;

				if ($this->stateRepository->countByNumber($number) > 0) {
					continue;
				}

				$state = $this->objectManager->get('Alat\\Assalat\\Domain\\Model\\State');
				/* @var $country \Alat\Assalat\Domain\Model\Country */

				$state->setName($name);
				$state->setNumber($number);

				$country->addState($state);
				$this->countryRepository->update($country);
		}
	}
}
