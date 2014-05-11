CREATE TABLE IF NOT EXISTS `ride` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`comment` text NOT NULL,
`track` text CHARACTER SET latin1 NOT NULL,
`length` double NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`username` varchar(25) CHARACTER SET latin1 NOT NULL,
`email` varchar(25) CHARACTER SET latin1 NOT NULL,
`password` varchar(50) CHARACTER SET latin1 NOT NULL,
`ip` varchar(25) CHARACTER SET latin1 NOT NULL,
`lastvisit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`default_lat` float(10,6) NOT NULL,
`default_lng` float(10,6) NOT NULL,
`default_zoom` int(11) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `username` (`username`),
UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
