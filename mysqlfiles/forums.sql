CREATE TABLE ibb_forums (
  fid int(11) NOT NULL auto_increment,
  name blob,
  description blob,
  time varchar(50) default NULL,
  allowhtml char(3) default NULL,
  allowcode char(3) default NULL,
  viewableto varchar(50) default 'all',
  whocanpost varchar(50) default 'all',
  whocanseeall varchar(50) default 'all',
  date varchar(50) default NULL,
  cid int(11) default NULL,
  locked varchar(50) default 'no',
  PRIMARY KEY  (fid)
) TYPE=MyISAM