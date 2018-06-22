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
    const User = 1;
    const StaffPick = 2;
    const CommunityManager = 4;
    const Curator = 8;
    const CommentAdmin = 16;
    const Admin = 32;
    const FeaturedCurator = 64;
}
