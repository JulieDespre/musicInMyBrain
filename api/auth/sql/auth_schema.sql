SET NAMES utf8;
SET
time_zone = '+00:00';
SET
foreign_key_checks = 0;
SET
sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `id`                               INT AUTO_INCREMENT PRIMARY KEY,
    `email`                            varchar(128) NOT NULL,
    `password`                         varchar(256) NOT NULL,
    `active`                           tinyint(4) NOT NULL DEFAULT 0,
    `activation_token`                 varchar(64) DEFAULT NULL,
    `activation_token_expiration_date` timestamp NULL DEFAULT NULL,
    `refresh_token`                    varchar(64) DEFAULT NULL,
    `refresh_token_expiration_date`    timestamp NULL DEFAULT NULL,
    `username`                         varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2023-10-03 13:52:01
