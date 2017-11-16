<?php

namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * ENUM status of Table flags
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class TableFlags
{
    /**
     * If dataset was deleted
     */
    const Deleted = 0;
    
    /**
     * Normal state for a dataset
     */
    const Normal = 1;
    
    /**
     * Inactive / hidden dataset
     */
    const Archived = 2;
}
