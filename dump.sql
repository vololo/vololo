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
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `src` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL,
  `oid` varchar(255) NOT NULL,
  `parsed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` char(1) NOT NULL DEFAULT '1',
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`),
  KEY `oid` (`oid`),
  KEY `date` (`date`),
  KEY `date_create` (`date_create`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=385 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (1,'Тест','<p>Тестовое описание</p>','http://test.ru/blog/1','2010-07-19 20:00:00','2007-11-16 20:00:00',1,'1','0000-00-00 00:00:00','1','Тестовый автор');
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ev`
--

DROP TABLE IF EXISTS `ev`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `message` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `url_linch` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ev`
--

LOCK TABLES `ev` WRITE;
/*!40000 ALTER TABLE `ev` DISABLE KEYS */;
/*!40000 ALTER TABLE `ev` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ev_vote`
--

DROP TABLE IF EXISTS `ev_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ev_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `ev` int(11) DEFAULT NULL,
  `message` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('content','navigation','design') DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `author` (`author`),
  KEY `ev` (`ev`),
  KEY `i_type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ev_vote`
--

LOCK TABLES `ev_vote` WRITE;
/*!40000 ALTER TABLE `ev_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `ev_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_blog`
--

DROP TABLE IF EXISTS `ls_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_blog` (
  `blog_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_owner_id` int(11) unsigned NOT NULL,
  `blog_title` varchar(200) NOT NULL,
  `blog_description` text NOT NULL,
  `blog_type` enum('personal','open','invite','close') DEFAULT 'personal',
  `blog_date_add` datetime NOT NULL,
  `blog_date_edit` datetime DEFAULT NULL,
  `blog_rating` float(9,3) NOT NULL DEFAULT '0.000',
  `blog_count_vote` int(11) unsigned NOT NULL DEFAULT '0',
  `blog_count_user` int(11) unsigned NOT NULL DEFAULT '0',
  `blog_limit_rating_topic` float(9,3) NOT NULL DEFAULT '0.000',
  `blog_url` varchar(200) DEFAULT NULL,
  `blog_avatar` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`blog_id`),
  KEY `user_owner_id` (`user_owner_id`),
  KEY `blog_type` (`blog_type`),
  KEY `blog_url` (`blog_url`),
  KEY `blog_title` (`blog_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_blog`
--

LOCK TABLES `ls_blog` WRITE;
/*!40000 ALTER TABLE `ls_blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_blog_user`
--

DROP TABLE IF EXISTS `ls_blog_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_blog_user` (
  `blog_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `user_role` int(3) DEFAULT '1',
  UNIQUE KEY `blog_id_user_id_uniq` (`blog_id`,`user_id`),
  KEY `blog_id` (`blog_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_blog_user`
--

LOCK TABLES `ls_blog_user` WRITE;
/*!40000 ALTER TABLE `ls_blog_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_blog_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_city`
--

DROP TABLE IF EXISTS `ls_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_city` (
  `city_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_name` varchar(30) NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `city_name` (`city_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_city`
--

LOCK TABLES `ls_city` WRITE;
/*!40000 ALTER TABLE `ls_city` DISABLE KEYS */;
INSERT INTO `ls_city` VALUES (1,'Волгоград');
/*!40000 ALTER TABLE `ls_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_city_user`
--

DROP TABLE IF EXISTS `ls_city_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_city_user` (
  `city_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`),
  KEY `city_id` (`city_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_city_user`
--

LOCK TABLES `ls_city_user` WRITE;
/*!40000 ALTER TABLE `ls_city_user` DISABLE KEYS */;
INSERT INTO `ls_city_user` VALUES (1,1);
/*!40000 ALTER TABLE `ls_city_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_comment`
--

DROP TABLE IF EXISTS `ls_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_comment` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment_pid` int(11) unsigned DEFAULT NULL,
  `target_id` int(11) unsigned DEFAULT NULL,
  `target_type` enum('topic','talk') NOT NULL DEFAULT 'topic',
  `target_parent_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `comment_text` text NOT NULL,
  `comment_text_hash` varchar(32) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_user_ip` varchar(20) NOT NULL,
  `comment_rating` float(9,3) NOT NULL DEFAULT '0.000',
  `comment_count_vote` int(11) unsigned NOT NULL DEFAULT '0',
  `comment_delete` tinyint(4) NOT NULL DEFAULT '0',
  `comment_publish` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`comment_id`),
  KEY `comment_pid` (`comment_pid`),
  KEY `type_date_rating` (`target_type`,`comment_date`,`comment_rating`),
  KEY `id_type` (`target_id`,`target_type`),
  KEY `type_delete_publish` (`target_type`,`comment_delete`,`comment_publish`),
  KEY `user_type` (`user_id`,`target_type`),
  KEY `target_parent_id` (`target_parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_comment`
--

LOCK TABLES `ls_comment` WRITE;
/*!40000 ALTER TABLE `ls_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_comment_online`
--

DROP TABLE IF EXISTS `ls_comment_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_comment_online` (
  `comment_online_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `target_id` int(11) unsigned DEFAULT NULL,
  `target_type` enum('topic','talk') NOT NULL DEFAULT 'topic',
  `target_parent_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`comment_online_id`),
  UNIQUE KEY `id_type` (`target_id`,`target_type`),
  KEY `comment_id` (`comment_id`),
  KEY `type_parent` (`target_type`,`target_parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_comment_online`
--

LOCK TABLES `ls_comment_online` WRITE;
/*!40000 ALTER TABLE `ls_comment_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_comment_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_country`
--

DROP TABLE IF EXISTS `ls_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_country` (
  `country_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(30) NOT NULL,
  PRIMARY KEY (`country_id`),
  KEY `country_name` (`country_name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_country`
--

LOCK TABLES `ls_country` WRITE;
/*!40000 ALTER TABLE `ls_country` DISABLE KEYS */;
INSERT INTO `ls_country` VALUES (1,'Россия');
/*!40000 ALTER TABLE `ls_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_country_user`
--

DROP TABLE IF EXISTS `ls_country_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_country_user` (
  `country_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_country_user`
--

LOCK TABLES `ls_country_user` WRITE;
/*!40000 ALTER TABLE `ls_country_user` DISABLE KEYS */;
INSERT INTO `ls_country_user` VALUES (1,1);
/*!40000 ALTER TABLE `ls_country_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_favourite`
--

DROP TABLE IF EXISTS `ls_favourite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_favourite` (
  `user_id` int(11) unsigned NOT NULL,
  `target_id` int(11) unsigned DEFAULT NULL,
  `target_type` enum('topic','comment','talk') DEFAULT 'topic',
  `target_publish` tinyint(1) DEFAULT '1',
  UNIQUE KEY `user_id_target_id_type` (`user_id`,`target_id`,`target_type`),
  KEY `target_publish` (`target_publish`),
  KEY `id_type` (`target_id`,`target_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_favourite`
--

LOCK TABLES `ls_favourite` WRITE;
/*!40000 ALTER TABLE `ls_favourite` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_favourite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_friend`
--

DROP TABLE IF EXISTS `ls_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_friend` (
  `user_from` int(11) unsigned NOT NULL DEFAULT '0',
  `user_to` int(11) unsigned NOT NULL DEFAULT '0',
  `status_from` int(4) NOT NULL,
  `status_to` int(4) NOT NULL,
  PRIMARY KEY (`user_from`,`user_to`),
  KEY `user_to` (`user_to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_friend`
--

LOCK TABLES `ls_friend` WRITE;
/*!40000 ALTER TABLE `ls_friend` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_friend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_invite`
--

DROP TABLE IF EXISTS `ls_invite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_invite` (
  `invite_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite_code` varchar(32) NOT NULL,
  `user_from_id` int(11) unsigned NOT NULL,
  `user_to_id` int(11) unsigned DEFAULT NULL,
  `invite_date_add` datetime NOT NULL,
  `invite_date_used` datetime DEFAULT NULL,
  `invite_used` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`invite_id`),
  UNIQUE KEY `invite_code` (`invite_code`),
  KEY `user_from_id` (`user_from_id`),
  KEY `user_to_id` (`user_to_id`),
  KEY `invite_date_add` (`invite_date_add`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_invite`
--

LOCK TABLES `ls_invite` WRITE;
/*!40000 ALTER TABLE `ls_invite` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_invite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_linch`
--

DROP TABLE IF EXISTS `ls_linch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_linch` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(11) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`topic_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_linch`
--

LOCK TABLES `ls_linch` WRITE;
/*!40000 ALTER TABLE `ls_linch` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_linch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_notify_task`
--

DROP TABLE IF EXISTS `ls_notify_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_notify_task` (
  `notify_task_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) DEFAULT NULL,
  `user_mail` varchar(50) DEFAULT NULL,
  `notify_subject` varchar(200) DEFAULT NULL,
  `notify_text` text,
  `date_created` datetime DEFAULT NULL,
  `notify_task_status` tinyint(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`notify_task_id`),
  KEY `date_created` (`date_created`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_notify_task`
--

LOCK TABLES `ls_notify_task` WRITE;
/*!40000 ALTER TABLE `ls_notify_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_notify_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_page`
--

DROP TABLE IF EXISTS `ls_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_page` (
  `page_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_pid` int(11) unsigned DEFAULT NULL,
  `page_url` varchar(50) NOT NULL,
  `page_url_full` varchar(254) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `page_text` text NOT NULL,
  `page_date_add` datetime NOT NULL,
  `page_date_edit` datetime DEFAULT NULL,
  `page_seo_keywords` varchar(250) DEFAULT NULL,
  `page_seo_description` varchar(250) DEFAULT NULL,
  `page_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `page_main` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_sort` int(11) NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `page_pid` (`page_pid`),
  KEY `page_url_full` (`page_url_full`,`page_active`),
  KEY `page_title` (`page_title`),
  KEY `page_sort` (`page_sort`),
  KEY `page_main` (`page_main`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_page`
--

LOCK TABLES `ls_page` WRITE;
/*!40000 ALTER TABLE `ls_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_reminder`
--

DROP TABLE IF EXISTS `ls_reminder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_reminder` (
  `reminder_code` varchar(32) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `reminder_date_add` datetime NOT NULL,
  `reminder_date_used` datetime DEFAULT '0000-00-00 00:00:00',
  `reminder_date_expire` datetime NOT NULL,
  `reminde_is_used` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`reminder_code`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_reminder`
--

LOCK TABLES `ls_reminder` WRITE;
/*!40000 ALTER TABLE `ls_reminder` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_reminder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_session`
--

DROP TABLE IF EXISTS `ls_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_session` (
  `session_key` varchar(32) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `session_ip_create` varchar(15) NOT NULL,
  `session_ip_last` varchar(15) NOT NULL,
  `session_date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `session_date_last` datetime NOT NULL,
  PRIMARY KEY (`session_key`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `session_date_last` (`session_date_last`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_session`
--

LOCK TABLES `ls_session` WRITE;
/*!40000 ALTER TABLE `ls_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_talk`
--

DROP TABLE IF EXISTS `ls_talk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_talk` (
  `talk_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `talk_title` varchar(200) NOT NULL,
  `talk_text` text NOT NULL,
  `talk_date` datetime NOT NULL,
  `talk_date_last` datetime NOT NULL,
  `talk_user_ip` varchar(20) NOT NULL,
  `talk_count_comment` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`talk_id`),
  KEY `user_id` (`user_id`),
  KEY `talk_title` (`talk_title`),
  KEY `talk_date` (`talk_date`),
  KEY `talk_date_last` (`talk_date_last`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_talk`
--

LOCK TABLES `ls_talk` WRITE;
/*!40000 ALTER TABLE `ls_talk` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_talk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_talk_blacklist`
--

DROP TABLE IF EXISTS `ls_talk_blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_talk_blacklist` (
  `user_id` int(10) unsigned NOT NULL,
  `user_target_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`user_target_id`),
  KEY `ls_talk_blacklist_fk_target` (`user_target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_talk_blacklist`
--

LOCK TABLES `ls_talk_blacklist` WRITE;
/*!40000 ALTER TABLE `ls_talk_blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_talk_blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_talk_user`
--

DROP TABLE IF EXISTS `ls_talk_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_talk_user` (
  `talk_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `date_last` datetime DEFAULT NULL,
  `comment_id_last` int(11) NOT NULL DEFAULT '0',
  `comment_count_new` int(11) NOT NULL DEFAULT '0',
  `talk_user_active` tinyint(1) DEFAULT '1',
  UNIQUE KEY `talk_id_user_id` (`talk_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `date_last` (`date_last`),
  KEY `date_last_2` (`date_last`),
  KEY `talk_user_active` (`talk_user_active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_talk_user`
--

LOCK TABLES `ls_talk_user` WRITE;
/*!40000 ALTER TABLE `ls_talk_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_talk_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_topic`
--

DROP TABLE IF EXISTS `ls_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_topic` (
  `topic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `topic_type` enum('topic','link','question','linch') DEFAULT 'topic',
  `topic_title` varchar(200) NOT NULL,
  `topic_linch` text,
  `topic_linchurl` varchar(255) DEFAULT NULL,
  `topic_tags` varchar(250) NOT NULL COMMENT 'tags separated by a comma',
  `topic_date_add` datetime NOT NULL,
  `topic_date_edit` datetime DEFAULT NULL,
  `topic_user_ip` varchar(20) NOT NULL,
  `topic_publish` tinyint(1) NOT NULL DEFAULT '0',
  `topic_publish_draft` tinyint(1) NOT NULL DEFAULT '1',
  `topic_publish_index` tinyint(1) NOT NULL DEFAULT '0',
  `topic_rating` float(9,3) NOT NULL DEFAULT '0.000',
  `topic_count_vote` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_count_read` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_count_comment` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_cut_text` varchar(100) DEFAULT NULL,
  `topic_forbid_comment` tinyint(1) NOT NULL DEFAULT '0',
  `topic_text_hash` varchar(32) NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `blog_id` (`blog_id`),
  KEY `user_id` (`user_id`),
  KEY `topic_date_add` (`topic_date_add`),
  KEY `topic_rating` (`topic_rating`),
  KEY `topic_publish` (`topic_publish`),
  KEY `topic_text_hash` (`topic_text_hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_topic`
--

LOCK TABLES `ls_topic` WRITE;
/*!40000 ALTER TABLE `ls_topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_topic_content`
--

DROP TABLE IF EXISTS `ls_topic_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_topic_content` (
  `topic_id` int(11) unsigned NOT NULL,
  `topic_text` longtext NOT NULL,
  `topic_text_short` text NOT NULL,
  `topic_text_source` longtext NOT NULL,
  `topic_extra` text NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_topic_content`
--

LOCK TABLES `ls_topic_content` WRITE;
/*!40000 ALTER TABLE `ls_topic_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_topic_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_topic_question_vote`
--

DROP TABLE IF EXISTS `ls_topic_question_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_topic_question_vote` (
  `topic_id` int(11) unsigned NOT NULL,
  `user_voter_id` int(11) unsigned NOT NULL,
  `answer` tinyint(4) NOT NULL,
  UNIQUE KEY `topic_id_user_id` (`topic_id`,`user_voter_id`),
  KEY `user_voter_id` (`user_voter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_topic_question_vote`
--

LOCK TABLES `ls_topic_question_vote` WRITE;
/*!40000 ALTER TABLE `ls_topic_question_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_topic_question_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_topic_read`
--

DROP TABLE IF EXISTS `ls_topic_read`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_topic_read` (
  `topic_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `date_read` datetime NOT NULL,
  `comment_count_last` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_id_last` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `topic_id_user_id` (`topic_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_topic_read`
--

LOCK TABLES `ls_topic_read` WRITE;
/*!40000 ALTER TABLE `ls_topic_read` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_topic_read` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_topic_tag`
--

DROP TABLE IF EXISTS `ls_topic_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_topic_tag` (
  `topic_tag_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `blog_id` int(11) unsigned NOT NULL,
  `topic_tag_text` varchar(50) NOT NULL,
  PRIMARY KEY (`topic_tag_id`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `blog_id` (`blog_id`),
  KEY `topic_tag_text` (`topic_tag_text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_topic_tag`
--

LOCK TABLES `ls_topic_tag` WRITE;
/*!40000 ALTER TABLE `ls_topic_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_topic_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_user`
--

DROP TABLE IF EXISTS `ls_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_mail` varchar(50) NOT NULL,
  `user_studia` varchar(255) DEFAULT NULL,
  `user_skill` float(9,3) unsigned NOT NULL DEFAULT '0.000',
  `user_date_register` datetime NOT NULL,
  `user_date_activate` datetime DEFAULT NULL,
  `user_date_comment_last` datetime DEFAULT NULL,
  `user_ip_register` varchar(20) NOT NULL,
  `user_rating` float(9,3) NOT NULL DEFAULT '0.000',
  `user_count_vote` int(11) unsigned NOT NULL DEFAULT '0',
  `user_activate` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_activate_key` varchar(32) DEFAULT NULL,
  `user_profile_name` varchar(50) DEFAULT NULL,
  `user_profile_sex` enum('man','woman','other') NOT NULL DEFAULT 'other',
  `user_profile_country` varchar(30) DEFAULT NULL,
  `user_profile_region` varchar(30) DEFAULT NULL,
  `user_profile_city` varchar(30) DEFAULT NULL,
  `user_profile_birthday` datetime DEFAULT NULL,
  `user_profile_site` varchar(200) DEFAULT NULL,
  `user_profile_site_name` varchar(50) DEFAULT NULL,
  `user_profile_icq` bigint(20) unsigned DEFAULT NULL,
  `user_profile_about` text,
  `user_profile_date` datetime DEFAULT NULL,
  `user_profile_avatar` varchar(250) DEFAULT NULL,
  `user_profile_foto` varchar(250) DEFAULT NULL,
  `user_settings_notice_new_topic` tinyint(1) NOT NULL DEFAULT '1',
  `user_settings_notice_new_comment` tinyint(1) NOT NULL DEFAULT '1',
  `user_settings_notice_new_talk` tinyint(1) NOT NULL DEFAULT '1',
  `user_settings_notice_reply_comment` tinyint(1) NOT NULL DEFAULT '1',
  `user_settings_notice_new_friend` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`),
  UNIQUE KEY `user_mail` (`user_mail`),
  KEY `user_activate_key` (`user_activate_key`),
  KEY `user_activate` (`user_activate`),
  KEY `user_rating` (`user_rating`),
  KEY `user_profile_sex` (`user_profile_sex`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_user`
--

LOCK TABLES `ls_user` WRITE;
/*!40000 ALTER TABLE `ls_user` DISABLE KEYS */;
INSERT INTO `ls_user` VALUES (1,'vololo','098f6bcd4621d373cade4e832627b4f6','info@vololo.ru',NULL,0.000,'2009-05-10 00:00:00',NULL,'2012-02-21 21:15:44','127.0.0.1',0.000,4,1,NULL,'Вася Вололошин','man','Россия',NULL,'Волгоград','1991-05-17 00:00:00','http://vololo.ru','ВОЛОЛО',NULL,NULL,'2010-07-29 21:33:46','',NULL,1,1,1,1,1);
/*!40000 ALTER TABLE `ls_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_user_administrator`
--

DROP TABLE IF EXISTS `ls_user_administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_user_administrator` (
  `user_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_user_administrator`
--

LOCK TABLES `ls_user_administrator` WRITE;
/*!40000 ALTER TABLE `ls_user_administrator` DISABLE KEYS */;
INSERT INTO `ls_user_administrator` VALUES (1);
/*!40000 ALTER TABLE `ls_user_administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls_vote`
--

DROP TABLE IF EXISTS `ls_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls_vote` (
  `target_id` int(11) unsigned NOT NULL DEFAULT '0',
  `target_type` enum('topic','blog','user','comment') NOT NULL DEFAULT 'topic',
  `user_voter_id` int(11) unsigned NOT NULL,
  `vote_direction` tinyint(2) DEFAULT '0',
  `vote_value` float(9,3) NOT NULL DEFAULT '0.000',
  `vote_date` datetime NOT NULL,
  PRIMARY KEY (`target_id`,`target_type`,`user_voter_id`),
  KEY `user_voter_id` (`user_voter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ls_vote`
--

LOCK TABLES `ls_vote` WRITE;
/*!40000 ALTER TABLE `ls_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `ls_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail`
--

DROP TABLE IF EXISTS `mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `mailid` (`title`),
  KEY `date` (`date`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail`
--

LOCK TABLES `mail` WRITE;
/*!40000 ALTER TABLE `mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_studia`
--

DROP TABLE IF EXISTS `mail_studia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_studia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailid` int(11) NOT NULL,
  `studiaid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stitle` (`studiaid`),
  KEY `mailid` (`mailid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_studia`
--

LOCK TABLES `mail_studia` WRITE;
/*!40000 ALTER TABLE `mail_studia` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_studia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_type`
--

DROP TABLE IF EXISTS `mail_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stitle` (`typeid`),
  KEY `mailid` (`mailid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_type`
--

LOCK TABLES `mail_type` WRITE;
/*!40000 ALTER TABLE `mail_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `stitle` varchar(255) DEFAULT NULL,
  `message` text,
  `cedit` char(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `i_can_edit` (`cedit`),
  KEY `i_stitle` (`stitle`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` VALUES (2,'Ошибка','error','<p>Ну вот :( вы сломали сайт.</p>','0'),(4,'Что такое ВОЛОЛО?','about','<p>ВОЛОЛО - это сервис, помогающий веб-студиям Волгограда оперативно получать информацию о деятельности друг друга. На данный момент есть возможность видеть появление новых работ в портфолио и сообщений в блогах. Также можно линчевать работы коллег и комментировать линчи.</p>\r\n\r\n<h2>В двух словах, что мне делать на ВОЛОЛО?</h2>\r\n<p>1. Самое полезное - подписка по RSS, e-mail, twitter на новые работы, блоги других студий. Воспользуйтесь кнопкой \"быть в курсе\" в правой колонке.<br />2. У нас есть <a href=\"/blog\">блог</a>, там будет основной экшн.<br />3. У нас есть линч. Он работает через блог, следите за постами.</p>\r\n\r\n<h2>Почему нас не спросили перед размещением здесь?</h2>\r\n\r\n<p>Потому что вся информация получена из открытых источников. Целью ВОЛОЛО не является копипаста работ или статей. Все материалы размещены внутри &lt;NOINDEX&gt; и это не создаст проблем дублирования контента. Везде присутствует ссылка на первоисточник. Сообщения блогов публикуются не полностью, а в виде анонса.</p>\r\n\r\n<h2>По какому принципу ранжируется информация?</h2>\r\n\r\n<p>Студии сортируются по дате добавления последней работы в портфолио, все остальное - по дате появления на ВОЛОЛО. Приоритетных размещений нет.</p>\r\n\r\n<h2>Что мне делать с ВОЛОЛО?</h2>\r\n\r\n<p>Подписаться на RSS, e-mail рассылку или зафоловить ВОЛОЛО в Твиттере. Так можно получать уведомленя о новых работах или статьях коллег.</p>\r\n\r\n<h2>Кто сделал ВОЛОЛО?</h2>\r\n\r\n<p>Это не сложно узнать, но афишироваться это не будет. В любом случае проект некоммерческий и не носит релкамного характера. Пожалуйста, не разглашайте эту информацию. Нам всем будет так легче.</p>\r\n\r\n<h2>Чего ждать от ВОЛОЛО?</h2>\r\n\r\n<p>Во-первых, постепенного включения всех даже самых маленьких студий. Во-вторых - новых сервисов: слухи (возможность постить и читать слухи и инсайдерскую информацию студий), синтетические тесты сайтов, сделанных студиями (валидность, скорость работы, стресс-тесты, среднее время отклика, использование технологий, вес), твиттеры студий, указание людей, делавших проект (где такую информацию можно найти).</p>','0'),(12,'Кто сделал ВОЛОЛО?','iloveyou','<p>Друзья, узнать кто сделал ВОЛОЛО не сложно. Есть прямые и косвенные указания на это в интернете.</p><p>Если вы узнали это - напишите о своей находке на <a href=\"mailto:info@vololo.ru\">info@vololo.ru</a>, мы обсудим ваши изыскания. Не пишите об этом на ВОЛОЛО. Мы не афишируем принадлежность сайта не из страха преследования, негодования, мы не хотим анонимно говнить все и вся. Мы скрыты, потому что не хотим рекламировать всем подряд себя и не хотим раздражать вас этим.</p><p>Спасибо за понимание, давайте разделим этот маленький секрет.</p>','1'),(13,'Как уйти из ВОЛОЛО?','ihateyou','<p>Процедуры выхода отсюда не предусмотрено. Представьте, что вы кинозвезда, а мы - папарацци.</p>\r\n<p>ВОЛОЛО допускает некоторые вольности с данными, полученными без вашего согласия. Если вы обоснованно попросите некоторые данные изъять или скрыть - мы это сделаем. Но это не касается тех данных, которые общедоступны и на которые у вас нет авторских прав.</p>\r\n<p>Если вы считаете, что мы нарушаем ваши права - пишите на <a href=\"mailto:info@vololo.ru\">info@vololo.ru</a>, мы сможем обсудить вашу проблему.</p>','1');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `src` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_create` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL,
  `oid` varchar(255) NOT NULL,
  `parsed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`),
  KEY `oid` (`oid`),
  KEY `date` (`date`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=1705 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES (1,'Тестовая работа','test.ru','http://pics.livejournal.com/so_wenok/pic/00099479','<p>Тестовое описание</p>','http://test.ru/work/1','2010-07-24 20:00:00','0000-00-00 00:00:00',1,'1','0000-00-00 00:00:00','1');
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studia`
--

DROP TABLE IF EXISTS `studia`;
CREATE TABLE IF NOT EXISTS `studia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `stitle` varchar(255) NOT NULL,
  `parsed_portfolio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `src_portfolio` varchar(255) NOT NULL,
  `parsed_blog` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `src_blog` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stitle` (`stitle`),
  KEY `parsed_portfolio` (`parsed_portfolio`),
  KEY `parsed_blog` (`parsed_blog`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `studia`
--

INSERT INTO `studia` (`id`, `title`, `url`, `message`, `stitle`, `parsed_portfolio`, `src_portfolio`, `parsed_blog`, `src_blog`) VALUES
(1, 'Интерволга', 'http://intervolga.ru', '', 'intervolga', '2012-02-21 10:52:04', '', '2012-02-21 01:35:23', ''),
(2, 'ClickON', 'http://clickon.ru', '', 'clickon', '2012-02-21 11:20:50', '', '2012-02-21 10:36:18', ''),
(3, 'Веб-решение', 'http://web-decision.ru', '', 'webdecision', '2012-02-21 11:54:48', '', '2012-02-21 11:05:30', ''),
(4, 'IRCIT', 'http://ircit.ru', '', 'ircit', '2012-02-21 12:20:05', '', '2012-02-21 02:35:03', ''),
(5, 'Web++', 'http://webpp.ru', '', 'webpp', '2012-02-21 12:51:02', '', '2012-02-21 11:35:01', ''),
(6, '21 век', 'http://21age.ru', '', '21age', '2012-02-21 13:20:15', '', '2012-02-21 12:05:02', ''),
(7, 'JinnWeb', 'http://jinnweb.ru', '', 'jinnweb', '2012-02-21 13:50:04', '', '2012-02-21 12:35:02', ''),
(17, 'Stride', 'http://stride.ru', '', 'stride', '2012-02-21 04:21:34', '', '2012-02-21 13:05:01', ''),
(9, 'Mechanical Frog', 'http://mfrog.ru', '', 'mfrog', '2012-02-21 15:50:14', '', '2012-02-21 13:35:01', ''),
(10, 'RW Русский веб', 'http://rw1.ru', '', 'rw1', '2012-02-21 16:20:03', '', '2012-02-21 14:05:02', ''),
(11, 'InterWeb', 'http://inweb.ru', '', 'inweb', '2012-02-21 18:50:04', '', '2012-02-21 14:35:02', ''),
(15, 'АртНет', 'http://artnet-studio.ru', '', 'artnet', '2012-02-21 00:50:10', '', '2012-02-21 15:05:02', ''),
(8, 'Магвай', 'http://magwai.ru', '', 'magwai', '2012-02-21 08:20:02', 'http://magwai.ru/x.json', '2012-02-21 19:05:04', 'http://blog.magwai.ru/feed/rss2'),
(18, 'Vivastudio', 'http://vivastudio.ru', '', 'vivastudio', '2012-02-21 01:20:09', '', '2012-02-21 15:35:02', ''),
(19, 'Studia7', 'http://studia7.com', '', 'studia7', '2012-02-21 01:50:20', '', '2012-02-21 16:05:02', ''),
(20, 'Modesco', 'http://modesco.ru', '', 'modesco', '2012-02-21 02:20:02', '', '2012-02-21 16:35:01', ''),
(21, 'Konovalov&Ershov', 'http://konovalovershov.ru', '', 'ke', '2012-02-21 04:50:02', '', '2012-02-21 17:05:02', ''),
(26, 'Студия Циколия', 'http://tsikoliya.ru', '', 'ts', '2012-02-21 05:20:04', '', '2012-02-21 17:35:02', ''),
(24, 'WEB-V', 'http://web-v.ru/', '', 'webv', '2012-02-21 05:50:14', '', '2012-02-21 18:35:02', ''),
(25, 'Бизнес-Альянс', 'http://b-alt.ru/', '', 'balt', '2012-02-21 06:20:03', '', '2012-02-21 19:35:02', ''),
(27, 'Актуальные Медиа', 'http://actual-media.ru/', '', 'actual', '2012-02-21 06:50:03', '', '2012-02-21 03:05:02', ''),
(28, 'ONVOLGA', 'http://onvolga.ru', '', 'onvolga', '2012-02-21 07:20:15', '', '2012-02-21 03:35:02', ''),
(29, 'Дефейс', 'http://df34.ru', '', 'df34', '2012-02-21 16:50:08', '', '2012-02-21 04:05:02', '');

--
-- Table structure for table `txt`
--

DROP TABLE IF EXISTS `txt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `txt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `i_key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `txt`
--

LOCK TABLES `txt` WRITE;
/*!40000 ALTER TABLE `txt` DISABLE KEYS */;
INSERT INTO `txt` VALUES (1,'site_title','Заголовок сайта','ВОЛОЛО'),(14,'txt_shout','Текст: объявление','');
/*!40000 ALTER TABLE `txt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `stitle` varchar(255) NOT NULL,
  `orderid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stitle` (`stitle`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,'Портфолио','portfolio',1),(2,'Блоги','blog',2);
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `url`
--

DROP TABLE IF EXISTS `url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `map` varchar(255) DEFAULT NULL,
  `orderid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i_orderid` (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `url`
--

LOCK TABLES `url` WRITE;
/*!40000 ALTER TABLE `url` DISABLE KEYS */;
INSERT INTO `url` VALUES (50,'iloveyou','page','iloveyou',NULL,2),(49,'about','page','about',NULL,1),(51,'ihateyou','page','ihateyou',NULL,3),(52,'mail/(.*)/(.*)','mail','index','type,studia',4),(53,'rss/(.*)/(.*)','rss','index','type,studia',5),(54,'mail/unsubscribe/(.*)','mail','unsubscribe','mail',6),(55,'studia/(.*)','studia','index','id',7),(56,'studia/(.*)/portfolio/(.*)','portfolio','index','studia,id',8),(57,'studia/(.*)/blog/(.*)','blog','index','studia,id',9),(58,'konkurs/(.*)','ev','index','year',10),(59,'konkurs/vote','ev','vote','',11);
/*!40000 ALTER TABLE `url` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;