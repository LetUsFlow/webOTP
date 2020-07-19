DROP DATABASE IF EXISTS `webotp`;
CREATE DATABASE `webotp`
    DEFAULT CHAR SET utf8
    COLLATE utf8_general_ci;
USE `webotp`;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    username     VARCHAR(32) NOT NULL PRIMARY KEY,
    passwordhash TEXT        NOT NULL,
    passwordsalt TEXT        NOT NULL
);

DROP TABLE IF EXISTS `keys`;
CREATE TABLE IF NOT EXISTS `keys`
(
    totpId   INTEGER      NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(32)  NOT NULL,
    secret   VARCHAR(512) NOT NULL,
    issuer   TEXT         NOT NULL,
    FOREIGN KEY fk_keys_user (username) REFERENCES `users` (username)
);

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session`
(
    sessiontoken   VARCHAR(256) NOT NULL PRIMARY KEY,
    username       VARCHAR(32)  NOT NULL,
    lastupdatetime TIMESTAMP    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    useragent      TEXT         NOT NULL,
    FOREIGN KEY fk_session_user (username) REFERENCES `users` (username)
);
