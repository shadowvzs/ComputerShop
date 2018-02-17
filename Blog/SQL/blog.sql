-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2018 at 05:44 AM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_published` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `status` enum('DRAFT','PUBLISHED') NOT NULL DEFAULT 'DRAFT',
  `views` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `description`, `date_published`, `date_created`, `status`, `views`) VALUES
(1, 3, 'Panoramic user 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', NULL, '2017-12-07 00:00:00', 'DRAFT', 28),
(2, 2, 'Valami 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&amp;lt;script&amp;gt;alert(&amp;#039;3&amp;#039;);&amp;lt;/script&amp;gt;', '2018-02-15 05:04:01', '2022-12-05 23:00:00', 'PUBLISHED', 11),
(3, 3, 'article 1 for user 5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', NULL, '2017-12-01 00:00:00', 'DRAFT', 4),
(4, 2, 'Sunset zebra', 'Lorem article ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', '2018-02-16 20:24:55', '2019-02-07 00:00:00', 'PUBLISHED', 8),
(5, 3, 'African article', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', NULL, '2017-12-01 00:00:00', 'PUBLISHED', 6),
(6, 2, 'Lorem ipsum', 'Lorem article ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', NULL, '2017-12-07 00:00:00', 'DRAFT', 0),
(7, 2, 'Few infos about this Blog', 'About blog i have few info, what maybe helpfull so i recommend read this few row before test it :)\n* note: maybe few thing i did different way, well, just because i like to make experiment if i can learn new thing with that, since this is not a real project what will be bought by a client :)\n\n\nloginable user if you dont want create a account:\nusername: john_smith@gmail.com\npassword: John87\n\nfeatures:\n- form validation with  regex patterns (on input html side and php side) and with my FormHelper class\n- search work with star, example: *article or article* or *article* \n- search priority: 1st if title got the word, 2nd if description got that word\n- pagination atm with select option box\n- thumbnail creation \n- highlight in articles the article title / short content with stroke (text-shadow)\n- convert line breaks to &amp;lt;br&amp;gt; (because of textarea linebreak need to be replaced)\n* etc', NULL, '2017-12-07 00:00:00', 'PUBLISHED', 3),
(8, 4, 'Savana &amp;lt;script&amp;gt;alert(&amp;#039;2&amp;#039;);&amp;lt;/script&amp;gt; article', 'gdfgdfgdfgdfg sd sd \r\ns dfss df\r\n\r\ns df', NULL, '2228-01-17 17:49:20', 'PUBLISHED', 2),
(9, 3, 'Something', 'asdasd', '2018-02-15 05:51:13', '2022-02-24 05:46:17', 'PUBLISHED', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `status` enum('PENDING','APROVED','REJECTED') DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `content`, `status`, `date_created`) VALUES
(1, 11, 2, 'gvhgf,f f hf hfgh f', 'APROVED', '2017-12-01 00:00:00'),
(5, 11, 2, 'sdfsdfsdf', 'APROVED', '2017-12-01 00:00:10'),
(92, 4, 4, ' 11 fghrty', 'APROVED', '2018-02-11 17:12:22'),
(91, 4, 2, ' fghrty', 'APROVED', '2018-02-11 17:02:22'),
(37, 2, 2, ' fghf', 'APROVED', '2018-02-11 18:48:50'),
(38, 2, 2, ' dfg', 'APROVED', '2018-02-11 18:49:31'),
(104, 4, 2, ' fgdfg', 'APROVED', '2018-02-15 14:08:02'),
(41, 2, 3, ' fgh', 'APROVED', '2018-02-11 18:54:10'),
(42, 2, 3, ' fgh', 'APROVED', '2018-01-16 18:54:36'),
(43, 2, 3, ' fgh', 'APROVED', '2018-02-11 18:54:59'),
(44, 2, 3, ' sdf', 'APROVED', '2018-02-11 18:56:03'),
(45, 2, 3, ' fghf', 'APROVED', '2018-02-11 18:56:35'),
(46, 2, 2, ' dfgd', 'APROVED', '2018-02-11 18:57:43'),
(73, 2, 2, ' sdfsdssssss', 'APROVED', '2018-02-13 15:48:54'),
(51, 5, 2, ' rtyrrty', 'APROVED', '2018-02-11 19:02:17'),
(52, 3, 2, ' rtyrrty', 'APROVED', '2018-02-11 19:04:08'),
(69, 2, 2, ' dfg', 'APROVED', '2018-02-12 17:42:10'),
(68, 2, 2, '1231231', 'APROVED', '2018-02-12 16:35:14'),
(56, 5, 3, ' dfgdfg', 'APROVED', '2018-02-11 19:05:58'),
(57, 2, 2, ' dfgdfgdfgdf', 'APROVED', '2018-02-11 19:06:01'),
(58, 2, 2, ' dfgdfgdfgdfsdfsd', 'APROVED', '2018-02-11 19:06:03'),
(59, 2, 2, ' ddfg', 'APROVED', '2018-02-11 19:06:13'),
(63, 2, 2, ' dfgdgdd fg', 'APROVED', '2018-02-11 21:26:47'),
(71, 2, 2, 'asdas`1123d', 'APROVED', '2018-02-14 17:42:22'),
(74, 2, 2, ' asdasd asd asd', 'APROVED', '2018-02-13 22:37:51'),
(75, 2, 2, ' asdasd asd asd1223', 'APROVED', '2018-02-13 22:37:57'),
(76, 8, 4, ' dfgdfg', 'REJECTED', '2018-02-14 04:48:07'),
(83, 8, 4, ' fghfgh', 'APROVED', '2018-02-14 05:49:44'),
(79, 9, 3, ' cdfgdfg dfgdf', 'APROVED', '2018-01-11 05:47:11'),
(80, 9, 3, ' cdfgdfg dfgdf dfgd dfg', 'APROVED', '2018-02-14 05:47:15'),
(84, 9, 3, ' fghfgh fgh', 'REJECTED', '2018-02-14 05:49:48'),
(101, 2, 3, 'my pending comment', 'REJECTED', '2018-02-15 06:11:23'),
(102, 2, 3, ' dfgdfg', 'APROVED', '2018-02-15 06:56:29'),
(103, 8, 4, ' fghyfg', 'PENDING', '2018-02-15 10:29:16'),
(105, 4, 2, ' fgdfg143534', 'APROVED', '2018-02-15 14:08:11'),
(106, 2, 2, ' asdasd', 'APROVED', '2018-02-15 20:01:31'),
(109, 2, 2, ' vbnvbn', 'REJECTED', '2018-02-15 22:32:06'),
(111, 1, 2, ' dfgdfg', 'PENDING', '2018-02-15 23:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `article_id`, `name`) VALUES
(1, 2, 'image.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` enum('ADMIN','USER') NOT NULL DEFAULT 'USER',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`) VALUES
(2, 'Kis Pista', 'valami@valami.com', '51f248f1992b7e680765a7b2c1436', 'USER'),
(3, 'Varga Zsolt', 'shadowvzs@hotmail.com', '5cf36d988fed286366f9c32a053f2656', 'USER'),
(4, 'valami2', 'valami2@valami.com', '5cf36d988fed286366f9c32a053f2656', 'USER');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
