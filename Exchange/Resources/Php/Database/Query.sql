DROP DATABASE IF EXISTS `database`;

CREATE DATABASE `database`;
USE `database`;

CREATE TABLE `users` (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(25),
    password varchar(255),
    exchange VARCHAR(15),
    apiKey VARCHAR (128),
    apiSecret VARCHAR(128)
);

INSERT INTO users (`username`, `password`, `exchange`, `apiKey`, `apiSecret`) values ('admin', 'admin', 'binance', '', '');