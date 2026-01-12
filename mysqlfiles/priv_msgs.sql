CREATE TABLE ibb_priv_msgs (
  pid int(11) NOT NULL auto_increment,
  mid varchar(50) NOT NULL default '',
  messege blob NOT NULL,
  subject varchar(50) NOT NULL default '',
  time varchar(50) NOT NULL default '',
  date varchar(50) NOT NULL default '',
  status char(3) NOT NULL default 'no',
  pmimage varchar(50) NOT NULL default '',
  fmid varchar(50) NOT NULL default '',
  PRIMARY KEY  (pid),
  UNIQUE KEY pid (pid),
  KEY pid_2 (pid)
) TYPE=MyISAM