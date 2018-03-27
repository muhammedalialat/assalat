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
 * CountryController
 */
class CountryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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

	public function initializeAction() {
		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$querySettings->setRespectEnableFields(FALSE);
		$this->countryRepository->setDefaultQuerySettings($querySettings);
	}

	public function initializeRepositories() {
		if (is_null($this->objectManager)) {
			$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		}
		if (is_null($this->countryRepository)) {
			/** @var $this->countryRepository Alat\Assalat\Domain\Repository\CountryRepository */
			$this->countryRepository = $this->objectManager->get('Alat\\Assalat\\Domain\\Repository\\CountryRepository');
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

		if ($config['row']['settings.update'] == 1 || $this->countryRepository->countAll() == 0) {
			$this->downloadCountries();
			$this->persistenceManager->persistAll();
		}

		$optionList = array();
		$optionList[] = array(
			0 => 'Please select',
			1 => '0'
		);

		foreach ($this->countryRepository->findAll() as $country) {
			$optionList[] = array(
				0 => $country->getName(),
				1 => $country->getNumber()
			);
		}

		$config['items'] = array_merge($config['items'], $optionList);

		return $config;
	}

	public function downloadCountries() {

		$countriesHtmlFile = file_get_contents('https://namazvakitleri.diyanet.gov.tr/tr-TR');
		$domDocument = new \DOMDocument();
		libxml_use_internal_errors(true);
		$domDocument->loadHTML($countriesHtmlFile);

		$selects = $domDocument->getElementsByTagName('select');

		foreach($selects as $select) {

			if ($select->getAttribute('name') != 'country' ) {
				continue;
			}

			foreach ($select->getElementsByTagName('option') as $option) {
				$name = ucwords(strtolower(trim($option->nodeValue)));
				$number = (int) $option->getAttribute('value');

				if ($this->countryRepository->countByNumber($number) > 0) {
					continue;
				}

				$country = $this->objectManager->get('Alat\\Assalat\\Domain\\Model\\Country');
				/* @var $country \Alat\Assalat\Domain\Model\Country */

				$country->setName($name);
				$country->setNumber($number);
				$this->countryRepository->add($country);
			}
		}
	}
}
