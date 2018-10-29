CREATE TABLE `bundles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL COMMENT 'image url',
  `createdAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  `updatedAt` int(10) unsigned DEFAULT NULL COMMENT 'timestamp',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bundleTags` (
  `bundleId` int(11) unsigned NOT NULL,
  `tagId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`bundleId`,`tagId`),
  KEY `bundleTagsTagId` (`tagId`),
  CONSTRAINT `bundleTagsBundleId` FOREIGN KEY (`bundleId`) REFERENCES `bundles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bundleTagsTagId` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------
ALTER TABLE `bundles` ADD COLUMN  `featured` tinyint(1) NOT NULL DEFAULT '0';
ALTER TABLE `bundles` ADD COLUMN  `slug` varchar(100) DEFAULT NULL COMMENT 'slug';
