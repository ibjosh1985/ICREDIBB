<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/

error_reporting(-1);
include ("header.php");

$ptitle = "$boardname - Online Users";
echo ("<title>$ptitle</title>");

$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}

$query = "select count(*) from ibb_onlineusers where username='Guest'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$guests = $row[0];

$query = "select count(*) from ibb_onlineusers where username<>'Guest'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$members = $row[0];
?>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD vAlign=top><FONT face=<?php echo $font; ?>
            size=2><B>
			<A href="index.php"><?php echo "$boardname"; ?></A> >> <A href="onlineusers.php">Online Users</A></B></FONT></TD></TR></TBODY></TABLE><BR>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor=<?php echo $muabgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
              <TR id=cat>
                <TD bgColor=<?php echo $muatopbarbgcolor; ?> colSpan=6><FONT 
                  face=<?php echo $font; ?> color=<?php echo $muatopbartxtcolor; ?> 
                  size=2><B><?php echo $boardname; ?>,&nbsp;Currently Active 
                  Users&nbsp;at&nbsp;<?php echo $realtime; ?> -</B>&nbsp;<?php echo $members; ?> Members 
                  and&nbsp;<?php echo $guests; ?> Guests</FONT></TD></TR>
              <TR align=middle>
                <TD bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?>
                  color=<?php echo $muatopbartxtcolor; ?> size=1><B>User Name</B></FONT></TD>
                <TD bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?>
                  color=<?php echo $muatopbartxtcolor; ?> size=1><B>Location</B></FONT></TD>
                <TD bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?>
                  color=<?php echo $muatopbartxtcolor; ?> size=1><B>Last Active</B></FONT></TD>
                <TD noWrap align=middle bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?>
                  color=<?php echo $muatopbartxtcolor; ?> size=1><B>Profile</B></FONT></TD>
                <TD align=middle bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?>
                  color=<?php echo $muatopbartxtcolor; ?> size=1><B>Email</B></FONT></TD>
                <TD bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?>
                  color=<?php echo $muatopbartxtcolor; ?> size=1><B>IP</B></FONT></TD></TR>
<?php

if (!isset($view)) {
	$view = "all";
	$thing = "";
}else{
	$thing = "WHERE username <> 'Guest'";
}

$theonlineusers = mysql_query("SELECT * FROM ibb_onlineusers $thing") or die(mysql_error());
while ($row=mysql_fetch_array($theonlineusers)) {
$username = $row["username"];
$actualtime = $row["actualtime"];
$userlocation = $row["location"];
$pagename = $row["pagename"];
$theirIP = $row["IP"];
$result = mysql_query("SELECT * FROM ibb_members WHERE name = '$username'") or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
	$membersonlinemid = $row["mid"];
	$memberonlinestatus = $row["status"];
	$memberemail = $row["email"];
}

if (isset($view)) {
if ((($memberonlinestatus == $view) || ($view == "all")) && ($username != "Guest")) {
?>
              <TR align=middle>
                <TD align=left bgColor=<?php echo $muatopbarbgcolor; ?>>
                  <P align=center><FONT face=<?php echo $font; ?> color=<?php echo $muatopbartxtcolor; ?>
                  size=2><?php 
if ($username == "Guest") {
echo ("$username<br>");
}else{
if ($memberonlinestatus == "admin") {
echo("<a href='member.php?MID=$membersonlinemid'><b><font color='$mualinkcolor'>$username</b></a><br>");
}else{
if ($memberonlinestatus == "Moderator") {
echo("<a href='member.php?MID=$membersonlinemid'><b><font color='$mualinkcolor'>$username</b></a><br>");
}else{
echo("<a href='member.php?MID=$membersonlinemid'><font color='$mualinkcolor'>$username</a><br>");
}
}
} ?></FONT></P></TD>
                <TD align=left bgColor=<?php echo $muaboxbgcolor; ?>>
                  <P align=center><FONT face="<?php echo $font; ?>" color=<?php echo $muaboxtxtcolor; ?> size=2><a href="<?php echo($userlocation); ?>"><?php echo($pagename); ?></a></FONT></P></TD>
                <TD noWrap bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $muatopbartxtcolor; ?>
                  size=2><?php
echo("$actualtime CST");
?></FONT></TD>
                <TD bgColor=<?php echo $muaboxbgcolor; ?>><FONT
                  face=Tahoma color=<?php echo $muaboxtxtcolor; ?> size=2><?php if ($username == "Guest") { }else{ ?><A 
                  href="member.php?MID=<?php echo $membersonlinemid; ?>"><?php } ?>Profile<?php if ($username == "Guest") { }else{ ?></A><?php } ?></FONT></TD>
                <TD bgColor=<?php echo $muatopbarbgcolor; ?>><FONT
                  face=Tahoma color=<?php echo $muatopbartxtcolor; ?> size=2><?php if ($username == "Guest") { }else{ ?><A 
                  href="mailto:<?php echo $memberemail; ?>"><font color=<?php echo $mualinkcolor; ?>>Email</A><?php 					  } ?></FONT></TD>
                <TD align=left bgColor=<?php echo $muaboxbgcolor; ?>>
                  <P align=center><FONT face=<?php echo $font; ?> color=<?php echo $muaboxtxtcolor; ?> size=2><?php if ($sessionstatus == "admin") 	{ echo $theirIP; }else{ echo "IP"; } ?></FONT></P></TD></TR>
<?php
}
}
}
?></TBODY></TABLE></TD></TR></TBODY></TABLE><BR>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor=<?php echo $muabgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
              <TR>
                <TD bgColor=<?php echo $muatopbarbgcolor; ?>><FONT
                  face=Tahoma color=<?php echo $muatopbartxtcolor; ?> size=1>Names in <B>Bold</B> are forum 
              Admins.</FONT></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><!-- /Legend --><BR>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD><FONT face="Tahoma, Verdana, Arial" size=1><A 
            href="javascript:window.location=window.location">[reload this 
            page]</A></FONT> </TD>
          <TD align=right>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <FORM action=forumdisplay.php method=get>
              <TBODY>
              <TR>
                <TD><FONT face="Tahoma, Verdana, Arial" size=1><B>View 
                  Other&nbsp;Forums:</B><BR><SELECT 
                  onchange="window.location=('forumdisplay.php?s=&amp;daysprune=30&amp;forumid='+this.options[this.selectedIndex].value)" 
                  name=forumid> <OPTION value=-1 selected>Select 
                    Forum:</OPTION> <OPTION 
                    value=-1>--------------------</OPTION> <OPTION 
                    value=pm>$forums</OPTION></SELECT>
              </FONT></TD></TR></FORM></TBODY></TABLE></TD></TR></TBODY></TABLE><FONT 
face="Tahoma, Verdana, Arial" 
size=1><BR>
<?php 
include "footer.php"; 
echo $copyrights; 


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>
