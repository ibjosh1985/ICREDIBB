<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


//gets the database.php file
//this file contains the information needed to connect to the database
include "database.php";


//this does the actual database connection
//this uses the information supplied in database.php
mysql_connect($db_Hostname, $db_UserName, $db_Password) || die("Can't Connect to Database: ".mysql_error());
mysql_select_db($db_Database);


//gets the time preference for the user
//this is used for the time part of the footer
$result = mysql_query("SELECT timepref FROM ibb_members WHERE name='$sessionuser'");
                  while ($row = mysql_fetch_array($result)) {
		  $timepreference = $row["timepref"];
	  }


//if the user hasn't selected a timepreference, this sets it to zero
//if the user has, it sets $timepreference equal to it
if ($timepreference == "") {
	$timepreference = "0";
}
	

//does the processing of the time to fit with the time preference of the user
$servertimemonth = substr($thetime, 0,2);
$servertimeday = substr($thetime, 3,2);
$servertimeyear = substr($thetime, 6,4);
$servertimehour = substr($thetime, 11,2);
$servertimemin = substr($thetime, 14,2);
$servertimesec = substr($thetime, 17,2);
$servertimehour = $servertimehour + $timepreference;
if ($timepreference > "0") {
	if ($servertimehour >= "12" && $timeofday == "pm") {
		$servertimeday = $servertimeday + "1";
			if ($servertimeday > $dayofmonth) {
				$servertimemonth = $servertimemonth + "1";
					if ($servertimemonth > "12") {
						$servertimeyear = $servertimeyear + "1";
						$servertimemonth = "01";
					}
				$servertimeday = "01";
			}
		$servertimehour = $servertimehour - "12";
	}else if ($servertimehour > "12") {
		$servertimehour = $servertimehour - "12";
	}
}	
if ($timepreference < "0") {
	if ($servertimehour < "1" && $timeofday == "am") {
		$servertimeday = $servertimeday - "1";
			if ($servertimeday == "0") {
				$servertimemonth = $servertimemonth + "1";
					if ($servertimemonth < "1") {
						$servertimeyear = $servertimeyear - "1";
						$servertimemonth = "12";
					}
					if ($dayofmonth == "31") {
						$servertimeday = "30";
					}else if ($monthofyear == "Mar") {
						$servertimeday = "28";
					}else{
						$servertimeday = "31";
					}
			}
		$servertimehour = $servertimehour + "12";
	}
}	
	

//if $servertime is smaller than ten (ie: 9) it'll add a zero in front of it (ie: 09)
if ($servertimehour < "10") {
		$servertimehour = "0$servertimehour";
}
	

//puts all the variables next to each other for the finishing touch
$actualtime = "$servertimemonth/$servertimeday/$servertimeyear $servertimehour:$servertimemin:$servertimesec";


//if the user is a guest, it shows a login link instead of the logout link
if ($sessionuser == "Guest") {
	$loginout = "<a href=\"index.php?function=register\">Register</a> | <a href=\"index.php?function=login\">Login</a>";
}else{
	$loginout = "<a href=\"index.php?function=logout\">Log Out</a>";
}


//this HTML is edittable
?>
<TABLE cellSpacing=0 cellPadding=2 width="100%" align=center border=0>
        <TBODY>
        <TR vAlign=top>
          <TD><FONT face="Tahoma, Verdana, Arial" size=1>All times are <?php echo $timepreference; ?> hours offset. The date and time now is <?php echo $actualtime; ?>.</FONT></TD>
          <TD align=right><FONT face="Tahoma, Verdana, Arial" 
            size=1>
<?php
echo $loginout;
?>
</FONT></TD></TR></TBODY></TABLE><BR>

<?php
//this is used for the index.php file
//it, when echoed, will show the forum images
$images = ("
	<TABLE cellSpacing=0 cellPadding=2 width=\"100%\" align=center border=0>
        <TBODY>
        <TR>
          <TD align=middle>&nbsp;<img src='images/on.gif'> <B><FONT 
            face=\"Tahoma, Verdana, Arial\" size=1>Announcements</FONT></B>&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/off.gif'> <B><FONT 
            face=\"Tahoma, Verdana, Arial\" size=1>Standard Forum</FONT></B>&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/lock.gif'>&nbsp; <B><FONT 
            face=\"Tahoma, Verdana, Arial\" size=1>Locked</FONT></B> 
        </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></CENTER>");


//this is the copyright line, do not change the copyright information
//changing the copyright is in violation of federal law
//you are allowed to change the style of it without changing the original purpose
$copyrights = ("<P align=center><FONT face=\"Tahoma, Verdana, Arial\" size=1>Content Copyright © $boardname<br>IcrediBB V 1.1 Copyright © 2001-2002 IcrediBB Design Team</FONT></P></BODY></HTML>");


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>																								