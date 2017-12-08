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
 
    const All = 0;
    
    /**
     * Unpublished state for a dataset
     */
    const Unpublished = 1;
    
    /**
     * Normal state for a dataset
     */
    const Published = 2;
    
    /**
     * Inactive / hidden dataset
     */
    const Archived = 3;
    
    /**
     * If dataset was deleted
     */
    const Deleted = 4;
}
