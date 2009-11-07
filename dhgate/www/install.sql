/*
SQLyog Enterprise - MySQL GUI v6.56
MySQL - 5.1.35-community : Database - dhgate
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`dhgate` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dhgate`;

/*Table structure for table `adress` */

DROP TABLE IF EXISTS `adress`;

CREATE TABLE `adress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `nickname` text,
  `title` text,
  `company` text,
  `adress` text,
  `adress2` text,
  `city` text,
  `zip` text,
  `country` text,
  `state` text,
  `phone` text,
  `fax` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `adress` */

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` double NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL,
  `active` int(11) DEFAULT '1',
  `order_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cart` */

insert  into `cart`(`id`,`user_id`,`product_id`,`count`,`active`,`order_id`) values (2,1,87,2,1,0);

/*Table structure for table `catalog` */

DROP TABLE IF EXISTS `catalog`;

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `coef` varchar(10) DEFAULT '1',
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

/*Data for the table `catalog` */

insert  into `catalog`(`id`,`parent`,`level`,`coef`,`title`) values (85,0,0,'1','Ñ‚ÐµÑÑ‚');

/*Table structure for table `comment_user` */

DROP TABLE IF EXISTS `comment_user`;

CREATE TABLE `comment_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `comment_user` */

/*Table structure for table `connect_catalog_product` */

DROP TABLE IF EXISTS `connect_catalog_product`;

CREATE TABLE `connect_catalog_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

/*Data for the table `connect_catalog_product` */

insert  into `connect_catalog_product`(`id`,`category_id`,`item_id`) values (86,85,86),(87,85,87);

/*Table structure for table `connect_product_interested` */

DROP TABLE IF EXISTS `connect_product_interested`;

CREATE TABLE `connect_product_interested` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `connect_product_interested` */

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `allowed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `country` */

/*Table structure for table `order` */

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `order` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `price` int(11) DEFAULT '0',
  `short_about` text,
  `about` text NOT NULL,
  `processing` int(11) DEFAULT '0',
  `free_shipping` int(1) DEFAULT '0',
  `main` int(1) DEFAULT '0',
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`title`,`price`,`short_about`,`about`,`processing`,`free_shipping`,`main`,`active`) values (86,'Ñ„Ñ‹Ð²Ð°',32,'32','Ð¹Ñ†ÑƒÐºÐ¹Ñ†ÑƒÐºÐ¹Ñ†ÑƒÐº',2,0,0,1),(87,'345',3,'345','34523',4,0,0,1);

/*Table structure for table `rating_comment_user` */

DROP TABLE IF EXISTS `rating_comment_user`;

CREATE TABLE `rating_comment_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `rating_comment_user` */

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `settings` */

/*Table structure for table `shipping` */

DROP TABLE IF EXISTS `shipping`;

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `shipping` */

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `state` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `mail` text NOT NULL,
  `firstname` text,
  `middlename` text,
  `lastname` text,
  `admin` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`login`,`pass`,`mail`,`firstname`,`middlename`,`lastname`,`admin`) values (1,'asdf','6a204bd89f3c8348afd5c77c717a097a','zloy.max@gmail.com',NULL,NULL,NULL,0);

/*Table structure for table `user_rating` */

DROP TABLE IF EXISTS `user_rating`;

CREATE TABLE `user_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `user_rating` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
