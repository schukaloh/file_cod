-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Апр 12 2011 г., 04:34
-- Версия сервера: 5.0.51
-- Версия PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `down`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `comments`
-- 

CREATE TABLE `comments` (
  `id` int(10) NOT NULL auto_increment,
  `file` varchar(60) NOT NULL,
  `name` varchar(30) NOT NULL,
  `comm` varchar(1000) NOT NULL,
  `comm_l` int(11) NOT NULL,
  `id_tree` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=190 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `downloads`
-- 

CREATE TABLE `downloads` (
  `file_id` int(4) NOT NULL auto_increment,
  `filename` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ver_br` varchar(150) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `aval_comm` tinyint(1) NOT NULL,
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=323 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(15) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
