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
  `userId` int(11) DEFAULT NULL,
  `cellId` int(11) unsigned DEFAULT NULL,
  `from` text,
  `to` text,
  `comment` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
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
  KEY `cityId` (`cityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle rowVotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rowVotes`;

CREATE TABLE `rowVotes` (
  `rowId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`rowId`,`userId`),
  KEY `rowVotesUserId` (`userId`),
  CONSTRAINT `rowVotesRowId` FOREIGN KEY (`rowId`) REFERENCES `tableCells` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rowVotesUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableColumns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableColumns`;

CREATE TABLE `tableColumns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `width` float unsigned DEFAULT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tableId` (`tableId`)
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
  `commentId` int(11) unsigned NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`commentId`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableLocations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableLocations`;

CREATE TABLE `tableLocations` (
  `tableId` int(11) unsigned NOT NULL,
  `locationId` int(11) NOT NULL,
  PRIMARY KEY (`tableId`,`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableCells
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableCells`;

CREATE TABLE `tableCells` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `columnId` int(11) unsigned DEFAULT NULL,
  `userId` int(11) unsigned NOT NULL COMMENT 'author (user id)',
  `row` int(11) unsigned NOT NULL COMMENT 'line number',
  `content` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `votesCount` int(10) DEFAULT NULL,
  `commentsCount` int(10) DEFAULT NULL,
  `lastEditedById` int(11) unsigned NOT NULL COMMENT 'last edited (user id)',
  `lastEditAt` int(11) unsigned NOT NULL COMMENT 'timestamp',
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `lastEditedById` (`lastEditedById`),
  KEY `columnId` (`columnId`),
  CONSTRAINT `rowsLastEditedBy` FOREIGN KEY (`lastEditedById`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rowsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableLog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableLog`;

CREATE TABLE `tableLog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tableId` int(11) unsigned DEFAULT NULL,
  `logType` tinyint(1) unsigned DEFAULT NULL,
  `text` mediumtext,
  `placeholders` text,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tableId` (`tableId`),
  KEY `logType` (`logType`),
  KEY `createdAt` (`createdAt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableRelations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableRelations`;

CREATE TABLE `tableRelations` (
  `tableId` int(11) unsigned NOT NULL,
  `relatedTableId` int(11) unsigned NOT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`tableId`,`relatedTableId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableRowVotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableRowVotes`;

CREATE TABLE `tableRowVotes` (
  `rowId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`rowId`,`userId`),
  KEY `tableVotesUserId` (`userId`),
  CONSTRAINT `tablerowvotes_ibfk_1` FOREIGN KEY (`rowId`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tablerowvotes_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tables`;

CREATE TABLE `tables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ownerUserId` int(11) unsigned NOT NULL COMMENT 'author',
  `typeId` tinyint(1) unsigned DEFAULT NULL,
  `topic1Id` int(10) unsigned DEFAULT NULL,
  `topic2Id` int(10) unsigned DEFAULT NULL,
  `url` text NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `tagline` varchar(140) DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `flags` tinytext,
  `createdAt` int(10) unsigned DEFAULT NULL,
  `lastUpdateAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `typeId` (`typeId`),
  KEY `topic1Id` (`topic1Id`),
  KEY `topic2Id` (`topic2Id`),
  KEY `createdAt` (`createdAt`),
  KEY `ownerUserId` (`ownerUserId`),
  CONSTRAINT `decksTypeId` FOREIGN KEY (`typeId`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableStats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableStats`;

CREATE TABLE `tableStats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `votesCount` int(11) unsigned DEFAULT NULL,
  `viewsCount` int(11) unsigned DEFAULT NULL,
  `commentsCount` int(11) unsigned DEFAULT NULL,
  `collaboratorCount` int(11) unsigned DEFAULT NULL,
  `contributionCount` int(11) unsigned DEFAULT NULL,
  `tokensCount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableSubscription
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableSubscription`;

CREATE TABLE `tableSubscription` (
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`tableId`,`userId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableTags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableTags`;

CREATE TABLE `tableTags` (
  `tableId` int(11) unsigned NOT NULL,
  `tagId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tableId`,`tagId`)
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
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableViews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableViews`;

CREATE TABLE `tableViews` (
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`tableId`,`userId`),
  KEY `createdAt` (`createdAt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle tableVotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tableVotes`;

CREATE TABLE `tableVotes` (
  `tableId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `createdAt` int(10) unsigned DEFAULT NULL,
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
  `createdAt` int(10) DEFAULT NULL,
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
  `image` varchar(100) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `securitySalt` varchar(255) DEFAULT NULL,
  `authUid` varchar(100) DEFAULT NULL,
  `authProvider` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `description` mediumtext,
  `website` varchar(200) DEFAULT NULL,
  `tagline` varchar(140) DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userFollower
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userFollower`;

CREATE TABLE `userFollower` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `followedByUserId` int(11) DEFAULT NULL,
  `createdAt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userLocations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userLocations`;

CREATE TABLE `userLocations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `locationId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
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
  KEY `createdAt` (`createdAt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userResetPassword
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userResetPassword`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle userSettings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userSettings`;

CREATE TABLE `userSettings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `followDigest` tinyint(1) unsigned DEFAULT NULL,
  `topicDigest` tinyint(1) unsigned DEFAULT NULL,
  `newProductAnnouncements` tinyint(1) unsigned DEFAULT NULL,
  `showTokensOnProfilePage` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userSettingsUserId` (`userId`),
  CONSTRAINT `userSettingsUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
