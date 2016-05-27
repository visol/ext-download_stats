#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	downloads int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_downloadstats_domain_model_download'
#
CREATE TABLE tx_downloadstats_domain_model_download (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	fe_user int(11) unsigned DEFAULT '0' NOT NULL,
	file int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);