CREATE TABLE ibb_bannedip (
  IP varchar(50) NOT NULL default '',
  time varchar(50) NOT NULL default '',
  bid int(11) NOT NULL auto_increment,
  PRIMARY KEY  (bid),
  UNIQUE KEY bid (bid)
) TYPE=MyISAM