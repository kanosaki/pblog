
CREATE TABLE `Posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `Body` text NOT NULL,
  `CreatedAt` int(11) unsigned NOT NULL,
  `UpdatedAt` int(11) unsigned NOT NULL,
  `AuthorID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Value` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Value` (`Value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Post_Tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `PostID` int(11) unsigned NOT NULL,
  `TagID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `PostID` (`PostID`),
  KEY `TagID` (`TagID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ScreenName` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
