/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных users
DROP DATABASE IF EXISTS `users`;
CREATE DATABASE IF NOT EXISTS `users` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `users`;

-- Дамп структуры для таблица users.client
DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `name_f` varchar(255) NOT NULL COMMENT 'Имя',
  `name_l` varchar(255) NOT NULL COMMENT 'Фамилия',
  `phone` varchar(255) NOT NULL COMMENT 'Телефон',
  `email` varchar(255) NOT NULL COMMENT 'E-Mail',
  `active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Признак активности',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы users.client: ~12 rows (приблизительно)
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
    (14, 'Александр', 'Каретный', '+7-965-547-81-55', 'primus@default.org', 1);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
