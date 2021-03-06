<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "newsfilter"
 *
 * Auto generated by Extension Builder 2014-05-06
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'News Filter',
	'description' => 'This Extension provides an interface where the news list view can be filtered by year / month.',
	'category' => 'plugin',
	'author' => 'Ben Walch',
	'author_email' => 'ben.walch@world-direct.at',
	'author_company' => 'World Direct eBusiness Solutions GmbH',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '6.0',
			'fluid' => '6.0',
			'typo3' => '6.0',
			'news' => '2.2.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>