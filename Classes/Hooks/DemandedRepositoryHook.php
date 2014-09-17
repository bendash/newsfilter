<?php
namespace WorldDirect\Newsfilter\Hooks;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Ben Walch <bwa@world-direct.at>, World-Direct eBusiness Solutions Gesellschaft m.b.H.
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 *
 *
 * @package newsfilter
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
 
class DemandedRepositoryHook {
	
	/**
	 * addConstraints
	 * 
	 * @param array $params
	 * @param Tx_News_Domain_Repository_AbstractDemandedRepository $parentObject
	 *
	 * @return void
	 */
	public function addConstraints($params, $parentObject) {
		
		$initialFilterSettings = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_newsfilter.']['settings.']['initialFilter.'];
		
		// month & year initial filtering for news list
		if ($initialFilterSettings && !$params['demand']->getYear() && !$params['demand']->getMonth()) {
			if ($initialFilterSettings['year']) {
				if ($initialFilterSettings['month']) {
					$begin = mktime(0, 0, 0, (int)strftime('%m', strtotime($initialFilterSettings['month'])), 1, (int)strftime('%Y', strtotime($initialFilterSettings['year'])));
					$end = mktime(23, 59, 59, ((int)strftime('%m', strtotime($initialFilterSettings['month'])) + 1), 0, (int)strftime('%Y', strtotime($initialFilterSettings['year'])));
				} else {
					$begin = mktime(0, 0, 0, 1, 1, (int)strftime('%Y', strtotime($initialFilterSettings['year'])));
					$end = mktime(23, 59, 59, 12, 31, (int)strftime('%Y', strtotime($initialFilterSettings['year'])));
				}
			}
			$params['constraints'][] = $params['query']->logicalAnd(
				$params['query']->greaterThanOrEqual($params['demand']->getDateField(), $begin),
				$params['query']->lessThanOrEqual($params['demand']->getDateField(), $end)
			);
		}
		
	}
	

}
