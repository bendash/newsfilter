<?php
namespace WorldDirect\Newsfilter\Controller;
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
 * @package theme_bmeia
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
 
class FilterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * categoryRepository
	 *
	 * @var Tx_News_Domain_Repository_CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;
	
	
	/**
	 *
	 * initialize
	 *
	 */
	public function initializeAction() {
				
		$defaultQuerySettings = $this->objectManager->get('\\TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$defaultQuerySettings->setRespectStoragePage(FALSE);
		$this->categoryRepository->setDefaultQuerySettings($defaultQuerySettings);
						
		if (!$_REQUEST['tx_news_pi1']['overwriteDemand'] && $this->settings['initialFilter']['year']) {
			$_REQUEST['tx_news_pi1']['overwriteDemand']['year'] = intval(strftime('%Y', strtotime($this->settings['initialFilter']['year'])));
			if ($this->settings['initialFilter']['month']) {
				$_REQUEST['tx_news_pi1']['overwriteDemand']['month'] = intval(strftime('%m', strtotime($this->settings['initialFilter']['month'])));
			}
		}
	}
	
	/**
	 * Display Filter view
	 *
	 * @return void
	 */
	public function displayAction() {
								
		$years = array();
		$months = array();
		
		for ($i = 1; $i <= 12; $i++)
			$months[$i] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:news/Resources/Private/Language/locallang.xml:month.'.sprintf('%02s', $i), 'News'); 
		
		for ($i = 0; $i <= 10; $i++) {
			$year = strftime('%Y', strtotime('-'.$i.' years'));
			$years[(int)$year] = $year;
		}
		
		$this->view->assignMultiple(
			array(
				'pageId' => $GLOBALS['TSFE']->id,
				'years' => $years,
				'months' => $months,
				'categories' => $this->categoryRepository->findAll(),
				'overwriteDemand' => $_REQUEST['tx_news_pi1']['overwriteDemand']
			)
		);
	}

}
