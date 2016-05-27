<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$GLOBALS['TCA']['tx_downloadstats_domain_model_download'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:download_stats/Resources/Private/Language/locallang_db.xlf:tx_downloadstats_domain_model_download',
        'label' => 'file',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'hideTable' => true,
        'origUid' => 't3_origuid',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('download_stats') . 'Resources/Public/Icons/tx_downloadstats_domain_model_download.png'
    ),
    'types' => array(
        '1' => array('showitem' => 'hidden;;1, crdate, file'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'crdate' => array(
            'label' => 'LLL:EXT:download_stats/Resources/Private/Language/locallang_db.xlf:tx_downloadstats_domain_model_download.crdate',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'readOnly' => 1
            ),
        ),
        'file' => array(
            'label' => 'LLL:EXT:download_stats/Resources/Private/Language/locallang_db.xlf:tx_downloadstats_domain_model_download.file',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_file',
                'minitems' => 1,
                'maxitems' => 1,
                'readOnly' => 1,
            ),
        ),
        'fe_user' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
    ),
);
