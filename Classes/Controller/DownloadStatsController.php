<?php
namespace Visol\DownloadStats\Controller;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */


class DownloadStatsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \Visol\DownloadStats\Domain\Repository\DownloadRepository
     * @inject
     */
    protected $downloadRepository;

    /**
     * List all users and their downloads
     *
     * @return void
     */
    public function listUsersAndDownloadsAction()
    {

        $downloads = $this->downloadRepository->findAll();
        $this->view->assign('downloads', $downloads);

    }

    /**
     * Export all users and their downloads as an Excel XML file
     */
    public function exportUsersAndDownloadsAction()
    {
        $downloads = $this->downloadRepository->findAll();
        $this->view->assign('downloads', $downloads);
        $content = $this->view->render();

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $formattedDate = date("Y-m-d");
        header('Content-Disposition: filename=export-' . $formattedDate . '.xml');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        header('Pragma: public');
        echo($content);
        exit;

    }

}