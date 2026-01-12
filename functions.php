<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/

//tells php to not show unnessary errors
//change 0 to -1 if you wish to show ALL errors
error_reporting(0);																						//decides if errors should be shown or not


//starts a session
//this contains things such as username and status
session_start();																							//starts a session
if (!isset($PHPSESSID)) {
if ((!$sessionuser) || (!$sessionstatus) || (!$count) || (!$usergroup) || (!$website)) {//if session variables don't exist, this goes on
	session_register('sessionuser');																//registers sessionuser session
	session_register('sessionstatus');																//registers sessionstatus session
	session_register('usergroup');	
}																												//ends if statement

if (!$sessionuser) {																						//if sessionuser isn't assigned, this goes on
	$sessionuser = "Guest";																			//sets sessionuser to Guest
}																												//ends if statement

if (!$sessionstatus) {																					//if sessionstatus isn't assigned, this goes on
	$sessionstatus = "Guest";																		//sets sessionstatus to Guest
}																												//ends if statement 


if (!$usergroup) {															
	$usergroup = "Guests";																	
}
}


//connects icredibb to database
//this uses information specified in database.php
include("database.php");																				//includes the database information
mysql_connect($db_Hostname, $db_UserName, $db_Password) || die("Can't Connect to Database: ".mysql_error()); // connects to mysql database
mysql_select_db($db_Database);																//selects the database to use


//gets the time in seconds form
$ttime = time();																							//sets $ttime to the current time in seconds


//gets user's time preference
//this is the number that is subtracted from the time on pages
$result = mysql_query("SELECT * FROM ibb_members WHERE name='$sessionuser'"); //selects everything from members table
	while ($row = mysql_fetch_array($result)) {													//sets $row to the $result array
		$timepreference = $row["timepref"];														//sets $timepreference to the row timepref
		$avheight = $row["avheight"];																	//sets $avheight to the row avheight
		$avwidth = $row["avwidth"];																	//sets $avwidth to the row avwidth
		$optionstatus = $row["options"];																//sets $optionstatus to the row options
		$usermid = $row["mid"];																		//sets $usermid to the row mid
		$website = $row["website"];																	//sets $website to the row website
		$usergroup = $row["groupname"];															//sets $usergroup to the row groupname
		$status = $row["status"];																		//sets $status to the row status
	  }																												//ends if statement


if ($sessionuser != "Guest") {
	$sessionstatus = $status;
}


$result = mysql_query("SELECT * FROM ibb_members WHERE name='$sessionuser'");
while ($row = mysql_fetch_array($result)) {
	$membername3 = $row["name"];
}


//gets group information for the user
$result = mysql_query("SELECT * FROM ibb_groups WHERE gname='$usergroup'"); //selects everything from members table
	while ($row = mysql_fetch_array($result)) {													//sets $row to the $result array
		$gtitle = $row["gtitle"];
		$gposttopics = $row["posttopics"];
		$gpostreplies = $row["postreplies"];
		$gedittopics = $row["edittopics"];
		$geditreplies = $row["editreplies"];
		$gdtopics = $row["dtopics"];
		$gdreplies = $row["dreplies"];
		$gptopics = $row["ptopics"];
		$gmtopics = $row["mtopics"];
		$geditownposts = $row["editownposts"];
		$gadminedit = $row["adminedit"];
		$guploadavatar = $row["uploadavatar"];
	  }																												//ends if statement

//gets IP address
//this is used for onlineusers information
$IP = $REMOTE_ADDR;


//gets ips from bannedip
$result = mysql_query("SELECT IP FROM ibb_bannedip WHERE IP LIKE '%$IP'");
	  while ($row = mysql_fetch_array($result)) {
		  $bannedip = $row["IP"];
	  }


//if the user's IP is in the table
//this will kill the script
if (!$bannedip) {
}else{
echo ("You have been a naughty person. Hence, you are banned from using this board.<br>If you believe this is in error, contact the webmaster.");
die();
}


//gets the URL of the page the user is on
//this is used for onlineusers information
//this should be safe for IIS servers as well now
$thelocation = $PHP_SELF . "?" . $HTTP_SERVER_VARS['QUERY_STRING'];


//gets online user info
//this gets information about the user online, and, if he isn't in it, it adds him
$result = mysql_query("SELECT * FROM ibb_onlineusers where username = '$sessionuser'");
	while ($row = mysql_fetch_array($result)) {
		$onlineIP = $row["IP"];
		$onlineusername = $row["username"];
		$location = $row["location"];
		$onlineusertime = $row["time"];
	}


//gets the time
//three different forms for onlineusers
$actualtime=date("h:i:s");
$onlinetime = time();
$newtime = $ttime-600;


//if the user's IP isn't in the DB
//this will add it
if (!$onlineIP) {
	$pagename = "$boardname";
	$sql = "INSERT INTO ibb_onlineusers SET IP='$IP', username='$sessionuser', location='$thelocation', time='$ttime', actualtime='$realtime', pagename='$pagename'";
	if (mysql_query($sql)) { 
	} else { 
		mysql_error(); 
	} 
}else{
}


//this will update the pagename, IP and so forth
//in the onlineusers table
$sql = "UPDATE ibb_onlineusers SET IP='$IP', username='$sessionuser', location='$thelocation', time='$ttime', actualtime='$actualtime' WHERE IP='$IP'";
if (mysql_query($sql)) { 
} else { 
	mysql_error(); 
} 


//deletes records in onlineusers 
//of users who have been longer than the time said
$sql = "DELETE FROM ibb_onlineusers WHERE time<'$newtime'";
if (mysql_query($sql)) { 
} else { 
} 


//gets the board's set avatar height and width
$result = mysql_query("SELECT * FROM ibb_boardinfo");
while ($row = mysql_fetch_array($result)) {
	$avwidth1 = $row["avwidth"];
	$avheight1 = $row["avheight"];
	$bdescription = $row["description"];
}


//gets the board info
//this includes the board name, the description, and the url
$result = mysql_query("SELECT * FROM ibb_boardinfo");
while ($row = mysql_fetch_array($result)) {
	$boardname = $row["boardname"]; 
	$bdescription = $row["description"];
	$boardurl = $row["boardurl"];
	$forumspage = $row["forumspage"];
	$threadspage = $row["threadspage"];
	$soffset = $row["offset"];
	$savwidth = $row["avwidth"];
	$savheight = $row["avheight"];
	$cookiestart = $row["cookie"];
	$htmltitles = $row["htmltitles"];
	$htmlsig = $row["htmlsig"];
	$codesig = $row["codesig"];
	$boardlogo = $row["logo"];
}


//gets htmltitles into the form for admincp change stuff
if ($htmltitles == "yes") {
	$htmltitlesc == "Allow";
}else{
	$htmltitlesc == "Don't Allow";
}

//sets cookies
//these contain your session information
//you can change the area in the "" to whatever you want for cookies
setcookie("userstuffid", $PHPSESSID, time()+1086400);
setcookie("sessionuser", $sessionuser, time()+1086400);
setcookie("sessionstatus", $sessionstatus, time()+1086400);
setcookie("usergroup", $usergroup, time()+1086400);


//adds the offset hours to the time
//makes the time coherent with the time preference selected
$offsettime1 = date("h");
$offsettime = $offsettime1 + $offset;
if ($offsettime < "10") {
	$offsettime = "0$offsettime";
}

//gets time in 3 different formats
//these are for various things on the board
$thetime=date("m/d/Y h:i:s");
$realtime=date("h:i:s");


//gets the users mid
//this is used on both pm.php and usercp.php
$query = "select mid from ibb_members where name='$sessionuser'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$usermid = $row[0];


//gets the name of the newest member
//this is for the Stats area
$query = "select name from ibb_members order by mid desc limit 1";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$newestmember = $row[0];


//gets the member ID from the newest member
$query = "select mid from ibb_members where name='$newestmember'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$newmemberid = $row[0];


//gets the amount of forums
$query = "select count(*) from ibb_forums";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$totalforums = $row[0];


//gets the totalamount of members
$query = "select count(*) from ibb_members";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$totalmembers = $row[0];


//gets number of topics
$query = "SELECT count(*) FROM ibb_threads";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$topicnumber = $row[0];


//gets number of replies
$query = "SELECT count(*) FROM ibb_replies";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$replynumber = $row[0];


//gets avatar and mid from user table
$result = mysql_query("SELECT * FROM ibb_members WHERE name='$sessionuser'") or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
$avatar = $row["aviator"];
$YOURMID = $row["mid"];
}


//gets the ids of people on the ignore list
$result = mysql_query("SELECT * FROM ibb_ignores WHERE mid='$usermid'");
while ($row = mysql_fetch_array($result)) {
$imid = $row["imid"];
$ilength = $row["length"];
$itime = $row["time"];


//if $ilength is forever, then it'll skip the formatting and deleting
if ($ilength == "forever") {																			//checks to see if $ilength = forever
}else{																										//if not, it does formatting and deleting


//gets the time formatted
$ilengthinsec = $itime * "86400";																	//gets length into seconds form
$ittime = $ilengthinsec + $itime;																	//adds length and the time it was inserted


//if the length period is up, this will delete the ignore
if ($ittime < $ttime) {																					//checks to see if time is up
	$sql = "DELETE FROM ibb_ignores WHERE imid='$imid'";							//deletes entry from db
	if (mysql_query($sql)) {																			//checks to see if query worked
	}																											//ends if statement
}																												//ends if statement
}																												//ends if statement
}																												//ends if statement


//gets the color theme
//this is used to control the colors of the board
$query = "select theme from ibb_boardinfo where boardname='$boardname'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$theme1 = $row[0];

$theme = "themes/$theme1/$theme1.php";

if (!$theme) {
	include "themes/default/default.php";
}else{
if (!file_exists($theme)) {
	include "themes/default/default.php";
}else{
	include $theme;
}
}


//gets all of the polls
//used to determine if the poll's time is up and if it is ready to die
$result = mysql_query("SELECT * FROM ibb_polls");
	while ($row = mysql_fetch_array($result)) {
		$pollid = $row["pollid"];

		$time = $row["time"];
		$destruct = $row["destruct"];
		
		if ($destruct == "forever") {
		}else{
			$timetokill = $destruct * 24 * 60 * 60;
			$totaltimes = $time + $timetokill;
			if ($totaltimes > $ttime) {
				$sql = "DELETE FROM ibb_polls WHERE pollid='$pollid'";			     								//deletes entry from db
				if (mysql_query($sql)) {																							//checks to see if query worked
					$sql = "DELETE FROM ibb_poll_votes WHERE pollid='$pollid'";			     					//deletes entry from db
					if (mysql_query($sql)) {																						//checks to see if query worked
						$sql = "UPDATE ibb_threads SET poll='no' WHERE timeline='$time' && subject='$question'";	//updates entry from db
						if (mysql_query($sql)) {																					//checks to see if query worked
						}
					}	
				}	
			}
		}
	}



/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>