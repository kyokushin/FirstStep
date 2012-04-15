-- MySQL dump 10.11
--
-- Host: localhost    Database: music_play_list
-- ------------------------------------------------------
-- Server version	5.0.95

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
Create TABLE `music` (
  `id` int(11) NOT NULL auto_increment,
  `song_name` varchar(30) NOT NULL,
  `artist_name` varchar(30) default NULL,
  `url` text NOT NULL,
  `reffered_count` int(10) unsigned default '0',
  `url_by_user` int(11) default '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music`
--

LOCK TABLES `music` WRITE;
/*!40000 ALTER TABLE `music` DISABLE KEYS */;
/*!40000 ALTER TABLE `music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `play_list`
--

DROP TABLE IF EXISTS `play_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
Create TABLE `play_list` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(30) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_comment` text,
  `genre` text NOT NULL,
  `access_count` int(10) unsigned NOT NULL default '0',
  `created_date_time` datetime NOT NULL,
  `last_access_date_time` datetime NOT NULL,
  `state` blob,
  KEY `user_id` (`user_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `play_list`
--

LOCK TABLES `play_list` WRITE;
/*!40000 ALTER TABLE `play_list` DISABLE KEYS */;
INSERT INTO `play_list` VALUES (1,'title',1,'comment','genre',0,'2012-03-27 23:20:59','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `play_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `play_list_comment`
--

DROP TABLE IF EXISTS `play_list_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
Create TABLE `play_list_comment` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `play_list_id` int(11) NOT NULL,
  `comment` text,
  `date_time` datetime NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `play_list_id` (`play_list_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `play_list_comment`
--

LOCK TABLES `play_list_comment` WRITE;
/*!40000 ALTER TABLE `play_list_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `play_list_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `play_list_item`
--

DROP TABLE IF EXISTS `play_list_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `play_list_item` (
  `id` int(11) NOT NULL auto_increment,
  `play_list_id` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  `order_number` int(10) unsigned NOT NULL,
  `sinc` int(11) default NULL,
  `bpm` int(11) default NULL,
  `genre` varchar(30) default NULL,
  `in_out` int(10) unsigned default NULL,
  `comment` text,
  KEY `play_list_id` (`play_list_id`),
  KEY `music_id` (`music_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `play_list_item`
--

LOCK TABLES `play_list_item` WRITE;
/*!40000 ALTER TABLE `play_list_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `play_list_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
Create TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `created_date_time` datetime NOT NULL,
  `last_login_date_time` datetime NOT NULL,
  `created_play_list_num` int(10) unsigned NOT NULL default '0',
  `icon_path` text,
  `password` blob NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'test_user','2012-03-27 23:20:59','2012-03-27 23:20:59',0,'NULL','password');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-04-05  2:46:13