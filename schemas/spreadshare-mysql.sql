-- Create syntax for TABLE 'rows'
CREATE TABLE `rows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL COMMENT 'author (user id)',
  `lastEditedById` int(11) unsigned NOT NULL COMMENT 'last edited (user id)',
  `lastEditAt` int(11) unsigned NOT NULL COMMENT 'timestamp',
  `line` int(11) unsigned NOT NULL COMMENT 'line number',
  `data` text NOT NULL,
  `votesCount` int(10) DEFAULT NULL,
  `commentsCount` int(10) DEFAULT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `lastEditedById` (`lastEditedById`),
  CONSTRAINT `rowsLastEditedBy` FOREIGN KEY (`lastEditedById`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rowsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'rowVotes'
CREATE TABLE `rowVotes` (
  `rowId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`rowId`,`userId`),
  KEY `rowVotesUserId` (`userId`),
  CONSTRAINT `rowVotesRowId` FOREIGN KEY (`rowId`) REFERENCES `rows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rowVotesUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableComments'
CREATE TABLE `tableComments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) unsigned DEFAULT NULL COMMENT 'parent tabelComment.id',
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `comment` text,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`parentId`),
  KEY `tableId` (`tableId`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableCommentsParentId` FOREIGN KEY (`parentId`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCommentsTabelId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCommentsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tables'
CREATE TABLE `tables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL COMMENT 'author',
  `typeId` tinyint(1) unsigned DEFAULT NULL,
  `url` text NOT NULL,
  `name` varchar(80) NOT NULL DEFAULT '',
  `description` varchar(200) DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `flags` tinytext,
  `votesCount` int(10) DEFAULT NULL,
  `commentsCount` int(10) DEFAULT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `typeId` (`typeId`),
  CONSTRAINT `decksTypeId` FOREIGN KEY (`typeId`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `decksUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableTags'
CREATE TABLE `tableTags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `title` varchar(100) DEFAULT NULL COMMENT 'tag name',
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableTagsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'tableVotes'
CREATE TABLE `tableVotes` (
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tableId`,`userId`),
  KEY `tableVotesUserId` (`userId`),
  CONSTRAINT `tableVotesTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableVotesUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'types'
CREATE TABLE `types` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `group` varchar(200) DEFAULT NULL,
  `color` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `securitySalt` varchar(255) DEFAULT NULL,
  `authUid` varchar(100) DEFAULT NULL,
  `authProvider` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `description` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `emailConfirmationToken` varchar(100) DEFAULT NULL,
  `passwordResetToken` varchar(255) DEFAULT '',
  `passwordResetSentAt` int(10) DEFAULT NULL,
  `lastSessionId` varchar(100) DEFAULT NULL,
  `creationDate` int(10) DEFAULT NULL,
  `lastLogin` int(10) DEFAULT NULL,
  `twitterUrl` varchar(200) DEFAULT NULL,
  `facebookUrl` varchar(200) DEFAULT NULL,
  `tablesOwnerCount` int(10) unsigned NOT NULL DEFAULT '0',
  `rowsOwnerCount` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
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
  CONSTRAINT `walletUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lat` int(11) unsigned NOT NULL COMMENT 'latitude',
  `lng` int(11) unsigned NOT NULL COMMENT 'longitude',
  `locationName` varchar(200) DEFAULT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Create syntax for TABLE 'userResetPassword'
CREATE TABLE `userResetPassword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `code` varchar(48) DEFAULT NULL,
  `createdAt` int(11) unsigned DEFAULT NULL,
  `updatedAt` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `code` (`code`),
  CONSTRAINT `userResetPasswordUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'userSettings'
CREATE TABLE `userSettings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `key` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userSettingsUserId` (`userId`),
  CONSTRAINT `userSettingsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;