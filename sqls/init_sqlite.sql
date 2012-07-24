
PRAGMA foreign_keys = ON;

CREATE TABLE `Posts` (
  `id` INTEGER,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `created_at` int(11)  NOT NULL,
  `updated_at` int(11)  NOT NULL,
  `author_id` int(11)  NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Tags` (
  `id` INTEGER,
  `value` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`value`)
);

CREATE TABLE `Post_Tag` (
  `id` INTEGER,
  `post_id` int(11)  NOT NULL,
  `tag_id` int(11)  NOT NULL,
  FOREIGN KEY(`post_id`) REFERENCES `Posts`(`id`) ON DELETE CASCADE,
  PRIMARY KEY (`id`, `post_id`, `tag_id`)
);

CREATE TABLE `Users` (
  `id` INTEGER,
  `name` varchar(50) NOT NULL DEFAULT '',
  `pass` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`name`)
);

INSERT INTO `Users`(`id`, `name`, `pass`) VALUES (1, "Admin", "f52a2f759824686540c990b76d164077");
