<?php
namespace Visol\DownloadStats\Slot;

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

use BeechIt\FalSecuredownload\Hooks\FileDumpHook;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;
use TYPO3\CMS\Frontend\Utility\EidUtility;

class FalSecuredownloadBeforeFileDumpSlot
{

    protected $downloadTable = 'tx_downloadstats_domain_model_download';

    protected $feUser;

    /**
     * Log each file download if user is authenticated
     *
     * @param File $file
     * @param FileDumpHook $parentObject
     */
    public function logFileDump(File $file, FileDumpHook $parentObject)
    {
        /* TODO: use $parentObject::feUser if EXT:fal_securedownload makes it public. See https://github.com/beechit/fal_securedownload/issues/37 */
        $this->initializeUserAuthentication();
        if ($this->getAuthenticatedUserUid() !== null) {
            if ($this->downloadMustBeLogged()) {
                $values = array(
                    'pid' => (int)$this->feUser->user['pid'],
                    'crdate' => time(),
                    'tstamp' => time(),
                    'file' => $file->getUid(),
                    'fe_user' => $this->getAuthenticatedUserUid()
                );
                $this->getDatabaseConnection()->exec_INSERTquery($this->downloadTable, $values);
                $this->updateRelationCount($this->downloadTable, 'fe_user', 'downloads', 'fe_users',
                    array('deleted', 'disable'));
            }
        }
    }

    /**
     * Initialise feUser
     */
    protected function initializeUserAuthentication()
    {
        if ($this->feUser === null) {
            $this->feUser = \TYPO3\CMS\Frontend\Utility\EidUtility::initFeUser();
            $this->feUser->fetchGroupData();
        }
    }


    /**
     * @return integer|null
     */
    protected function getAuthenticatedUserUid()
    {
        if ((int)$this->feUser->user['uid'] > 0) {
            return (int)$this->feUser->user['uid'];
        } else {
            return null;
        }
    }

    /**
     * Logging of downloads can be limited to configured user groups
     * Check if the criteria to log the donwload is met
     *
     * @return bool
     */
    protected function downloadMustBeLogged()
    {
        $extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['download_stats']);
        if (is_array($extensionConfiguration)
            && isset($extensionConfiguration['restrictLoggingToUserGroup'])
            && !empty($extensionConfiguration['restrictLoggingToUserGroup'])
        ) {
            // We have a restriction, so we need to evaluate if the current user is in at least one of the groups
            $userGroupsIncludedForLogging = GeneralUtility::trimExplode(',',
                $extensionConfiguration['restrictLoggingToUserGroup']);
            $authenticatedUserGroupsArray = $this->getAuthenticatedUserGroupsArray();

            foreach ($authenticatedUserGroupsArray as $authenticatedUserGroup) {
                if (in_array($authenticatedUserGroup, $userGroupsIncludedForLogging)) {
                    return true;
                }
            }

            return false;

        } else {
            // No restriction, so download must be logged
            return true;
        }

    }

    /**
     * @return string|null
     */
    protected function getAuthenticatedUserGroupsArray()
    {
        if (!empty($this->feUser->user['usergroup'])) {
            return GeneralUtility::trimExplode(',', $this->feUser->user['usergroup']);
        } else {
            return null;
        }
    }

    /**
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }

    /**
     * Update the relations count for an 1:n IRRE relation
     *
     * @param string $foreignTable The table with child records
     * @param string $foreignField The field in the child record holding the uid of the parent
     * @param string $localRelationField The field that holds the relation count
     * @param string $localTable The parent table
     * @param array $localEnableFields The enable fields to consider for the parent table
     * @param array $foreignEnableFields The enable fields to consider from the children table
     */
    protected function updateRelationCount(
        $foreignTable,
        $foreignField,
        $localRelationField,
        $localTable = 'fe_users',
        $localEnableFields = array('hidden', 'deleted'),
        $foreignEnableFields = array('hidden', 'deleted')
    ) {
        $foreignEnableFieldsClause = '';
        foreach ($foreignEnableFields as $foreignEnableField) {
            $foreignEnableFieldsClause .= ' AND NOT ' . $foreignEnableField;
        }
        $localEnableFieldsClause = '';
        foreach ($localEnableFields as $localEnableField) {
            $localEnableFieldsClause .= ' AND NOT parent.' . $localEnableField;
        }
        $q = '
			UPDATE ' . $localTable . ' AS parent
			LEFT JOIN (
				SELECT ' . $foreignField . ', COUNT(*) foreignCount
				FROM  ' . $foreignTable . '
				WHERE 1=1 ' . $foreignEnableFieldsClause . '
				GROUP BY ' . $foreignField . '
				) AS children
			ON parent.uid = children.' . $foreignField . '
			SET parent.' . $localRelationField . ' = CASE
				WHEN children.foreignCount IS NULL THEN 0
				WHEN children.foreignCount > 0 THEN children.foreignCount
			END
			WHERE 1=1 ' . $localEnableFieldsClause . ';
		';
        $this->getDatabaseConnection()->sql_query($q);
    }

}