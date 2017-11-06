<?php
namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * ENUM status of hiringProjects
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class DatasetStatus
{
    /**
     * If dataset was deleted
     */
    const Deleted = 0;

    /**
     * Normal state for a dataset
     */
    const Active = 1;

    /**
     * Inactive / hidden dataset
     */
    const Inactive = 2;
}