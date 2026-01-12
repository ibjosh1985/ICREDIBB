CREATE TABLE ibb_announcements (
  aid int(11) NOT NULL auto_increment,
  name varchar(250) NOT NULL default '',
  description varchar(250) NOT NULL default '',
  allowreplies char(3) NOT NULL default '',
  PRIMARY KEY  (aid)
) TYPE=MyISAM