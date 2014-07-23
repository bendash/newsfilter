<?php
namespace WorldDirect\Newsfilter\ViewHelpers;
/***************************************************************
*  Copyright notice
*
*  (c) 2014 Ben Walch <ben.walch@world-direct.at>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * ViewHelper to render news records
 *
 * # Example: Basic example
 * <code>
 * <bm:news as="newsRecords">
 *	{newsRecords -> f:count()}
 * </bm:news>
 * </code>
 * <output>
 *  3
 * </output>
 *
 */
class NewsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @param array $constraints
	 * @param string $as name of the placeholder variable
	 * @return string Rendered string
	 * @api
	 */
	public function render($constraints, $as) {		
		
		$news = $this->getNewsWithConstraints($constraints);
		
		$this->templateVariableContainer->add($as, $news);
		$output = $this->renderChildren();
		return $output;
	}
	
	protected function getNewsWithConstraints($constraints) {

		$newsRepository = $constraints['repository'] ? $this->objectManager->get($constraints['repository']) : $this->objectManager->get('Tx_News_Domain_Repository_NewsRepository');
		$defaultQuerySettings = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$defaultOrderings = array();
		
		$defaultQuerySettings->setStoragePageIds(array($constraints['storagePage']));
		$defaultOrderings = array(
			$constraints['orderBy'] => $orderings[$orderField] = (
				(strtolower($constraints['orderDirection']) == 'desc') ? \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING : \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
			)
		);
		
		$newsRepository->setDefaultQuerySettings($defaultQuerySettings);
		$newsRepository->setDefaultOrderings($defaultOrderings);
		
		$query = $newsRepository->createQuery();
		$query->setLimit((int)$constraints['limit']);
		
		if ($constraints['timeRestriction']) {
			switch (strtolower($constraints['orderDirection'])) {
				case 'asc':
					$query->matching($query->greaterThanOrEqual($constraints['dateField'], strtotime($constraints['timeRestriction'])));
					break;
				case 'desc':
					$query->matching($query->lessThanOrEqual($constraints['dateField'], strtotime($constraints['timeRestriction'])));
			}
		}
		return $query->execute()->toArray();
	}
}
