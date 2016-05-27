<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
$signalSlotDispatcher->connect(
    'BeechIt\FalSecuredownload\Hooks\FileDumpHook',
    'BeforeFileDump',
    'Visol\DownloadStats\Slot\FalSecuredownloadBeforeFileDumpSlot',
    'logFileDump'
);
