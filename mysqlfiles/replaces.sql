# phpMyAdmin MySQL-Dump
# version 2.2.3
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Host: localhost
# Generation Time: Mar 22, 2002 at 07:26 PM
# Server version: 3.23.43
# PHP Version: 4.0.6
# Database : `fenderbender`
# --------------------------------------------------------

#
# Table structure for table `ibb_replaces`
#

CREATE TABLE ibb_replaces (
  id int(11) NOT NULL auto_increment,
  this varchar(25) NOT NULL default '',
  that varchar(50) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

