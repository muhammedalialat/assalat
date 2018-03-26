<?php
namespace Alat\Assalat\Domain\Repository;

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
 * The repository for Salatdays
 */
class SalatdayRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

/*
	protected $defaultOrderings = array(
		'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
	);
*/

	public function findDays($city, $limit = 7) {

		$today = new \DateTime();
		$today->setTimestamp(time());
		$today->setTime(0, 0, 0);

		$query = $this->createQuery();

#		$query->getQuerySettings()->setRespectStoragePage(FALSE);
#		$query->getQuerySettings()->setIgnoreEnableFields(TRUE);
#		$query->getQuerySettings()->setRespectSysLanguage(FALSE);


		$query->setLimit((int) $limit);
		$query->matching(
		 		$query->logicalAnd(
		 			$query->equals('city', $city->getUid()),
		 		   $query->greaterThanOrEqual('date', date('Y-m-d'))
		 		)
		);
#		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($city->getUid());

		$result = $query->execute();

		return $result;

	}

	/**
	 *
	 * @param integer $cityNumber
	 * @param \DateTime $date
	 * @return boolean
	 */
	public function existsDayOfCity($cityNumber, $date) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$query->getQuerySettings()->setIgnoreEnableFields(TRUE);

		$query->matching(
				$query->logicalAnd(
						$query->equals('city', $cityNumber),
						$query->equals('date', $date)
				)
		);
		$result = $query->execute();
		return ($result->count() > 0);
	}

}
