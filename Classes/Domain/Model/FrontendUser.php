<?php
namespace Visol\DownloadStats\Domain\Model;

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

class FrontendUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Visol\DownloadStats\Domain\Model\Download>
     * @lazy
     */
    protected $downloads;

    /**
     * __construct
     *
     * @return FrontendUser
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->downloads = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

}