CREATE TABLE ibb_ignores (
  iid int(11) NOT NULL auto_increment,
  mid varchar(50) NOT NULL default '',
  imid varchar(50) NOT NULL default '',
  length varchar(50) NOT NULL default '',
  time varchar(50) NOT NULL default '',
  PRIMARY KEY  (iid)
) TYPE=MyISAM