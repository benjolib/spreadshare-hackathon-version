<?php

namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * ENUM status of Table log events
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class TableLogType
{
    const Created = 1;
    
    const Updated = 2;
    
    const Contributed = 3;
    
    const Voted = 4;
    
    const Deleted = 5;
    
    const OwnerChagned = 5;
    
    const DataImported = 6;
}
