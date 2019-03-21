SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `students-list`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `year_of_birth` smallint(4) UNSIGNED NOT NULL,
  `locate` enum('local','foreign') NOT NULL,
  `group_number` varchar(5) NOT NULL,
  `email` varchar(150) NOT NULL,
  `points` mediumint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `gender`, `year_of_birth`, `locate`, `group_number`, `email`, `points`) VALUES
(1, 'Александр', 'Пичушкин', 'm', 1974, 'local', '34в21', 'pich@mail.ru', 231),
(2, 'Чарльз', 'Мэнсон', 'm', 1934, 'local', '5пр32', 'mdk123@ya.ru', 228),
(4, 'Антон', 'Сычев', 'm', 1999, 'foreign', '07ми9', 'kondratev.matvei@dorofeev.ru', 78),
(5, 'Дженис', 'Джоплин', 'f', 1943, 'local', '34в21', 'jane@jop.ru', 78),
(6, 'Ярослава', 'Котова', 'f', 1999, 'local', '34в21', 'nikodim.uvarov@inbox.ru', 195),
(7, 'Евгений', 'Вольнов', 'm', 1986, 'foreign', 'упдк5', 'volnov228@gmail.com', 269),
(8, 'Дима', 'Лобнев', 'm', 1989, 'local', '34в21', 'dimm12@mail.ru', 113),
(9, 'Игорь', 'Тальков', 'm', 1956, 'local', 'у555ш', 'talk69@ya.ru', 221),
(10, 'Павел', 'Мягков', 'm', 1993, 'foreign', '5пр32', 'paulusm@hotmail.com', 86),
(11, 'Юрий', 'Семецкий', 'm', 1962, 'foreign', 'упдк5', 'sema0605@yandex.ru', 114),
(12, 'Элвис', 'Пресли', 'm', 1935, 'foreign', 'у555ш', 'pelvismajor777@yahoo.com', 100),
(13, 'Цезарь', 'Мевесович', 'm', 2017, 'foreign', 'кет33', 'zesor777@gmail.com', 300),
(16, 'Ерик', 'Ангельский', 'm', 2016, 'foreign', 'кет33', 'erich1488@outlook.com', 300),
(17, 'Питер', 'Сатклифф', 'm', 1946, 'local', '5пр32', 'satty46@yahoo.com', 165),
(18, 'Джеймс', 'Хетфилд', 'm', 1963, 'local', '123уц', 'masterofpuppets@ya.ru', 198),
(19, 'Курт', 'Кобейн', 'm', 1967, 'local', '55555', 'kurtka27@hotmail.com', 222);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
