-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生日期: 2014 年 01 月 25 日 18:41
-- 伺服器版本: 5.5.32
-- PHP 版本: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `elearning`
--

-- --------------------------------------------------------

--
-- 表的結構 `chu_belong`
--

CREATE TABLE IF NOT EXISTS `chu_belong` (
  `TID` int(10) unsigned NOT NULL,
  `ThemeID` int(10) unsigned NOT NULL,
  `Weights` float NOT NULL COMMENT '當次學習主題的某一個學習標的之權重',
  PRIMARY KEY (`TID`,`ThemeID`),
  KEY `ThemeID` (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和主題之間';

--
-- 轉存資料表中的資料 `chu_belong`
--

INSERT INTO `chu_belong` (`TID`, `ThemeID`, `Weights`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 1, 7),
(5, 1, 4),
(6, 1, 5),
(7, 1, 2),
(8, 1, 6),
(9, 1, 7),
(10, 1, 9),
(11, 1, 6),
(12, 1, 4),
(13, 1, 5),
(14, 1, 5),
(15, 1, 9),
(16, 1, 1),
(17, 1, 2),
(18, 1, 4),
(19, 1, 7),
(20, 1, 4),
(21, 1, 5),
(22, 1, 2),
(23, 1, 6),
(24, 1, 7),
(25, 1, 9),
(26, 1, 6),
(27, 1, 4),
(28, 1, 5),
(29, 1, 5),
(30, 1, 9);

-- --------------------------------------------------------

--
-- 表的結構 `chu_edge`
--

CREATE TABLE IF NOT EXISTS `chu_edge` (
  `Ti` int(10) unsigned NOT NULL,
  `Tj` int(10) unsigned NOT NULL,
  `MoveTime` varchar(20) NOT NULL COMMENT '移動時間(分鐘)',
  `Distance` varchar(20) NOT NULL COMMENT '距離(M)',
  PRIMARY KEY (`Ti`,`Tj`),
  KEY `Tj` (`Tj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的和標的之間';

--
-- 轉存資料表中的資料 `chu_edge`
--

INSERT INTO `chu_edge` (`Ti`, `Tj`, `MoveTime`, `Distance`) VALUES
(0, 1, '0', '0'),
(0, 2, '0', '0'),
(0, 3, '0', '0'),
(0, 4, '0', '0'),
(0, 5, '0', '0'),
(0, 6, '0', '0'),
(0, 7, '0', '0'),
(0, 8, '0', '0'),
(0, 9, '0', '0'),
(0, 10, '0', '0'),
(0, 11, '0', '0'),
(0, 12, '0', '0'),
(0, 13, '0', '0'),
(0, 14, '0', '0'),
(0, 15, '0', '0'),
(0, 16, '0', '2'),
(0, 17, '1', '2'),
(0, 18, '1', '2'),
(0, 19, '1', '2'),
(0, 20, '2', '3'),
(0, 21, '2', '3'),
(0, 22, '3', '3'),
(0, 23, '3', '4'),
(0, 24, '3', '4'),
(0, 25, '4', '4'),
(0, 26, '4', '5'),
(0, 27, '5', '5'),
(0, 28, '5', '6'),
(0, 29, '6', '6'),
(0, 30, '6', '7'),
(1, 2, '0', '0'),
(1, 3, '0', '0'),
(1, 4, '0', '0'),
(1, 5, '0', '0'),
(1, 6, '0', '0'),
(1, 7, '0', '0'),
(1, 8, '0', '0'),
(1, 9, '0', '0'),
(1, 10, '0', '0'),
(1, 11, '0', '0'),
(1, 12, '0', '0'),
(1, 13, '0', '0'),
(1, 14, '0', '0'),
(1, 15, '0', '0'),
(1, 16, '1', '0'),
(1, 17, '1', '0'),
(1, 18, '1', '0'),
(1, 19, '2', '0'),
(1, 20, '2', '0'),
(1, 21, '2', '0'),
(1, 22, '2', '0'),
(1, 23, '2', '0'),
(1, 24, '3', '0'),
(1, 25, '3', '0'),
(1, 26, '4', '0'),
(1, 27, '4', '0'),
(1, 28, '4', '0'),
(1, 29, '6', '0'),
(1, 30, '1', '0'),
(2, 1, '0', '0'),
(2, 3, '0', '0'),
(2, 4, '0', '0'),
(2, 5, '0', '0'),
(2, 6, '0', '0'),
(2, 7, '0', '0'),
(2, 8, '0', '0'),
(2, 9, '0', '0'),
(2, 10, '0', '0'),
(2, 11, '0', '0'),
(2, 12, '0', '0'),
(2, 13, '0', '0'),
(2, 14, '0', '0'),
(2, 15, '0', '0'),
(2, 16, '1', '0'),
(2, 17, '1', '0'),
(2, 18, '1', '0'),
(2, 19, '1', '0'),
(2, 20, '1', '0'),
(2, 21, '1', '0'),
(2, 22, '1', '0'),
(2, 23, '1', '0'),
(2, 24, '2', '0'),
(2, 25, '2', '0'),
(2, 26, '3', '0'),
(2, 27, '3', '0'),
(2, 28, '3', '0'),
(2, 29, '5', '0'),
(2, 30, '1', '0'),
(3, 1, '0', '0'),
(3, 2, '0', '0'),
(3, 4, '0', '0'),
(3, 5, '0', '0'),
(3, 6, '0', '0'),
(3, 7, '0', '0'),
(3, 8, '0', '0'),
(3, 9, '0', '0'),
(3, 10, '0', '0'),
(3, 11, '0', '0'),
(3, 12, '0', '0'),
(3, 13, '0', '0'),
(3, 14, '0', '0'),
(3, 15, '0', '0'),
(3, 16, '1', '0'),
(3, 17, '1', '0'),
(3, 18, '1', '0'),
(3, 19, '1', '0'),
(3, 20, '1', '0'),
(3, 21, '1', '0'),
(3, 22, '1', '0'),
(3, 23, '1', '0'),
(3, 24, '2', '0'),
(3, 25, '2', '0'),
(3, 26, '3', '0'),
(3, 27, '3', '0'),
(3, 28, '3', '0'),
(3, 29, '5', '0'),
(3, 30, '1', '0'),
(4, 1, '0', '0'),
(4, 2, '0', '0'),
(4, 3, '0', '0'),
(4, 5, '0', '0'),
(4, 6, '0', '0'),
(4, 7, '0', '0'),
(4, 8, '0', '0'),
(4, 9, '0', '0'),
(4, 10, '0', '0'),
(4, 11, '0', '0'),
(4, 12, '0', '0'),
(4, 13, '0', '0'),
(4, 14, '0', '0'),
(4, 15, '0', '0'),
(4, 16, '1', '0'),
(4, 17, '1', '0'),
(4, 18, '1', '0'),
(4, 19, '1', '0'),
(4, 20, '1', '0'),
(4, 21, '1', '0'),
(4, 22, '1', '0'),
(4, 23, '1', '0'),
(4, 24, '2', '0'),
(4, 25, '2', '0'),
(4, 26, '3', '0'),
(4, 27, '3', '0'),
(4, 28, '3', '0'),
(4, 29, '5', '0'),
(4, 30, '1', '0'),
(5, 1, '0', '0'),
(5, 2, '0', '0'),
(5, 3, '0', '0'),
(5, 4, '0', '0'),
(5, 6, '0', '0'),
(5, 7, '0', '0'),
(5, 8, '0', '0'),
(5, 9, '0', '0'),
(5, 10, '0', '0'),
(5, 11, '0', '0'),
(5, 12, '0', '0'),
(5, 13, '0', '0'),
(5, 14, '0', '0'),
(5, 15, '0', '0'),
(5, 16, '2', '0'),
(5, 17, '1', '0'),
(5, 18, '1', '0'),
(5, 19, '1', '0'),
(5, 20, '1', '0'),
(5, 21, '1', '0'),
(5, 22, '1', '0'),
(5, 23, '1', '0'),
(5, 24, '1', '0'),
(5, 25, '1', '0'),
(5, 26, '2', '0'),
(5, 27, '2', '0'),
(5, 28, '2', '0'),
(5, 29, '4', '0'),
(5, 30, '2', '0'),
(6, 1, '0', '0'),
(6, 2, '0', '0'),
(6, 3, '0', '0'),
(6, 4, '0', '0'),
(6, 5, '0', '0'),
(6, 7, '0', '0'),
(6, 8, '0', '0'),
(6, 9, '0', '0'),
(6, 10, '0', '0'),
(6, 11, '0', '0'),
(6, 12, '0', '0'),
(6, 13, '0', '0'),
(6, 14, '0', '0'),
(6, 15, '0', '0'),
(6, 16, '2', '0'),
(6, 17, '1', '0'),
(6, 18, '1', '0'),
(6, 19, '1', '0'),
(6, 20, '1', '0'),
(6, 21, '1', '0'),
(6, 22, '1', '0'),
(6, 23, '1', '0'),
(6, 24, '1', '0'),
(6, 25, '1', '0'),
(6, 26, '2', '0'),
(6, 27, '2', '0'),
(6, 28, '2', '0'),
(6, 29, '4', '0'),
(6, 30, '2', '0'),
(7, 1, '0', '0'),
(7, 2, '0', '0'),
(7, 3, '0', '0'),
(7, 4, '0', '0'),
(7, 5, '0', '0'),
(7, 6, '0', '0'),
(7, 8, '0', '0'),
(7, 9, '0', '0'),
(7, 10, '0', '0'),
(7, 11, '0', '0'),
(7, 12, '0', '0'),
(7, 13, '0', '0'),
(7, 14, '0', '0'),
(7, 15, '0', '0'),
(7, 16, '2', '0'),
(7, 17, '1', '0'),
(7, 18, '1', '0'),
(7, 19, '1', '0'),
(7, 20, '1', '0'),
(7, 21, '1', '0'),
(7, 22, '1', '0'),
(7, 23, '1', '0'),
(7, 24, '1', '0'),
(7, 25, '1', '0'),
(7, 26, '2', '0'),
(7, 27, '2', '0'),
(7, 28, '2', '0'),
(7, 29, '4', '0'),
(7, 30, '2', '0'),
(8, 1, '0', '0'),
(8, 2, '0', '0'),
(8, 3, '0', '0'),
(8, 4, '0', '0'),
(8, 5, '0', '0'),
(8, 6, '0', '0'),
(8, 7, '0', '0'),
(8, 9, '0', '0'),
(8, 10, '0', '0'),
(8, 11, '0', '0'),
(8, 12, '0', '0'),
(8, 13, '0', '0'),
(8, 14, '0', '0'),
(8, 15, '0', '0'),
(8, 16, '2', '0'),
(8, 17, '1', '0'),
(8, 18, '1', '0'),
(8, 19, '1', '0'),
(8, 20, '1', '0'),
(8, 21, '1', '0'),
(8, 22, '1', '0'),
(8, 23, '1', '0'),
(8, 24, '1', '0'),
(8, 25, '1', '0'),
(8, 26, '2', '0'),
(8, 27, '2', '0'),
(8, 28, '2', '0'),
(8, 29, '4', '0'),
(8, 30, '2', '0'),
(9, 1, '0', '0'),
(9, 2, '0', '0'),
(9, 3, '0', '0'),
(9, 4, '0', '0'),
(9, 5, '0', '0'),
(9, 6, '0', '0'),
(9, 7, '0', '0'),
(9, 8, '0', '0'),
(9, 10, '0', '0'),
(9, 11, '0', '0'),
(9, 12, '0', '0'),
(9, 13, '0', '0'),
(9, 14, '0', '0'),
(9, 15, '0', '0'),
(9, 16, '2', '0'),
(9, 17, '1', '0'),
(9, 18, '1', '0'),
(9, 19, '1', '0'),
(9, 20, '1', '0'),
(9, 21, '1', '0'),
(9, 22, '1', '0'),
(9, 23, '1', '0'),
(9, 24, '1', '0'),
(9, 25, '1', '0'),
(9, 26, '2', '0'),
(9, 27, '2', '0'),
(9, 28, '2', '0'),
(9, 29, '4', '0'),
(9, 30, '2', '0'),
(10, 1, '0', '0'),
(10, 2, '0', '0'),
(10, 3, '0', '0'),
(10, 4, '0', '0'),
(10, 5, '0', '0'),
(10, 6, '0', '0'),
(10, 7, '0', '0'),
(10, 8, '0', '0'),
(10, 9, '0', '0'),
(10, 11, '0', '0'),
(10, 12, '0', '0'),
(10, 13, '0', '0'),
(10, 14, '0', '0'),
(10, 15, '0', '0'),
(10, 16, '3', '0'),
(10, 17, '2', '0'),
(10, 18, '2', '0'),
(10, 19, '2', '0'),
(10, 20, '1', '0'),
(10, 21, '1', '0'),
(10, 22, '1', '0'),
(10, 23, '1', '0'),
(10, 24, '1', '0'),
(10, 25, '1', '0'),
(10, 26, '1', '0'),
(10, 27, '1', '0'),
(10, 28, '1', '0'),
(10, 29, '3', '0'),
(10, 30, '3', '0'),
(11, 1, '0', '0'),
(11, 2, '0', '0'),
(11, 3, '0', '0'),
(11, 4, '0', '0'),
(11, 5, '0', '0'),
(11, 6, '0', '0'),
(11, 7, '0', '0'),
(11, 8, '0', '0'),
(11, 9, '0', '0'),
(11, 10, '0', '0'),
(11, 12, '0', '0'),
(11, 13, '0', '0'),
(11, 14, '0', '0'),
(11, 15, '0', '0'),
(11, 16, '3', '0'),
(11, 17, '2', '0'),
(11, 18, '2', '0'),
(11, 19, '2', '0'),
(11, 20, '1', '0'),
(11, 21, '1', '0'),
(11, 22, '1', '0'),
(11, 23, '1', '0'),
(11, 24, '1', '0'),
(11, 25, '1', '0'),
(11, 26, '1', '0'),
(11, 27, '1', '0'),
(11, 28, '1', '0'),
(11, 29, '3', '0'),
(11, 30, '3', '0'),
(12, 1, '0', '0'),
(12, 2, '0', '0'),
(12, 3, '0', '0'),
(12, 4, '0', '0'),
(12, 5, '0', '0'),
(12, 6, '0', '0'),
(12, 7, '0', '0'),
(12, 8, '0', '0'),
(12, 9, '0', '0'),
(12, 10, '0', '0'),
(12, 11, '0', '0'),
(12, 13, '0', '0'),
(12, 14, '0', '0'),
(12, 15, '0', '0'),
(12, 16, '4', '0'),
(12, 17, '3', '0'),
(12, 18, '3', '0'),
(12, 19, '3', '0'),
(12, 20, '2', '0'),
(12, 21, '2', '0'),
(12, 22, '2', '0'),
(12, 23, '2', '0'),
(12, 24, '2', '0'),
(12, 25, '1', '0'),
(12, 26, '1', '0'),
(12, 27, '1', '0'),
(12, 28, '1', '0'),
(12, 29, '2', '0'),
(12, 30, '4', '0'),
(13, 1, '0', '0'),
(13, 2, '0', '0'),
(13, 3, '0', '0'),
(13, 4, '0', '0'),
(13, 5, '0', '0'),
(13, 6, '0', '0'),
(13, 7, '0', '0'),
(13, 8, '0', '0'),
(13, 9, '0', '0'),
(13, 10, '0', '0'),
(13, 11, '0', '0'),
(13, 12, '0', '0'),
(13, 14, '0', '0'),
(13, 15, '0', '0'),
(13, 16, '4', '0'),
(13, 17, '3', '0'),
(13, 18, '3', '0'),
(13, 19, '3', '0'),
(13, 20, '2', '0'),
(13, 21, '2', '0'),
(13, 22, '2', '0'),
(13, 23, '2', '0'),
(13, 24, '2', '0'),
(13, 25, '1', '0'),
(13, 26, '1', '0'),
(13, 27, '1', '0'),
(13, 28, '1', '0'),
(13, 29, '2', '0'),
(13, 30, '4', '0'),
(14, 1, '0', '0'),
(14, 2, '0', '0'),
(14, 3, '0', '0'),
(14, 4, '0', '0'),
(14, 5, '0', '0'),
(14, 6, '0', '0'),
(14, 7, '0', '0'),
(14, 8, '0', '0'),
(14, 9, '0', '0'),
(14, 10, '0', '0'),
(14, 11, '0', '0'),
(14, 12, '0', '0'),
(14, 13, '0', '0'),
(14, 15, '0', '0'),
(14, 16, '4', '0'),
(14, 17, '3', '0'),
(14, 18, '3', '0'),
(14, 19, '3', '0'),
(14, 20, '2', '0'),
(14, 21, '2', '0'),
(14, 22, '2', '0'),
(14, 23, '2', '0'),
(14, 24, '2', '0'),
(14, 25, '1', '0'),
(14, 26, '1', '0'),
(14, 27, '1', '0'),
(14, 28, '1', '0'),
(14, 29, '1', '0'),
(14, 30, '4', '0'),
(15, 1, '0', '0'),
(15, 2, '0', '0'),
(15, 3, '0', '0'),
(15, 4, '0', '0'),
(15, 5, '0', '0'),
(15, 6, '0', '0'),
(15, 7, '0', '0'),
(15, 8, '0', '0'),
(15, 9, '0', '0'),
(15, 10, '0', '0'),
(15, 11, '0', '0'),
(15, 12, '0', '0'),
(15, 13, '0', '0'),
(15, 14, '0', '0'),
(15, 16, '0', '0'),
(15, 17, '0', '0'),
(15, 18, '0', '0'),
(15, 19, '0', '0'),
(15, 20, '0', '0'),
(15, 21, '0', '0'),
(15, 22, '0', '0'),
(15, 23, '0', '0'),
(15, 24, '0', '0'),
(15, 25, '0', '0'),
(15, 26, '0', '0'),
(15, 27, '0', '0'),
(15, 28, '0', '0'),
(15, 29, '0', '0'),
(15, 30, '0', '0'),
(16, 1, '0', '1'),
(16, 2, '0', '1'),
(16, 3, '0', '1'),
(16, 4, '0', '1'),
(16, 5, '0', '1'),
(16, 6, '0', '1'),
(16, 7, '0', '1'),
(16, 8, '0', '1'),
(16, 9, '0', '1'),
(16, 10, '0', '1'),
(16, 11, '0', '1'),
(16, 12, '0', '1'),
(16, 13, '0', '1'),
(16, 14, '0', '1'),
(16, 15, '0', '1'),
(16, 17, '1', '1'),
(16, 18, '1', '1'),
(16, 19, '1', '1'),
(16, 20, '2', '1'),
(16, 21, '2', '1'),
(16, 22, '2', '1'),
(16, 23, '2', '1'),
(16, 24, '2', '1'),
(16, 25, '3', '1'),
(16, 26, '3', '1'),
(16, 27, '4', '1'),
(16, 28, '4', '1'),
(16, 29, '4', '1'),
(16, 30, '6', '1'),
(17, 1, '0', '2'),
(17, 2, '0', '2'),
(17, 3, '0', '2'),
(17, 4, '0', '2'),
(17, 5, '0', '2'),
(17, 6, '0', '2'),
(17, 7, '0', '2'),
(17, 8, '0', '2'),
(17, 9, '0', '2'),
(17, 10, '0', '2'),
(17, 11, '0', '2'),
(17, 12, '0', '2'),
(17, 13, '0', '2'),
(17, 14, '0', '2'),
(17, 15, '0', '2'),
(17, 16, '1', '2'),
(17, 18, '1', '2'),
(17, 19, '1', '2'),
(17, 20, '1', '2'),
(17, 21, '1', '2'),
(17, 22, '1', '2'),
(17, 23, '1', '2'),
(17, 24, '1', '2'),
(17, 25, '2', '2'),
(17, 26, '2', '2'),
(17, 27, '3', '2'),
(17, 28, '3', '2'),
(17, 29, '3', '2'),
(17, 30, '5', '2'),
(18, 1, '0', '3'),
(18, 2, '0', '3'),
(18, 3, '0', '3'),
(18, 4, '0', '3'),
(18, 5, '0', '3'),
(18, 6, '0', '3'),
(18, 7, '0', '3'),
(18, 8, '0', '3'),
(18, 9, '0', '3'),
(18, 10, '0', '3'),
(18, 11, '0', '3'),
(18, 12, '0', '3'),
(18, 13, '0', '3'),
(18, 14, '0', '3'),
(18, 15, '0', '3'),
(18, 16, '1', '3'),
(18, 17, '1', '3'),
(18, 19, '1', '3'),
(18, 20, '1', '3'),
(18, 21, '1', '3'),
(18, 22, '1', '3'),
(18, 23, '1', '3'),
(18, 24, '1', '3'),
(18, 25, '2', '3'),
(18, 26, '2', '3'),
(18, 27, '3', '3'),
(18, 28, '3', '3'),
(18, 29, '3', '3'),
(18, 30, '5', '3'),
(19, 1, '0', '4'),
(19, 2, '0', '4'),
(19, 3, '0', '4'),
(19, 4, '0', '4'),
(19, 5, '0', '4'),
(19, 6, '0', '4'),
(19, 7, '0', '4'),
(19, 8, '0', '4'),
(19, 9, '0', '4'),
(19, 10, '0', '4'),
(19, 11, '0', '4'),
(19, 12, '0', '4'),
(19, 13, '0', '4'),
(19, 14, '0', '4'),
(19, 15, '0', '4'),
(19, 16, '1', '4'),
(19, 17, '1', '4'),
(19, 18, '1', '4'),
(19, 20, '1', '4'),
(19, 21, '1', '4'),
(19, 22, '1', '4'),
(19, 23, '1', '4'),
(19, 24, '1', '4'),
(19, 25, '2', '4'),
(19, 26, '2', '4'),
(19, 27, '3', '4'),
(19, 28, '3', '4'),
(19, 29, '3', '4'),
(19, 30, '5', '4'),
(20, 1, '0', '2'),
(20, 2, '0', '2'),
(20, 3, '0', '2'),
(20, 4, '0', '2'),
(20, 5, '0', '2'),
(20, 6, '0', '2'),
(20, 7, '0', '2'),
(20, 8, '0', '2'),
(20, 9, '0', '2'),
(20, 10, '0', '2'),
(20, 11, '0', '2'),
(20, 12, '0', '2'),
(20, 13, '0', '2'),
(20, 14, '0', '2'),
(20, 15, '0', '2'),
(20, 16, '2', '2'),
(20, 17, '1', '2'),
(20, 18, '1', '2'),
(20, 19, '1', '2'),
(20, 21, '1', '2'),
(20, 22, '1', '2'),
(20, 23, '1', '2'),
(20, 24, '1', '2'),
(20, 25, '1', '2'),
(20, 26, '1', '2'),
(20, 27, '2', '2'),
(20, 28, '2', '2'),
(20, 29, '2', '2'),
(20, 30, '4', '2'),
(21, 1, '0', '3'),
(21, 2, '0', '3'),
(21, 3, '0', '3'),
(21, 4, '0', '3'),
(21, 5, '0', '3'),
(21, 6, '0', '3'),
(21, 7, '0', '3'),
(21, 8, '0', '3'),
(21, 9, '0', '3'),
(21, 10, '0', '3'),
(21, 11, '0', '3'),
(21, 12, '0', '3'),
(21, 13, '0', '3'),
(21, 14, '0', '3'),
(21, 15, '0', '3'),
(21, 16, '2', '3'),
(21, 17, '1', '3'),
(21, 18, '1', '3'),
(21, 19, '1', '3'),
(21, 20, '1', '3'),
(21, 22, '1', '3'),
(21, 23, '1', '3'),
(21, 24, '1', '3'),
(21, 25, '1', '3'),
(21, 26, '1', '3'),
(21, 27, '2', '3'),
(21, 28, '2', '3'),
(21, 29, '2', '3'),
(21, 30, '4', '3'),
(22, 1, '0', '6'),
(22, 2, '0', '6'),
(22, 3, '0', '6'),
(22, 4, '0', '6'),
(22, 5, '0', '6'),
(22, 6, '0', '6'),
(22, 7, '0', '6'),
(22, 8, '0', '6'),
(22, 9, '0', '6'),
(22, 10, '0', '6'),
(22, 11, '0', '6'),
(22, 12, '0', '6'),
(22, 13, '0', '6'),
(22, 14, '0', '6'),
(22, 15, '0', '6'),
(22, 16, '2', '6'),
(22, 17, '1', '6'),
(22, 18, '1', '6'),
(22, 19, '1', '6'),
(22, 20, '1', '6'),
(22, 21, '1', '6'),
(22, 23, '1', '6'),
(22, 24, '1', '6'),
(22, 25, '1', '6'),
(22, 26, '1', '6'),
(22, 27, '2', '6'),
(22, 28, '2', '6'),
(22, 29, '2', '6'),
(22, 30, '4', '6'),
(23, 1, '0', '5'),
(23, 2, '0', '5'),
(23, 3, '0', '5'),
(23, 4, '0', '5'),
(23, 5, '0', '5'),
(23, 6, '0', '5'),
(23, 7, '0', '5'),
(23, 8, '0', '5'),
(23, 9, '0', '5'),
(23, 10, '0', '5'),
(23, 11, '0', '5'),
(23, 12, '0', '5'),
(23, 13, '0', '5'),
(23, 14, '0', '5'),
(23, 15, '0', '5'),
(23, 16, '2', '5'),
(23, 17, '1', '5'),
(23, 18, '1', '5'),
(23, 19, '1', '5'),
(23, 20, '1', '5'),
(23, 21, '1', '5'),
(23, 22, '1', '5'),
(23, 24, '1', '5'),
(23, 25, '1', '5'),
(23, 26, '1', '5'),
(23, 27, '2', '5'),
(23, 28, '2', '5'),
(23, 29, '2', '5'),
(23, 30, '4', '5'),
(24, 1, '0', '4'),
(24, 2, '0', '4'),
(24, 3, '0', '4'),
(24, 4, '0', '4'),
(24, 5, '0', '4'),
(24, 6, '0', '4'),
(24, 7, '0', '4'),
(24, 8, '0', '4'),
(24, 9, '0', '4'),
(24, 10, '0', '4'),
(24, 11, '0', '4'),
(24, 12, '0', '4'),
(24, 13, '0', '4'),
(24, 14, '0', '4'),
(24, 15, '0', '4'),
(24, 16, '2', '4'),
(24, 17, '1', '4'),
(24, 18, '1', '4'),
(24, 19, '1', '4'),
(24, 20, '1', '4'),
(24, 21, '1', '4'),
(24, 22, '1', '4'),
(24, 23, '1', '4'),
(24, 25, '1', '4'),
(24, 26, '1', '4'),
(24, 27, '2', '4'),
(24, 28, '2', '4'),
(24, 29, '2', '4'),
(24, 30, '4', '4'),
(25, 1, '0', '7'),
(25, 2, '0', '7'),
(25, 3, '0', '7'),
(25, 4, '0', '7'),
(25, 5, '0', '7'),
(25, 6, '0', '7'),
(25, 7, '0', '7'),
(25, 8, '0', '7'),
(25, 9, '0', '7'),
(25, 10, '0', '7'),
(25, 11, '0', '7'),
(25, 12, '0', '7'),
(25, 13, '0', '7'),
(25, 14, '0', '7'),
(25, 15, '0', '7'),
(25, 16, '3', '7'),
(25, 17, '2', '7'),
(25, 18, '2', '7'),
(25, 19, '2', '7'),
(25, 20, '1', '7'),
(25, 21, '1', '7'),
(25, 22, '1', '7'),
(25, 23, '1', '7'),
(25, 24, '1', '7'),
(25, 26, '1', '7'),
(25, 27, '1', '7'),
(25, 28, '1', '7'),
(25, 29, '1', '7'),
(25, 30, '3', '7'),
(26, 1, '0', '8'),
(26, 2, '0', '8'),
(26, 3, '0', '8'),
(26, 4, '0', '8'),
(26, 5, '0', '8'),
(26, 6, '0', '8'),
(26, 7, '0', '8'),
(26, 8, '0', '8'),
(26, 9, '0', '8'),
(26, 10, '0', '8'),
(26, 11, '0', '8'),
(26, 12, '0', '8'),
(26, 13, '0', '8'),
(26, 14, '0', '8'),
(26, 15, '0', '8'),
(26, 16, '3', '8'),
(26, 17, '2', '8'),
(26, 18, '2', '8'),
(26, 19, '2', '8'),
(26, 20, '1', '8'),
(26, 21, '1', '8'),
(26, 22, '1', '8'),
(26, 23, '1', '8'),
(26, 24, '1', '8'),
(26, 25, '1', '8'),
(26, 27, '1', '8'),
(26, 28, '1', '8'),
(26, 29, '1', '8'),
(26, 30, '3', '8'),
(27, 1, '0', '6'),
(27, 2, '0', '6'),
(27, 3, '0', '6'),
(27, 4, '0', '6'),
(27, 5, '0', '6'),
(27, 6, '0', '6'),
(27, 7, '0', '6'),
(27, 8, '0', '6'),
(27, 9, '0', '6'),
(27, 10, '0', '6'),
(27, 11, '0', '6'),
(27, 12, '0', '6'),
(27, 13, '0', '6'),
(27, 14, '0', '6'),
(27, 15, '0', '6'),
(27, 16, '4', '6'),
(27, 17, '3', '6'),
(27, 18, '3', '6'),
(27, 19, '3', '6'),
(27, 20, '2', '6'),
(27, 21, '2', '6'),
(27, 22, '2', '6'),
(27, 23, '2', '6'),
(27, 24, '2', '6'),
(27, 25, '1', '6'),
(27, 26, '1', '6'),
(27, 28, '1', '6'),
(27, 29, '1', '6'),
(27, 30, '2', '6'),
(28, 1, '0', '8'),
(28, 2, '0', '8'),
(28, 3, '0', '8'),
(28, 4, '0', '8'),
(28, 5, '0', '8'),
(28, 6, '0', '8'),
(28, 7, '0', '8'),
(28, 8, '0', '8'),
(28, 9, '0', '8'),
(28, 10, '0', '8'),
(28, 11, '0', '8'),
(28, 12, '0', '8'),
(28, 13, '0', '8'),
(28, 14, '0', '8'),
(28, 15, '0', '8'),
(28, 16, '4', '8'),
(28, 17, '3', '8'),
(28, 18, '3', '8'),
(28, 19, '3', '8'),
(28, 20, '2', '8'),
(28, 21, '2', '8'),
(28, 22, '2', '8'),
(28, 23, '2', '8'),
(28, 24, '2', '8'),
(28, 25, '1', '8'),
(28, 26, '1', '8'),
(28, 27, '1', '8'),
(28, 29, '1', '8'),
(28, 30, '2', '8'),
(29, 1, '0', '7'),
(29, 2, '0', '7'),
(29, 3, '0', '7'),
(29, 4, '0', '7'),
(29, 5, '0', '7'),
(29, 6, '0', '7'),
(29, 7, '0', '7'),
(29, 8, '0', '7'),
(29, 9, '0', '7'),
(29, 10, '0', '7'),
(29, 11, '0', '7'),
(29, 12, '0', '7'),
(29, 13, '0', '7'),
(29, 14, '0', '7'),
(29, 15, '0', '7'),
(29, 16, '4', '7'),
(29, 17, '3', '7'),
(29, 18, '3', '7'),
(29, 19, '3', '7'),
(29, 20, '2', '7'),
(29, 21, '2', '7'),
(29, 22, '2', '7'),
(29, 23, '2', '7'),
(29, 24, '2', '7'),
(29, 25, '1', '7'),
(29, 26, '1', '7'),
(29, 27, '1', '7'),
(29, 28, '1', '7'),
(29, 30, '1', '7'),
(30, 1, '0', '9'),
(30, 2, '0', '9'),
(30, 3, '0', '9'),
(30, 4, '0', '9'),
(30, 5, '0', '9'),
(30, 6, '0', '9'),
(30, 7, '0', '9'),
(30, 8, '0', '9'),
(30, 9, '0', '9'),
(30, 10, '0', '9'),
(30, 11, '0', '9'),
(30, 12, '0', '9'),
(30, 13, '0', '9'),
(30, 14, '0', '9'),
(30, 15, '0', '9'),
(30, 16, '6', '9'),
(30, 17, '5', '9'),
(30, 18, '5', '9'),
(30, 19, '5', '9'),
(30, 20, '4', '9'),
(30, 21, '4', '9'),
(30, 22, '4', '9'),
(30, 23, '4', '9'),
(30, 24, '4', '9'),
(30, 25, '3', '9'),
(30, 26, '3', '9'),
(30, 27, '2', '9'),
(30, 28, '2', '9'),
(30, 29, '1', '9');

-- --------------------------------------------------------

--
-- 表的結構 `chu_group`
--

CREATE TABLE IF NOT EXISTS `chu_group` (
  `GID` varchar(30) NOT NULL,
  `GName` varchar(15) NOT NULL,
  `Gauth_Admin` tinyint(1) NOT NULL DEFAULT '0',
  `Gauth_ClientAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群組';

--
-- 轉存資料表中的資料 `chu_group`
--

INSERT INTO `chu_group` (`GID`, `GName`, `Gauth_Admin`, `Gauth_ClientAdmin`) VALUES
('admin', '管理者', 1, 1),
('student', '學生', 0, 0),
('user', '使用者', 0, 0);

-- --------------------------------------------------------

--
-- 表的結構 `chu_question`
--

CREATE TABLE IF NOT EXISTS `chu_question` (
  `QID` varchar(5) NOT NULL,
  `TID` int(10) unsigned NOT NULL,
  `Cnumber` int(10) unsigned DEFAULT NULL COMMENT '答對次數',
  `Wnumber` int(10) unsigned DEFAULT NULL COMMENT '答錯次數',
  PRIMARY KEY (`QID`),
  KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='題目';

-- --------------------------------------------------------

--
-- 表的結構 `chu_recommend`
--

CREATE TABLE IF NOT EXISTS `chu_recommend` (
  `TID` int(10) unsigned NOT NULL,
  `UID` varchar(30) NOT NULL COMMENT '使用者帳號',
  `gradation` int(50) unsigned NOT NULL COMMENT '系統推薦標地順序',
  PRIMARY KEY (`TID`,`UID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推薦';

-- --------------------------------------------------------

--
-- 表的結構 `chu_study`
--

CREATE TABLE IF NOT EXISTS `chu_study` (
  `TID` int(10) unsigned NOT NULL,
  `UID` varchar(30) NOT NULL COMMENT '使用者帳號',
  `In_TargetTime` datetime NOT NULL,
  `Out_TargetTime` datetime DEFAULT NULL,
  PRIMARY KEY (`TID`,`UID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者與標的間study';

-- --------------------------------------------------------

--
-- 表的結構 `chu_target`
--

CREATE TABLE IF NOT EXISTS `chu_target` (
  `TID` int(10) unsigned NOT NULL,
  `MapID` varchar(20) NOT NULL COMMENT '地圖編號',
  `MaterialID` varchar(20) NOT NULL COMMENT '教材編號',
  `TName` varchar(15) NOT NULL COMMENT '標的名稱',
  `TLearn_Time` int(10) unsigned NOT NULL COMMENT '預估此標的應該學習的時間',
  `PLj` int(200) unsigned NOT NULL COMMENT '學習標的的人數限制',
  `Mj` int(200) unsigned DEFAULT NULL COMMENT '目前人數',
  `S` float unsigned DEFAULT NULL COMMENT '學習標的飽和率上限',
  `Fj` tinyint(1) DEFAULT NULL COMMENT '學習標的滿額指標',
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標的';

--
-- 轉存資料表中的資料 `chu_target`
--

INSERT INTO `chu_target` (`TID`, `MapID`, `MaterialID`, `TName`, `TLearn_Time`, `PLj`, `Mj`, `S`, `Fj`) VALUES
(0, '1F.gif', '', '入口', 1, 100, 0, 0.6, 0),
(1, 'map_01_02_03.png', '01.html', '含有生物遺跡的岩石', 7, 2, 2, 0.6, 0),
(2, 'map_01_02_03.png', '02.html', '岩石中的紀錄', 8, 2, 1, 0.6, 0),
(3, 'map_01_02_03.png', '03.html', '生命在水中的演化', 3, 2, 2, 0.6, 0),
(4, 'map_04.jpg', '04.html', '最早的森林', 3, 2, 2, 0.6, 0),
(5, 'map_05.jpg', '05.html', '古代的兩棲類', 5, 2, 1, 0.6, 0),
(6, 'map_06.jpg', '06.html', '恐龍時代', 6, 2, 2, 0.6, 0),
(7, 'map_07.jpg', '07.html', '蒙古的恐龍', 4, 2, 2, 0.6, 0),
(8, 'map_08.jpg', '08.html', '恐龍再現', 4, 2, 2, 0.6, 0),
(9, 'map_09.jpg', '09.html', '竊蛋龍', 4, 2, 1, 0.6, 0),
(10, 'map_10.jpg', '10.html', '巨龍的腳印', 4, 2, 2, 0.6, 0),
(11, 'map_11.jpg', '11.html', '始祖鳥與帶有羽毛的恐龍', 8, 2, 2, 0.6, 0),
(12, 'map_12.jpg', '12.html', '阿法南猿', 4, 2, 2, 0.6, 0),
(13, 'map_13.jpg', '13.html', '探索人類的過去', 5, 1, 1, 0.6, 0),
(14, 'map_14.jpg', '14.html', '周口店北京人', 3, 2, 2, 0.6, 0),
(15, 'map_15.jpg', '15.html', '木乃伊', 8, 2, 2, 0.6, 0),
(16, 'map_01_02_03.png', '16.html', '含有生物遺跡的岩石', 7, 2, 2, 0.6, 0),
(17, 'map_01_02_03.png', '17.html', '岩石中的紀錄', 8, 2, 1, 0.6, 0),
(18, 'map_01_02_03.png', '18.html', '生命在水中的演化', 3, 2, 2, 0.6, 0),
(19, 'map_04.jpg', '19.html', '最早的森林', 3, 2, 2, 0.6, 0),
(20, 'map_05.jpg', '20.html', '古代的兩棲類', 5, 2, 1, 0.6, 0),
(21, 'map_06.jpg', '21.html', '恐龍時代', 6, 2, 2, 0.6, 0),
(22, 'map_07.jpg', '22.html', '蒙古的恐龍', 4, 2, 2, 0.6, 0),
(23, 'map_08.jpg', '23.html', '恐龍再現', 4, 2, 2, 0.6, 0),
(24, 'map_09.jpg', '24.html', '竊蛋龍', 4, 2, 1, 0.6, 0),
(25, 'map_10.jpg', '25.html', '巨龍的腳印', 4, 2, 2, 0.6, 0),
(26, 'map_11.jpg', '26.html', '始祖鳥與帶有羽毛的恐龍', 8, 2, 2, 0.6, 0),
(27, 'map_12.jpg', '27.html', '阿法南猿', 4, 2, 2, 0.6, 0),
(28, 'map_13.jpg', '28.html', '探索人類的過去', 5, 2, 2, 0.6, 0),
(29, 'map_14.jpg', '29.html', '周口店北京人', 3, 2, 2, 0.6, 0),
(30, 'map_15.jpg', '30.html', '木乃伊', 8, 2, 2, 0.6, 0);

-- --------------------------------------------------------

--
-- 表的結構 `chu_theme`
--

CREATE TABLE IF NOT EXISTS `chu_theme` (
  `ThemeID` int(10) unsigned NOT NULL,
  `ThemeName` varchar(15) NOT NULL,
  `theme_Learn_DateTime` datetime NOT NULL COMMENT '本次學習此主題發生的日期時間',
  `Theme_LearnTotal` int(10) unsigned NOT NULL COMMENT '學習此主題要花的總時間(m)',
  `Theme_Introduction` varchar(70) NOT NULL,
  PRIMARY KEY (`ThemeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主題';

--
-- 轉存資料表中的資料 `chu_theme`
--

INSERT INTO `chu_theme` (`ThemeID`, `ThemeName`, `theme_Learn_DateTime`, `Theme_LearnTotal`, `Theme_Introduction`) VALUES
(1, '生命科學', '2014-01-26 00:00:00', 40, '');

-- --------------------------------------------------------

--
-- 表的結構 `chu_user`
--

CREATE TABLE IF NOT EXISTS `chu_user` (
  `UID` varchar(30) NOT NULL COMMENT '使用者帳號',
  `GID` varchar(30) NOT NULL COMMENT '使用者群組',
  `UPassword` varchar(40) NOT NULL COMMENT '密碼',
  `ULogged_code` varchar(32) DEFAULT NULL COMMENT '登入碼',
  `ULast_In_Time` timestamp NULL DEFAULT NULL COMMENT '最後登入時間',
  `UBuild_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '帳號建立時間',
  `UEnabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '帳號啟用狀態',
  `In_Learn_Time` datetime NOT NULL COMMENT '開始學習時間',
  `UReal_Name` varchar(20) DEFAULT NULL COMMENT '真實姓名',
  `UNickname` varchar(20) DEFAULT NULL COMMENT '使用者暱稱',
  `UEmail` varchar(50) DEFAULT NULL COMMENT '使用者email',
  PRIMARY KEY (`UID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者';

--
-- 匯出資料表的 Constraints
--

--
-- 資料表的 Constraints `chu_belong`
--
ALTER TABLE `chu_belong`
  ADD CONSTRAINT `chu_belong_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`),
  ADD CONSTRAINT `chu_belong_ibfk_2` FOREIGN KEY (`ThemeID`) REFERENCES `chu_theme` (`ThemeID`);

--
-- 資料表的 Constraints `chu_edge`
--
ALTER TABLE `chu_edge`
  ADD CONSTRAINT `chu_edge_ibfk_1` FOREIGN KEY (`Ti`) REFERENCES `chu_target` (`TID`),
  ADD CONSTRAINT `chu_edge_ibfk_2` FOREIGN KEY (`Tj`) REFERENCES `chu_target` (`TID`);

--
-- 資料表的 Constraints `chu_question`
--
ALTER TABLE `chu_question`
  ADD CONSTRAINT `chu_question_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`);

--
-- 資料表的 Constraints `chu_recommend`
--
ALTER TABLE `chu_recommend`
  ADD CONSTRAINT `chu_recommend_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`),
  ADD CONSTRAINT `chu_recommend_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `chu_user` (`UID`);

--
-- 資料表的 Constraints `chu_study`
--
ALTER TABLE `chu_study`
  ADD CONSTRAINT `chu_study_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `chu_target` (`TID`),
  ADD CONSTRAINT `chu_study_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `chu_user` (`UID`);

--
-- 資料表的 Constraints `chu_user`
--
ALTER TABLE `chu_user`
  ADD CONSTRAINT `chu_user_ibfk_1` FOREIGN KEY (`GID`) REFERENCES `chu_group` (`GID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
