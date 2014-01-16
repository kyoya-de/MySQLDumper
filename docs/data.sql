INSERT INTO `User` (`id`, `username`, `password`, `salt`, `active`, `email`, `current_connection`) VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 1, '', NULL);
INSERT INTO `Role` (`id`, `name`, `role`) VALUES (1, 'Administrators', 'ROLE_ADMIN');
INSERT INTO `Role` (`id`, `name`, `role`) VALUES (2, 'Users', 'ROLE_USER');
INSERT INTO `user_role` (`user_id`, `role_id`) VALUES (1, 1);
