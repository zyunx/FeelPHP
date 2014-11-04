-- phpMyAdmin SQL Dump
-- version 4.2.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2014 at 02:27 PM
-- Server version: 5.5.37-0+wheezy1
-- PHP Version: 5.4.4-14+deb7u11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `feelblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `bl_authn`
--

CREATE TABLE IF NOT EXISTS `bl_authn` (
`authn_id` int(11) NOT NULL,
  `authn_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `authn_password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `profile_id` int(11) NOT NULL,
  `last_authn` int(11) NOT NULL,
  `this_authn` int(11) NOT NULL,
  `token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bl_authn`
--

INSERT INTO `bl_authn` (`authn_id`, `authn_name`, `authn_password`, `profile_id`, `last_authn`, `this_authn`, `token`, `status`) VALUES
(19, 'aa@aa.aa', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 31, 0, 0, '', 'active'),
(20, 'bb@bb.bb', 'bdb480de655aa6ec75ca058c849c4faf3c0f75b1', 32, 0, 0, '', 'inactive'),
(21, 'cc@cc.cc', 'bdb480de655aa6ec75ca058c849c4faf3c0f75b1', 33, 0, 0, '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bl_post`
--

CREATE TABLE IF NOT EXISTS `bl_post` (
`post_id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `allow_comment` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bl_user`
--

CREATE TABLE IF NOT EXISTS `bl_user` (
`user_id` int(11) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `real_name` varchar(50) DEFAULT NULL,
  `bio` mediumtext,
  `status` enum('active','inactive') DEFAULT NULL,
  `role` enum('administrator','editor','user') DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bl_user`
--

INSERT INTO `bl_user` (`user_id`, `user_name`, `email`, `real_name`, `bio`, `status`, `role`, `created`) VALUES
(31, '', 'aa@aa.aa', '', '', 'active', 'user', 1414489746),
(33, '', 'cc@cc.cc', '', '', 'active', 'user', 1414490543);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `nu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`nu`) VALUES
(2014);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bl_authn`
--
ALTER TABLE `bl_authn`
 ADD PRIMARY KEY (`authn_id`);

--
-- Indexes for table `bl_post`
--
ALTER TABLE `bl_post`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `bl_user`
--
ALTER TABLE `bl_user`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bl_authn`
--
ALTER TABLE `bl_authn`
MODIFY `authn_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `bl_post`
--
ALTER TABLE `bl_post`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bl_user`
--
ALTER TABLE `bl_user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
