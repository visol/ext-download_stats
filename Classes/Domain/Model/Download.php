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

class Download extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var \Visol\DownloadStats\Domain\Model\FrontendUser
     */
    public $feUser;

    /**
     * @var \DateTime
     */
    public $crdate;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\File
     */
    public $file;

    /**
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @return FrontendUser
     */
    public function getFeUser()
    {
        return $this->feUser;
    }

    /**
     * @return \TYPO3\CMS\Core\Resource\File
     */
    public function getFile()
    {
        return $this->file;
    }


}