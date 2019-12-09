# Host: localhost  (Version 5.5.5-10.1.37-MariaDB)
# Date: 2019-03-06 12:47:06
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "akses"
#

DROP TABLE IF EXISTS `akses`;
CREATE TABLE `akses` (
  `id_akses` tinyint(3) NOT NULL AUTO_INCREMENT,
  `nama_akses` varchar(150) NOT NULL DEFAULT '',
  `hak` char(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_akses`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Data for table "akses"
#

INSERT INTO `akses` VALUES (1,'Administrator','crud');

#
# Structure for table "attachments"
#

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE `attachments` (
  `id_upload` int(11) NOT NULL AUTO_INCREMENT,
  `id_message` int(11) NOT NULL DEFAULT '0',
  `file_name` varchar(150) NOT NULL DEFAULT '',
  `file_download` varchar(100) NOT NULL DEFAULT '',
  `raw_name` varchar(100) NOT NULL DEFAULT '',
  `extension` varchar(10) NOT NULL DEFAULT '',
  `ts_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_upload`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# Data for table "attachments"
#


#
# Structure for table "category"
#

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "category"
#


#
# Structure for table "chat"
#

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL AUTO_INCREMENT,
  `id_to` varchar(150) NOT NULL DEFAULT '0',
  `id_from` varchar(150) NOT NULL DEFAULT '0',
  `pesan` text NOT NULL,
  `ts_chat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recd` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_chat`),
  KEY `from` (`id_from`),
  KEY `to` (`id_to`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

#
# Data for table "chat"
#


#
# Structure for table "files"
#

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id_file` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_kategori` int(11) NOT NULL DEFAULT '0',
  `file_nama` varchar(100) NOT NULL DEFAULT '',
  `file_download` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `size` varchar(50) NOT NULL DEFAULT '',
  `publish_from` varchar(100) NOT NULL DEFAULT '0',
  `publish_to` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "files"
#


#
# Structure for table "forum_category"
#

DROP TABLE IF EXISTS `forum_category`;
CREATE TABLE `forum_category` (
  `id_forkat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_category` varchar(50) NOT NULL DEFAULT '',
  `deskripsi` varchar(130) NOT NULL DEFAULT '',
  `jurusan` enum('FTI','FIKOM','FEB','FISIP','FT') NOT NULL DEFAULT 'FTI',
  `slug_category` varchar(150) NOT NULL DEFAULT '',
  `akses` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_forkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "forum_category"
#


#
# Structure for table "forum_comments"
#

DROP TABLE IF EXISTS `forum_comments`;
CREATE TABLE `forum_comments` (
  `id_comments` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_threads` int(11) NOT NULL DEFAULT '0',
  `komentar` text NOT NULL,
  `likes_comments` int(11) NOT NULL DEFAULT '0',
  `dislikes_comments` int(11) NOT NULL DEFAULT '0',
  `ts_comments` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comments`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "forum_comments"
#


#
# Structure for table "forum_subcategory"
#

DROP TABLE IF EXISTS `forum_subcategory`;
CREATE TABLE `forum_subcategory` (
  `id_forsubkat` int(11) NOT NULL AUTO_INCREMENT,
  `id_forkat` int(11) NOT NULL DEFAULT '0',
  `nama_subcategory` varchar(50) NOT NULL DEFAULT '',
  `deskripsi_subcategory` varchar(130) NOT NULL DEFAULT '',
  `slug_subcategory` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_forsubkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "forum_subcategory"
#


#
# Structure for table "forum_threads"
#

DROP TABLE IF EXISTS `forum_threads`;
CREATE TABLE `forum_threads` (
  `id_threads` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_forsubkat` int(11) NOT NULL DEFAULT '0',
  `title_threads` varchar(100) NOT NULL DEFAULT '',
  `slug_threads` varchar(150) NOT NULL DEFAULT '',
  `isi_threads` text NOT NULL,
  `likes_threads` int(11) NOT NULL DEFAULT '0',
  `dislikes_threads` int(11) NOT NULL DEFAULT '0',
  `ts_threads` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_threads`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "forum_threads"
#


#
# Structure for table "message"
#

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id_message` int(11) NOT NULL DEFAULT '0',
  `id_from` int(11) NOT NULL DEFAULT '0',
  `id_to` int(11) NOT NULL DEFAULT '0',
  `subject` varchar(150) NOT NULL DEFAULT '',
  `isi` text NOT NULL,
  `ts_message` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "message"
#


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_akses` tinyint(3) NOT NULL DEFAULT '0',
  `nama` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `foto_user` varchar(100) NOT NULL DEFAULT '',
  `is_online` enum('tidak','online') NOT NULL DEFAULT 'tidak',
  `ts_user` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,1,'Administrator','admin','7b2e9f54cdff413fcde01f330af6896c3cd7e6cd','admin@admin.com','avatar5.png','tidak','2019-03-03 02:40:05');

#
# Structure for table "video"
#

DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_kategori` int(5) NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL DEFAULT '',
  `file_name` varchar(150) NOT NULL DEFAULT '',
  `file_download` varchar(150) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `thumbnail` varchar(150) NOT NULL DEFAULT '',
  `tipe_file` varchar(50) NOT NULL DEFAULT '',
  `ts_video` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "video"
#

