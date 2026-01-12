CREATE TABLE ibb_poll_votes (
  voteid int(11) NOT NULL auto_increment,
  pollid int(11) NOT NULL default '0',
  choice text NOT NULL,
  mid int(11) NOT NULL default '0',
  PRIMARY KEY  (voteid)
) TYPE=MyISAM