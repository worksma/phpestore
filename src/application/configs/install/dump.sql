SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `apps__vk` (
  `id` int(9) NOT NULL,
  `app_id` int(9) NOT NULL,
  `app_secret` varchar(128) NOT NULL,
  `app_service` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `apps__vk` (`id`, `app_id`, `app_secret`, `app_service`) VALUES
(1, '', '', '');

CREATE TABLE `configs` (
  `id` int(9) NOT NULL,
  `template` varchar(32) NOT NULL DEFAULT 'standart',
  `cache` int(9) NOT NULL DEFAULT '1',
  `title` varchar(64) NOT NULL DEFAULT 'PHP eStore',
  `description` varchar(256) NOT NULL DEFAULT 'Здесь вы можете купить готовый сайт для заработка или других целей. Магазин скриптов PHP eStore предоставляет огромный выбор качественных сайтов.',
  `keywords` varchar(1024) NOT NULL DEFAULT 'создание сайта, создать сайт самому, скрипт, скачать скрипты бесплатно, скачать скрипты, скрипты для сайта, скрипты сайтов, движки сайтов, Интернет-магазин, skript, opcash, денежные кейсы, кейсы с деньгами, скрипты буксов, буксы, Хайпы, экономический игры, азартные игры, скрипт интернет магазина, магазин аккаунтов, скрипты рулеток, cosmocard, jetcash, spinmoney, bangcash, armycash, luxacesh, cash, рулетки cs:go, скрипт cs:go рулетки, заработок в сети, заработок в интернете, софт для веб-мастера, взлом рулетки с денежными кейсы, взлом opcash, создание сайта под заказ, создать сайт, заказать сайт, купить сайт, купить opcash, как установить сайт, установка скрипты, как установить скрипт, Купить рулетку, скрипт кейсов, купить web скрипт, купить сайт, рулетка варфейс, рулетка warface, заказать рулетку, купить недорого web скрипт, купить nvuti, скрипт nvuti,купить веб скрипт,магазин скриптов, купить скрипт рулетки,магазин скриптов рулеток,купить рулетку сайт, nvuti',
  `version` varchar(12) NOT NULL DEFAULT '1.4',
  `date` varchar(64) NOT NULL DEFAULT '2022-02-09 02:24:25'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `configs` (`id`, `template`, `cache`, `title`, `description`, `keywords`, `version`, `date`) VALUES
(1, :template, 1, :title, :description, :keywords, '1.4', '2022-02-09 02:24:25');

CREATE TABLE `configs__kassa` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code_name` varchar(64) NOT NULL,
  `password1` varchar(256) NOT NULL DEFAULT 'none',
  `password2` varchar(128) NOT NULL DEFAULT 'none',
  `password3` varchar(128) NOT NULL DEFAULT 'none',
  `enable` int(11) NOT NULL DEFAULT '0',
  `date` varchar(64) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `configs__kassa` (`id`, `name`, `code_name`, `password1`, `password2`, `password3`, `enable`, `date`) VALUES
(1, 'Qiwi Wallet', 'qiwi', '', 'none', 'none', 0, '2021-12-15 18:46:00'),
(2, 'FreeKassa', 'freekassa', '', '', '', 0, '2022-02-05 18:46:00');

CREATE TABLE `logs__pays` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(64) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product` (
  `id` int(9) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `price` int(9) NOT NULL,
  `image` varchar(256) NOT NULL,
  `file` varchar(256) NOT NULL,
  `category` int(9) NOT NULL DEFAULT '0',
  `date` varchar(64) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product__category` (
	`id` int NOT NULL AUTO_INCREMENT,
	`oid` int NOT NULL,
	`name` varchar(32) NOT NULL,
	`position` int NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product__optgroup` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(32) NOT NULL,
	`position` int NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product__images` (
  `id` int(9) NOT NULL,
  `id_product` int(9) NOT NULL,
  `file` varchar(256) NOT NULL,
  `date` varchar(64) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product__links` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_product` int(9) NOT NULL,
  `hash` varchar(256) NOT NULL,
  `date` varchar(64) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product__purchases` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `id_product` int(9) NOT NULL,
  `price` int(9) NOT NULL,
  `date` varchar(64) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reviews` (
  `id` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(64) DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `login` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(64) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `id_group` int(9) NOT NULL DEFAULT '1',
  `ava` varchar(256) NOT NULL,
  `balance` int(9) NOT NULL DEFAULT '0',
  `hash` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users__groups` (
  `id` int(9) NOT NULL,
  `name` varchar(64) NOT NULL,
  `access` varchar(32) NOT NULL DEFAULT 'z'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users__groups` (`id`, `name`, `access`) VALUES
(1, 'Клиент', 'z'),
(2, 'Директор', 'abcdefghijklmnopqrstuvwxyz');

CREATE TABLE `users__purse` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `message` text NOT NULL,
  `system` varchar(64) NOT NULL,
  `date` varchar(64) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `apps__vk`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `configs__kassa`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `logs__pays`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product__images`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product__links`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `product__purchases`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users__groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users__purse`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `apps__vk`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `configs`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `configs__kassa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `logs__pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product__images`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product__links`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `product__purchases`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reviews`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users__groups`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users__purse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;