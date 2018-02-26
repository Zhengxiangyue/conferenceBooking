CREATE TABLE `mrbs`.`mrbs_config` ( `id` INT NOT NULL AUTO_INCREMENT , `key` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `value` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `mrbs_config` CHANGE `key` `configKey` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
INSERT INTO `mrbs`.`mrbs_config` (`id`, `configKey`, `value`) VALUES (NULL, 'needList', 'a:2:{i:0;s:9:"投影仪";i:1;s:9:"激光笔";}');

