-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 28 2012 г., 22:30
-- Версия сервера: 5.5.27
-- Версия PHP: 5.4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `vkusomania`
--
CREATE DATABASE `vkusomania` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `vkusomania`;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `category_name` char(40) CHARACTER SET cp1251 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) NOT NULL,
  `cat_id` int(2) NOT NULL,
  `date` date NOT NULL,
  `portion` char(10) NOT NULL,
  `cost` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_user` int(5) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `id_order` int(5) NOT NULL,
  `id_dish` int(5) NOT NULL,
  `num` int(5) NOT NULL,
  PRIMARY KEY (`id_order`,`id_dish`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL,
  `orders` int(1) NOT NULL,
  `admin` int(1) NOT NULL,
  `edit_roles` int(1) NOT NULL,
  `user_roles` int(1) NOT NULL,
  `reports` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login` char(20) NOT NULL,
  `pass` char(32) NOT NULL,
  `FIO` char(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
