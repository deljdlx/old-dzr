CREATE TABLE user (
  `id` varchar(50) PRIMARY KEY,
  `email` varchar(255),
  `name` varchar(255),
  `creation_date` datetime,
  `data` text
);

CREATE TABLE playlist (
  `id` varchar(50) PRIMARY KEY,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL
);

CREATE TABLE song (
  `id` varchar(50) PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `duration` int(10)
);

CREATE TABLE playlist_song (
  `id` varchar(50) PRIMARY KEY,
  `playlist_id` int(10) NOT NULL,
  `song_id` int(10) NOT NULL,
  `order` int(10)
);

