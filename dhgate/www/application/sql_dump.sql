-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Ноя 07 2009 г., 20:48
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `dhgate`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `adress`
-- 

CREATE TABLE `adress` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
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
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `cart`
-- 

CREATE TABLE `cart` (
  `id` double NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `product_id` int(11) default NULL,
  `count` int(11) NOT NULL,
  `active` int(11) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 AUTO_INCREMENT=138 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalog`
-- 

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `coef` varchar(10) default '1',
  `title` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `comment_user`
-- 

CREATE TABLE `comment_user` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime default NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `connect_catalog_product`
-- 

CREATE TABLE `connect_catalog_product` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `connect_product_interested`
-- 

CREATE TABLE `connect_product_interested` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `country`
-- 

CREATE TABLE `country` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `allowed` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `order`
-- 

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `product`
-- 

CREATE TABLE `product` (
  `id` int(11) NOT NULL auto_increment,
  `title` text,
  `price` int(11) default '0',
  `short_about` text,
  `about` text NOT NULL,
  `processing` int(11) default '0',
  `free_shipping` int(1) default '0',
  `main` int(1) default '0',
  `active` int(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `rating_comment_user`
-- 

CREATE TABLE `rating_comment_user` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `text` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `state`
-- 

CREATE TABLE `state` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `country_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `user`
-- 

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `mail` text NOT NULL,
  `firstname` text,
  `middlename` text,
  `lastname` text,
  `admin` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `user_rating`
-- 

CREATE TABLE `user_rating` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        