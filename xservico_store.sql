-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: krantz.iad1-mysql-e2-3a.dreamhost.com
-- Generation Time: May 09, 2022 at 08:16 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xservico_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int UNSIGNED NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `activity` text NOT NULL,
  `api` varchar(5) NOT NULL DEFAULT '0',
  `date_posted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `user_id`, `activity`, `api`, `date_posted`) VALUES
(679, '7', 'Attempted account login.', '0', '2021-07-11 19:00:36'),
(680, '7', 'Logged in to account.', '0', '2021-07-11 19:00:36'),
(681, '6', 'Attempted account login.', '0', '2021-07-12 19:49:35'),
(682, '6', 'Logged in to account.', '0', '2021-07-12 19:49:35'),
(683, '7', 'Attempted account login.', '0', '2021-07-12 20:59:59'),
(684, '7', 'Logged in to account.', '0', '2021-07-12 20:59:59'),
(685, '7', 'Attempted account login.', '0', '2021-07-12 21:01:47'),
(686, '7', 'Logged in to account.', '0', '2021-07-12 21:01:47'),
(687, '8', 'Attempted account login.', '0', '2021-07-13 09:55:04'),
(688, '8', 'Logged in to account.', '0', '2021-07-13 09:55:05'),
(689, '8', 'Attempted account login.', '0', '2021-07-13 10:51:42'),
(690, '8', 'Logged in to account.', '0', '2021-07-13 10:51:42'),
(691, '6', 'Attempted account login.', '0', '2021-07-15 01:43:41'),
(692, '6', 'Logged in to account.', '0', '2021-07-15 01:43:41'),
(693, '7', 'Attempted account login.', '0', '2021-07-15 10:29:24'),
(694, '7', 'Logged in to account.', '0', '2021-07-15 10:29:24'),
(695, '6', 'Attempted account login.', '0', '2021-07-15 11:14:17'),
(696, '6', 'Logged in to account.', '0', '2021-07-15 11:14:17'),
(697, '7', 'Attempted account login.', '0', '2021-07-17 15:42:08'),
(698, '7', 'Logged in to account.', '0', '2021-07-17 15:42:08'),
(699, '8', 'Attempted account login.', '0', '2021-07-18 10:03:20'),
(700, '8', 'Logged in to account.', '0', '2021-07-18 10:03:20'),
(701, '8', 'Attempted account login.', '0', '2021-07-18 10:03:22'),
(702, '8', 'Logged in to account.', '0', '2021-07-18 10:03:22'),
(703, '7', 'Attempted account login.', '0', '2021-07-18 11:39:07'),
(704, '7', 'Logged in to account.', '0', '2021-07-18 11:39:07'),
(705, '6', 'Attempted account login.', '0', '2021-07-18 14:05:32'),
(706, '6', 'Logged in to account.', '0', '2021-07-18 14:05:32'),
(707, '7', 'Attempted account login.', '0', '2021-07-18 17:05:45'),
(708, '7', 'Logged in to account.', '0', '2021-07-18 17:05:46'),
(709, '6', 'Attempted account login.', '0', '2021-07-18 17:33:05'),
(710, '6', 'Logged in to account.', '0', '2021-07-18 17:33:05'),
(711, '6', 'Attempted account login.', '0', '2021-07-19 12:38:19'),
(712, '6', 'Logged in to account.', '0', '2021-07-19 12:38:19'),
(713, '8', 'Attempted account login.', '0', '2021-07-19 20:22:15'),
(714, '8', 'Logged in to account.', '0', '2021-07-19 20:22:15'),
(715, '8', 'Attempted account login.', '0', '2021-07-19 20:22:16'),
(716, '8', 'Logged in to account.', '0', '2021-07-19 20:22:16'),
(717, '7', 'Attempted account login.', '0', '2021-07-20 09:27:38'),
(718, '7', 'Logged in to account.', '0', '2021-07-20 09:27:38'),
(719, '8', 'Attempted account login.', '0', '2021-07-21 07:54:59'),
(720, '8', 'Logged in to account.', '0', '2021-07-21 07:54:59'),
(721, '7', 'Attempted account login.', '0', '2021-07-21 07:59:45'),
(722, '7', 'Logged in to account.', '0', '2021-07-21 07:59:45'),
(723, '7', 'Attempted account login.', '0', '2021-07-21 19:32:06'),
(724, '7', 'Logged in to account.', '0', '2021-07-21 19:32:06'),
(725, '10', 'Account created.', '0', '2021-07-24 22:33:38'),
(726, '10', 'Attempted account login.', '0', '2021-07-24 22:33:50'),
(727, '10', 'Logged in to account.', '0', '2021-07-24 22:33:50'),
(728, '11', 'Account created.', '0', '2021-07-25 17:11:41'),
(729, '11', 'Attempted account login.', '0', '2021-07-25 17:14:23'),
(730, '11', 'Logged in to account.', '0', '2021-07-25 17:14:23'),
(731, '7', 'Logged out of account.', '0', '2021-07-28 01:01:10'),
(732, '6', 'Attempted account login.', '0', '2021-07-29 18:21:11'),
(733, '6', 'Logged in to account.', '0', '2021-07-29 18:21:11'),
(734, '7', 'Attempted account login.', '0', '2021-08-02 15:53:58'),
(735, '7', 'Logged in to account.', '0', '2021-08-02 15:53:58'),
(736, '7', 'Logged out of account.', '0', '2021-08-02 15:58:29'),
(737, '6', 'Logged out of account.', '0', '2021-08-02 17:36:31'),
(738, '6', 'Attempted account login.', '0', '2021-08-03 10:45:30'),
(739, '6', 'Logged in to account.', '0', '2021-08-03 10:45:30'),
(740, '6', 'Attempted account login.', '0', '2021-08-03 20:10:58'),
(741, '6', 'Logged in to account.', '0', '2021-08-03 20:10:58'),
(742, '6', 'Logged out of account.', '0', '2021-08-03 20:13:04'),
(743, '6', 'Attempted account login.', '0', '2021-08-03 20:13:48'),
(744, '6', 'Login failed because of incorrect password.', '0', '2021-08-03 20:13:48'),
(745, '12', 'Account created.', '0', '2021-08-03 20:15:52'),
(746, '12', 'Attempted account login.', '0', '2021-08-03 20:16:30'),
(747, '12', 'Logged in to account.', '0', '2021-08-03 20:16:30'),
(748, '12', 'Logged out of account.', '0', '2021-08-03 20:18:21'),
(749, '12', 'Attempted account login.', '0', '2021-08-03 20:37:19'),
(750, '12', 'Logged in to account.', '0', '2021-08-03 20:37:19'),
(751, '12', 'Logged out of account.', '0', '2021-08-03 20:39:14'),
(752, '13', 'Account created.', '0', '2021-08-03 20:39:49'),
(753, '12', 'Attempted account login.', '0', '2021-08-04 09:18:18'),
(754, '12', 'Logged in to account.', '0', '2021-08-04 09:18:18'),
(755, '12', 'Logged out of account.', '0', '2021-08-04 09:21:43'),
(756, '12', 'Attempted account login.', '0', '2021-08-04 09:28:18'),
(757, '12', 'Logged in to account.', '0', '2021-08-04 09:28:18'),
(758, '12', 'Logged out of account.', '0', '2021-08-04 10:11:18'),
(759, '14', 'Account created.', '0', '2021-08-04 10:13:06'),
(760, '15', 'Account created.', '0', '2021-08-04 10:14:19'),
(761, '15', 'Attempted account login.', '0', '2021-08-04 10:15:09'),
(762, '15', 'Logged in to account.', '0', '2021-08-04 10:15:09'),
(763, '15', 'Attempted account login.', '0', '2021-08-04 10:15:30'),
(764, '15', 'Logged in to account.', '0', '2021-08-04 10:15:30'),
(765, '12', 'Attempted account login.', '0', '2021-08-04 10:15:41'),
(766, '12', 'Logged in to account.', '0', '2021-08-04 10:15:42'),
(767, '12', 'Payment - Merchant Account', '0', '2021-08-07 11:13:20'),
(768, '12', 'Payment - Merchant Account', '0', '2021-08-07 11:19:16'),
(769, '16', 'Account created.', '0', '2021-08-07 11:19:20'),
(770, '16', 'Attempted account login.', '0', '2021-08-07 11:20:57'),
(771, '16', 'Logged in to account.', '0', '2021-08-07 11:20:57'),
(772, '12', 'Attempted account login.', '0', '2021-08-07 11:23:38'),
(773, '12', 'Logged in to account.', '0', '2021-08-07 11:23:38'),
(774, '12', 'Logged out of account.', '0', '2021-08-07 11:23:51'),
(775, '16', 'Attempted account login.', '0', '2021-08-07 11:24:08'),
(776, '16', 'Logged in to account.', '0', '2021-08-07 11:24:09'),
(777, '12', 'Attempted account login.', '0', '2021-08-07 11:24:14'),
(778, '12', 'Logged in to account.', '0', '2021-08-07 11:24:14'),
(779, '12', 'Attempted updating user information.', '0', '2021-08-07 11:24:34'),
(780, '12', 'Update was successful.', '0', '2021-08-07 11:24:34'),
(781, '12', 'Logged out of account.', '0', '2021-08-07 11:24:47'),
(782, '16', 'Attempted account login.', '0', '2021-08-07 11:25:01'),
(783, '16', 'Logged in to account.', '0', '2021-08-07 11:25:01'),
(784, '16', 'Logged out of account.', '0', '2021-08-07 11:26:21'),
(785, '16', 'Attempted account login.', '0', '2021-08-07 11:26:24'),
(786, '16', 'Logged in to account.', '0', '2021-08-07 11:26:24'),
(787, '16', 'Attempted account login.', '0', '2021-08-08 02:17:47'),
(788, '16', 'Logged in to account.', '0', '2021-08-08 02:17:47'),
(789, '16', 'Logged out of account.', '0', '2021-08-08 02:19:20'),
(790, '12', 'Attempted account login.', '0', '2021-08-08 21:56:34'),
(791, '12', 'Logged in to account.', '0', '2021-08-08 21:56:34'),
(792, '16', 'Attempted account login.', '0', '2021-08-08 22:00:20'),
(793, '16', 'Logged in to account.', '0', '2021-08-08 22:00:20'),
(794, '16', 'Attempted account login.', '0', '2021-08-09 08:24:37'),
(795, '16', 'Logged in to account.', '0', '2021-08-09 08:24:37'),
(796, '16', 'Attempted account login.', '0', '2021-08-11 12:19:40'),
(797, '16', 'Attempted account login.', '0', '2021-08-13 21:47:04'),
(798, '16', 'Attempted account login.', '0', '2021-08-13 21:47:12'),
(799, '16', 'Attempted account login.', '0', '2021-08-19 20:26:01'),
(800, '16', 'Attempted account login.', '0', '2021-08-19 20:26:02'),
(801, '16', 'Attempted account login.', '0', '2021-08-19 20:26:14'),
(802, '16', 'Attempted account login.', '0', '2021-09-08 09:47:23'),
(803, '12', 'Attempted account login.', '0', '2021-09-08 09:47:30'),
(804, '12', 'Logged in to account.', '0', '2021-09-08 09:47:30'),
(805, '17', 'Account created.', '0', '2021-10-21 03:41:03'),
(806, '16', 'Attempted account login.', '0', '2021-10-26 10:32:04'),
(807, '16', 'Attempted account login.', '0', '2021-11-02 09:11:07'),
(808, '16', 'Attempted account login.', '0', '2021-11-02 09:36:13'),
(809, '12', 'Attempted account login.', '0', '2022-01-15 10:49:04'),
(810, '12', 'Logged in to account.', '0', '2022-01-15 10:49:04'),
(811, '12', 'Logged out of account.', '0', '2022-01-15 10:52:42'),
(812, '16', 'Attempted account login.', '0', '2022-01-15 10:53:56'),
(813, '12', 'Attempted account login.', '0', '2022-01-15 11:21:52'),
(814, '12', 'Logged in to account.', '0', '2022-01-15 11:21:52'),
(815, '12', 'Logged out of account.', '0', '2022-01-15 11:22:07'),
(816, '16', 'Attempted account login.', '0', '2022-01-15 11:22:19'),
(817, '16', 'Logged in to account.', '0', '2022-01-15 11:22:19'),
(818, '16', 'Attempted updating profile information.', '0', '2022-01-15 11:26:18'),
(819, '16', 'Update was successful.', '0', '2022-01-15 11:26:18'),
(820, '16', 'Attempted account login.', '0', '2022-01-15 11:26:30'),
(821, '16', 'Logged in to account.', '0', '2022-01-15 11:26:31'),
(822, '16', 'Logged out of account.', '0', '2022-01-15 11:29:17'),
(823, '12', 'Attempted account login.', '0', '2022-01-15 11:29:57'),
(824, '12', 'Logged in to account.', '0', '2022-01-15 11:29:57'),
(825, '12', 'Attempted creating new admin.', '0', '2022-01-15 11:30:55'),
(826, '12', 'Account creation was successful.', '0', '2022-01-15 11:30:55'),
(827, '12', 'Attempted updating admin information.', '0', '2022-01-15 11:33:29'),
(828, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:33:29'),
(829, '12', 'Logged out of account.', '0', '2022-01-15 11:34:02'),
(830, '18', 'Attempted account login.', '0', '2022-01-15 11:34:10'),
(831, '18', 'Logged in to account.', '0', '2022-01-15 11:34:10'),
(832, '18', 'Logged out of account.', '0', '2022-01-15 11:36:36'),
(833, '18', 'Attempted account login.', '0', '2022-01-15 11:37:18'),
(834, '18', 'Logged in to account.', '0', '2022-01-15 11:37:18'),
(835, '18', 'Logged out of account.', '0', '2022-01-15 11:38:59'),
(836, '12', 'Attempted account login.', '0', '2022-01-15 11:39:07'),
(837, '12', 'Logged in to account.', '0', '2022-01-15 11:39:07'),
(838, '12', 'Attempted updating admin information.', '0', '2022-01-15 11:40:03'),
(839, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:40:03'),
(840, '12', 'Attempted updating admin information.', '0', '2022-01-15 11:40:20'),
(841, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:40:20'),
(842, '12', 'Attempted updating admin information.', '0', '2022-01-15 11:40:37'),
(843, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:40:37'),
(844, '12', 'Attempted updating admin information.', '0', '2022-01-15 11:40:49'),
(845, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:40:49'),
(846, '12', 'Logged out of account.', '0', '2022-01-15 11:40:53'),
(847, '12', 'Attempted account login.', '0', '2022-01-15 11:41:00'),
(848, '12', 'Logged in to account.', '0', '2022-01-15 11:41:00'),
(849, '12', 'Attempted updating admin information.', '0', '2022-01-15 11:41:22'),
(850, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:41:22'),
(851, '12', 'Attempted updating admin information.', '0', '2022-01-15 11:41:42'),
(852, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:41:42'),
(853, '12', 'Attempted creating new admin.', '0', '2022-01-15 11:45:58'),
(854, '12', 'Creation failed due to wrong password.', '0', '2022-01-15 11:45:58'),
(855, '12', 'Attempted creating new admin.', '0', '2022-01-15 11:46:20'),
(856, '12', 'Account creation was successful.', '0', '2022-01-15 11:46:20'),
(857, '12', 'Attempted creating new admin.', '0', '2022-01-15 11:48:06'),
(858, '12', 'Account creation was successful.', '0', '2022-01-15 11:48:06'),
(859, '12', 'Logged out of account.', '0', '2022-01-15 11:48:12'),
(860, '20', 'Attempted account login.', '0', '2022-01-15 11:48:38'),
(861, '20', 'Login failed because of incorrect password.', '0', '2022-01-15 11:48:39'),
(862, '20', 'Attempted account login.', '0', '2022-01-15 11:49:24'),
(863, '20', 'Logged in to account.', '0', '2022-01-15 11:49:24'),
(864, '20', 'Attempted updating profile information.', '0', '2022-01-15 11:50:00'),
(865, '20', 'Update was successful.', '0', '2022-01-15 11:50:00'),
(866, '20', 'Logged out of account.', '0', '2022-01-15 11:50:21'),
(867, '20', 'Attempted account login.', '0', '2022-01-15 11:50:38'),
(868, '20', 'Logged in to account.', '0', '2022-01-15 11:50:38'),
(869, '20', 'Attempted account login.', '0', '2022-01-15 20:57:03'),
(870, '20', 'Logged in to account.', '0', '2022-01-15 20:57:03'),
(871, '16', 'Attempted account login.', '0', '2022-01-15 20:58:07'),
(872, '16', 'Logged in to account.', '0', '2022-01-15 20:58:07'),
(873, '16', 'Logged out of account.', '0', '2022-01-15 20:59:38'),
(874, '20', 'Attempted account login.', '0', '2022-01-15 20:59:44'),
(875, '20', 'Logged in to account.', '0', '2022-01-15 20:59:44'),
(876, '21', 'Account created.', '0', '2022-02-08 01:28:12'),
(877, '16', 'Attempted account login.', '0', '2022-02-15 11:36:34'),
(878, '16', 'Logged in to account.', '0', '2022-02-15 11:36:34'),
(879, '16', 'Logged out of account.', '0', '2022-02-15 12:02:09'),
(880, '20', 'Attempted account login.', '0', '2022-02-15 12:02:21'),
(881, '20', 'Login failed because of incorrect password.', '0', '2022-02-15 12:02:21'),
(882, '12', 'Attempted account login.', '0', '2022-02-15 12:02:31'),
(883, '12', 'Logged in to account.', '0', '2022-02-15 12:02:31'),
(884, '22', 'Account created.', '0', '2022-02-23 23:18:02'),
(885, '22', 'Attempted account login.', '0', '2022-02-23 23:18:49'),
(886, '22', 'Logged in to account.', '0', '2022-02-23 23:18:49'),
(887, '22', 'Attempted account login.', '0', '2022-02-23 23:19:09'),
(888, '22', 'Logged in to account.', '0', '2022-02-23 23:19:09'),
(889, '20', 'Attempted account login.', '0', '2022-02-27 20:34:20'),
(890, '20', 'Logged in to account.', '0', '2022-02-27 20:34:20'),
(891, '23', 'Account created.', '0', '2022-03-01 15:35:16'),
(892, '20', 'Attempted account login.', '0', '2022-03-10 12:18:23'),
(893, '20', 'Login failed because of incorrect password.', '0', '2022-03-10 12:18:23'),
(894, '12', 'Attempted account login.', '0', '2022-03-10 12:18:29'),
(895, '12', 'Logged in to account.', '0', '2022-03-10 12:18:29'),
(896, '12', 'Attempted account login.', '0', '2022-05-09 15:53:11'),
(897, '12', 'Logged in to account.', '0', '2022-05-09 15:53:11');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_subscriptions`
--

CREATE TABLE `email_subscriptions` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` text NOT NULL,
  `email_slug` text NOT NULL,
  `user_status` varchar(1) NOT NULL DEFAULT '1',
  `date_registered` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `roles` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `fname`, `lname`, `email`, `phone`, `password`, `email_slug`, `user_status`, `date_registered`, `date_modified`, `roles`) VALUES
(12, 'Enterprise', 'Xservico', 'enterprise@xservico.com', '000000000000', '$2y$10$LBVAA6M.inDCK5ioV9pcPuzWV3lHNssmp4AZgEATZ12aLdohkl0ui', '$2y$10$TTPimjeQ6H4Tir2Aytquz.V26gvvOvXXpxuUCifbU2F1eTeCrsoru', '1', '2021-08-03 20:15:52', '2021-08-03 20:15:52', '1'),
(16, 'Mubashir', 'Shuaib', 'hadipartiv21@gmail.com', '000000000000', '$2y$10$710/pkl6DggMhr6bK9pXPO2ER4dA2T1RLb.SWzB.fxb8frZ1.CfUu', '$2y$10$t99XfiGXzmQDZaX5RelO5Oy.xQNUDA9OzGUr0Mdlg9BaMGqxLn30O', '1', '2021-08-07 11:19:20', '2022-01-15 11:26:18', '7'),
(20, 'Mubashir', 'Shuaib', 'admin@xservico.com', '00000000000', '$2y$10$Q3xWLiHRu9vDidaa1XyQCuG/2KyQ.cgvpgfUEUt1tjxvzG0BnZC9K', '$2y$10$q8zuleluokhKTzPssQpkk.gheR2ZRsDAdILDtmjz1tozeBvExAnb6', '1', '2022-01-15 11:48:06', '2022-01-15 11:50:00', '1'),
(21, 'xservico.com bbbdnwkdowifhrdokpwoeiyutrieowsowddfbvksodkasofjgiekwskfieghrhjkfejfegigofwkdkbhbgiejfwokdd', 'xservico.com bbbdnwkdowifhrdokpwoeiyutrieowsowddfbvksodkasofjgiekwskfieghrhjkfejfegigofwkdkbhbgiejfwokdd', 'dimafokin199506780tx+z3w2@inbox.ru', '82486326764', '$2y$10$DKZdGidPbypdMeoq7A0UveeogKLnmyohRm6QG826X4pqcWGSZ.qFS', '$2y$10$gDxqtuOSFpXg04imdUtuheFAMUIsehJQVfkexvuzgfrGOz/W8KT1e', '1', '2022-02-08 01:28:12', '2022-02-08 01:28:12', NULL),
(22, 'Elaine', 'Fakrogha', 'elainefakrogha@gmail.com', '07069571056', '$2y$10$J7HmENNX.0pCNa4b0EJqqeptsmx3LpCUHQFZS.mgqoH6M0zSbdq32', '$2y$10$N.1297v.Q2gr2NDW6IjXZO5n0NIx0sebuKJ8c7ylWxSb/u/ckZ0b.', '1', '2022-02-23 23:18:02', '2022-02-23 23:18:02', NULL),
(23, 'Andre', 'Obi', 'obiandre71@gmail.com', '09021551088', '$2y$10$bM9cYC5UMeYY65isG2L.7.IjnK9l0KBPWhxj5ZSwzMMQfnowjelYu', '$2y$10$eeKcVdZRd6pR6F2sRFlOL.fJO0C/Pvb4YuUjE9WDZ3Ev9h71v0Vwm', '1', '2022-03-01 15:35:16', '2022-03-01 15:35:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `id` int NOT NULL,
  `order_ref` varchar(255) NOT NULL,
  `prod_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `note` text,
  `payment_option` varchar(255) NOT NULL,
  `billing_address1` varchar(255) DEFAULT NULL,
  `billing_address2` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(255) DEFAULT NULL,
  `billing_email` varchar(255) DEFAULT NULL,
  `shipping_address1` varchar(255) DEFAULT NULL,
  `shipping_address2` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_zip` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `admin` varchar(255) DEFAULT NULL,
  `date_posted` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordertracks`
--

CREATE TABLE `ordertracks` (
  `id` int NOT NULL,
  `order_ref` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `others`
--

CREATE TABLE `others` (
  `id` int NOT NULL,
  `type` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `value` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `others`
--

INSERT INTO `others` (`id`, `type`, `value`, `date_modified`) VALUES
(1, 'merchant_fees', '2500', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `type` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `type`, `info`, `date_modified`) VALUES
(6, 'shipping', '<h1><b>Manage Shipping Details.</b></h1>', '2021-07-16 17:13:05'),
(7, 'return_policy', '<p>No Return Policy Set.</p>', '2021-07-16 17:13:05'),
(8, 'terms_use', '<p><strong>Our Terms of Use.--</strong></p>\r\n', '2021-07-16 17:13:05'),
(9, 'privacy_policy', '<p><em>Privacy Policy.--</em></p>\r\n', '2021-07-16 17:13:05'),
(10, 'order_cancellation', '<p>Order Cancellation.--</p>\r\n', '2021-07-16 17:13:05'),
(5, 'general', '<h1><strong>Manage Store Details:</strong></h1>\r\n\r\n<p><strong>Address Line:</strong></p>\r\n\r\n<p><strong>Contact Info:</strong></p>\r\n\r\n<p><strong>Work Hours:</strong></p>\r\n', '2021-07-16 17:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `acct_name` varchar(255) DEFAULT NULL,
  `acct_number` varchar(255) DEFAULT NULL,
  `trans_date` varchar(255) DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `date_posted` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `admin` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `method`, `amount`, `image`, `bank_name`, `acct_name`, `acct_number`, `trans_date`, `status`, `date_posted`, `date_modified`, `admin`) VALUES
(2, 'paypal-checkout-merchant-account-fees', 'paypal-checkout-merchant-fees', 2500, NULL, 'sb-47157y6653101@personal.example.com', 'hadipartiv21@gmail.com', 'merchant-fees', NULL, '0', '2021-08-07 11:19:16', '2021-08-07 11:19:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prods`
--

CREATE TABLE `prods` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `cat_id` varchar(255) NOT NULL,
  `brand_id` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `discounted_price` float DEFAULT '0',
  `quantity` varchar(5) NOT NULL,
  `brief` varchar(255) NOT NULL,
  `warranty` varchar(255) NOT NULL,
  `return_policy` varchar(255) NOT NULL,
  `pay_on_delivery` varchar(255) NOT NULL,
  `tags` text,
  `description` text NOT NULL,
  `additional_info` text,
  `featured` varchar(1) NOT NULL DEFAULT '0',
  `special_offer` varchar(1) NOT NULL DEFAULT '0',
  `deal` varchar(1) NOT NULL DEFAULT '0',
  `deal_start_level` varchar(255) DEFAULT NULL,
  `deal_stop_date` date DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `images` int NOT NULL DEFAULT '0',
  `status` varchar(1) NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `date_posted` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `uploaded_by` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prod_cats`
--

CREATE TABLE `prod_cats` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'flaticon-responsive',
  `status` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prod_images`
--

CREATE TABLE `prod_images` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `prod_id` varchar(255) NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `main_title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `previous` float NOT NULL,
  `date_posted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `days_due` int NOT NULL,
  `date_posted` datetime NOT NULL,
  `date_enc` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `pending` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `type`, `days_due`, `date_posted`, `date_enc`, `pending`) VALUES
(1, 16, 'merchant-fees', 356, '2021-08-07 11:19:16', '62063ca87a3db1f7722e41c720bcab6b', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `prod_id` varchar(255) NOT NULL,
  `member_id` varchar(255) NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_subscriptions`
--
ALTER TABLE `email_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordertracks`
--
ALTER TABLE `ordertracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `others`
--
ALTER TABLE `others`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prods`
--
ALTER TABLE `prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prod_cats`
--
ALTER TABLE `prod_cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prod_images`
--
ALTER TABLE `prod_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=898;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `email_subscriptions`
--
ALTER TABLE `email_subscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ordertracks`
--
ALTER TABLE `ordertracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `others`
--
ALTER TABLE `others`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prods`
--
ALTER TABLE `prods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prod_cats`
--
ALTER TABLE `prod_cats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prod_images`
--
ALTER TABLE `prod_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
