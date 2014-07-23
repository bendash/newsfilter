<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WorldDirect.' . $_EXTKEY,
	'Pi1',
	array(
		'Filter' => 'display'
	),
	// non-cacheable actions
	array(
		
	)
);

// DemandedRepository Hook
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['Domain/Repository/AbstractDemandedRepository.php']['findDemanded'][$_EXTKEY . '_pi1'] =
	'\WorldDirect\Newsfilter\Hooks\DemandedRepositoryHook->addConstraints';

?>