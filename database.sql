SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `library`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `books`
--

CREATE TABLE `books` (
                         `id` int(11) NOT NULL,
                         `title` varchar(200) NOT NULL,
                         `author` varchar(150) NOT NULL,
                         `language` varchar(20) NOT NULL,
                         `category` varchar(100) NOT NULL,
                         `series` varchar(50) DEFAULT NULL,
                         `image` varchar(200) DEFAULT NULL,
                         `description` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `language`, `category`, `series`, `image`, `description`) VALUES
                                                                                                            (1, 'Harry Potter a Kámen Mudrců', 'J.K.Rowling', 'CZ', 'dětské', 'Harry Potter', '/images/HP1.jpg', 'kouzelnický hoch se učí ve škole kouzel'),
                                                                                                            (2, 'Harry Potter a Tajemná Komnata', 'J.K.Rowling', 'CZ', 'dětské', 'Harry Potter', '/images/HP2.jpg', 'Druhý díl dobrodružství kouzelnického učně Harryho');

-- --------------------------------------------------------

--
-- Struktura tabulky `games`
--

CREATE TABLE `games` (
                         `id` int(11) NOT NULL,
                         `name` varchar(100) NOT NULL,
                         `image` varchar(200) DEFAULT NULL,
                         `minPlayer` int(11) NOT NULL,
                         `maxPlayer` int(11) NOT NULL,
                         `note` varchar(200) DEFAULT NULL,
                         `description` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `games`
--

INSERT INTO `games` (`id`, `name`, `image`, `minPlayer`, `maxPlayer`, `note`, `description`) VALUES
    (1, 'Carcassonne', '', 3, 4, '', '');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `books`
--
ALTER TABLE `books`
    ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `games`
--
ALTER TABLE `games`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `books`
--
ALTER TABLE `books`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `games`
--
ALTER TABLE `games`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
