CREATE TABLE ibb_polls (
  pollid int(11) NOT NULL auto_increment,
  question varchar(125) NOT NULL default '',
  numberchoices int(11) NOT NULL default '0',
  choices text NOT NULL,
  time int(11) NOT NULL default '0',
  destruct int(11) NOT NULL default '0',
  allowreplies char(3) NOT NULL default '',
  PRIMARY KEY  (pollid)
) TYPE=MyISAM