-- ----------------------------------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.28-log - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              10.3.0.5771
-- ---------------------------------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных tasklist
DROP DATABASE IF EXISTS `tasklist`;
CREATE DATABASE IF NOT EXISTS `tasklist` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tasklist`;


-- Дамп структуры для таблица tasklist.client
CREATE TABLE IF NOT EXISTS `client` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `name_f` varchar(255) NOT NULL COMMENT 'Имя',
  `name_l` varchar(255) NOT NULL COMMENT 'Фамилия',
  `phone` varchar(255) NOT NULL COMMENT 'Телефон',
  `email` varchar(255) NOT NULL COMMENT 'E-Mail',
  `active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Признак активности',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы tasklist.client: ~14 rows (приблизительно)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `name_f`, `name_l`, `phone`, `email`, `active`) VALUES
    (1, 'Владимир', 'Дороховский', '+7-888-777-55-66', 'dv@wax.com', 0),
    (2, 'Александр', 'Парфёнов', '+7-987-654-32-01', 'alexandr.parfenov@supermail.com', 1),
    (3, 'Алексей', 'Щукин', '+7-930-568-71-93', 'superman@yandex.ru', 1),
    (4, 'Павел', 'Митрофанов', '+7-871-325-55-14', 'maxogen@gmail.org', 1),
    (5, 'Владислав', 'Петров', '+7-124-624-89-44', 'petrov.v@globs.ru', 1),
    (6, 'Алексей', 'Кузовков', '+7-635-114-85-04', 'A.Kuzovkov@ellipse.net', 1),
    (7, 'Глеб', 'Самойлов', '+7-458-657-21-65', 'glessam@mail.net', 1),
    (8, 'Лилия', 'Аромаватая', '+7-975-115-09-09', 'aromalil@kx-box.net', 1),
    (9, 'Анастасия', 'Крыльникова', '+7-911-199-90-25', 'dark-lady@new-server.ru', 1),
    (10, 'Максим', 'Поднебеснов', '+7-894-465-15-97', 'skymax@armada.ru', 1),
    (11, 'Наталия', 'Хлопышева', '+7-549-284-22-48', 'xlop-natalie@supreme.ru', 1),
    (12, 'Игорь', 'Ивановников', '+7-745-234-46-87', 'superigor@tradeout.ru', 1),
    (13, 'Андрей', 'Скороход', '+7-926-954-12-24', 'AndreySkorokhod@sssr.ru', 1),
    (14, 'Александр', 'Каретный', '+7-965-547-81-55', 'primus@default.org', 1),
    (15, 'Владимир', 'Климентов', '+7-951-215-45-58', 'all-maz@pochty.net', 1);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;


-- Дамп структуры для таблица tasklist.task_list
CREATE TABLE IF NOT EXISTS `task_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(80) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `body` longtext,
  `status` varchar(32) DEFAULT NULL,
  `complete` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы tasklist.task_list: ~19 rows (приблизительно)
/*!40000 ALTER TABLE `task_list` DISABLE KEYS */;
INSERT INTO `task_list` (`id`, `user_name`, `email`, `body`, `status`, `complete`, `deleted`) VALUES
    (1, 'Маслов Александр', 'amaslov@server.net', 'Пойди туда, не знаю куда\nПринеси то, не знаю что', 'отредактировано администратором', 0, 1),
    (2, 'Орлов Венеамин', 'vorlov@server.net', 'Выполнить задачу!', 'отредактировано администратором', 0, 1),
    (3, 'Перепёлкин Константин', 'casper@server.net', 'Выполнять!', NULL, 0, 1),
    (4, 'Бакланов Игорь', 'billion@yubyte.net', 'Комбинация вариантов', NULL, 0, 1),
    (5, 'Тостеровский Павел', 'KONUS1@pluck.net', 'Тестовое задание\n&lt;script&gt;alert(\'ХУЙ\');&lt;/script&gt;', NULL, 0, 1),
    (6, 'Петровский Семён', 'dropperty@mail.ru', 'ХУЯКСЕЛЬ', NULL, 0, 1),
    (7, 'Няшечкин Иван', 'hoserty@packer.org', 'Приоритет\nВторой', NULL, 0, 1),
    (8, 'Максимов Павел', 'pamax@server.org', 'Главная задача\nНаивысший приоритет\nСкоро будет!!!', NULL, 0, 1),
    (9, 'Камиров Богдан', 'bcamirov@xcerwa.cm', 'bodyup\nКоромысло\nsdgfb dxfbh 12', NULL, 0, 1),
    (10, 'Кривоносов Александр', 'alekriv@test.net', 'Задача:', NULL, 0, 1),
    (11, 'Орехов Михаил', 'morex@test.com', 'Test Job Special', 'отредактировано администратором', 1, 1),
    (12, 'Иванов Максим', 'test@test.com', 'Test Job 21', 'отредактировано администратором', 0, 1),
    (13, 'Абакумов Владимир', 'vlabakum@server.net', 'Test Job 1111', 'отредактировано администратором', 1, 1),
    (14, 'Перевёртышев Афанасий', 'aperev@testserver.net', 'TEST JOB 1112', NULL, 0, 1),
    (15, 'Кривотулов Константин', 'kkk2010@googel.net', 'Test job 01', NULL, 0, 1),
    (16, 'Кривотулов Константин', 'kkk2010@googel.net', 'Test Job 0001', NULL, 0, 0),
    (17, 'test 02', 'test@test.com', 'test job 0002', NULL, 0, 0),
    (18, 'test 03', 'test03@test.com', 'Test Job 03', NULL, 0, 0),
    (19, 'test 04', 'test04@test.com', 'Test Job 04', NULL, 0, 0);
/*!40000 ALTER TABLE `task_list` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
