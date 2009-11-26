-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Ноя 26 2009 г., 23:43
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `dhgate`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `address`
-- 

CREATE TABLE `address` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `contact` text,
  `title` text,
  `company` text,
  `address` text,
  `address2` text,
  `city` text,
  `postal` text,
  `region` text,
  `state` text,
  `phone` text,
  `fax` text,
  `shipping` int(1) default '0',
  `last` int(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `cart`
-- 

CREATE TABLE `cart` (
  `id` double NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `product_id` int(11) default NULL,
  `count` int(11) NOT NULL,
  `order_id` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=199 DEFAULT CHARSET=utf8 AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalog`
-- 

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `coef` float default '1',
  `title` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `connect_catalog_product`
-- 

CREATE TABLE `connect_catalog_product` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `order`
-- 

CREATE TABLE `order` (
  `id` int(11) NOT NULL auto_increment,
  `shipping` int(11) NOT NULL,
  `address_shipping` int(11) default NULL,
  `address_billing` int(11) default '0',
  `payment` int(11) default '0',
  `user_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `payment`
-- 

CREATE TABLE `payment` (
  `id` int(11) NOT NULL auto_increment,
  `title` text,
  `about` text,
  `image` varchar(100) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `product`
-- 

CREATE TABLE `product` (
  `id` int(11) NOT NULL auto_increment,
  `title` text,
  `price` float default '0',
  `short_about` text,
  `about` text NOT NULL,
  `processing` int(11) default '0',
  `free_shipping` int(1) default '0',
  `main` int(1) default '0',
  `hot` int(1) default '0',
  `active` int(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `region`
-- 

CREATE TABLE `region` (
  `id` int(11) NOT NULL auto_increment,
  `name` text,
  `coef` float default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `settings`
-- 

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `shipping`
-- 

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL auto_increment,
  `title` text,
  `about` text,
  `image` varchar(100) default '0',
  `coef` float NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `user`
-- 

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `mail` text NOT NULL,
  `admin` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `valute`
-- 

CREATE TABLE `valute` (
  `id` int(11) NOT NULL auto_increment,
  `prefix` char(3) character set utf8 collate utf8_bin default NULL,
  `rate` double default NULL,
  `default` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=13 ;
        