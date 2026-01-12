CREATE TABLE ibb_groups (
  gid int(11) NOT NULL auto_increment,
  gname varchar(50) NOT NULL default '',
  gtitle varchar(250) NOT NULL default '',
  posttopics char(3) NOT NULL default 'no',
  postreplies char(3) NOT NULL default 'no',
  edittopics char(3) NOT NULL default 'no',
  editreplies char(3) NOT NULL default 'no',
  dtopics char(3) NOT NULL default 'no',
  dreplies char(3) NOT NULL default 'no',
  ptopics char(3) NOT NULL default 'no',
  mtopics char(3) NOT NULL default 'no',
  editownposts char(3) NOT NULL default 'no',
  adminedit char(3) NOT NULL default 'no',
  uploadavatar char(3) NOT NULL default 'no',
  amaxsize int(11) NOT NULL default '0',
  PRIMARY KEY  (gid)
) TYPE=MyISAM