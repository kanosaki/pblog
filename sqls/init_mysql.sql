
CREATE TABLE `Posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Value` (`Value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Post_Tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `PostID` (`PostID`),
  KEY `TagID` (`TagID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Users`(`id`, `name`) VALUES (1, "Admin");
