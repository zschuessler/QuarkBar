<?php

$installer = $this;
$installer->startSetup();

// DELETE FROM core_resource WHERE code = 'quarkbar_setup';

/**
 * Create quarkbar_session to store admin sessions 
 */
$installer->run("
CREATE TABLE IF NOT EXISTS `quarkbar_session` (
  `quarkbar_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `quarkbar_user` varchar(255) NOT NULL,
  `quarkbar_salt` varchar(255) NOT NULL,
  PRIMARY KEY (`quarkbar_session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
");


$installer->endSetup();