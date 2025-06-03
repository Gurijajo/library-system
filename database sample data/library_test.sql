-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2025 at 08:48 AM
-- Server version: 8.0.32
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_test`
--
CREATE DATABASE IF NOT EXISTS `library_test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `library_test`;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci,
  `birth_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `biography`, `birth_date`, `death_date`, `nationality`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'J.K. Rowling', 'British author, best known for the Harry Potter series.', '1965-07-31', NULL, 'British', NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(2, 'Stephen King', 'American author of horror, supernatural fiction, suspense, and fantasy novels.', '1947-09-21', NULL, 'American', NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(3, 'Agatha Christie', 'English writer known for her detective novels.', '1890-09-15', '1976-01-12', 'British', NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(4, 'George Orwell', 'English novelist and essayist, journalist and critic.', '1903-06-25', '1950-01-21', 'British', NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(5, 'Harper Lee', 'American novelist widely known for To Kill a Mockingbird.', '1926-04-28', '2016-02-19', 'American', NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(6, 'F. Scott Fitzgerald', 'American novelist and short story writer, known for his novels depicting the flamboyance and excess of the Jazz Age.', '1896-09-24', '1940-12-21', 'American', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(7, 'Harper Lee', 'American novelist best known for her 1960 novel To Kill a Mockingbird, which deals with racial injustice.', '1926-04-28', '2016-02-19', 'American', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(8, 'George Orwell', 'English novelist and essayist, known for his dystopian novels 1984 and Animal Farm.', '1903-06-25', '1950-01-21', 'British', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(9, 'Jane Austen', 'English novelist known for her social commentary and wit in novels like Pride and Prejudice.', '1775-12-16', '1817-07-18', 'British', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(10, 'J.D. Salinger', 'American writer known for his novel The Catcher in the Rye and his reclusive lifestyle.', '1919-01-01', '2010-01-27', 'American', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(11, 'William Golding', 'British novelist and playwright, Nobel Prize winner known for Lord of the Flies.', '1911-09-19', '1993-06-19', 'British', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(12, 'J.R.R. Tolkien', 'English writer and philologist, best known for The Hobbit and The Lord of the Rings.', '1892-01-03', '1973-09-02', 'British', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(13, 'J.K. Rowling', 'British author best known for the Harry Potter fantasy series.', '1965-07-31', NULL, 'British', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(14, 'Dan Brown', 'American author best known for his thriller novels including The Da Vinci Code.', '1964-06-22', NULL, 'American', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(15, 'Paulo Coelho', 'Brazilian lyricist and novelist, best known for his novel The Alchemist.', '1947-08-24', NULL, 'Brazilian', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(16, 'Suzanne Collins', 'American television writer and author, best known for The Hunger Games trilogy.', '1962-08-10', NULL, 'American', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(17, 'Aldous Huxley', 'English writer and philosopher, best known for his dystopian novel Brave New World.', '1894-07-26', '1963-11-22', 'British', NULL, '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(18, 'F. Scott Fitzgerald', 'American novelist and short story writer, known for his novels depicting the flamboyance and excess of the Jazz Age.', '1896-09-24', '1940-12-21', 'American', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(19, 'Harper Lee', 'American novelist best known for her 1960 novel To Kill a Mockingbird, which deals with racial injustice.', '1926-04-28', '2016-02-19', 'American', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(20, 'George Orwell', 'English novelist and essayist, known for his dystopian novels 1984 and Animal Farm.', '1903-06-25', '1950-01-21', 'British', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(21, 'Jane Austen', 'English novelist known for her social commentary and wit in novels like Pride and Prejudice.', '1775-12-16', '1817-07-18', 'British', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(22, 'J.D. Salinger', 'American writer known for his novel The Catcher in the Rye and his reclusive lifestyle.', '1919-01-01', '2010-01-27', 'American', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(23, 'William Golding', 'British novelist and playwright, Nobel Prize winner known for Lord of the Flies.', '1911-09-19', '1993-06-19', 'British', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(24, 'J.R.R. Tolkien', 'English writer and philologist, best known for The Hobbit and The Lord of the Rings.', '1892-01-03', '1973-09-02', 'British', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(25, 'J.K. Rowling', 'British author best known for the Harry Potter fantasy series.', '1965-07-31', NULL, 'British', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(26, 'Dan Brown', 'American author best known for his thriller novels including The Da Vinci Code.', '1964-06-22', NULL, 'American', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(27, 'Paulo Coelho', 'Brazilian lyricist and novelist, best known for his novel The Alchemist.', '1947-08-24', NULL, 'Brazilian', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(28, 'Suzanne Collins', 'American television writer and author, best known for The Hunger Games trilogy.', '1962-08-10', NULL, 'American', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(29, 'Aldous Huxley', 'English writer and philosopher, best known for his dystopian novel Brave New World.', '1894-07-26', '1963-11-22', 'British', NULL, '2025-06-03 04:19:01', '2025-06-03 04:19:01'),
(30, 'F. Scott Fitzgerald', 'American novelist and short story writer, known for his novels depicting the flamboyance and excess of the Jazz Age.', '1896-09-24', '1940-12-21', 'American', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(31, 'Harper Lee', 'American novelist best known for her 1960 novel To Kill a Mockingbird, which deals with racial injustice.', '1926-04-28', '2016-02-19', 'American', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(32, 'George Orwell', 'English novelist and essayist, known for his dystopian novels 1984 and Animal Farm.', '1903-06-25', '1950-01-21', 'British', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(33, 'Jane Austen', 'English novelist known for her social commentary and wit in novels like Pride and Prejudice.', '1775-12-16', '1817-07-18', 'British', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(34, 'J.D. Salinger', 'American writer known for his novel The Catcher in the Rye and his reclusive lifestyle.', '1919-01-01', '2010-01-27', 'American', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(35, 'William Golding', 'British novelist and playwright, Nobel Prize winner known for Lord of the Flies.', '1911-09-19', '1993-06-19', 'British', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(36, 'J.R.R. Tolkien', 'English writer and philologist, best known for The Hobbit and The Lord of the Rings.', '1892-01-03', '1973-09-02', 'British', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(37, 'J.K. Rowling', 'British author best known for the Harry Potter fantasy series.', '1965-07-31', NULL, 'British', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(38, 'Dan Brown', 'American author best known for his thriller novels including The Da Vinci Code.', '1964-06-22', NULL, 'American', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(39, 'Paulo Coelho', 'Brazilian lyricist and novelist, best known for his novel The Alchemist.', '1947-08-24', NULL, 'Brazilian', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(40, 'Suzanne Collins', 'American television writer and author, best known for The Hunger Games trilogy.', '1962-08-10', NULL, 'American', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(41, 'Aldous Huxley', 'English writer and philosopher, best known for his dystopian novel Brave New World.', '1894-07-26', '1963-11-22', 'British', NULL, '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(42, 'F. Scott Fitzgerald', 'American novelist and short story writer, known for his novels depicting the flamboyance and excess of the Jazz Age.', '1896-09-24', '1940-12-21', 'American', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(43, 'Harper Lee', 'American novelist best known for her 1960 novel To Kill a Mockingbird, which deals with racial injustice.', '1926-04-28', '2016-02-19', 'American', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(44, 'George Orwell', 'English novelist and essayist, known for his dystopian novels 1984 and Animal Farm.', '1903-06-25', '1950-01-21', 'British', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(45, 'Jane Austen', 'English novelist known for her social commentary and wit in novels like Pride and Prejudice.', '1775-12-16', '1817-07-18', 'British', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(46, 'J.D. Salinger', 'American writer known for his novel The Catcher in the Rye and his reclusive lifestyle.', '1919-01-01', '2010-01-27', 'American', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(47, 'William Golding', 'British novelist and playwright, Nobel Prize winner known for Lord of the Flies.', '1911-09-19', '1993-06-19', 'British', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(48, 'J.R.R. Tolkien', 'English writer and philologist, best known for The Hobbit and The Lord of the Rings.', '1892-01-03', '1973-09-02', 'British', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(49, 'J.K. Rowling', 'British author best known for the Harry Potter fantasy series.', '1965-07-31', NULL, 'British', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(50, 'Dan Brown', 'American author best known for his thriller novels including The Da Vinci Code.', '1964-06-22', NULL, 'American', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(51, 'Paulo Coelho', 'Brazilian lyricist and novelist, best known for his novel The Alchemist.', '1947-08-24', NULL, 'Brazilian', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(52, 'Suzanne Collins', 'American television writer and author, best known for The Hunger Games trilogy.', '1962-08-10', NULL, 'American', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(53, 'Aldous Huxley', 'English writer and philosopher, best known for his dystopian novel Brave New World.', '1894-07-26', '1963-11-22', 'British', NULL, '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(54, 'F. Scott Fitzgerald', 'American novelist and short story writer, known for his novels depicting the flamboyance and excess of the Jazz Age.', '1896-09-24', '1940-12-21', 'American', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(55, 'Harper Lee', 'American novelist best known for her 1960 novel To Kill a Mockingbird, which deals with racial injustice.', '1926-04-28', '2016-02-19', 'American', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(56, 'George Orwell', 'English novelist and essayist, known for his dystopian novels 1984 and Animal Farm.', '1903-06-25', '1950-01-21', 'British', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(57, 'Jane Austen', 'English novelist known for her social commentary and wit in novels like Pride and Prejudice.', '1775-12-16', '1817-07-18', 'British', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(58, 'J.D. Salinger', 'American writer known for his novel The Catcher in the Rye and his reclusive lifestyle.', '1919-01-01', '2010-01-27', 'American', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(59, 'William Golding', 'British novelist and playwright, Nobel Prize winner known for Lord of the Flies.', '1911-09-19', '1993-06-19', 'British', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(60, 'J.R.R. Tolkien', 'English writer and philologist, best known for The Hobbit and The Lord of the Rings.', '1892-01-03', '1973-09-02', 'British', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(61, 'J.K. Rowling', 'British author best known for the Harry Potter fantasy series.', '1965-07-31', NULL, 'British', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(62, 'Dan Brown', 'American author best known for his thriller novels including The Da Vinci Code.', '1964-06-22', NULL, 'American', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(63, 'Paulo Coelho', 'Brazilian lyricist and novelist, best known for his novel The Alchemist.', '1947-08-24', NULL, 'Brazilian', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(64, 'Suzanne Collins', 'American television writer and author, best known for The Hunger Games trilogy.', '1962-08-10', NULL, 'American', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(65, 'Aldous Huxley', 'English writer and philosopher, best known for his dystopian novel Brave New World.', '1894-07-26', '1963-11-22', 'British', NULL, '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(66, 'F. Scott Fitzgerald', 'American novelist and short story writer, known for his novels depicting the flamboyance and excess of the Jazz Age.', '1896-09-24', '1940-12-21', 'American', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(67, 'Harper Lee', 'American novelist best known for her 1960 novel To Kill a Mockingbird, which deals with racial injustice.', '1926-04-28', '2016-02-19', 'American', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(68, 'George Orwell', 'English novelist and essayist, known for his dystopian novels 1984 and Animal Farm.', '1903-06-25', '1950-01-21', 'British', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(69, 'Jane Austen', 'English novelist known for her social commentary and wit in novels like Pride and Prejudice.', '1775-12-16', '1817-07-18', 'British', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(70, 'J.D. Salinger', 'American writer known for his novel The Catcher in the Rye and his reclusive lifestyle.', '1919-01-01', '2010-01-27', 'American', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(71, 'William Golding', 'British novelist and playwright, Nobel Prize winner known for Lord of the Flies.', '1911-09-19', '1993-06-19', 'British', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(72, 'J.R.R. Tolkien', 'English writer and philologist, best known for The Hobbit and The Lord of the Rings.', '1892-01-03', '1973-09-02', 'British', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(73, 'J.K. Rowling', 'British author best known for the Harry Potter fantasy series.', '1965-07-31', NULL, 'British', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(74, 'Dan Brown', 'American author best known for his thriller novels including The Da Vinci Code.', '1964-06-22', NULL, 'American', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(75, 'Paulo Coelho', 'Brazilian lyricist and novelist, best known for his novel The Alchemist.', '1947-08-24', NULL, 'Brazilian', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(76, 'Suzanne Collins', 'American television writer and author, best known for The Hunger Games trilogy.', '1962-08-10', NULL, 'American', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(77, 'Aldous Huxley', 'English writer and philosopher, best known for his dystopian novel Brave New World.', '1894-07-26', '1963-11-22', 'British', NULL, '2025-06-03 04:24:36', '2025-06-03 04:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `author_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `total_copies` int NOT NULL,
  `available_copies` int NOT NULL,
  `publication_date` date DEFAULT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'English',
  `pages` int DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `status` enum('active','inactive','maintenance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `isbn`, `description`, `author_id`, `category_id`, `total_copies`, `available_copies`, `publication_date`, `publisher`, `language`, `pages`, `cover_image`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Voluptas expedita co', 'Suscipit est necessi', 'Doloremque praesenti', 2, 4, 34, 33, '1984-11-15', 'Dolore lorem debitis', 'Sed accusantium quis', 14, 'book-covers/fvmD8dznQxTmT3nC2O4AYXC3dA8oNoUku79hQ7HU.jpg', 193.00, 'active', '2025-06-03 03:51:39', '2025-06-03 04:45:45'),
(2, 'The Great Gatsby', '9780743273565', 'A classic American novel set in the Jazz Age, exploring themes of wealth, love, and the American Dream.', 16, 5, 5, 3, '1925-04-10', 'Scribner', 'English', 180, 'book-covers/Cql8YBxm513NLpB6Ti7Oex80Ut4MHOeNEdokMK3Z.jpg', NULL, 'active', '2024-09-19 04:19:01', '2025-06-03 04:26:07'),
(4, 'Iste aliquid sed odio.', '9782858269846', 'Numquam est accusamus ipsum eos dolore aut ipsam ut. Aut enim delectus dolores fugit et sit. Non numquam pariatur sed et est. Culpa libero sapiente quisquam sint.', 8, 3, 12, 0, '1989-04-06', 'Paucek, Franecki and Prohaska', 'Chinese', 428, 'https://via.placeholder.com/200x300.png/005555?text=books+Faker+Book+quam', 88.80, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(5, 'Dicta nisi id debitis ipsam sit.', '9784910377209', 'Totam dolorem eligendi perferendis quia. Molestiae incidunt consequatur est consectetur a omnis quis perspiciatis. Accusantium et suscipit recusandae ut. Qui enim consequuntur nostrum.', 9, 5, 9, 2, '2007-03-02', 'Gottlieb, Stiedemann and Reynolds', 'German', 106, 'https://via.placeholder.com/200x300.png/0022ee?text=books+Faker+Book+qui', 52.91, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(6, 'Voluptates sint ut incidunt.', '9785010191252', 'Porro est voluptas molestiae autem natus. Quod aut iste alias sint cupiditate aut. Non eos ea animi blanditiis. Quia nostrum tenetur pariatur ea alias. Sequi eligendi aut rem et et amet.', 6, 3, 9, 7, '2012-04-18', 'Howe, Dietrich and Nicolas', 'English', 780, 'https://via.placeholder.com/200x300.png/004444?text=books+Faker+Book+laborum', 94.60, 'inactive', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(7, 'Nihil temporibus praesentium voluptatem.', '9798042943027', 'Reprehenderit quis sed sunt expedita ut dolorem. Consequatur mollitia accusantium sit nostrum sint quo. Voluptatibus voluptatum voluptates saepe iste iusto. Et qui sint non recusandae voluptatem accusamus sed cupiditate. Sunt vitae qui consequuntur voluptas voluptatem. Aut hic dicta delectus.', 6, 5, 15, 3, '1995-10-29', 'McLaughlin PLC', 'German', 696, 'https://via.placeholder.com/200x300.png/00ffff?text=books+Faker+Book+quia', 37.44, 'maintenance', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(8, 'Eius hic nisi provident voluptatem.', '9789270537140', 'Facilis voluptate neque maiores labore et est quis et. Aliquam recusandae voluptatem eum itaque. Doloribus aperiam repudiandae quis laborum. Natus dicta eos fugiat sed.', 4, 4, 10, 10, '1971-09-24', 'Labadie Inc', 'English', 303, 'https://via.placeholder.com/200x300.png/007766?text=books+Faker+Book+sed', 19.31, 'maintenance', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(9, 'Ab reiciendis quia.', '9797789666176', 'Enim minima et quo similique suscipit. Id velit temporibus culpa qui. Dolorum et alias voluptatem assumenda commodi optio consectetur. Qui laboriosam sint ullam officiis voluptatum et.', 1, 1, 5, 4, '1971-08-19', 'Schmeler Inc', 'Spanish', 704, 'https://via.placeholder.com/200x300.png/00ddcc?text=books+Faker+Book+perspiciatis', 82.81, 'maintenance', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(10, 'Sequi ad enim doloremque.', '9795188657122', 'Est labore sed et deleniti saepe iure et. Quidem ea laboriosam libero impedit eaque aut qui voluptate. Consequuntur quod ut dolorum quas ea ab quia. Distinctio dolores pariatur repellat iure laudantium blanditiis.', 3, 4, 20, 17, '2020-11-22', 'Murray Group', 'German', 255, 'https://via.placeholder.com/200x300.png/0000cc?text=books+Faker+Book+doloremque', 30.39, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(11, 'Alias corrupti ea ipsa autem quia.', '9794948007467', 'Quidem dolores qui dignissimos pariatur deleniti commodi. Maxime voluptate et sit ut repellendus unde rerum esse. Facilis est alias ducimus ea ut est. Quisquam aut est in. Esse tempora autem veritatis debitis rerum dicta ducimus. Alias fugiat sed a commodi aut quas.', 3, 3, 10, 10, '1975-04-22', 'Fadel, White and Deckow', 'Chinese', 430, 'https://via.placeholder.com/200x300.png/001122?text=books+Faker+Book+quos', 62.33, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(12, 'Necessitatibus incidunt sit eos eos.', '9783385805392', 'Non voluptas iure est ut nam sit sit. Et sit sed et aperiam vitae sapiente nobis. Consectetur non magni qui sunt velit omnis laborum nam. Blanditiis eum laudantium odio labore dolorem quis corporis.', 10, 2, 9, 8, '2019-05-29', 'O\'Keefe, Kirlin and Doyle', 'Spanish', 573, 'https://via.placeholder.com/200x300.png/008800?text=books+Faker+Book+error', 65.37, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(13, 'Qui perspiciatis excepturi asperiores occaecati.', '9790418888055', 'Suscipit rerum iste ipsam non. Qui nam eum quos suscipit officiis ducimus assumenda. Aut repellendus suscipit fugiat perferendis odit nulla omnis perferendis. Enim magni et dicta architecto.', 5, 5, 8, 1, '1987-08-17', 'Pacocha PLC', 'English', 133, 'https://via.placeholder.com/200x300.png/00aa33?text=books+Faker+Book+delectus', 40.40, 'inactive', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(14, 'Quos voluptatum omnis facilis veniam voluptates.', '9785458902250', 'Quo recusandae deserunt reprehenderit magnam quo ex. Non voluptatem necessitatibus sequi. Voluptas vel voluptatum natus est ad impedit. Aliquam aliquid aliquam commodi iste unde repudiandae. Quidem praesentium minima ut molestiae qui voluptatum sit. Eos aut facilis itaque veritatis.', 3, 4, 19, 16, '1972-12-27', 'Weissnat-Sporer', 'Spanish', 740, 'https://via.placeholder.com/200x300.png/000022?text=books+Faker+Book+cumque', 85.49, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(15, 'Ut numquam rerum ducimus ut sunt.', '9799443175185', 'Sit omnis corporis atque at velit. Quo cum rerum consequuntur voluptas. Enim doloremque nesciunt porro vel magnam voluptas ducimus. Et id temporibus dolor et.', 3, 5, 1, 0, '1995-03-15', 'Nikolaus, Bednar and Borer', 'Chinese', 531, 'https://via.placeholder.com/200x300.png/003399?text=books+Faker+Book+ducimus', 22.03, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(16, 'Omnis id est consequuntur enim.', '9791659126708', 'Deleniti iure minima aut ex. Sequi sit harum consequatur facere aliquid. Sapiente molestiae esse itaque suscipit facere. Aperiam placeat ipsum excepturi dolorem dicta fugit eum totam.', 2, 5, 16, 12, '1981-04-20', 'Bruen-Rutherford', 'French', 229, 'https://via.placeholder.com/200x300.png/002266?text=books+Faker+Book+ipsa', 71.17, 'maintenance', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(17, 'Saepe dolorem quia et hic.', '9791065929542', 'Quasi eligendi laboriosam dicta. Quam exercitationem nesciunt ipsum aliquid ut. Iste velit necessitatibus deleniti doloremque ducimus necessitatibus. Quas id quia quia est et voluptatibus. Laborum voluptatem est est.', 4, 3, 7, 2, '1993-03-04', 'Schaefer-O\'Hara', 'Chinese', 230, 'https://via.placeholder.com/200x300.png/00dd77?text=books+Faker+Book+at', 69.82, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(18, 'Eaque tenetur impedit.', '9787846033034', 'Omnis sed tenetur accusantium autem et. Non et cumque sit aperiam illo. Iusto eos blanditiis illo mollitia dolor et. Minima officia vel expedita repudiandae amet ut quod et.', 6, 4, 15, 9, '1997-11-14', 'Smitham-Stiedemann', 'Spanish', 440, 'https://via.placeholder.com/200x300.png/005588?text=books+Faker+Book+perferendis', 77.40, 'inactive', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(19, 'Provident molestiae magni.', '9797559486553', 'Optio praesentium et voluptas nihil. Ullam eos aut incidunt natus aliquam enim. In dolorem qui sequi aut. Ducimus rerum ducimus soluta ut nihil. Sapiente atque aliquid sed vel hic mollitia labore.', 1, 3, 18, 15, '1993-05-29', 'Crooks-Cruickshank', 'German', 213, 'https://via.placeholder.com/200x300.png/006611?text=books+Faker+Book+fugit', 34.62, 'inactive', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(20, 'Vero voluptas delectus eum.', '9782343319988', 'Repellendus iusto repudiandae pariatur. Quidem omnis error voluptas veniam et. Velit nostrum minus eius maxime sint quos ipsum. Corrupti optio voluptates laudantium ad et.', 8, 4, 16, 6, '2004-03-06', 'Beer-Gerlach', 'Spanish', 562, 'https://via.placeholder.com/200x300.png/000000?text=books+Faker+Book+illum', 41.61, 'maintenance', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(21, 'Mollitia inventore voluptas in sint.', '9783242563748', 'Quia delectus totam est velit. Omnis qui doloremque ratione nulla autem adipisci rerum. Nobis sunt omnis eius cupiditate qui. Non doloremque nisi facilis aut natus culpa.', 6, 2, 19, 11, '1988-09-26', 'Mohr-DuBuque', 'German', 295, 'https://via.placeholder.com/200x300.png/002288?text=books+Faker+Book+et', 61.49, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(22, 'Iure maiores pariatur.', '9796977155119', 'Consequatur natus est repellat reprehenderit est. Qui modi velit ut possimus mollitia unde odit. Sed porro enim qui repudiandae pariatur facere. Eaque neque qui qui iure asperiores excepturi quaerat. Rerum adipisci qui adipisci fuga. Autem ut eaque voluptas ut optio molestias voluptas.', 9, 5, 8, 7, '1973-11-08', 'Bernhard Ltd', 'English', 306, 'https://via.placeholder.com/200x300.png/000000?text=books+Faker+Book+est', 94.50, 'inactive', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(23, 'Assumenda quia iusto error.', '9783751350013', 'Delectus et aut rerum sit quasi. Id minus officiis corrupti maiores sequi laudantium velit. Iure illum quae optio iure voluptatem. Non temporibus nesciunt ut labore et ipsum aut reiciendis. Velit soluta minima quasi et illum.', 6, 2, 3, 0, '2019-12-17', 'Luettgen LLC', 'French', 746, 'https://via.placeholder.com/200x300.png/002233?text=books+Faker+Book+est', 81.05, 'active', '2025-06-03 04:24:36', '2025-06-03 04:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

DROP TABLE IF EXISTS `borrowings`;
CREATE TABLE `borrowings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `borrowed_date` date NOT NULL,
  `due_date` date NOT NULL,
  `returned_date` date DEFAULT NULL,
  `status` enum('borrowed','returned','overdue','lost') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'borrowed',
  `fine_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `fine_paid` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `issued_by` bigint UNSIGNED NOT NULL,
  `returned_to` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `book_id`, `borrowed_date`, `due_date`, `returned_date`, `status`, `fine_amount`, `fine_paid`, `notes`, `issued_by`, `returned_to`, `created_at`, `updated_at`) VALUES
(1, 13, 1, '2025-06-01', '2025-06-11', NULL, 'borrowed', 0.00, 0, NULL, 2, NULL, '2025-06-03 03:55:39', '2025-06-03 03:55:39'),
(2, 12, 1, '2025-06-03', '2025-06-17', '2025-06-03', 'returned', 0.00, 0, NULL, 2, 2, '2025-06-03 03:56:51', '2025-06-03 03:57:03'),
(3, 3, 1, '2025-06-03', '2025-06-28', '2025-06-03', 'returned', 0.00, 0, 'test', 2, 1, '2025-06-03 04:07:59', '2025-06-03 04:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Fiction', 'Fictional literature and novels', '#3B82F6', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(2, 'Non-Fiction', 'Non-fictional books and documentaries', '#10B981', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(3, 'Science', 'Scientific books and research', '#8B5CF6', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(4, 'History', 'Historical books and biographies', '#F59E0B', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(5, 'Technology', 'Technology and programming books', '#EF4444', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(6, 'Art & Design', 'Art, design, and creative books', '#EC4899', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(7, 'Business', 'Business and entrepreneurship', '#6366F1', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(8, 'Self-Help', 'Personal development and self-help', '#14B8A6', '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(9, 'Fiction', 'Imaginative and creative literary works', '#3B82F6', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(10, 'Science Fiction', 'Fiction dealing with futuristic concepts and advanced technology', '#8B5CF6', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(11, 'Fantasy', 'Fiction involving magical or supernatural elements', '#10B981', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(12, 'Mystery', 'Fiction dealing with puzzling or unexplained events', '#F59E0B', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(13, 'Romance', 'Fiction focusing on romantic relationships', '#EC4899', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(14, 'Thriller', 'Fast-paced fiction designed to hold readers in suspense', '#EF4444', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(15, 'Young Adult', 'Fiction targeted at teenage and young adult readers', '#06B6D4', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(16, 'Classic Literature', 'Enduring works of literary fiction from past eras', '#84CC16', '2025-06-03 04:16:46', '2025-06-03 04:16:46'),
(17, 'Fiction', 'Imaginative and creative literary works', '#3B82F6', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(18, 'Science Fiction', 'Fiction dealing with futuristic concepts and advanced technology', '#8B5CF6', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(19, 'Fantasy', 'Fiction involving magical or supernatural elements', '#10B981', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(20, 'Mystery', 'Fiction dealing with puzzling or unexplained events', '#F59E0B', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(21, 'Romance', 'Fiction focusing on romantic relationships', '#EC4899', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(22, 'Thriller', 'Fast-paced fiction designed to hold readers in suspense', '#EF4444', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(23, 'Young Adult', 'Fiction targeted at teenage and young adult readers', '#06B6D4', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(24, 'Classic Literature', 'Enduring works of literary fiction from past eras', '#84CC16', '2025-06-03 04:19:00', '2025-06-03 04:19:00'),
(25, 'Fiction', 'Imaginative and creative literary works', '#3B82F6', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(26, 'Science Fiction', 'Fiction dealing with futuristic concepts and advanced technology', '#8B5CF6', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(27, 'Fantasy', 'Fiction involving magical or supernatural elements', '#10B981', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(28, 'Mystery', 'Fiction dealing with puzzling or unexplained events', '#F59E0B', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(29, 'Romance', 'Fiction focusing on romantic relationships', '#EC4899', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(30, 'Thriller', 'Fast-paced fiction designed to hold readers in suspense', '#EF4444', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(31, 'Young Adult', 'Fiction targeted at teenage and young adult readers', '#06B6D4', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(32, 'Classic Literature', 'Enduring works of literary fiction from past eras', '#84CC16', '2025-06-03 04:20:45', '2025-06-03 04:20:45'),
(33, 'Fiction', 'Imaginative and creative literary works', '#3B82F6', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(34, 'Science Fiction', 'Fiction dealing with futuristic concepts and advanced technology', '#8B5CF6', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(35, 'Fantasy', 'Fiction involving magical or supernatural elements', '#10B981', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(36, 'Mystery', 'Fiction dealing with puzzling or unexplained events', '#F59E0B', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(37, 'Romance', 'Fiction focusing on romantic relationships', '#EC4899', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(38, 'Thriller', 'Fast-paced fiction designed to hold readers in suspense', '#EF4444', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(39, 'Young Adult', 'Fiction targeted at teenage and young adult readers', '#06B6D4', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(40, 'Classic Literature', 'Enduring works of literary fiction from past eras', '#84CC16', '2025-06-03 04:23:25', '2025-06-03 04:23:25'),
(41, 'Fiction', 'Imaginative and creative literary works', '#3B82F6', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(42, 'Science Fiction', 'Fiction dealing with futuristic concepts and advanced technology', '#8B5CF6', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(43, 'Fantasy', 'Fiction involving magical or supernatural elements', '#10B981', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(44, 'Mystery', 'Fiction dealing with puzzling or unexplained events', '#F59E0B', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(45, 'Romance', 'Fiction focusing on romantic relationships', '#EC4899', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(46, 'Thriller', 'Fast-paced fiction designed to hold readers in suspense', '#EF4444', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(47, 'Young Adult', 'Fiction targeted at teenage and young adult readers', '#06B6D4', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(48, 'Classic Literature', 'Enduring works of literary fiction from past eras', '#84CC16', '2025-06-03 04:23:55', '2025-06-03 04:23:55'),
(49, 'Fiction', 'Imaginative and creative literary works', '#3B82F6', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(50, 'Science Fiction', 'Fiction dealing with futuristic concepts and advanced technology', '#8B5CF6', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(51, 'Fantasy', 'Fiction involving magical or supernatural elements', '#10B981', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(52, 'Mystery', 'Fiction dealing with puzzling or unexplained events', '#F59E0B', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(53, 'Romance', 'Fiction focusing on romantic relationships', '#EC4899', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(54, 'Thriller', 'Fast-paced fiction designed to hold readers in suspense', '#EF4444', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(55, 'Young Adult', 'Fiction targeted at teenage and young adult readers', '#06B6D4', '2025-06-03 04:24:36', '2025-06-03 04:24:36'),
(56, 'Classic Literature', 'Enduring works of literary fiction from past eras', '#84CC16', '2025-06-03 04:24:36', '2025-06-03 04:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_01_01_000001_create_authors_table', 1),
(4, '2024_01_01_000002_create_categories_table', 1),
(5, '2024_01_01_000003_create_books_table', 1),
(6, '2024_01_01_000005_create_borrowings_table', 1),
(7, '2024_01_01_000006_create_reservations_table', 1),
(8, '2024_01_02_000006_create_reservations_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `status` enum('active','fulfilled','cancelled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `reserved_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `fulfilled_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `book_id`, `status`, `reserved_date`, `expiry_date`, `fulfilled_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'active', '2025-06-03', '2025-06-10', NULL, 'testsssss', '2025-06-03 04:35:22', '2025-06-03 04:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `date_of_birth` date DEFAULT NULL,
  `role` enum('admin','librarian','member') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `membership_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `membership_expiry` date DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `date_of_birth`, `role`, `status`, `membership_id`, `membership_expiry`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin@library.com', NULL, '$2y$12$rg3uRq51.fBXiSo/4XYP0OaMFzldlhaxrWsmFw4KcRfG9Elp1CWSG', NULL, NULL, NULL, 'admin', 'active', 'LIB20240001', NULL, 'avatars/v9jMBTCONioJKrICqgNvQ4YtUDPuoEInIs21se5A.jpg', NULL, '2025-06-03 03:49:54', '2025-06-03 04:01:06'),
(2, 'Head Librarian', 'librarian@library.com', NULL, '$2y$12$wJZdpY3RtWrsBLGFH8zWK.5ZXzZt9X3.JskDRmlzsRYUJ08MKsIWG', NULL, NULL, NULL, 'librarian', 'active', 'LIB20240002', NULL, 'avatars/AMcyQhXaOL2WY49tDpUQDyiGtv4BOUEBLXI8uk2Z.jpg', NULL, '2025-06-03 03:49:54', '2025-06-03 04:15:56'),
(3, 'Member 1', 'member1@example.com', NULL, '$2y$12$R2ZCkZ3wpI7PaO5YpoBeU..QNltL4lD0ngVoDmKqlfl0Ze7.8ChAm', NULL, NULL, NULL, 'member', 'active', 'LIB20240003', '2026-06-03', NULL, NULL, '2025-06-03 03:49:54', '2025-06-03 03:49:54'),
(4, 'Member 2', 'member2@example.com', NULL, '$2y$12$h5bIl6WE0N8hJys/XdUp8erhbF9i5ua0ql.rVkbzExVWDLjBmFv5K', NULL, NULL, NULL, 'member', 'active', 'LIB20240004', '2026-06-03', NULL, NULL, '2025-06-03 03:49:55', '2025-06-03 03:49:55'),
(5, 'Member 3', 'member3@example.com', NULL, '$2y$12$ntWuhPaTfZUnBJAbRfec5e7qCHvYfpYct3vwkX5ER0ctPbj4GBR9a', NULL, NULL, NULL, 'member', 'active', 'LIB20240005', '2026-06-03', NULL, NULL, '2025-06-03 03:49:55', '2025-06-03 03:49:55'),
(6, 'Member 4', 'member4@example.com', NULL, '$2y$12$5xCNiedW8B2DaxZsn/A6De3NLqnZqG0gV/eFTGXOA0X7xBSlDxmTK', NULL, NULL, NULL, 'member', 'active', 'LIB20240006', '2026-06-03', NULL, NULL, '2025-06-03 03:49:55', '2025-06-03 03:49:55'),
(7, 'Member 5', 'member5@example.com', NULL, '$2y$12$WrBq1/3X6QJFrlMI2F5AOOthy/H32OY0M9a5ROb0e/.RSjNZb8YgW', NULL, NULL, NULL, 'member', 'active', 'LIB20240007', '2026-06-03', NULL, NULL, '2025-06-03 03:49:55', '2025-06-03 03:49:55'),
(8, 'Member 6', 'member6@example.com', NULL, '$2y$12$LzEi4grMpSzaexbqLlzKAeIYQK3IeRnvZteO16iIfowzD0A1/J2Cu', NULL, NULL, NULL, 'member', 'active', 'LIB20240008', '2026-06-03', NULL, NULL, '2025-06-03 03:49:55', '2025-06-03 03:49:55'),
(9, 'Member 7', 'member7@example.com', NULL, '$2y$12$42QuHgSTqggPwf9KrAuqiOJS6lw95cG7qouxNG.Z7WRg8DddSGuj.', NULL, NULL, NULL, 'member', 'active', 'LIB20240009', '2026-06-03', NULL, NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(10, 'Member 8', 'member8@example.com', NULL, '$2y$12$2OgNg42Xo961LvQIeuwE2.RsPHPFkB54A.rqZtqDQQJzJCMfuU2mS', NULL, NULL, NULL, 'member', 'active', 'LIB20240010', '2026-06-03', NULL, NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(11, 'Member 9', 'member9@example.com', NULL, '$2y$12$k.TDCJSduSRMLn46n0sKmu40F7R2RcVrmxByqG/Eib3cT5.yCQSQy', NULL, NULL, NULL, 'member', 'active', 'LIB20240011', '2026-06-03', NULL, NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(12, 'Member 10', 'member10@example.com', NULL, '$2y$12$IZfbwP.A5eWfhWqCIwYiweHe/u7Ib/xhpeTybbWOQGifCVBmvwRVS', NULL, NULL, NULL, 'member', 'active', 'LIB20240012', '2026-06-03', NULL, NULL, '2025-06-03 03:49:56', '2025-06-03 03:49:56'),
(13, 'Rana Weeks', 'tupizywilu@mailinator.com', NULL, '$2y$12$jTtGfFfyulv63C1oLUNbJ.sNivnZX/HoZvyXt5zHpoSLsW.3Ka7M.', '+1 (254) 941-5266', 'Asperiores saepe off', '1998-04-23', 'member', 'active', 'LIB20250589', '2026-06-03', 'avatars/jCdSrLMTbM99oG89owRwdSXhhQwTvtErSIiH94zo.jpg', NULL, '2025-06-03 03:53:03', '2025-06-03 03:53:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_isbn_unique` (`isbn`),
  ADD KEY `books_author_id_foreign` (`author_id`),
  ADD KEY `books_category_id_foreign` (`category_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowings_user_id_foreign` (`user_id`),
  ADD KEY `borrowings_book_id_foreign` (`book_id`),
  ADD KEY `borrowings_issued_by_foreign` (`issued_by`),
  ADD KEY `borrowings_returned_to_foreign` (`returned_to`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_status_index` (`user_id`,`status`),
  ADD KEY `reservations_book_id_status_index` (`book_id`,`status`),
  ADD KEY `reservations_reserved_date_index` (`reserved_date`),
  ADD KEY `reservations_expiry_date_index` (`expiry_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_membership_id_unique` (`membership_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowings_issued_by_foreign` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowings_returned_to_foreign` FOREIGN KEY (`returned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
