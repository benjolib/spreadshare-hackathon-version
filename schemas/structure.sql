
-- Do not check foreign keys while creating tables in arbitrary order
SET foreign_key_checks=0;

-- Create syntax for TABLE 'changeRequests'
CREATE TABLE `changeRequests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `cellId` int(11) unsigned DEFAULT NULL,
  `from` text,
  `to` text,
  `comment` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `cellId` (`cellId`),
  CONSTRAINT `changeRequestsCellId` FOREIGN KEY (`cellId`) REFERENCES `tableCells` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `changeRequestsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'cities'
CREATE TABLE `cities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(200) DEFAULT NULL,
  `region` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `continent` varchar(200) DEFAULT NULL,
  `lat` float unsigned DEFAULT NULL,
  `lng` float unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7323 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'locations'
CREATE TABLE `locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cityId` int(11) unsigned DEFAULT NULL,
  `lat` float unsigned NOT NULL COMMENT 'latitude',
  `lng` float unsigned NOT NULL COMMENT 'longitude',
  `locationName` varchar(200) DEFAULT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cityId` (`cityId`),
  KEY `locationName` (`locationName`),
  CONSTRAINT `locationsCityId` FOREIGN KEY (`cityId`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8252 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'row_add_request'
CREATE TABLE `row_add_request` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `table_id` int(11) unsigned NOT NULL,
  `content` longtext NOT NULL,
  `comment` text,
  `image` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `createdAt` int(10) unsigned DEFAULT NULL,
  `updateddAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `table_id` (`table_id`),
  CONSTRAINT `row_add_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `row_add_request_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'row_delete_request'
CREATE TABLE `row_delete_request` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `row_id` int(11) unsigned NOT NULL,
  `comment` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `createdAt` int(10) unsigned DEFAULT NULL,
  `updateddAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `row_id` (`row_id`),
  CONSTRAINT `row_delete_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `row_delete_request_ibfk_2` FOREIGN KEY (`row_id`) REFERENCES `tableRows` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableCells'
CREATE TABLE `tableCells` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL COMMENT 'author (user id)',
  `columnId` int(11) unsigned DEFAULT NULL COMMENT 'associated column (tableColumns.id)',
  `rowId` int(11) unsigned DEFAULT NULL,
  `content` text COMMENT 'text content of row',
  `link` varchar(255) DEFAULT NULL COMMENT 'optional link (http://..)',
  `updatedById` int(11) unsigned NOT NULL COMMENT 'last edited (user id)',
  `updatedAt` int(11) unsigned NOT NULL COMMENT 'timestamp',
  `createdAt` int(10) DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `updatedById` (`updatedById`),
  KEY `columnId` (`columnId`),
  KEY `rowId` (`rowId`),
  CONSTRAINT `tableCellsColumnId` FOREIGN KEY (`columnId`) REFERENCES `tableColumns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCellsRowId` FOREIGN KEY (`rowId`) REFERENCES `tableRows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCellsUpdatedById` FOREIGN KEY (`updatedById`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCellsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=263098 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableColumns'
CREATE TABLE `tableColumns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'auther (user.id)',
  `tableId` int(11) unsigned DEFAULT NULL COMMENT 'associated table (tables.id)',
  `title` varchar(200) DEFAULT NULL COMMENT 'column title',
  `position` int(11) DEFAULT NULL COMMENT 'position number / order',
  `width` float unsigned DEFAULT NULL COMMENT 'width in px',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `tableId` (`tableId`),
  KEY `userId` (`userId`),
  KEY `position` (`position`),
  CONSTRAINT `tableColumnsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableColumnsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=569 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableComments'
CREATE TABLE `tableComments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) unsigned DEFAULT NULL COMMENT 'parent tabelComment.id',
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `comment` text,
  `votesCount` int(11) DEFAULT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`parentId`),
  KEY `tableId` (`tableId`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableCommentsParentId` FOREIGN KEY (`parentId`) REFERENCES `tableComments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCommentsTabelId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCommentsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableCommentVotes'
CREATE TABLE `tableCommentVotes` (
  `commentId` int(11) unsigned NOT NULL COMMENT 'tableComments.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user that created the comment (user.id)',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`commentId`,`userId`),
  KEY `tableCommentVotesUserid` (`userId`),
  CONSTRAINT `tableCommentVotesCommentId` FOREIGN KEY (`commentId`) REFERENCES `tableComments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCommentVotesUserid` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableContributors'
CREATE TABLE `tableContributors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned DEFAULT NULL COMMENT 'table.id',
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'contributor user.id',
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT 'contribution type',
  `tableOwnership` float DEFAULT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableFlags'
CREATE TABLE `tableFlags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned DEFAULT NULL,
  `flag` varchar(25) DEFAULT NULL,
  `text` varchar(200) DEFAULT '',
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `tableId` (`tableId`),
  CONSTRAINT `tableFlagsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableFlagsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableLocations'
CREATE TABLE `tableLocations` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `locationId` int(11) unsigned NOT NULL COMMENT 'locations.id',
  PRIMARY KEY (`tableId`,`locationId`),
  KEY `tableLocationsLocationId` (`locationId`),
  CONSTRAINT `tableLocationsLocationId` FOREIGN KEY (`locationId`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableLocationsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableLog'
CREATE TABLE `tableLog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned DEFAULT NULL COMMENT 'tables.id',
  `userId` int(11) unsigned DEFAULT NULL,
  `logType` tinyint(1) unsigned DEFAULT NULL COMMENT 'log type',
  `text` mediumtext COMMENT 'log text',
  `placeholders` text COMMENT 'json placeholders',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `tableId` (`tableId`),
  KEY `logType` (`logType`),
  KEY `createdAt` (`createdAt`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableLogTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableLogUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=264374 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableProperties'
CREATE TABLE `tableProperties` (
  `tableId` int(11) unsigned NOT NULL,
  `fixedRowsTop` mediumint(9) DEFAULT NULL,
  `fixedColumnsLeft` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`tableId`),
  CONSTRAINT `tablePropertiesTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableRelations'
CREATE TABLE `tableRelations` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `relatedTableId` int(11) unsigned NOT NULL COMMENT 'relation to another table (tables.id)',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`tableId`,`relatedTableId`),
  KEY `tableRelationsRelatedTableId` (`relatedTableId`),
  KEY `createdAt` (`createdAt`),
  CONSTRAINT `tableRelationsRelatedTableId` FOREIGN KEY (`relatedTableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableRelationsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableRows'
CREATE TABLE `tableRows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'user that created the row',
  `tableId` int(11) unsigned DEFAULT NULL,
  `content` longtext COMMENT 'cached json content for row',
  `lineNumber` int(11) DEFAULT NULL,
  `votesCount` int(11) DEFAULT NULL COMMENT 'total votes cache',
  `commentsCount` int(11) DEFAULT NULL COMMENT 'total comments cache',
  `image` varchar(255) DEFAULT NULL COMMENT 'image url',
  `updatedAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `tableId` (`tableId`),
  CONSTRAINT `tableRowsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableRowsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26488 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableRowVotes'
CREATE TABLE `tableRowVotes` (
  `rowId` int(11) unsigned NOT NULL COMMENT 'tableRows.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`rowId`,`userId`),
  KEY `tableVotesUserId` (`userId`),
  CONSTRAINT `tableRowVotesRowId` FOREIGN KEY (`rowId`) REFERENCES `tableRows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableRowVotesUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tables'
CREATE TABLE `tables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ownerUserId` int(11) unsigned NOT NULL COMMENT 'author',
  `typeId` tinyint(1) unsigned DEFAULT NULL COMMENT 'table type (types.id)',
  `topic1Id` tinyint(1) unsigned DEFAULT NULL COMMENT 'first topic (topics.id)',
  `topic2Id` tinyint(1) unsigned DEFAULT NULL COMMENT 'second topic (topics.id)',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT 'table name',
  `slug` varchar(100) DEFAULT NULL COMMENT 'slug',
  `tagline` varchar(140) DEFAULT '' COMMENT 'description',
  `image` varchar(255) DEFAULT NULL COMMENT 'image url',
  `description` text,
  `flags` tinyint(4) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `updatedAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `typeId` (`typeId`),
  KEY `topic1Id` (`topic1Id`),
  KEY `topic2Id` (`topic2Id`),
  KEY `createdAt` (`createdAt`),
  KEY `ownerUserId` (`ownerUserId`),
  CONSTRAINT `tablesOwnerUserId` FOREIGN KEY (`ownerUserId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tablesTopic1Id` FOREIGN KEY (`topic1Id`) REFERENCES `topics` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tablesTopic2Id` FOREIGN KEY (`topic2Id`) REFERENCES `topics` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tablesTypeId` FOREIGN KEY (`typeId`) REFERENCES `types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableStaffPicks'
CREATE TABLE `tableStaffPicks` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'table.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'admin user.id',
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`tableId`,`userId`),
  KEY `tableStaffPicsUserId` (`userId`),
  CONSTRAINT `tableStaffPicsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableStaffPicsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableStats'
CREATE TABLE `tableStats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `votesCount` int(11) unsigned DEFAULT '0' COMMENT 'upvotes',
  `viewsCount` int(11) unsigned DEFAULT '0' COMMENT 'views',
  `commentsCount` int(11) unsigned DEFAULT '0' COMMENT 'comments',
  `collaboratorCount` int(11) unsigned DEFAULT '0' COMMENT 'collaborators',
  `contributionCount` int(11) unsigned DEFAULT '0' COMMENT 'contributions',
  `tokensCount` int(11) unsigned DEFAULT '0' COMMENT 'all distributed tokens',
  `subscriberCount` int(11) unsigned DEFAULT '0' COMMENT 'subscribers',
  `unconfirmedChangesCount` int(11) unsigned DEFAULT '0' COMMENT 'changelog notification counter',
  PRIMARY KEY (`id`),
  KEY `tableId` (`tableId`),
  CONSTRAINT `tableStatsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableSubscription'
CREATE TABLE `tableSubscription` (
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `type` char(1) NOT NULL DEFAULT 'D' COMMENT 'D=Daily,W=Weekly,M=Monthly',
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`tableId`,`userId`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableSubscriptionTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableSubscriptionUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableTags'
CREATE TABLE `tableTags` (
  `tableId` int(11) unsigned NOT NULL,
  `tagId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tableId`,`tagId`),
  KEY `tableTagsTagId` (`tagId`),
  CONSTRAINT `tableTagsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableTagsTagId` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableTokens'
CREATE TABLE `tableTokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned NOT NULL,
  `rowId` int(11) unsigned DEFAULT NULL,
  `userId` int(11) unsigned NOT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `ownership` float DEFAULT NULL,
  `tokensEarned` float DEFAULT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tokensEarned` (`tokensEarned`),
  KEY `ownership` (`ownership`),
  KEY `rowId` (`rowId`),
  KEY `createdAt` (`createdAt`),
  KEY `type` (`type`),
  KEY `tableId` (`tableId`,`userId`),
  KEY `tableTokensUserId` (`userId`),
  CONSTRAINT `tableTokensRowId` FOREIGN KEY (`rowId`) REFERENCES `tableRows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableTokensTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableTokensUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableViews'
CREATE TABLE `tableViews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `createdAt` (`createdAt`),
  KEY `tableViewsUserId` (`userId`),
  KEY `tableId` (`tableId`),
  CONSTRAINT `tableViewsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableViewsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2951 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableVotes'
CREATE TABLE `tableVotes` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`tableId`,`userId`),
  KEY `tableVotesUserId` (`userId`),
  KEY `createdAt` (`createdAt`),
  CONSTRAINT `tableVotesTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableVotesUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tags'
CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'user.id',
  `title` varchar(100) DEFAULT NULL COMMENT 'tag name',
  `createdAt` int(10) DEFAULT NULL COMMENT 'timestamp',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `slug` varchar(100) DEFAULT NULL COMMENT 'slug',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `title` (`title`),
  CONSTRAINT `tableTagsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17212 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'topics'
CREATE TABLE `topics` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL COMMENT 'image url',
  `color` varchar(6) DEFAULT NULL COMMENT 'hex color',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'types'
CREATE TABLE `types` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL COMMENT 'image url',
  `color` varchar(6) DEFAULT NULL COMMENT 'hex color',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'user'
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `handle` varchar(100) DEFAULT NULL COMMENT 'usernama',
  `name` varchar(255) DEFAULT NULL COMMENT 'given name',
  `email` varchar(255) DEFAULT NULL COMMENT 'email address',
  `securitySalt` varchar(255) DEFAULT NULL COMMENT 'password',
  `authUid` varchar(100) DEFAULT NULL COMMENT 'uid of auth provider (e.g. twitter)',
  `authProvider` varchar(255) DEFAULT NULL COMMENT 'auth provider name',
  `location` varchar(100) DEFAULT NULL COMMENT 'users location',
  `description` mediumtext COMMENT 'text info about',
  `website` varchar(200) DEFAULT NULL COMMENT 'url',
  `tagline` varchar(140) DEFAULT NULL COMMENT 'tagline',
  `image` varchar(255) DEFAULT NULL COMMENT 'image url',
  `emailConfirmationToken` varchar(100) DEFAULT NULL COMMENT 'email confirmation hash',
  `passwordResetToken` varchar(255) DEFAULT '' COMMENT 'password reset hash',
  `passwordResetSentAt` int(10) DEFAULT NULL COMMENT 'hash sent at timestamp',
  `lastSessionId` varchar(100) DEFAULT NULL COMMENT 'session id',
  `lastLogin` int(10) DEFAULT NULL COMMENT 'timestamp',
  `confirmed` int(1) DEFAULT NULL COMMENT 'confirmed = 1, unconfirmed = 0',
  `status` tinyint(1) DEFAULT NULL COMMENT 'deleted = 0, active = 1',
  `roles` mediumint(8) unsigned DEFAULT '1',
  `createdAt` int(10) DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userConnections'
CREATE TABLE `userConnections` (
  `userId` int(11) unsigned NOT NULL,
  `twitter` varchar(200) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `medium` varchar(200) DEFAULT NULL,
  `dribbble` varchar(200) DEFAULT NULL,
  `behance` varchar(200) DEFAULT NULL,
  `github` varchar(200) DEFAULT NULL,
  `gitlab` varchar(200) DEFAULT NULL,
  `bitbucket` varchar(200) DEFAULT NULL,
  `slack` varchar(200) DEFAULT NULL,
  `angellist` varchar(200) DEFAULT NULL,
  `googleplus` varchar(200) DEFAULT NULL,
  `stackoverflow` varchar(200) DEFAULT NULL,
  `linkedin` varchar(200) DEFAULT NULL,
  `quora` varchar(200) DEFAULT NULL,
  `reddit` varchar(200) DEFAULT NULL,
  `ycombinator` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `visco` varchar(200) DEFAULT NULL,
  `soundcloud` varchar(200) DEFAULT NULL,
  `vsco` varchar(200) DEFAULT NULL,
  `fivehundretpx` varchar(200) DEFAULT NULL,
  `codepen` varchar(200) DEFAULT NULL,
  `producthunt` varchar(200) DEFAULT NULL,
  `discord` varchar(200) DEFAULT NULL,
  `raspberrypi` varchar(200) DEFAULT NULL,
  `periscope` varchar(200) DEFAULT NULL,
  `vimeo` varchar(200) DEFAULT NULL,
  `twitch` varchar(200) DEFAULT NULL,
  `patreon` varchar(200) DEFAULT NULL,
  `youtube` varchar(200) DEFAULT NULL,
  `deviantart` varchar(200) DEFAULT NULL,
  `bloglovin` varchar(200) DEFAULT NULL,
  `bandcamp` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  CONSTRAINT `userConnectionsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userFollower'
CREATE TABLE `userFollower` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'user.id',
  `followedByUserId` int(11) unsigned DEFAULT NULL COMMENT 'user.id that follows',
  `createdAt` int(10) DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `followedByUserId` (`followedByUserId`),
  CONSTRAINT `userFollowerFollowedByUserId` FOREIGN KEY (`followedByUserId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userFollowerUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=291 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userLocations'
CREATE TABLE `userLocations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `locationId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userLocationsUserId` (`userId`),
  KEY `userLocationsLocationId` (`locationId`),
  CONSTRAINT `userLocationsLocationId` FOREIGN KEY (`locationId`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userLocationsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userNotifications'
CREATE TABLE `userNotifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `sourceTableId` int(11) unsigned DEFAULT NULL,
  `sourceUserId` int(11) unsigned DEFAULT NULL,
  `notificationType` tinyint(5) unsigned DEFAULT NULL,
  `text` mediumtext,
  `placeholders` text,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `notificationType` (`notificationType`),
  KEY `createdAt` (`createdAt`),
  KEY `sourceTableId` (`sourceTableId`),
  KEY `sourceUserId` (`sourceUserId`),
  CONSTRAINT `userNotifcationsSourceTableId` FOREIGN KEY (`sourceTableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userNotifcationsSourceUserId` FOREIGN KEY (`sourceUserId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userNotificationsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1931 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userResetPassword'
CREATE TABLE `userResetPassword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'user.id',
  `code` varchar(48) DEFAULT NULL COMMENT 'reset code',
  `createdAt` int(11) unsigned DEFAULT NULL COMMENT 'timestamp',
  `updatedAt` int(11) DEFAULT NULL COMMENT 'timtestamp',
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `code` (`code`),
  CONSTRAINT `userResetPasswordUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userSettings'
CREATE TABLE `userSettings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'user.id',
  `followDigest` tinyint(1) unsigned DEFAULT NULL,
  `topicDigest` tinyint(1) unsigned DEFAULT NULL,
  `newProductAnnouncements` tinyint(1) unsigned DEFAULT NULL,
  `showTokensOnProfilePage` tinyint(1) unsigned DEFAULT NULL,
  `hideHeroOnHomepage` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userSettingsUserId` (`userId`),
  CONSTRAINT `userSettingsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userStats'
CREATE TABLE `userStats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `tablesOwnerCount` int(10) DEFAULT '0' COMMENT 'tables count (cache)',
  `rowsOwnerCount` int(10) DEFAULT '0' COMMENT 'rows count (cache)',
  `unreadNotificationsCount` int(10) unsigned DEFAULT '0',
  `contributionsCount` int(10) unsigned DEFAULT '0',
  `tablesCreatedCount` int(10) unsigned DEFAULT '0',
  `rejectedChangeRequestsCount` int(10) unsigned DEFAULT '0',
  `approvedChangeRequestsCount` int(10) unsigned DEFAULT '0',
  `visitedAddTablePage` tinyint(1) unsigned DEFAULT '0',
  `followerCount` int(10) unsigned DEFAULT NULL,
  `upvotesCount` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userStatsUserId` (`userId`),
  KEY `contributionsCount` (`contributionsCount`),
  KEY `upvotesCount` (`upvotesCount`),
  KEY `followerCount` (`followerCount`),
  CONSTRAINT `userStatsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userTopics'
CREATE TABLE `userTopics` (
  `userId` int(11) unsigned NOT NULL,
  `topicId` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`userId`,`topicId`),
  KEY `userTopicsTopicId` (`topicId`),
  CONSTRAINT `userTopicsTopicId` FOREIGN KEY (`topicId`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userTopicsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'wallet'
CREATE TABLE `wallet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `data` text,
  `contractAddress` varchar(200) DEFAULT NULL,
  `tokens` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `contractAddress` (`contractAddress`),
  KEY `tokens` (`tokens`),
  CONSTRAINT `walletUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

-- Enable foreign keys check when all tables are in place
SET foreign_key_checks=1;
