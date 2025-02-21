CREATE TABLE `app_project_assets` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `app_project_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `asset_id` (`asset_id`);

ALTER TABLE `app_project_assets` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `app_events` ADD `client_id` INT(11) NOT NULL DEFAULT '0' AFTER `id`; 
ALTER TABLE `app_events` ADD INDEX(`client_id`);
ALTER TABLE `app_events` ADD `reminder_id` INT(11) NOT NULL DEFAULT '0' AFTER `client_id`; 
ALTER TABLE `app_events` ADD INDEX(`reminder_id`);
ALTER TABLE `app_reminders` ADD `notify_client` INT(1) NOT NULL DEFAULT '0' AFTER `client_id`;

INSERT INTO `core_email_templates` (`id`, `name`, `subject`, `body`, `info`, `created_at`, `updated_at`) VALUES (NULL, 'Client | Reminder alert', 'Reminder: {reminder}', '<p>Hi {name}</p>\r\n<p> </p>\r\n<p>The following reminder has been triggered:</p>\r\n<p><strong>{reminder}</strong></p>', '', '2022-11-09 15:48:07.000000', '2022-11-09 15:48:07.000000');
UPDATE `core_settings` SET `value` = '2' WHERE `core_settings`.`name` = 'db_level'; 