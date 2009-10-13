/*
SQLyog Enterprise - MySQL GUI v6.56
MySQL - 5.0.45-community-nt : Database - dhgate
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`dhgate` /*!40100 DEFAULT CHARACTER SET cp1251 */;

USE `dhgate`;

/*Table structure for table `adress` */

DROP TABLE IF EXISTS `adress`;

CREATE TABLE `adress` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `nickname` text NOT NULL,
  `title` text NOT NULL,
  `company` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `middlename` text NOT NULL,
  `adress` text,
  `adress2` text NOT NULL,
  `city` text NOT NULL,
  `zip` text NOT NULL,
  `country` text NOT NULL,
  `state` text NOT NULL,
  `phone` text NOT NULL,
  `mobilephone` text,
  `fax` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=cp1251;

/*Data for the table `adress` */

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `active` int(11) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

/*Data for the table `cart` */

/*Table structure for table `catalog` */

DROP TABLE IF EXISTS `catalog`;

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=cp1251;

/*Data for the table `catalog` */

insert  into `catalog`(`id`,`parent`,`level`,`title`) values (1,0,0,'qwer'),(2,0,0,'asdf'),(3,0,0,'zzz'),(4,0,0,'asdf'),(5,0,0,'sadfasdf'),(6,0,0,'sadfasdf'),(7,0,0,'sadfasdf'),(8,0,0,'sadfasdf'),(9,0,0,'sadfasdf'),(10,0,0,'sadfasdf'),(11,0,0,'sadfasdf');

/*Table structure for table `comment_user` */

DROP TABLE IF EXISTS `comment_user`;

CREATE TABLE `comment_user` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime default NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=cp1251;

/*Data for the table `comment_user` */

/*Table structure for table `connect_catalog_product` */

DROP TABLE IF EXISTS `connect_catalog_product`;

CREATE TABLE `connect_catalog_product` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251;

/*Data for the table `connect_catalog_product` */

/*Table structure for table `connect_product_interested` */

DROP TABLE IF EXISTS `connect_product_interested`;

CREATE TABLE `connect_product_interested` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

/*Data for the table `connect_product_interested` */

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `allowed` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=cp1251;

/*Data for the table `country` */

/*Table structure for table `order` */

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL auto_increment,
  `shipping` int(11) NOT NULL,
  `adress` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `card_number` text,
  `card_name` text NOT NULL,
  `num` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

/*Data for the table `order` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL auto_increment,
  `title` text,
  `price` int(11) NOT NULL,
  `oldprice` int(11) NOT NULL,
  `text` text NOT NULL,
  `short_about` text NOT NULL,
  `about` text NOT NULL,
  `specifications` text NOT NULL,
  `freeexpress` int(11) NOT NULL,
  `main` int(11) NOT NULL,
  `left` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251;

/*Data for the table `product` */

/*Table structure for table `rating_comment_user` */

DROP TABLE IF EXISTS `rating_comment_user`;

CREATE TABLE `rating_comment_user` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*Data for the table `rating_comment_user` */

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL auto_increment,
  `gbp` double NOT NULL,
  `usd` double NOT NULL,
  `eur` double NOT NULL,
  `about` text NOT NULL,
  `help` text NOT NULL,
  `contact` text,
  `terms` text NOT NULL,
  `privacy` text NOT NULL,
  `info` text NOT NULL,
  `window` text NOT NULL,
  `title` text NOT NULL,
  `buy` text NOT NULL,
  `payment` text NOT NULL,
  `mail` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

/*Data for the table `settings` */

/*Table structure for table `shipping` */

DROP TABLE IF EXISTS `shipping`;

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;

/*Data for the table `shipping` */

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `country_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=cp1251;

/*Data for the table `state` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `mail` text NOT NULL,
  `company` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `middlename` text NOT NULL,
  `title` text NOT NULL,
  `adress` text NOT NULL,
  `adress2` text NOT NULL,
  `city` text NOT NULL,
  `zip` text NOT NULL,
  `country` text NOT NULL,
  `state` text NOT NULL,
  `phone` text NOT NULL,
  `mobilephone` text NOT NULL,
  `fax` text NOT NULL,
  `admin` int(1) NOT NULL,
  `current_adress` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251;

/*Data for the table `user` */

/*Table structure for table `user_rating` */

DROP TABLE IF EXISTS `user_rating`;

CREATE TABLE `user_rating` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*Data for the table `user_rating` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
