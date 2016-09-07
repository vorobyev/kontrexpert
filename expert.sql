-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 07 2016 г., 10:58
-- Версия сервера: 5.6.27-log
-- Версия PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `expert`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `idKontr` int(11) NOT NULL,
  `kontrAccount` varchar(40) NOT NULL,
  `bankName` text NOT NULL,
  `korrAccount` varchar(40) NOT NULL,
  `bik` varchar(40) NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`id`, `idKontr`, `kontrAccount`, `bankName`, `korrAccount`, `bik`, `address`, `city`) VALUES
(5, 13, '40702810416160009320', 'ФИЛИАЛ N 3652 ВТБ 24 (ПАО)', '30101810100000000738', '042007738', '', 'ВОРОНЕЖ'),
(7, 16, '40702810207000101146', 'БЕЛГОРОДСКОЕ ОТДЕЛЕНИЕ N8592 ПАО СБЕРБАНК', '30101810100000000633', '041403633', '', 'БЕЛГОРОД'),
(8, 17, '40702810310160004803', 'ФИЛИАЛ N 3652 ВТБ 24 (ПАО)', '30101810100000000738', '042007738', '', 'ВОРОНЕЖ'),
(9, 19, '40702810401000000207', 'БФ АО КБ "РУСНАРБАНК"', '30101810300000000802', '041403802', '', 'БЕЛГОРОД'),
(10, 20, '40702810010160009823', 'ФИЛИАЛ N 3652 ВТБ 24 (ПАО)', '30101810100000000738', '042007738', '', 'ВОРОНЕЖ');

-- --------------------------------------------------------

--
-- Структура таблицы `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `idKontr` int(11) NOT NULL,
  `dateContract` date NOT NULL,
  `numberContract` varchar(20) NOT NULL,
  `subj` varchar(255) DEFAULT NULL,
  `comments` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contracts`
--

INSERT INTO `contracts` (`id`, `idKontr`, `dateContract`, `numberContract`, `subj`, `comments`) VALUES
(6, 13, '2016-08-31', '258', 'СОУТ', ''),
(8, 16, '2016-08-30', '260', 'СОУТ', ''),
(9, 17, '2016-09-01', '259', 'СПЕЦИАЛЬНАЯ ОЦЕНКА УСЛОВИЙ ТРУДА', ''),
(10, 19, '2016-09-05', '263', 'СОУТ', ''),
(11, 20, '2016-09-05', '264', 'СОУТ', ''),
(12, 21, '2016-01-11', '001', 'СОУТ', ''),
(13, 22, '2016-01-11', '002', 'СОУТ', ''),
(14, 23, '2016-01-11', '002/1', 'СОУТ', 'выполнен'),
(15, 24, '2016-01-11', '003', 'СОУТ', 'выполнен'),
(16, 25, '2016-01-11', '278567/004', 'СОУТ', ''),
(17, 26, '2016-01-11', '005', 'СОУТ', 'выполнен'),
(18, 27, '2016-01-11', '006', 'СОУТ', 'выполнен'),
(19, 27, '2016-01-11', '007', 'СОУТ', 'выполнен'),
(20, 27, '2016-01-11', '008', 'СОУТ', 'выполнен'),
(21, 28, '2016-01-12', '010', 'СОУТ', 'выполнен'),
(22, 29, '2016-01-13', '011', 'СОУТ', 'выполнен'),
(23, 30, '2016-01-13', '012', 'СОУТ', 'выполнен'),
(24, 31, '2016-01-13', '013', '3700', 'выполнен'),
(25, 32, '2016-01-13', '014', 'СОУТ', 'выполнен'),
(26, 33, '2016-01-13', 'Д/с 8', 'ПК', 'выполнен'),
(27, 34, '2016-01-14', '014/1', 'ПК', 'выполнен'),
(28, 35, '2016-01-15', '016', 'СОУТ', 'выполнен'),
(29, 36, '2016-01-18', '017', 'СОУТ', 'выполнен'),
(30, 37, '2016-01-18', '018', 'СОУТ', ''),
(31, 38, '2016-02-24', '019', 'НТД', 'выполнен'),
(32, 39, '2016-01-20', '020', 'СОУТ', 'выполнен'),
(33, 40, '2016-01-21', '022', 'СОУТ', 'выполнен'),
(34, 41, '2016-01-21', '023', 'СОУТ', 'выполнен'),
(35, 42, '2016-01-22', '024', 'СОУТ', 'выполнен'),
(36, 43, '2016-01-25', '025', 'СОУТ', 'выполнен'),
(37, 44, '2016-01-26', '027', 'СОУТ', 'выполнен'),
(38, 45, '2016-01-20', '028', 'СОУТ', 'выполнен 09.2016'),
(39, 46, '2016-02-01', '029', 'СОУТ', 'выполнен'),
(40, 47, '2016-01-21', '024/1', 'СОУТ', 'выполнен'),
(41, 48, '2016-02-02', '030-ПК', 'ПК', 'выполнен'),
(42, 49, '2016-02-03', '031-ПК', 'ПК', ''),
(43, 50, '2016-02-03', '032-ПК', 'ПК', ''),
(44, 52, '2016-02-04', '033', 'СОУТ', 'выполнен'),
(45, 53, '2016-02-05', '034', 'СОУТ', 'выполнен'),
(46, 54, '2016-02-08', '035', 'СОУТ', 'выполнен');

-- --------------------------------------------------------

--
-- Структура таблицы `history_contracts`
--

CREATE TABLE `history_contracts` (
  `id` int(11) NOT NULL,
  `idContr` int(11) NOT NULL,
  `dateContr` datetime NOT NULL,
  `volumeJob` text NOT NULL,
  `summ` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `history_contracts`
--

INSERT INTO `history_contracts` (`id`, `idContr`, `dateContr`, `volumeJob`, `summ`) VALUES
(7, 6, '2016-08-31 10:54:54', '2', '2800'),
(9, 8, '2016-09-01 16:41:14', '20', '33000'),
(10, 9, '2016-09-02 10:18:45', '9', '14400'),
(11, 10, '2016-09-05 11:04:25', '12', '19000'),
(12, 11, '2016-09-05 14:58:30', '1', '1400'),
(13, 12, '2016-09-06 14:44:39', '5', '9600'),
(14, 13, '2016-09-06 14:48:18', '2', '3200'),
(15, 14, '2016-09-06 14:50:00', '22', '35200'),
(16, 15, '2016-09-06 14:53:20', '342', '513570'),
(17, 16, '2016-09-06 15:06:00', '1354', '1544400'),
(18, 17, '2016-09-06 15:08:40', '129', '132000'),
(19, 18, '2016-09-06 15:12:36', '124', '99000'),
(20, 19, '2016-09-06 15:13:30', '130', '99500'),
(21, 20, '2016-09-06 15:14:09', '131', '99800'),
(22, 21, '2016-09-06 15:23:05', '74', '94540'),
(23, 22, '2016-09-06 15:28:20', '8', '12800'),
(24, 23, '2016-09-06 15:34:49', '10', '16800'),
(25, 24, '2016-09-06 15:37:00', '2', ''),
(26, 25, '2016-09-06 15:40:13', '20', '33000'),
(27, 26, '2016-09-06 15:45:09', '', '3920'),
(28, 27, '2016-09-06 15:47:40', '', '10800'),
(29, 28, '2016-09-06 15:50:54', '52', '80000'),
(30, 29, '2016-09-06 15:53:33', '30', '48000'),
(31, 30, '2016-09-06 15:57:31', '1', '2500'),
(32, 31, '2016-09-06 16:00:41', '', '15000'),
(33, 32, '2016-09-06 16:14:46', '2', '3200'),
(34, 33, '2016-09-06 16:17:57', '22', '43300'),
(35, 34, '2016-09-06 16:21:04', '21', '36800'),
(36, 35, '2016-09-07 10:30:31', '6', '8400'),
(37, 36, '2016-09-07 10:34:22', '4', '6800'),
(38, 37, '2016-09-07 10:36:17', '9', '15300'),
(39, 38, '2016-09-07 10:38:56', '86', '99990'),
(40, 39, '2016-09-07 10:42:32', '28', '37000'),
(41, 40, '2016-09-07 10:45:01', '28', '41160'),
(42, 41, '2016-09-07 10:47:39', '', '15210'),
(43, 42, '2016-09-07 10:50:34', '', '180000'),
(44, 43, '2016-09-07 10:54:30', '', '76906'),
(45, 44, '2016-09-07 10:57:26', '16', '15500'),
(46, 45, '2016-09-07 11:14:05', '2', '3400'),
(47, 46, '2016-09-07 11:48:45', '21', '29000');

-- --------------------------------------------------------

--
-- Структура таблицы `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `rukovod` text,
  `fullName` text NOT NULL,
  `name` text NOT NULL,
  `name1c` varchar(255) NOT NULL,
  `inn` varchar(20) NOT NULL,
  `kpp` varchar(20) DEFAULT NULL,
  `okpo` varchar(20) DEFAULT NULL,
  `ogrn` varchar(20) DEFAULT NULL,
  `dateReg` date NOT NULL,
  `address` text NOT NULL,
  `addressfact` text,
  `saved` varchar(35) DEFAULT NULL,
  `phone` text,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `organizations`
--

INSERT INTO `organizations` (`id`, `rukovod`, `fullName`, `name`, `name1c`, `inn`, `kpp`, `okpo`, `ogrn`, `dateReg`, `address`, `addressfact`, `saved`, `phone`, `email`) VALUES
(13, 'ДИРЕКТОР ИЩЕНКО ЮРИЙ ИВАНОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЭЛИТИУМ"', 'ООО "ЭЛИТИУМ"', 'ЭЛИТИУМ ООО', '3123359652', '312301001', '', '1153123001778', '2016-09-01', '308010, Белгородская Область, Белгород Город, Урожайная Улица, ДОМ 1', '308010, Белгородская Область, Белгород Город, Урожайная Улица, ДОМ 1', NULL, '89192801082', 'ELITIUM.36@GMAIL.COM'),
(14, 'ГЛАВНЫЙ ВРАЧ КУРБАНИСМАИЛОВ ДЖАФЕР КУРБАНИСМАИЛОВИЧ', 'ОБЛАСТНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ УЧРЕЖДЕНИЕ ЗДРАВООХРАНЕНИЯ "РОВЕНЬСКАЯ ЦЕНТРАЛЬНАЯ РАЙОННАЯ БОЛЬНИЦА"', 'ОГБУЗ "РОВЕНЬСКАЯ ЦРБ"', 'РОВЕНЬСКАЯ ЦРБ ОГБУЗ', '3117000921', '311701001', '', '1023102158991', '2016-08-31', '309740, Белгородская Область, Ровеньский Район, Ровеньки Поселок, М.Горького Улица, 52', '', NULL, '', ''),
(16, 'ДИРЕКТОР ЧИГАРЕВ ГЕННАДИЙ ИВАНОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ НАУЧНО-ПРОИЗВОДСТВЕННАЯ ФИРМА "ГЕОС"', 'ООО НПФ "ГЕОС"', 'НПФ ГЕОС ООО', '3125002182', '312301001', '', '1023101644631', '2016-09-01', '308000, Белгородская Область, Белгород Город, Студенческая Улица, 4', '308000, Белгородская Область, Белгород Город, Студенческая Улица, 4', NULL, '(4722)31-21-02', 'tchigl@yandex.ru'),
(17, 'ДИРЕКТОР ПРИСТАВКА ВЛАДИМИР АЛЕКСАНДРОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ПРОЗРЕНИЕ ПЛЮС"', 'ООО "ПРОЗРЕНИЕ ПЛЮС"', 'ПРОЗРЕНИЕ ПЛЮС ООО', '3123352456', '312301001', '', '1143123016739', '2016-09-02', '308000, Белгородская Область, Белгород Город, Костюкова Улица, 36Б', '308000, Белгородская Область, Белгород Город, Костюкова Улица, 36Б', NULL, '(4722) 25-73-77, 89102205538', ''),
(18, 'ГЛАВНЫЙ ВРАЧ МИЗЕНКО ИВАН ВАСИЛЬЕВИЧ', 'ОБЛАСТНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ УЧРЕЖДЕНИЕ ЗДРАВООХРАНЕНИЯ "ВОЛОКОНОВСКАЯ ЦЕНТРАЛЬНАЯ РАЙОННАЯ БОЛЬНИЦА"', 'ОГБУЗ "ВОЛОКОНОВСКАЯ ЦРБ"', 'ВОЛОКОНОВСКАЯ ЦРБ ОГБУЗ', '3106001916', '310601001', '', '1023100738430', '2016-09-02', '309650, Белгородская Область, Волоконовский Район, Волоконовка Поселок, Курочкина Улица, 1', '309650, Белгородская Область, Волоконовский Район, Волоконовка Поселок, Курочкина Улица, 1', NULL, '89205931205', 'kiselewa.natali2011@yandex.ru'),
(19, 'ДИРЕКТОР ПРОКУДИН ИГОРЬ НИКОЛАЕВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "СТОМАТОЛОГ И Я"', 'ООО "СТОМАТОЛОГ И Я"', 'СТОМАТОЛОГ И Я ООО', '3102020611', '312301001', '', '1053100526940', '2016-09-05', '308001, Белгородская Область, Белгород Город, Белгородский Проспект, 54', '308001, Белгородская Область, Белгород Город, Белгородский Проспект, 54', NULL, '(4722) 40-60-66', 'belstom.31@mail.ru'),
(20, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР КОРОЛЕВ РОМАН МИХАЙЛОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ПИЦЦА ФЕНИКС"', 'ООО "ПИЦЦА ФЕНИКС"', 'ПИЦЦА ФЕНИКС ООО', '3123198370', '312301001', '89683380', '1093123007955', '2016-09-05', '308000, Белгородская Область, Белгород Город, Щорса Улица, ДОМ 52', '308000, Белгородская Область, Белгород Город, Щорса Улица, ДОМ 52', NULL, '', 'in-kravchenko@mail.ru, kr1980@yandex.ru'),
(21, 'ДИРЕКТОР СКЛЯРЕНКО ВИКТОР ВЛАДИМИРОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ДАЛЬ"', 'ООО "ДАЛЬ"', 'ДАЛЬ ООО', '3103005454', '310301001', '', '1123116000501', '2016-09-06', '309341, Белгородская Область, Борисовский Район, Борисовка Поселок, Новоборисовская Улица, 24', '309341, Белгородская Область, Борисовский Район, Борисовка Поселок, Новоборисовская Улица, 24', NULL, '(47246)53210', ''),
(22, 'УПРАВЛЯЮЩИЙ МАРЧЕНКО АЛЕКСАНДР ЕВГЕНЬЕВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЛУЧШЕЕ ИЗ ИНДИИ"', 'ООО "ЛУЧШЕЕ ИЗ ИНДИИ"', 'ЛУЧШЕЕ ИЗ ИНДИИ ООО', '6713012056', '671301001', '', '1126713000083', '2016-09-06', '216790, Смоленская Область, Руднянский Район, Рудня Город, Киреева Улица, 193', '216790, Смоленская Область, Руднянский Район, Рудня Город, Киреева Улица, 193', NULL, '', ''),
(23, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ВЕРПЕТА СЕРГЕЙ ВАСИЛЬЕВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЧАСТНАЯ ОХРАННАЯ ОРГАНИЗАЦИЯ "БАЯЗЕТ"', 'ООО "ЧОО "БАЯЗЕТ"', 'ЧОО БАЯЗЕТ" ООО', '3120081511', '312001001', '', '1053104000333', '2016-09-06', '309290, Белгородская Область, Шебекино Город, Октябрьская Улица, 11', '309290, Белгородская Область, Шебекино Город, Октябрьская Улица, 11', NULL, '(47248)25600', ''),
(24, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ВАЩЕНКО АЛЕКСАНДР ИВАНОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "БЕЛЭНЕРГОМАШ-БЗЭМ"', 'ООО "БЕЛЭНЕРГОМАШ-БЗЭМ"', 'БЕЛЭНЕРГОМАШ-БЗЭМ ООО', '3123315768', '312301001', '', '1133123000801', '2016-09-06', '308017, Белгородская Область, Белгород Город, Волчанская Улица, ДОМ 165', '308017, Белгородская Область, Белгород Город, Волчанская Улица, ДОМ 165', NULL, '', ''),
(25, '', 'АКЦИОНЕРНОЕ ОБЩЕСТВО "ОСКОЛЬСКИЙ ЭЛЕКТРОМЕТАЛЛУРГИЧЕСКИЙ КОМБИНАТ"', 'АО "ОЭМК"', 'ОЭМК АО', '3128005752', '312801001', '', '1023102358620', '2016-09-06', '309515, Белгородская Область, Старый Оскол Город, проспект Алексея Угарова Проспект, 218 ЗДАНИЕ 2', '309515, Белгородская Область, Старый Оскол Город, проспект Алексея Угарова Проспект, 218 ЗДАНИЕ 2', NULL, '', ''),
(26, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР СЛОВЕЦКИЙ АНТОН КАЗИМИРОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ТРАНСЮЖСТРОЙ - ПГС"', 'ООО "ТЮС - ПГС"', 'ТЮС - ПГС ООО', '3123136631', '312301001', '', '1063123135680', '2016-09-06', '308012, Белгородская Область, Белгород Город, Костюкова Улица, 36 Б', '308012, Белгородская Область, Белгород Город, Костюкова Улица, 36 Б', NULL, '(4722)583820', ''),
(27, 'ГЛАВНЫЙ ВРАЧ ДРУЖИНИН СЕРГЕЙ ВАЛЕНТИНОВИЧ', 'ОБЛАСТНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ УЧРЕЖДЕНИЕ ЗДРАВООХРАНЕНИЯ "ГОРОДСКАЯ БОЛЬНИЦА № 2 ГОРОДА СТАРОГО ОСКОЛА"', 'ОГБУЗ "ГБ № 2 Г. СТАРОГО ОСКОЛА"', 'ГБ № 2 Г. СТАРОГО ОСКОЛА ОГБУЗ', '3128020310', '312801001', '', '1023102363371', '2016-09-06', '309500, Белгородская Область, Старый Оскол Город, Ублинские горы Улица, 1А', '309500, Белгородская Область, Старый Оскол Город, Ублинские горы Улица, 1А', NULL, '', ''),
(28, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР СТАРОКОЖЕВ ВИКТОР ВЛАДИМИРОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ГАЗЭНЕРГОСЕТЬ БЕЛГОРОД"', 'ООО "ГЭС БЕЛГОРОД"', 'ГЭС БЕЛГОРОД ООО', '3123215499', '312301001', '', '1103123008042', '2016-09-06', '308017, Белгородская Область, Белгород Город, Разуменская Улица, 1', '308017, Белгородская Область, Белгород Город, Разуменская Улица, 1', NULL, '(4722)739300', ''),
(29, 'ПРЕЗИДЕНТ СУЯЗОВА ИРИНА ВИКТОРОВНА', 'БЕЛГОРОДСКАЯ ОБЛАСТНАЯ НОТАРИАЛЬНАЯ ПАЛАТА (АССОЦИАЦИЯ)', 'БНП', ' БНП', '3125018560', '312301001', '', '1023100000978', '2016-09-06', '308012, Белгородская Область, Белгород Город, Костюкова Улица, 34', '308012, Белгородская Область, Белгород Город, Костюкова Улица, 34', NULL, '(4722)555038', ''),
(30, 'ДИРЕКТОР ДОЛГОДУШ АЛЕКСАНДР ИВАНОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "БОРИСОВКАХИМИЯ"', 'ООО "БОРИСОВКАХИМИЯ"', 'БОРИСОВКАХИМИЯ ООО', '3103005165', '310301001', '', '1113116000073', '2016-09-06', '309341, Белгородская Область, Борисовский Район, Борисовка Поселок, Новоборисовская Улица, 17', '309341, Белгородская Область, Борисовский Район, Борисовка Поселок, Новоборисовская Улица, 17', NULL, '(47246)50818', ''),
(31, '', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "СВИНОКОМПЛЕКС КАЛИНОВСКИЙ"', 'ООО "СВИНОКОМПЛЕКС КАЛИНОВСКИЙ"', 'СВИНОКОМПЛЕКС КАЛИНОВСКИЙ ООО', '3115006318', '311501001', '', '1093130001854', '2016-09-06', '309026, Белгородская Область, Прохоровский Район, Холодное Село', '309026, Белгородская Область, Прохоровский Район, Холодное Село', NULL, '', ''),
(32, 'ДИРЕКТОР ФОМЕНКО АЛЕКСАНДР ПЕТРОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "МОНТАЖГРУПП31"', 'ООО "МОНТАЖГРУПП31"', 'МОНТАЖГРУПП31 ООО', '3123374636', '312301001', '', '1153123016386', '2016-09-06', '308000, Белгородская Область, Белгород Город, Щорса Улица, ДОМ 62', '308000, Белгородская Область, Белгород Город, Щорса Улица, ДОМ 62', NULL, '', ''),
(33, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР КЛАДОВ АЛЕКСАНДР АЛЕКСАНДРОВИЧ', 'ЗАКРЫТОЕ АКЦИОНЕРНОЕ ОБЩЕСТВО "ПРИОСКОЛЬЕ"', 'ЗАО "ПРИОСКОЛЬЕ"', 'ПРИОСКОЛЬЕ ЗАО', '3123100360', '311401001', '', '1033107033882', '2016-09-06', '309614, Белгородская Область, Новооскольский Район, Холки Станция', '309614, Белгородская Область, Новооскольский Район, Холки Станция', NULL, '', ''),
(34, 'ДИРЕКТОР ГОНТАРЕВА НАТАЛЬЯ ВАСИЛЬЕВНА', 'ОТКРЫТОЕ АКЦИОНЕРНОЕ ОБЩЕСТВО "ЗИНАИДИНСКОЕ ХЛЕБОПРИЕМНОЕ ПРЕДПРИЯТИЕ"', 'ОАО "ЗИНАИДИНСКОЕ ХПП"', 'ЗИНАИДИНСКОЕ ХПП ОАО', '3116000580', '311601001', '', '1033103500011', '2016-09-06', '309310, Белгородская Область, Ракитянский Район, Ракитное Поселок, Гагарина Улица, 7 "А"', '309310, Белгородская Область, Ракитянский Район, Ракитное Поселок, Гагарина Улица, 7 "А"', NULL, '', ''),
(35, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР БЕРЕСТОВОЙ ДМИТРИЙ ВИКТОРОВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ОХОТНИЧИЙ КОМПЛЕКС "БЕЛОРЕЧЬЕ"', 'ООО "ОК "БЕЛОРЕЧЬЕ"', 'ОК БЕЛОРЕЧЬЕ" ООО', '3120012740', '311001001', '', '1043104000840', '2016-09-06', '309206, Белгородская Область, Корочанский Район, Алексеевка Село, Мирошникова Улица, 1Д', '309206, Белгородская Область, Корочанский Район, Алексеевка Село, Мирошникова Улица, 1Д', NULL, '(47231)35219', ''),
(36, 'ДИРЕКТОР МЯЧИКОВ АЛЕКСАНДР ВИТАЛЬЕВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "СОКОЛ"', 'ООО "СОКОЛ"', 'СОКОЛ ООО', '3123138188', '312301001', '', '1063123138781', '2016-09-06', '308010, Белгородская Область, Белгород Город, Б.Хмельницкого Проспект, 137', '308010, Белгородская Область, Белгород Город, Б.Хмельницкого Проспект, 137', NULL, '', ''),
(37, 'Индивидуальный предприниматель МИРОНЕНКО ВИКТОР ЮРЬЕВИЧ', 'ИП МИРОНЕНКО ВИКТОР ЮРЬЕВИЧ', 'ИП МИРОНЕНКО В.Ю.', 'МИРОНЕНКО В.Ю. ИП', '312200088635', '', '', '304312219700060', '2016-09-06', '', 'Белгородская область, г. Алексеевка, с.Ильинка, ул. Ленина 9/1', NULL, '89194345272', ''),
(38, 'ДИРЕКТОР РЖЕВСКИЙ ВЛАДИМИР ИВАНОВИЧ', 'МУНИЦИПАЛЬНОЕ ОБЩЕОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ БЕЛОЗОРОВСКАЯ ОСНОВНАЯ ОБЩЕОБРАЗОВАТЕЛЬНАЯ ШКОЛА АЛЕКСЕЕВСКОГО РАЙОНА БЕЛГОРОДСКОЙ ОБЛАСТИ', 'МОУ БЕЛОЗОРОВСКАЯ ООШ', 'БЕЛОЗОРОВСКАЯ ООШ МОУ', '3122008235', '312201001', '', '1033106501944', '2016-09-06', '309807, Белгородская Область, Алексеевский Район, Ковалево Село, Центральная Улица, 66', '309807, Белгородская Область, Алексеевский Район, Ковалево Село, Центральная Улица, 66', NULL, '', ''),
(39, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ЯГОДИНА СВЕТЛАНА ВЛАДИМИРОВНА', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЮРИДИЧЕСКАЯ ФИРМА "БЕЛЮРИКОН"', 'ООО "ЮРИДИЧЕСКАЯ ФИРМА "БЕЛЮРИКОН"', 'ЮРИДИЧЕСКАЯ ФИРМА БЕЛЮРИКОН" ООО', '3123195066', '312301001', '', '1093123003940', '2016-09-06', '308000, Белгородская Область, Белгород Город, Князя Трубецкого Улица, 60 А', '308000, Белгородская Область, Белгород Город, Князя Трубецкого Улица, 60 А', NULL, '(4722)334397', ''),
(40, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР БОГДАНОВА ЛЮБОВЬ НИКОЛАЕВНА', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "АЛЬЯНС"', 'ООО "АЛЬЯНС"', 'АЛЬЯНС ООО', '6730067016', '673001001', '', '1066731116858', '2016-09-06', '214000, Смоленская Область, Смоленск Город, Октябрьской Революции Улица, 9', '214000, Смоленская Область, Смоленск Город, Октябрьской Революции Улица, 9', NULL, '(4812)700100', ''),
(41, 'ДИРЕКТОР КИРЕЕВА ЕЛЕНА ОЛЕГОВНА', 'ЧАСТНОЕ ДОШКОЛЬНОЕ ОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ "ИЗЮМИНКА"', 'ЧДОУ "ИЗЮМИНКА"', 'ИЗЮМИНКА ЧДОУ', '3123231229', '312301001', '', '1113100001178', '2016-09-06', '308036, Белгородская Область, Белгород Город, Славянская Улица, 9 "Б"', '308036, Белгородская Область, Белгород Город, Славянская Улица, 9 "Б"', NULL, '(4722)424089', ''),
(42, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ЗАГОРУЙКО ВАЛЕРИЙ НИКОЛАЕВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ПРОИЗВОДСТВЕННОЕ ОБЪЕДИНЕНИЕ БЕЛЭЛЕКТРОМАШИНА"', 'ООО "ПО БЕЛЭЛЕКТРОМАШИНА"', 'ПО БЕЛЭЛЕКТРОМАШИНА ООО', '3123378020', '312301001', '', '1153123019884', '2016-09-07', '308017, Белгородская Область, Белгород Город, Константина Заслонова Улица, ДОМ  88', '308017, Белгородская Область, Белгород Город, Константина Заслонова Улица, ДОМ  88', NULL, '', ''),
(43, 'Индивидуальный предприниматель ГАРКОВЕНКО СЕРГЕЙ АЛЕКСЕЕВИЧ', 'ИП ГАРКОВЕНКО СЕРГЕЙ АЛЕКСЕЕВИЧ', 'ИП ГАРКОВЕНКО С.А.', 'ГАРКОВЕНКО С.А. ИП', '312300524846', '', '', '304312307800238', '2016-09-07', '', 'г. Белгород, б-р Юности 23/30', NULL, '', ''),
(44, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР БАРАННИКОВ ВЛАДИМИР ДМИТРИЕВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "КОНТРОЛЬ-БЕЛОГОРЬЕ"', 'ООО "КОНТРОЛЬ-БЕЛОГОРЬЕ"', 'КОНТРОЛЬ-БЕЛОГОРЬЕ ООО', '3123202242', '312301001', '', '1093123013224', '2016-09-07', '308019, Белгородская Область, Белгород Город, Ворошилова Улица, 2-Б', '308019, Белгородская Область, Белгород Город, Ворошилова Улица, 2-Б', NULL, '', ''),
(45, 'РУКОВОДИТЕЛЬ ПУШКАРСКАЯ ИРИНА ЕВГЕНЬЕВНА', 'ФЕДЕРАЛЬНОЕ КАЗЕННОЕ УЧРЕЖДЕНИЕ "ГЛАВНОЕ БЮРО МЕДИКО-СОЦИАЛЬНОЙ ЭКСПЕРТИЗЫ ПО БЕЛГОРОДСКОЙ ОБЛАСТИ" МИНИСТЕРСТВА ТРУДА И СОЦИАЛЬНОЙ ЗАЩИТЫ РОССИЙСКОЙ ФЕДЕРАЦИИ', 'ФКУ "ГБ МСЭ ПО БЕЛГОРОДСКОЙ ОБЛАСТИ" МИНТРУДА РОССИИ."', 'ГБ МСЭ ПО БЕЛГОРОДСКОЙ ОБЛАСТИ МИНТРУДА РОССИИ." ФКУ', '3123113850', '312301001', '', '1043107048160', '2016-09-07', '308006, Белгородская Область, Белгород Город, Корочанская Улица, 48', '308006, Белгородская Область, Белгород Город, Корочанская Улица, 48', NULL, '', ''),
(46, 'ДИРЕКТОР МАУ "МФЦ Г. БЕЛГОРОДА" ЧЕПЕЛЕВА ТАТЬЯНА ДМИТРИЕВНА', 'МУНИЦИПАЛЬНОЕ АВТОНОМНОЕ УЧРЕЖДЕНИЕ "МНОГОФУНКЦИОНАЛЬНЫЙ ЦЕНТР ПРЕДОСТАВЛЕНИЯ ГОСУДАРСТВЕННЫХ И МУНИЦИПАЛЬНЫХ УСЛУГ ГОРОДА БЕЛГОРОДА"', 'МАУ "МФЦ Г.БЕЛГОРОДА"', 'МФЦ Г.БЕЛГОРОДА МАУ', '3123349069', '312301001', '', '1143123013340', '2016-09-07', '308036, Белгородская Область, Белгород Город, Есенина Улица, ДОМ 9 КОРПУС 4', '308036, Белгородская Область, Белгород Город, Есенина Улица, ДОМ 9 КОРПУС 4', NULL, '', ''),
(47, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ВОЛКОВ МИХАИЛ ЮРЬЕВИЧ', 'СТРАХОВОЕ ПУБЛИЧНОЕ АКЦИОНЕРНОЕ ОБЩЕСТВО "ИНГОССТРАХ"', 'СПАО "ИНГОССТРАХ"', 'ИНГОССТРАХ СПАО', '7705042179', '775001001', '', '1027739362474', '2016-09-07', '117997, Москва Город, Пятницкая Улица, 12 СТР.2', '117997, Москва Город, Пятницкая Улица, 12 СТР.2', NULL, '(4722)265955', ''),
(48, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ГАЛИЦКИЙ СЕРГЕЙ АНАТОЛЬЕВИЧ', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "БЕЛГОРОДСКИЕ ГРАНУЛИРОВАННЫЕ КОРМА"', 'ООО "БЕЛГРАНКОРМ"', 'БЕЛГРАНКОРМ ООО', '3116003662', '311601001', '', '1023101180321', '2016-09-07', '309300, Белгородская Область, Ракитянский Район, Пролетарский Поселок, Борисовское Шоссе, 1', '309300, Белгородская Область, Ракитянский Район, Пролетарский Поселок, Борисовское Шоссе, 1', NULL, '', ''),
(49, 'ДИРЕКТОР БУДНИК ВАСИЛИЙ ФИЛИППОВИЧ', 'АКЦИОНЕРНОЕ ОБЩЕСТВО "МЕЛСТРОМ"', 'АО "МЕЛСТРОМ"', 'МЕЛСТРОМ АО', '3102002179', '310201001', '', '1023100508342', '2016-09-07', '308571, Белгородская Область, Белгородский Район, Петропавловка Село, Заводская Улица, 1 А', '308571, Белгородская Область, Белгородский Район, Петропавловка Село, Заводская Улица, 1 А', NULL, '', ''),
(50, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР БАШКАТОВ ВЛАДИМИР ВАСИЛЬЕВИЧ', 'АКЦИОНЕРНОЕ ОБЩЕСТВО "БЕЛГОРОДСКИЙ ЗАВОД ГОРНОГО МАШИНОСТРОЕНИЯ"', 'АО "ГОРМАШ"', 'ГОРМАШ АО', '3124013819', '312301001', '', '1023101645522', '2016-09-07', '308000, Белгородская Область, Белгород Город, Сумская Улица, 72', '308000, Белгородская Область, Белгород Город, Сумская Улица, 72', NULL, '', ''),
(51, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ТИТОВСКИЙ СЕРГЕЙ АЛЕКСАНДРОВИЧ', 'ОТКРЫТОЕ АКЦИОНЕРНОЕ ОБЩЕСТВО "ПРИОСКОЛЬЕ-АГРО СЕМЕНА"', 'ОАО "ПРИОСКОЛЬЕ-АГРО СЕМЕНА"', 'ПРИОСКОЛЬЕ-АГРО СЕМЕНА ОАО', '3113001603', '311301001', '', '1083116000472', '2016-09-07', '309420, Белгородская Область, Краснояружский Район, Красная Яруга Поселок, Центральная Улица, 75', '309420, Белгородская Область, Краснояружский Район, Красная Яруга Поселок, Центральная Улица, 75', NULL, '', ''),
(52, 'ГЕНЕРАЛЬНЫЙ ДИРЕКТОР ТИТОВСКИЙ СЕРГЕЙ АЛЕКСАНДРОВИЧ', 'ОТКРЫТОЕ АКЦИОНЕРНОЕ ОБЩЕСТВО "ПРИОСКОЛЬЕ-АГРО СЕМЕНА"', 'ОАО "ПРИОСКОЛЬЕ-АГРО СЕМЕНА"', 'ПРИОСКОЛЬЕ-АГРО СЕМЕНА ОАО', '3113001603', '311301001', '', '1083116000472', '2016-09-07', '309420, Белгородская Область, Краснояружский Район, Красная Яруга Поселок, Центральная Улица, 75', '309420, Белгородская Область, Краснояружский Район, Красная Яруга Поселок, Центральная Улица, 75', NULL, '', ''),
(53, 'Индивидуальный предприниматель АНАЦКИЙ АЛЕКСАНДР ВЛАДИМИРОВИЧ', 'ИП АНАЦКИЙ АЛЕКСАНДР ВЛАДИМИРОВИЧ', 'ИП АНАЦКИЙ А.В.', 'АНАЦКИЙ А.В. ИП', '312332651847', '', '', '314313025900034', '2016-09-07', '', 'г. Строитель, ул. Жукова 5/93', NULL, '', ''),
(54, 'ДИРЕКТОР АЛЕКСАНДРОВА ОЛЬГА ЛЕОНИДОВНА', 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЛИДЕР СТРОЙ ПЛЮС"', 'ООО "ЛИДЕР СТРОЙ ПЛЮС"', 'ЛИДЕР СТРОЙ ПЛЮС ООО', '3123349774', '312301001', '', '1143123014055', '2016-09-07', '308023, Белгородская Область, Белгород Город, Промышленный Проезд, 5', '308023, Белгородская Область, Белгород Город, Промышленный Проезд, 5', NULL, '(4722)316097', '');

-- --------------------------------------------------------

--
-- Структура таблицы `payments_contracts`
--

CREATE TABLE `payments_contracts` (
  `id` int(11) NOT NULL,
  `idContr` int(11) NOT NULL,
  `datePayment` date NOT NULL,
  `summ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payments_contracts`
--

INSERT INTO `payments_contracts` (`id`, `idContr`, `datePayment`, `summ`) VALUES
(1, 12, '2016-01-28', 9600),
(2, 15, '2016-06-22', 513570),
(3, 14, '2016-05-18', 17600),
(4, 14, '2016-06-14', 17600),
(5, 16, '2016-04-05', 340800),
(6, 16, '2016-07-04', 460800),
(7, 17, '2016-01-21', 66000),
(8, 17, '2016-03-16', 66000),
(9, 18, '2016-03-02', 99000),
(10, 19, '2016-03-03', 99500),
(11, 20, '2016-03-11', 99800),
(12, 21, '2016-01-29', 47270),
(13, 21, '2016-03-11', 47270),
(14, 22, '2016-02-04', 12800),
(15, 23, '2016-01-29', 16800),
(16, 24, '2016-02-04', 3700),
(17, 25, '2016-02-01', 33000),
(18, 26, '2016-01-15', 3920),
(19, 27, '2016-02-16', 10800),
(20, 28, '2016-02-03', 20000),
(21, 28, '2016-04-11', 20000),
(22, 28, '2016-06-09', 40000),
(23, 29, '2016-01-29', 24000),
(24, 29, '2016-09-01', 24000),
(25, 30, '2016-01-18', 2500),
(26, 31, '2016-03-10', 15000),
(27, 32, '2016-01-29', 3200),
(28, 33, '2016-02-02', 15155),
(29, 33, '2016-03-01', 15155),
(30, 33, '2016-03-30', 12990),
(31, 34, '2016-02-02', 16800),
(32, 34, '2016-09-02', 20000),
(33, 35, '2016-02-12', 8400),
(34, 36, '2016-01-29', 6800),
(35, 37, '2016-02-03', 15300),
(36, 38, '2016-01-28', 99990),
(37, 39, '2016-04-06', 37000),
(38, 40, '2016-02-19', 41160),
(39, 41, '2016-02-11', 15210),
(40, 41, '2016-02-11', 15210),
(41, 42, '2016-03-11', 45000),
(42, 42, '2016-07-14', 45000),
(43, 43, '2016-04-06', 38453),
(44, 44, '2016-02-19', 15500),
(45, 44, '2016-02-19', 15500),
(46, 44, '2016-02-19', 15500),
(47, 45, '2016-02-16', 3400),
(48, 46, '2016-02-18', 29000);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `authKey` varchar(32) NOT NULL,
  `accessToken` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `authKey`, `accessToken`) VALUES
(1, 'expert', '2954d7eb52fa433ed9f060be50bdc926', '', '2954d7eb52fa', '2954d7eb52fa4');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `history_contracts`
--
ALTER TABLE `history_contracts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payments_contracts`
--
ALTER TABLE `payments_contracts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT для таблицы `history_contracts`
--
ALTER TABLE `history_contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT для таблицы `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT для таблицы `payments_contracts`
--
ALTER TABLE `payments_contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
