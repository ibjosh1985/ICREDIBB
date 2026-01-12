CREATE TABLE ibb_mods (
  modid int(11) NOT NULL auto_increment,
  name varchar(100) default NULL,
  fid varchar(100) NOT NULL default '',
  mid int(11) NOT NULL default '0',
  PRIMARY KEY  (modid)
) TYPE=MyISAM