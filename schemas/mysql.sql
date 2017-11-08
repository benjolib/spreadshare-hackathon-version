CREATE DATABASE IF NOT EXISTS spreadshare;
USE spreadshare;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle changeRequests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `changeRequests`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle cities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(200) DEFAULT NULL,
  `region` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `continent` varchar(200) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cityId` int(11) unsigned DEFAULT NULL,
  `lat` int(11) unsigned NOT NULL COMMENT 'latitude',
  `lng` int(11) unsigned NOT NULL COMMENT 'longitude',
  `locationName` varchar(200) DEFAULT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cityId` (`cityId`),
  CONSTRAINT `locationsCityId` FOREIGN KEY (`cityId`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableCells
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableCells`;

CREATE TABLE `tableCells` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL COMMENT 'author (user id)',
  `columnId` int(11) unsigned DEFAULT NULL COMMENT 'associated column (tableColumns.id)',
  `rowId` int(11) unsigned DEFAULT NULL,
  `content` text NOT NULL COMMENT 'text content of row',
  `link` varchar(255) DEFAULT NULL COMMENT 'optional link (http://..)',
  `lastEditedById` int(11) unsigned NOT NULL COMMENT 'last edited (user id)',
  `lastEditAt` int(11) unsigned NOT NULL COMMENT 'timestamp',
  `createdAt` int(10) DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `lastEditedById` (`lastEditedById`),
  KEY `columnId` (`columnId`),
  KEY `rowId` (`rowId`),
  CONSTRAINT `tableCellsColumnId` FOREIGN KEY (`columnId`) REFERENCES `tableColumns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCellsLastEditedById` FOREIGN KEY (`lastEditedById`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCellsRowId` FOREIGN KEY (`rowId`) REFERENCES `tableRows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCellsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableColumns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableColumns`;

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
  CONSTRAINT `tableColumnsTableid` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableColumnsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableComments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableComments`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableCommentVotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableCommentVotes`;

CREATE TABLE `tableCommentVotes` (
  `commentId` int(11) unsigned NOT NULL COMMENT 'tableComments.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user that created the comment (user.id)',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`commentId`,`userId`),
  KEY `tableCommentVotesUserid` (`userId`),
  CONSTRAINT `tableCommentVotesCommentId` FOREIGN KEY (`commentId`) REFERENCES `tableComments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableCommentVotesUserid` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableLocations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableLocations`;

CREATE TABLE `tableLocations` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `locationId` int(11) unsigned NOT NULL COMMENT 'locations.id',
  PRIMARY KEY (`tableId`,`locationId`),
  KEY `tableLocationsLocationId` (`locationId`),
  CONSTRAINT `tableLocationsLocationId` FOREIGN KEY (`locationId`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableLocationsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableLog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableLog`;

CREATE TABLE `tableLog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned DEFAULT NULL COMMENT 'tables.id',
  `logType` tinyint(1) unsigned DEFAULT NULL COMMENT 'log type',
  `text` mediumtext COMMENT 'log text',
  `placeholders` text COMMENT 'json placeholders',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `tableId` (`tableId`),
  KEY `logType` (`logType`),
  KEY `createdAt` (`createdAt`),
  CONSTRAINT `tableLogTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableRelations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableRelations`;

CREATE TABLE `tableRelations` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `relatedTableId` int(11) unsigned NOT NULL COMMENT 'relation to another table (tables.id)',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`tableId`,`relatedTableId`),
  KEY `tableRelationsRelatedTableId` (`relatedTableId`),
  CONSTRAINT `tableRelationsRelatedTableId` FOREIGN KEY (`relatedTableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableRelationsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableRows
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableRows`;

CREATE TABLE `tableRows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'user that created the row',
  `content` longtext COMMENT 'cached json content for row',
  `votesCount` int(11) DEFAULT NULL COMMENT 'total votes cache',
  `commentsCount` int(11) DEFAULT NULL COMMENT 'total comments cache',
  `lastEdited` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableRowsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableRowVotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableRowVotes`;

CREATE TABLE `tableRowVotes` (
  `rowId` int(11) unsigned NOT NULL COMMENT 'tableRows.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`rowId`,`userId`),
  KEY `tableVotesUserId` (`userId`),
  CONSTRAINT `tableRowVotesRowId` FOREIGN KEY (`rowId`) REFERENCES `tableRows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableRowVotesUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tables`;

CREATE TABLE `tables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ownerUserId` int(11) unsigned NOT NULL COMMENT 'author',
  `typeId` tinyint(1) unsigned DEFAULT NULL COMMENT 'table type (types.id)',
  `topic1Id` tinyint(1) unsigned DEFAULT NULL COMMENT 'first topic (topics.id)',
  `topic2Id` tinyint(1) unsigned DEFAULT NULL COMMENT 'second topic (topics.id)',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT 'table name',
  `tagline` varchar(140) DEFAULT '' COMMENT 'description',
  `image` varchar(255) DEFAULT NULL COMMENT 'image url',
  `flags` tinytext,
  `lastUpdateAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableStats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableStats`;

CREATE TABLE `tableStats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `votesCount` int(11) unsigned DEFAULT NULL COMMENT 'upvotes',
  `viewsCount` int(11) unsigned DEFAULT NULL COMMENT 'views',
  `commentsCount` int(11) unsigned DEFAULT NULL COMMENT 'comments',
  `collaboratorCount` int(11) unsigned DEFAULT NULL COMMENT 'collaborators',
  `contributionCount` int(11) unsigned DEFAULT NULL COMMENT 'contributions',
  `tokensCount` int(11) DEFAULT NULL COMMENT 'all distributed tokens',
  PRIMARY KEY (`id`),
  KEY `tableId` (`tableId`),
  CONSTRAINT `tableStatsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableSubscription
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableSubscription`;

CREATE TABLE `tableSubscription` (
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`tableId`,`userId`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableSubscriptionTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableSubscriptionUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableTags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableTags`;

CREATE TABLE `tableTags` (
  `tableId` int(11) unsigned NOT NULL,
  `tagId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tableId`,`tagId`),
  KEY `tableTagsTagId` (`tagId`),
  CONSTRAINT `tableTagsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableTagsTagId` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableTokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableTokens`;

CREATE TABLE `tableTokens` (
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `ownership` float DEFAULT NULL,
  `tokensEarned` float DEFAULT NULL,
  PRIMARY KEY (`tableId`,`userId`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableTokensTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableTokensUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableViews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableViews`;

CREATE TABLE `tableViews` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`tableId`,`userId`),
  KEY `createdAt` (`createdAt`),
  KEY `tableViewsUserId` (`userId`),
  CONSTRAINT `tableViewsTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableViewsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableVotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableVotes`;

CREATE TABLE `tableVotes` (
  `tableId` int(11) unsigned NOT NULL COMMENT 'tables.id',
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`tableId`,`userId`),
  KEY `tableVotesUserId` (`userId`),
  CONSTRAINT `tableVotesTableId` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tableVotesUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL COMMENT 'user.id',
  `title` varchar(100) DEFAULT NULL COMMENT 'tag name',
  `createdAt` int(10) DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `tableTagsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle topics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `topics`;

CREATE TABLE `topics` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL COMMENT 'image url',
  `color` varchar(6) DEFAULT NULL COMMENT 'hex color',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL COMMENT 'image url',
  `color` varchar(6) DEFAULT NULL COMMENT 'hex color',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

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
  `createdAt` int(10) DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userConnections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userConnections`;

CREATE TABLE `userConnections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
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
  `stackoverlflow` varchar(200) DEFAULT NULL,
  `linkedin` varchar(200) DEFAULT NULL,
  `quora` varchar(200) DEFAULT NULL,
  `reddit` varchar(200) DEFAULT NULL,
  `ycombinator` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `visco` varchar(200) DEFAULT NULL,
  `soundcloud` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `userConnectionsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userFollower
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userFollower`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userLocations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userLocations`;

CREATE TABLE `userLocations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `locationId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userLocationsUserId` (`userId`),
  KEY `userLocationsLocationId` (`locationId`),
  CONSTRAINT `userLocationsLocationId` FOREIGN KEY (`locationId`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userLocationsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userNotifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userNotifications`;

CREATE TABLE `userNotifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `notificationType` tinyint(5) unsigned DEFAULT NULL,
  `text` mediumtext,
  `placeholders` text,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `notificationType` (`notificationType`),
  KEY `createdAt` (`createdAt`),
  CONSTRAINT `userNotificationsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userResetPassword
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userResetPassword`;

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



# Export von Tabelle userSettings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userSettings`;

CREATE TABLE `userSettings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL COMMENT 'user.id',
  `followDigest` tinyint(1) unsigned DEFAULT NULL,
  `topicDigest` tinyint(1) unsigned DEFAULT NULL,
  `newProductAnnouncements` tinyint(1) unsigned DEFAULT NULL,
  `showTokensOnProfilePage` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userSettingsUserId` (`userId`),
  CONSTRAINT `userSettingsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userStats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userStats`;

CREATE TABLE `userStats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `tablesOwnerCount` int(10) DEFAULT NULL COMMENT 'tables count (cache)',
  `rowsOwnerCount` int(10) DEFAULT NULL COMMENT 'rows count (cache)',
  PRIMARY KEY (`id`),
  KEY `userStatsUserId` (`userId`),
  CONSTRAINT `userStatsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle wallet
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet`;

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




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
