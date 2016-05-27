<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$tempColumns = array(
	'downloads' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:download_stats/Resources/Private/Language/locallang_db.xlf:fe_users.downloads',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_downloadstats_domain_model_download',
			'foreign_field' => 'fe_user',
			'maxitems' => 9999,
			'appearance' => array(
				'collapseAll' => 1,
				'levelLinksPosition' => 'none',
			),
		),
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'downloads', '', 'after:email');
