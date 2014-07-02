-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 11, 2013 at 11:29 AM
-- Server version: 5.1.69
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `fussball`
--
CREATE DATABASE IF NOT EXISTS `fussball` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `fussball`;

-- --------------------------------------------------------

--
-- Table structure for table `Matches`
--

CREATE TABLE IF NOT EXISTS `Matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player1_id` int(10) unsigned NOT NULL,
  `player2_id` int(10) unsigned NOT NULL,
  `score1` tinyint(3) unsigned NOT NULL,
  `score2` tinyint(3) unsigned NOT NULL,
  `fixture` datetime NOT NULL,
  `winner` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `winner` (`winner`),
  KEY `player1_id` (`player1_id`),
  KEY `player2_id` (`player2_id`),
  KEY `fixture` (`fixture`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `Players`
--

CREATE TABLE IF NOT EXISTS `Players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
