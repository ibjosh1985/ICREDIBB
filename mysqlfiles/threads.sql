CREATE TABLE ibb_threads (
  tid int(11) NOT NULL auto_increment,
  name varchar(100) default NULL,
  fid varchar(100) default NULL,
  cid varchar(100) default NULL,
  description blob,
  date varchar(50) default NULL,
  email varchar(50) default NULL,
  image varchar(50) default NULL,
  subject varchar(50) default NULL,
  time varchar(100) default NULL,
  pin char(3) default 'no',
  views varchar(100) default NULL,
  locktopic char(3) default 'no',
  timeline varchar(100) default NULL,
  lpid int(15) NOT NULL default '0',
  PRIMARY KEY  (tid)
) TYPE=MyISAM