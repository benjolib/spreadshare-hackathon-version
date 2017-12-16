<?php

namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * ENUM status of User status
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class UserRoles
{
    /**
     * Administrator
     */
    const Admin = 31;
    
    /**
     * Staff
     */
    const User = 1;
    
    /**
     * Staff
     */
    const StaffPick = 2;
    
    /**
     * Community Manager
     */
    const CommunityManager = 4;
    
    /**
     * TableEditor
     */
    const TableEditor = 8;
    
    /**
     * CommentAdmin
     */
    const CommentAdmin = 16;
}
