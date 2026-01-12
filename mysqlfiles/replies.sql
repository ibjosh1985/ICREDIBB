CREATE TABLE ibb_replies (
  rid int(11) NOT NULL auto_increment,
  tid varchar(100) default NULL,
  cid varchar(100) default NULL,
  fid varchar(100) default NULL,
  name varchar(100) default NULL,
  time varchar(100) default NULL,
  description blob,
  subject varchar(50) default NULL,
  email varchar(50) default NULL,
  timeline varchar(100) default NULL,
  PRIMARY KEY  (rid)
) TYPE=MyISAM