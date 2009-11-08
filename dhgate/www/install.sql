-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Ноя 08 2009 г., 21:08
-- Версия сервера: 5.0.45f
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
  `company` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `address2` text NOT NULL,
  `city` text NOT NULL,
  `country` int(11) NOT NULL,
  `postal` text NOT NULL,
  `phone` text NOT NULL,
  `fax` text NOT NULL,
  `state` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `shipping` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `address`
-- 

INSERT INTO `address` VALUES (1, 'qwer', 'qwer', 'qwer', 'wqer', 'qwer', 0, 'qwe', 'qwer', 'qwer', 'qwer', 5, 1);
        