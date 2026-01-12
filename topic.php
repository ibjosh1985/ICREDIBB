<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


include "header.php";

$query = "SELECT name FROM ibb_mods WHERE fid='$FID'";
$toto = mysql_query($query);
$bob = mysql_fetch_row($toto);
$moderators = $bob[0];

if ($t == "a") {
	$addon = "&t=a";
	$viewableto = "all";
	$whocanseeall = "all";
	$bla3 = str_replace("a", "", $FID);
	$variables = mysql_query("SELECT * FROM ibb_announcements WHERE aid='$bla3'");
	while ( $row = mysql_fetch_array($variables) ) {
	$allowreplies = $row["allowreplies"];
	if ($allowreplies == "yes") {
		$whocanpost = "all";
	}
	}
}

$variables = mysql_query("SELECT * FROM ibb_forums WHERE fid='$FID'");
while ( $row = mysql_fetch_array($variables) ) {
$viewableto = $row["viewableto"]; 
$whocanpost = $row["whocanpost"]; 
$whocanseeall = $row["whocanseeall"];
$allowcode = $row["allowcode"];
}

//gets the topic title and lock status and other stuff
$result = mysql_query("SELECT * FROM ibb_threads WHERE tid=$TID");
while ( $row = mysql_fetch_array($result) ) {
$subject = $row["subject"]; 
$lock = $row["locktopic"];
$isitapoll = $row["poll"];
$topictimeline = $row["timeline"];
}

if ($isitapoll == "yes") {
	$result = mysql_query("SELECT * FROM ibb_polls WHERE question='$subject' && time='$topictimeline'");
	while ( $row = mysql_fetch_array($result) ) {
	$pid = $row["pollid"];
	$choices = $row["choices"];
	$name = $row["name"];
	$allowreplies = $row["allowreplies"];
	}
}

$result = mysql_query("select views from ibb_threads where tid='$TID'") or die(mysql_error());
while ($row = mysql_fetch_array($result) ) {
$theviews = $row["views"];
$views = $theviews + "1";
}
$sql = "UPDATE ibb_threads SET views='$views' WHERE tid='$TID'";
if (mysql_query($sql)) { 
} else { 
echo(
mysql_error()); 
} 

$query = "SELECT name FROM ibb_forums WHERE fid='$FID'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$forumname = $row[0];

if (!$threadspage) {
$threadspage = "10"; 
}

if(!isset($start)) {
$start="0";
}

if(!isset($perpage)) {
$perpage="$threadspage";
}

$query = mysql_query("SELECT * FROM ibb_replies WHERE tid='$TID' ORDER BY rid"); 
$newnum = mysql_num_rows($query); 

$newnum = $newnum;

$numpages = ceil($newnum/$perpage);

for($i=0; $i<$numpages; $i++){ 
    $startrow = $perpage*$i; 
    $page = $i+1; 
    if($startrow == $start){ 
        $pages .= " [ $page ] "; 
    }else{ 
        $pages .= " [ <a href='$PHP_SELF?TID=$TID&FID=$FID&start=$startrow&perpage=$perpage$addon'>$page</a> ] "; 
    } 
} 

if ($t == "a") {
	$forumname = "Announcement";
}

$ptitle = "$boardname - $forumname - $subject";
echo ("<title>$ptitle</title>");

$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}

$query = "SELECT count(*) FROM ibb_onlineusers WHERE pagename='$ptitle'";
$toto = mysql_query($query);
$bob = mysql_fetch_row($toto);
$pageviewers = $bob[0];

if((strstr($viewableto, $sessionstatus)) || ($viewableto == "all")) {
if((strstr($whocanseeall, $sessionstatus)) || ($whocanseeall == "all")) {
?>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD vAlign=top width="60%"><STRONG>
			<FONT face=Tahoma size=2 color="<?php echo $topictxtcolor; ?>">
			<A href="index.php"><FONT face=Tahoma size=2 color="<?php echo $topiclinkcolor; ?>"><?php echo $boardname; ?></font></A> >> <?php if ($t == "a") { echo $forumname; }else{ ?><A href="viewforum.php?FID=<?php echo $FID; ?>"><FONT face=Tahoma size=2 color="<?php echo $topiclinkcolor; ?>"><?php echo $forumname; ?></font></A><?php } ?> >> <A href="topic.php?<?php if ($t == "a") { echo "t=a&"; } ?>TID=<?php echo $TID; ?>&FID=<?php echo $FID; ?>"><FONT face=Tahoma size=2 color="<?php echo $topiclinkcolor; ?>"><?php echo $subject; ?></font></A></FONT></STRONG></A><FONT size=1><BR><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topictxtcolor; ?>">(Users viewing this Topic: 
            <?php echo $pageviewers; ?>)</FONT></FONT></TD>
          <TD vAlign=bottom align=right><?php if ($t == "a") { }else{ if ($gposttopics == "yes") { ?><A href="viewforum.php?FID=<?php echo $FID; ?>&function=addpoll"><FONT face="<?php echo $font; ?>" color=<?php echo $topictxtcolor; ?> size=3><img src="themes/<?php echo $theme1; ?>/images/newpoll.gif" border=0></A> <?php } if ($gposttopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") { ?><A href="viewforum.php?FID=<?php echo $FID; ?>&function=addtopic"><img src="themes/<?php echo $theme1; ?>/images/newthread.gif" border=0></A><?php } } ?></TD></TR>
		<TR>
          <TD colspan=2>
			<TABLE cellSpacing=1 cellPadding=2 width="175" align=left border=0n bgcolor=<?php echo $topicbgcolor; ?>>
				<TBODY>
				<TR>
					<TD colspan=2 vAlign=top bgcolor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topictopbartxtcolor; ?>"><b>Permissions</b></FONT></center></TD></TR>
				<TR>
					<TD width="70%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>">Post Topics</FONT></center></TD>
					<TD width="70%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>"><b><?php if ($gposttopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") { echo "YES"; }else if ($t == "a"){ echo "NO"; } ?></b></FONT></center></TD></TR>
				<TR>
					<TD width="70%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>">Post Replies</FONT></center></TD>
					<TD width="70%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>"><b><?php if ($gpostreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator" || $t == "a") { echo "YES"; }else{ echo "NO"; } ?></b></FONT></center></TD></TR>
				<TR>
					<TD width="70%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>">HTML</FONT></center></TD>
					<TD width="70%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>"><b><?php if ($allowhtml == "yes") { echo "YES"; }else{ echo "NO"; } ?></b></FONT></center></TD></TR>
				<TR>
					<TD width="30%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>">IcrediCode</FONT></center></TD>
					<TD width="30%" vAlign=top bgcolor=<?php echo $topicmainbgcolor; ?>><center><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topicmaintxtcolor; ?>"><b><?php if ($allowcode == "yes" || $t == "a") { echo "YES"; }else{ echo "NO"; } ?></b></FONT></center></TD></TR>
			</TBODY></TABLE>	  
		  </TD></TR>
		<TR>
          <TD vAlign=top><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topictxtcolor; ?>">Page: <?php echo $pages; ?></FONT></TD></tr>



<?php
if ($Submit == "Submit Vote") {
	?>
	<tr><td colspan=2><TABLE cellSpacing=1 cellPadding=0 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
	<tbody><tr><td>
	<TABLE cellSpacing=0 cellPadding=5 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
	<TBODY><TR><TD width="100%" bgColor=<?php echo $topictopbarbgcolor; ?> colSpan=2><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2><center>
	<?php
	$query = "select mid from ibb_poll_votes WHERE pollid='$pid' && mid='$usermid'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$mid = $row[0];
	if ($mid == $usermid) {
		echo "You have already voted. Please click the back button.";
	}else{
	$sql = "INSERT INTO ibb_poll_votes SET " .
	"pollid='$PID'," .
	"mid='$usermid'," .
	"choice='$userschoice'";
	if (mysql_query($sql)) {
		?>
		<META HTTP-EQUIV="Refresh" 
		CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
		<?php
		echo "Your vote has been added. Redirecting...";
	}else{
		echo mysql_error();
	}
	}
	?>
	</TD></TR></tbody></table></TD></TR></tbody></table></TD></TR></tbody></table>
	<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
	<TBODY>
	<TR>
	<TD vAlign=top>
	<?php
}else{

//if the user selected to move the topic, this is what happens
if ($function == "movetopic") {
if ($gmtopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
?><form action="topic.php?<?php echo("TID=$TID&FID=$FID"); ?>" method=POST>
<tr><td colspan=2><TABLE cellSpacing=1 cellPadding=0 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
<tbody><tr><td>
<TABLE cellSpacing=0 cellPadding=5 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
<TBODY><TR><TD width="100%" bgColor=<?php echo $topictopbarbgcolor; ?> colSpan=2>
<FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2><center>Move Topic To Different Forum:<br></font>
<select name="newforum">
<OPTION value= selected>Select Form To Move To:</OPTION> <OPTION value=>--------------------</OPTION>
<?php
$result = mysql_query("SELECT fid FROM ibb_forums WHERE fid<>'$FID'");
while ($row = mysql_fetch_array($result)) {
$fids[] = $row["fid"];
}
foreach ($fids as $fid) {
$result = mysql_query("SELECT * FROM ibb_forums WHERE fid='$fid'");
while ($row = mysql_fetch_array($result)) {
$forumsname = $row["name"];
}
echo("<option value='$fid'>$forumsname</option>");
}
?>

</select></td></tr><tr><td bgColor=<?php echo $topictopbarbgcolor; ?> colSpan=2>
<center><input type=SUBMIT name="movetopicsubmit" value="Move Topic To Forum">
</TD></TR></tbody></table></TD></TR></tbody></table></TD></TR></tbody></table>
<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
<TBODY>
<TR>
<TD vAlign=top>
<?php
}else{
	echo("<TR><TD colspan=3><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to move topics. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if ($movetopicsubmit == "Move Topic To Forum") {
if ($gmtopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
?>
<tr><td colspan=2><TABLE cellSpacing=1 cellPadding=0 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
<tbody><tr><td>
<TABLE cellSpacing=0 cellPadding=5 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
<TBODY><TR><TD width="100%" bgColor=<?php echo $topictopbarbgcolor; ?> colSpan=2><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2><center>
<?php
$sql = "UPDATE ibb_replies SET fid='$newforum' WHERE tid='$TID'";
if (mysql_query($sql)) {
}
$sql = "UPDATE ibb_threads SET fid='$newforum' WHERE tid='$TID'";
if (mysql_query($sql)) {
echo("Topic has been moved. You are now being redirected.");
?>
</TD></TR></tbody></table></TD></TR></tbody></table></TD></TR></tbody></table>
<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
<TBODY>
<TR>
<TD vAlign=top>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$newforum&TID=$TID"); ?>">
<?php
}else{
echo(mysql_error());
}
}else{
	echo("<TR><TD colspan=3><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to move topics. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if ($function == "addreply" && ($gpostreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") && $allowreplies != "no") {
$orderby = "DESC";
?>
<tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#000000 
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><B>Your Username:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2>
		<?php 
		if ($sessionuser == "Guest") {
			echo "A Guest";
		}else{
			echo $sessionuser; } ?></FONT></TD></TR>
        <TR bgColor=<?php echo $topictopbarbgcolor; ?>>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>>
			<FORM ACTION="topic.php?<?php if ($t == "a") { ?>t=a&<?php } echo ("FID=$FID&TID=$TID"); ?>" METHOD=POST name=newreply><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><B>Subject:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><?php echo $subject; ?></FONT></TD></TR>
        <TR>
          <TD noWrap bgColor=<?php echo $topictopbarbgcolor; ?>>
            <P><center>
<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="#000000">
<TR>
<TD height=10 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2>Emoticons</center>
</TD>
</TR>
<TR>
<TD height=90 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?> valign=center>
<center>
<a href="javascript:void(0);" onclick="newreply.message.value=newreply.message.value +':)';"><img src="images/smile.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newreply.message.value=newreply.message.value +':(';"><img src="images/sad.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="newreply.message.value=newreply.message.value +':mad:';"><img src="images/mad.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newreply.message.value=newreply.message.value +':D';"><img src="images/biggrin.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="newreply.message.value=newreply.message.value +':-/';"><img src="images/slant.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newreply.message.value=newreply.message.value +';)';"><img src="images/wink.gif" border=0></a>
</center>
</TD>
</TR>
</Table></center></FONT></P></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=message rows=10 wrap=virtual cols=60></TEXTAREA>
			</TD></TR>
			</TBODY></TABLE></TD></TR>
			<TR><TD bgColor=<?php echo $topictopbarbgcolor; ?> colspan=2><center>
          <INPUT type=submit value="Submit Reply" name=submitreply></center></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></td></tr><tr><td><br><br></td></tr>
<?php
}

if ("Submit Reply" == $submitreply && ($gpostreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator")) {
if (($gpostreplies !="yes" && ($sessionstatus !="admin" || $sessionuser !="Moderator")) && $function == "addreply") {
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to post replies. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}else{
if ($message == "") {
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You left the message field blank. Please click the back button.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
}else{
$message = str_replace("
", "[br]", $message);

$query = "SELECT posts FROM ibb_members WHERE name='$sessionuser'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$postcountone = $row[0];
$newpostcount = $postcountone + "1";
$sql = "UPDATE ibb_members SET posts='$newpostcount' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
}else{
echo(mysql_error());
}

$sql = "INSERT INTO ibb_replies SET " .
"name='$sessionuser'," .
"fid='$FID'," .
"tid='$TID'," .
"time='Replied On: $thetime'," . 
"timeline='$ttime'," . 
"description='$message'";
if (mysql_query($sql)) {
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Reply added successfully. You are being redirected.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
			?>
			<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
        <TBODY>
        <TR>
          <TD vAlign=top>
			<?php
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=topic.php?<?php if ($t == "a") { ?>t=a&<?php } echo ("FID=$FID&TID=$TID"); ?>">
<?php
} else {
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Error adding submitted reply: " .
mysql_error() . "</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
}
$query = "select max(lpid) from ibb_threads";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$newtid = $row[0];

$newtid++;

$sql = "UPDATE ibb_threads SET lpid='$newtid' WHERE tid='$TID'";
if (mysql_query($sql)) {
}else{
echo mysql_error();
}
}
	}
}else{

if ($function == "deletetopic") {
if ($gdtopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
?>
<tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width="100%" bgcolor=<?php echo $topicbgcolor; ?>><tr><td bgColor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2>
<center><br>
<form action="<?php echo("topic.php?TID=$TID&FID=$FID&deletetopic=$TID"); ?>" method=POST>
<input type=submit name="dtopic" value="Delete Topic">
</form>
<form action="<?php echo("topic.php?TID=$TID&FID=$FID"); ?>" method=POST>
<input type=submit name="ktopic" value="Keep Topic">
</form>
</center>
</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>
<?php
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to delete topics. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if (isset($deletetopic)) { 
if ($gdtopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
if (($sessionstatus == "admin") || ($sessionstatus == "Moderator")) {
$sql = "DELETE FROM ibb_replies " . 
"WHERE tid=$deletetopic"; 
if (mysql_query($sql)) { 
} else { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Error deleting topic's replies: " . 
mysql_error()) . "</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>"; 
?>
<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
<TBODY>
<TR>
<TD vAlign=top>
<?php
} 
$sql = "DELETE FROM ibb_threads " . 
"WHERE tid=$deletetopic"; 
if (mysql_query($sql)) { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Topic deleted successfully. You are now being redirected.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
$sql = "DELETE FROM ibb_replies " . 
"WHERE tid=$deletetopic"; 
if (mysql_query($sql)) {
}else{
	echo mysql_error();
}
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=<?php echo("viewforum.php?FID=$FID"); ?>">
<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
<TBODY>
<TR>
<TD vAlign=top>
<?php
} else { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Error deleting topic: " . 
mysql_error()) . "</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>"; 
?>
<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
<TBODY>
<TR>
<TD vAlign=top>
<?php
} 
}else{
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You are not authorized to delete topics/replies.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
}
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to delete topics. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if ($function == "deletereply") {
if ($gdreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
?>
<tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width="100%" bgcolor=<?php echo $topicbgcolor; ?>><tr><td bgColor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2>
<center><br>
<form action="<?php echo("topic.php?TID=$TID&FID=$FID&deletereply=$RID"); ?>" method=POST>
<input type=submit name="dreply" value="Delete Reply">
</form>
<form action="<?php echo("topic.php?TID=$TID&FID=$FID"); ?>" method=POST>
<input type=submit name="kreply" value="Keep Reply">
</form>
</center>
</td></tr></table></TD></TR></tbody></table></TD></TR>
<?php
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to delete replies. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if (isset($deletereply)) { 
if ($gdreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
if (($sessionstatus == "admin") || ($sessionstatus == "Moderator")) {
$sql = "DELETE FROM ibb_replies " . 
"WHERE rid=$deletereply"; 
if (mysql_query($sql)) { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Reply deleted successfully. You are now being redirected.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="0;URL=<?php echo("$PHP_SELF?&TID=$TID&FID=$FID"); ?>">
<?php
} else { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Error deleting reply: " . 
mysql_error() . 
"</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>"); 
} 
}else{
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You are not authorized to delete replies.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="0;URL=<?php echo($PHP_SELF); ?>">
<?php
}
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to delete replies. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if (isset($edittopic)) {
if (($gedittopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") && $sessionuser != "Guest") {
$result = mysql_query("SELECT * FROM ibb_threads WHERE tid='$TID' ORDER BY tid desc");
while ( $row = mysql_fetch_array($result) ) { 
$name = $row["name"];
$subject = $row["subject"]; 
$messege = $row["description"];
}
$query = "SELECT status FROM ibb_members WHERE name='$name'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$usersstatus = $row[0];
if ($usersstatus == "admin" && $sessionuser != $name) {
	if (($gadminedit == "no" || $gadminedit == "") && $sessionstatus != "admin") {
		echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to edit an Administrator's topic. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
		?>
		<META HTTP-EQUIV="Refresh" 
		CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
		<?php
	}
}else{
if (($sessionuser == $name && $geditownposts == "yes") || ($sessionstatus == "admin") || ($sessionstatus == "Moderator")) {
?>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor="<?php echo $topicbgcolor; ?>"
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><B>Your Username:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><?php 
		if ($sessionuser == "Guest") {
			echo "A Guest";
		}else{
			echo $sessionuser; } 
			echo (" (Posted By $name)"); ?></FONT></TD></TR>
        <TR bgColor=<?php echo $topictopbarbgcolor; ?>>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FORM ACTION="<?php echo("topic.php?FID=$FID&TID=$TID"); ?>" METHOD=POST name=edittopic><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><B>Subject:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><INPUT class=bginput tabIndex=1 maxLength=85 size=40 
            name=subjectone value="<?php echo $subject; ?>"></FONT></TD></TR>
        <TR>
          <TD vAlign=top bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><B>Mood:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2>
<input type="radio" name="images" value="images/smile.gif" checked><img src="images/smile.gif"> 
<input type="radio" name="images" value="images/sad.gif"><img src="images/sad.gif"> 
<input type="radio" name="images" value="images/mad.gif"><img src="images/mad.gif"> 
<input type="radio" name="images" value="images/biggrin.gif"><img src="images/biggrin.gif"> 
<input type="radio" name="images" value="images/slant.gif"><img src="images/slant.gif"> 
<input type="radio" name="images" value="images/wink.gif"><img src="images/wink.gif"> </FONT></TD></TR>
        <TR>
          <TD noWrap bgColor=<?php echo $topictopbarbgcolor; ?>>
            <P><center>
<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="<?php echo $topicbgcolor; ?>">
<TR>
<TD height=10 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2>Emoticons</center>
</TD>
</TR>
<TR>
<TD height=90 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?> valign=center>
<center>
<a href="javascript:void(0);" onclick="edittopic.bla.value=edittopic.bla.value +':)';"><img src="images/smile.gif" border=0></a> 
<a href="javascript:void(0);" onclick="edittopic.bla.value=edittopic.bla.value +':(';"><img src="images/sad.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="edittopic.bla.value=edittopic.bla.value +':mad:';"><img src="images/mad.gif" border=0></a> 
<a href="javascript:void(0);" onclick="edittopic.bla.value=edittopic.bla.value +':D';"><img src="images/biggrin.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="edittopic.bla.value=edittopic.bla.value +':-/';"><img src="images/slant.gif" border=0></a> 
<a href="javascript:void(0);" onclick="edittopic.bla.value=edittopic.bla.value +';)';"><img src="images/wink.gif" border=0></a>
</center>
</TD>
</TR>
</Table></center></FONT></P></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=bla rows=10 wrap=virtual cols=60><?php echo $messege; ?></TEXTAREA>
			</TD></TR>
			</TBODY></TABLE></TD></TR>
			<TR><TD bgColor=<?php echo $topictopbarbgcolor; ?> colspan=2><center>
          <INPUT type=submit value="Submit Editted Thread" name=edittedtopic></center></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><br>
<TABLE cellSpacing=0 cellPadding=2 width="760" border=0>
<TBODY>
<?php
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to edit topics. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to edit topics. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if ($edittedtopic == "Submit Editted Thread") {

$bla = str_replace("
", "[br]", $bla);

$sql = "UPDATE ibb_threads SET " .
"subject='$subjectone'," .
"description='$bla'," . 
"image='$images'," . 
"time='Editted on: $thetime'" . 
"WHERE tid=$TID";
if (mysql_query($sql)) { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Topic is now editted. You are being redirected.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
<?php
} else { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Error editing topic: " . 
mysql_error() . "</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>"); 
} 
}else{

if (isset($editreply)) {
if (($geditreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") && $sessionuser != "Guest") {
$result = mysql_query("SELECT * FROM ibb_replies WHERE rid='$editreply'");
while ( $row = mysql_fetch_array($result) ) { 
$name = $row["name"];
$subject = $row["subject"]; 
$replymessege = $row["description"];
}
$query = "SELECT status FROM ibb_members WHERE name='$name'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$usersstatus = $row[0];
if ($usersstatus == "admin" && $sessionuser != $name) {
	if (($gadminedit == "no" || $gadminedit == "") && $sessionstatus != "admin") {
		echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to edit an Administrator's reply. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
		?>
		<META HTTP-EQUIV="Refresh" 
		CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
		<?php
	}
}else{
if ($sessionuser != "Guest" && ($sessionuser == $name && $geditownposts == "yes") || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
?>
<TABLE cellSpacing=0 cellPadding=0 width="760" align=center bgColor=<?php echo $topicbgcolor; ?> 
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><B>Your Username:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2><?php 
		if ($sessionuser == "Guest") {
			echo "A Guest";
		}else{
			echo $sessionuser; } ?></FONT></TD></TR>
          <TD noWrap bgColor=<?php echo $topictopbarbgcolor; ?>>
            <P><center>
<FORM ACTION="<?php echo("topic.php?FID=$FID&TID=$TID&RID=$editreply"); ?>" METHOD=POST name=newtopic>
<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="#000000">
<TR>
<TD height=10 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=2>Emoticons</center>
</TD>
</TR>
<TR>
<TD height=90 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?> valign=center>
<center>
<a href="javascript:void(0);" onclick="newtopic.message.value=newtopic.message.value +':)';"><img src="images/smile.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newtopic.message.value=newtopic.message.value +':(';"><img src="images/sad.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="newtopic.message.value=newtopic.message.value +':mad:';"><img src="images/mad.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newtopic.message.value=newtopic.message.value +':D';"><img src="images/biggrin.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="newtopic.message.value=newtopic.message.value +':-/';"><img src="images/slant.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newtopic.message.value=newtopic.message.value +';)';"><img src="images/wink.gif" border=0></a>
</center>
</TD>
</TR>
</Table></center></FONT></P></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=bla rows=10 wrap=virtual cols=60><?php echo $replymessege; ?></TEXTAREA>
			</TD></TR>
			</TBODY></TABLE></TD></TR>
			<TR><TD bgColor=<?php echo $topictopbarbgcolor; ?> colspan=2><center>
          <INPUT type=submit value="Submit Editted Reply" name=edittedreply></center></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
<TABLE cellSpacing=0 cellPadding=2 width="760" border=0>
<TBODY>
<?php
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to edit replies. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}
}else{
	echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to edit replies. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
	?>
	<META HTTP-EQUIV="Refresh" 
	CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
	<?php
}
}else{

if ($edittedreply == "Submit Editted Reply") {

$bla = str_replace("
", "[br]", $bla);

$sql = "UPDATE ibb_replies SET " .
"description='$bla'," . 
"time='Editted on: $thetime'" . 
"WHERE rid=$RID";
if (mysql_query($sql)) { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Reply is now editted. You are being redirected.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
<?php
} else { 
echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>Error editing Reply: " . 
mysql_error() . "</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>"); 
} 
}else{

if ($function == "pintopic") {
	if ($gptopics == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") {
		?>
		<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width="100%" bgcolor=<?php echo $topicbgcolor; ?>><tr><td bgColor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2>
		<?php
		$query = "SELECT pin FROM ibb_threads WHERE tid='$TID'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$currentpin = $row[0];
		if (($currentpin == "") || ($currentpin == "no")) {
			$sql = "UPDATE ibb_threads SET pin='yes' WHERE tid='$TID'";
			if (mysql_query($sql)) {
				echo("Topic is now pinned. You are being redirected.");
				?>
				<META HTTP-EQUIV="Refresh" 
				CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
				<?php
			}else{
				echo(mysql_error());
			}
		}else{
			$sql = "UPDATE ibb_threads SET pin='no' WHERE tid='$TID'";
			if (mysql_query($sql)) {
				echo("Topic is now UnPinned. You are being redirected.");
				?>
				<META HTTP-EQUIV="Refresh" 
				CONTENT="0;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
				<?php
			}else{
				echo(mysql_error());
			}
		}
		?>
		</font></center></td></tr></tbody></table></td></tr></tbody></table></td></tr>
		<?php
	}else{
		echo("<TR><TD colspan=2><tr><td colspan=2><TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center bgColor=#000000 border=0><tr><td><table cellspacing=1 cellpadding=2 width=\"100%\" bgcolor=$topicbgcolor><tr><td bgColor=$topictopbarbgcolor><center><FONT face=\"$font\" color=\"$topictopbartxtcolor\" size=2>You do not have the proper credentials to pin and unpin topics. Redirecting to topic.</FONT></center></td></tr></table></TD></TR></tbody></table></TD></TR>");
		?>
		<META HTTP-EQUIV="Refresh" 
		CONTENT="2;URL=<?php echo("$PHP_SELF?FID=$FID&TID=$TID"); ?>">
		<?php
	}
}else{
if ($function != "pintopic") {
?><tr><td colspan=2>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor="<?php echo $topicbgcolor; ?>" border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
              <TR>
                <TD noWrap width=175 bgColor="<?php echo $topictopbarbgcolor; ?>"><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=1><B>User 
                  ID</B></FONT></TD>
                <TD width="100%" bgColor="<?php echo $topictopbarbgcolor; ?>">
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 bgColor="<?php echo $topictopbarbgcolor; ?>">
                    <TBODY>
                    <TR bgColor="<?php echo $topictopbarbgcolor; ?>">
                      <TD width="20%" bgColor="<?php echo $topictopbarbgcolor; ?>"><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=1><B>Message</B></FONT></TD>
                      <TD width="80%">
                        <P align=right>&nbsp;&nbsp;<FONT face="<?php echo $font; ?>" color=<?php echo $topictopbartxtcolor; ?> size=3><?php if (($gpostreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") && $allowreplies != "no") { ?>
                         <A href="topic.php?<?php if ($t == "a") { ?>t=a&<?php } ?>FID=<?php echo "$FID&TID=$TID"; ?>&function=addreply""><img src="themes/<?php echo $theme1; ?>/images/newreply.gif" border=0></A><?php } ?></FONT></TD></TR></TBODY></TABLE></TD></TR>
<?php
if(!isset($start)) {
	$start="0";
}

if(!isset($perpage)) {
	$perpage="10";
}
 
if ($start <= "0") {
$result = mysql_query("SELECT * FROM ibb_threads WHERE tid='$TID'");
while ( $row = mysql_fetch_array($result) ) {
	$fid = $row["fid"];
	$tid = $row["tid"];
	$name = $row["name"];
	$topictime = $row["time"];
	$subject = $row["subject"];
	$messege = $row["description"];
	$isitapoll = $row["poll"];
	$topictimeline = $row["timeline"];
}

$result = mysql_query("SELECT * FROM ibb_members WHERE name='$name'") or die(mysql_error());
while ( $row = mysql_fetch_array($result) ) {
	$status = $row["status"];
	$title = $row["title"];
	$avatar = $row["aviator"];
	$apostcounts = $row["posts"];
	$threadmid = $row["mid"];
	$threademail = $row["email"];
	$signature = $row["signature"];
	$membersince = $row["time"];
	$memberlocation = $row["location"];
	$topicusergroup = $row["groupname"];
	$topicavheight = $row["avheight"];
	$topicavwidth = $row["avwidth"];
	if (($topicavheight == "") || ($topicavwidth == "")) {
		$topicavheight = $savheight;
		$topicavwidth = $savwidth;
	}
}

$resultt = mysql_query("SELECT * FROM ibb_onlineusers WHERE username='$name'") or die(mysql_error());
while ( $row = mysql_fetch_array($resultt) ) {
	$pagename = $row["pagename"];
	$onlinelocation = $row["location"];
}

if (!$signature) {
	$signature = "My signature.";
}

if (!$membersince) {
	$membersince = "Forever";
}

$timetitle = substr($topictime, 0,12);

//gets rid of the beginning part of the date
$topictime = eregi_replace("Posted On: ", "", $topictime);
$topictime = eregi_replace("Editted On: ", "", $topictime);
$topictime = eregi_replace("Replied On: ", "", $topictime);

$query = "SELECT count(*) FROM ibb_threads WHERE name='$name'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$post = $row[0];

$query = "SELECT allowhtml FROM ibb_forums WHERE FID='$FID'";
$toto = mysql_query($query);
$bob = mysql_fetch_row($toto);
$allowhtml = $bob[0];

$query = "SELECT image FROM ibb_threads WHERE tid='$TID'";
$toto = mysql_query($query);
$bob = mysql_fetch_row($toto);
$timage = $bob[0];

if ($membersince == "Forever") {
	$membersincet=$membersince;
}else{
}
//gets rid of the beginning part of the date
$servertime = $topictime;

$servertimemonth = substr($servertime, 0,2);
$servertimeday = substr($servertime, 3,2);
$servertimeyear = substr($servertime, 6,4);
$servertimehour = substr($servertime, 11,2);
$servertimemin = substr($servertime, 14,2);
$servertimesec = substr($servertime, 17,2);
$servertimehour = $servertimehour + $timepreference;

//does all the processing of the time to comply with the user's time offset
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

if ($servertimehour < "10") {
	$servertimehour = "0$servertimehour";
}

$time = "Date: $servertimemonth/$servertimeday/$servertimeyear $servertimehour:$servertimemin:$servertimesec";

$query = "SELECT count(*) FROM ibb_replies WHERE name='$name'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$thecount = $row[0];
if ($name == "Guest") {
	$status = "Guest";
	$title = "Guest";
}

//if board doesn't allow html, this gets rid of the tags
if($allowhtml == "no") {
	$messege = eregi_replace("<([^\\[]*)>", "",$messege);
}
$postcount = $thecount + $post;
if (($allowcode == "yes" && ($allowhtml == "yes" || $allowhtml == "no")) || ($t == "a")) {
	$messege = str_replace(":)", "<img src='./images/smile.gif'>", $messege);
	$messege = str_replace(":(", "<img src='./images/sad.gif'>", $messege);
	$messege = str_replace(":butt:", "<img src='./images/butt.gif'>", $messege);
	$messege = str_replace(":D", "<img src='./images/biggrin.gif'>", $messege);
	$messege = str_replace(":-/", "<img src='./images/slant.gif'>", $messege);
	$messege = str_replace(";)", "<img src='./images/wink.gif'>", $messege);
	$messege = str_replace(":mad:", "<img src='./images/mad.gif'>", $messege);
	$messege = str_replace(":laugh:", "<img src='./images/laugh.gif'>", $messege);
	$messege = str_replace(":cool:", "<img src='./images/cool.gif'>", $messege);
	$messege = str_replace(":weird:", "<img src='./images/weird.gif'>", $messege);
	$messege = str_replace(":rolleyes:", "<img src='./images/rolleyes.gif'>", $messege);
	$messege = str_replace(":tongue:", "<img src='./images/tongue.gif'>", $messege);
	$messege = str_replace("[center]", "<center>", $messege);
	$messege = str_replace("[/center]", "</center>", $messege);
	$messege = str_replace("[b]", "<b>", $messege);
	$messege = str_replace("[/b]", "</b>", $messege);
	$messege = str_replace("[i]", "<i>", $messege);
	$messege = str_replace("[/i]", "</i>", $messege);
	$messege = str_replace("[u]", "<u>", $messege);
	$messege = str_replace("[/u]", "</u>", $messege);
	$messege = preg_replace("/(\[code\])(.*)(\[\/code\])/e","htmlentities(\"\\2\")", $messege);
	$messege = eregi_replace("\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]", "<font color=\\1>\\2</font>", $messege);
	$messege = eregi_replace("\\[size=([^\\[]*)\\]([^\\[]*)\\[/size\\]", "<font size=\\1>\\2</font>", $messege);
	$messege = eregi_replace("\\[url=www.([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>\\2</a>", $messege);
	$messege = eregi_replace("\\[url=http://([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://\\1\" target=_blank>\\2</a>", $messege);
	$messege = str_replace("[quote]", "<i>", $messege);
	$messege = str_replace("[/quote]", "</i><br><br>", $messege);
}

if ($htmlsig == "no") {
	$signature = eregi_replace("<", "", $signature);
	$signature = eregi_replace(">", "", $signature);
}

if ($codesig == "yes") {
	$signature = str_replace(":)", "<img src='./images/smile.gif'>", $signature);
	$signature = str_replace(":(", "<img src='./images/sad.gif'>", $signature);
	$signature = str_replace(":butt:", "<img src='./images/butt.gif'>", $signature);
	$signature = str_replace(":D", "<img src='./images/biggrin.gif'>", $signature);
	$signature = str_replace(":-/", "<img src='./images/slant.gif'>", $signature);
	$signature = str_replace(";)", "<img src='./images/wink.gif'>", $signature);
	$signature = str_replace(":mad:", "<img src='./images/mad.gif'>", $signature);
	$signature = str_replace(":laugh:", "<img src='./images/laugh.gif'>", $signature);
	$signature = str_replace(":cool:", "<img src='./images/cool.gif'>", $signature);
	$signature = str_replace(":weird:", "<img src='./images/weird.gif'>", $signature);
	$signature = str_replace(":rolleyes:", "<img src='./images/rolleyes.gif'>", $signature);
	$signature = str_replace(":tongue:", "<img src='./images/tongue.gif'>", $signature);
	$signature = str_replace("[br]", "<br>", $signature);
	$signature = str_replace("[center]", "<center>", $signature);
	$signature = str_replace("[/center]", "</center>", $signature);
	$signature = str_replace("[b]", "<b>", $signature);
	$signature = str_replace("[/b]", "</b>", $signature);
	$signature = str_replace("[i]", "<i>", $signature);
	$signature = str_replace("[/i]", "</i>", $signature);
	$signature = str_replace("[u]", "<u>", $signature);
	$signature = str_replace("[/u]", "</u>", $signature);
	$signature = eregi_replace("\\[code\\]([^\\[]*)\\[/code\\]", htmlspecialchars("\\1"), $signature);
	$signature = eregi_replace("\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]", "<font color=\\1>\\2</font>", $signature);
	$signature = eregi_replace("\\[size=([^\\[]*)\\]([^\\[]*)\\[/size\\]", "<font size=\\1>\\2</font>", $signature);
	$signature = eregi_replace("\\[url=www.([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>\\2</a>", $signature);
	$signature = eregi_replace("\\[url=http://([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://\\1\" target=_blank>\\2</a>", $signature);
	$signature = str_replace("[quote]", "<i>", $signature);
	$signature = str_replace("[/quote]", "</i><br>", $signature);
	$signature = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $signature);
	$signature = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $signature);
}

if($htmltitles == "no") {
	$title = strip_tags($title);
}

$signature = str_replace("[br]", "<br>", $signature);
$messege = str_replace("[br]", "<br>", $messege);
$messege = str_replace(" fuck ", "****", $messege);
$messege = str_replace(" ass ", "***", $messege);
$messege = str_replace(" dick ", "****", $messege);
$messege = str_replace(" shit ", "****", $messege);
$messege = str_replace(" damn ", "****", $messege);

$messege = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $messege);
$messege = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $messege);

if (($threadmid == $imid) && ($name != "Guest") && ($name != "Administrator")) {
	?>
		<TR>
			<TD bgColor="<?php echo $topictopbarbgcolor; ?>" colspan=2>
				<center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2><?php echo $name; ?> is on your ignore list. Message will not be shown.</font></center>
<?php
}else{
?>
              <TR>
                <TD vAlign=top noWrap width=175 bgColor="<?php echo $topicleftbgcolor; ?>">
				<FONT face="<?php echo $font; ?>" color="<?php echo $topiclefttxtcolor; ?>" size=2><STRONG><?php echo $name; ?></STRONG></FONT></FONT><BR><?php
				if ($name != "Guest") { ?><FONT face="<?php echo $font; ?>" color="<?php echo $topiclefttxtcolor; ?>" size=1><?php echo $title; ?><BR><?php } ?>
<?php if ($t == "a") { }else{ ?>
<?php 
			if ($name == "Guest") {
				  echo ("<img src='images/guestavatar.gif' height=64 width=64>");
			}else{
				if ($avatar == "") {
				  echo ("<img src='images/noavatar.gif' height=64 width=64>");
				}else{
					echo ("<img src='$avatar' height=$topicavwidth width=$topicavheight>");
				} 
			}
?>
					
				<?php if ($name == "Guest") { }else{ ?><BR></FONT><FONT face="<?php echo $font; ?>" color="<?php echo $topiclefttxtcolor; ?>" size=1>
					Group: <?php echo $topicusergroup; ?>
				  <BR>Registered: <? echo $membersince; ?>
				  <BR>Location: <?php echo $memberlocation; ?>
				  <BR>Total Posts: 
                  <?php echo $apostcounts; ?><BR>Active Posts: <?php echo $postcount; } } ?></FONT><?php } ?></TD>
                <TD vAlign=top width="100%" bgColor="<?php echo $topicmainbgcolor; ?>"><FONT face="<?php echo $font; ?>" color="<?php echo $topiclefttxtcolor; ?>" size=1>
<?php if ($t == "a") { }else{ 
if ($timage == "") {
}else{
?>
<img src="<?php echo($timage); ?>">
<? } } ?>&nbsp;<STRONG><?php echo $subject; ?></STRONG></FONT> 
                  <P><FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=2><?php if ($isitapoll == "yes") { 
					$query = "select count(*) from ibb_poll_votes WHERE pollid='$pid'";
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
					$totalvotes = $row[0];
					?>
					<center><TABLE cellSpacing=1 cellPadding=3 width="95%" border=0 bgcolor=<?php echo $topicbgcolor; ?>>
									<TBODY>
									<TR bgcolor=<?php echo $topictopbarbgcolor; ?>>
									  <TD colspan=2>
										<FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2><center><?php echo $subject; ?><br><font size=1>Total Votes: <?php echo $totalvotes; ?></center></td></tr>
				<?php 
					$result = mysql_query("SELECT mid FROM ibb_poll_votes WHERE pollid='$pid' && mid='$usermid'");
							while ( $row = mysql_fetch_array($result) ) {
								$umid = $row["mid"];
							}
					if ($umid == $usermid && $sessionuser != "Guest") {
					$choices = explode("*-*!!*-*", $choices); 
					foreach ($choices as $choice) { 
							$result = mysql_query("SELECT * FROM ibb_poll_votes WHERE pollid='$pid'");
							while ( $row = mysql_fetch_array($result) ) {
								$voteid = $row["voteid"];
								$votemid = $row["mid"];
							}
							$query = "select count(*) from ibb_poll_votes WHERE pollid='$pid' && choice='$choice'";
							$result = mysql_query($query);
							$row = mysql_fetch_row($result);
							$totalvotesasthis = $row[0];
							$decimal = $totalvotesasthis / $totalvotes;
							$imagesize = getimagesize("themes/$theme1/images/pollbar.gif");
							$oldimagewidth = $imagesize[0];
							$percent = $decimal * 100;
							$percent = round($percent, 1);
							$imagewidth = ($oldimagewidth * $decimal) * 55;
							?>
							<TR bgcolor=<?php echo $topicmainbgcolor; ?>><td width="25%">
							<FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=1><?php
							echo "$choice ($totalvotesasthis Votes)</font></td><td width=\"*\"><img src='themes/$theme1/images/pollbar.gif' width=$imagewidth height=10> <FONT face=\"$font\" color=\"$topicmaintxtcolor\" size=1>$percent%<br></font>"; ?></td></tr></center><?php
					}
					}else if ($sessionuser != "Guest"){
						?><FORM action="<?php echo "topic.php?TID=$TID&FID=$FID&PID=$pid"; ?>" method=POST>
									<?php
									$count = 0;
									$choices = explode("*-*!!*-*", $choices); 
									foreach ($choices as $choice) { 
										$count++
										?>
										<TR bgcolor=<?php echo $topicmainbgcolor; ?>>
										  <TD width="8%">
											<FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=2><center><INPUT TYPE="radio" NAME="userschoice" value="<?php echo $choice; ?>">
										  </TD>
										  <TD width="*">
											<FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=2><?php echo "Option $count: $choice"; ?>
										  </TD>
										</TR>
										<?php
									}
									?>
									<TR bgcolor=<?php echo $topicbrightbgcolor; ?>><td colspan=2>
									<FONT face="<?php echo $font; ?>" color="<?php echo $topicbrighttxtcolor; ?>" size=2><center>
									<input type=Submit name=Submit value="Submit Vote"></td></tr>
									</FORM>
									</TBODY>
						<?php
					}else if ($sessionuser == "Guest"){
						?>
						<TR bgcolor=<?php echo $topicmainbgcolor; ?>><td>
						<FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=2><center>
						<?php
						echo "You must be logged in in order to participate in a poll.<br>Click <a href=\"index.php?function=login\">here</a> to log in.<br>Click <a href=\"index.php?function=register\">here</a> to register.";
						?></td></tr></center><?php
					}
				echo "</TABLE></center><br>";
				} 
				echo $messege; if ($t == "a") { }else if ($name != "Guest"){ echo ("<BR><BR><BR>------------------------------------<BR>$signature"); } ?></FONT></P></TD></TR>
              <?php if ($t == "a") { }else{ ?><TR>
                <TD noWrap width=175 bgColor="<?php echo $topicbleftbgcolor; ?>" height=16>
					<FONT face=<?php echo $font; ?> color="<?php echo $topicblefttxtcolor; ?>" size=1><?php echo $time; ?></FONT></TD>
                <TD vAlign=center width="100%" bgColor="<?php echo $topicbrightbgcolor; ?>" height=16>
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                    <TBODY>
                    <TR vAlign=bottom>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $topicbrighttxtcolor; ?>" size=1>
					  <?php if ($name != "Guest") { if (!$pagename) { }else{ ?>[<a href="javascript:void(0);" onclick="return overlib('<a href=\'<?php echo $onlinelocation; ?>\'><?php echo $pagename; ?></a>', STICKY, CAPTION, '<?php echo $name; ?>\'s Online Status', CENTER);" onmouseout="nd();"><font color=<?php echo $topiclinkcolor; ?>>User's Status</font></a>] <?php } ?>[<?php echo ("<a href=\"member.php?MID=$threadmid\">"); ?><font color=<?php echo $topiclinkcolor; ?>>View Profile</font></a>]</FONT><?php } ?></TD>
                      <TD noWrap align=right><FONT face="<?php echo $font; ?>" color="<?php echo $topicbrighttxtcolor; ?>" size=1>
						<?php if (($sessionstatus == "admin") || ($sessionstatus == "Moderator")) { 
							?>
							 [<a href="topic.php?<?php echo ("FID=$FID&TID=$TID&function=pintopic"); ?>"><font color=<?php echo $topiclinkcolor; ?>>Pin/UnPin Topic</font></a>]
						<?php 
						} 
						if (($sessionstatus == "admin") || ($sessionstatus == "Moderator")) { 
							?>
							[<a href="topic.php?<?php echo ("FID=$FID&TID=$TID&function=deletetopic"); ?>"><font color=<?php echo $topiclinkcolor; ?>>Delete Topic</font></a>]
							<?php 
						} 
						if (($sessionstatus == "admin" || $sessionstatus == "Moderator" || $sessionuser == $name) && $sessionuser != "Guest") { 
							?> 
							[<A HREF='topic.php<?php echo "?TID=$TID&FID=$FID&edittopic=$TID"; ?>'><font color=<?php echo $topiclinkcolor; ?>>Edit Topic</font></a>] 
							[<A HREF='topic.php<?php echo "?TID=$TID&FID=$FID&function=movetopic"; ?>'><font color=<?php echo $topiclinkcolor; ?>>Move Topic</font></a>]
							<?php 
						} ?></FONT></TD></TR></TBODY></TABLE><?php } ?></TD></TR>
<?php
if ($function == "addreply") {
	echo ("<TR><TD bgcolor=$topictopbarbgcolor colspan=2><FONT face=$font color=\"$topictopbartxtcolor\" size=2><center>Replies<br><font size=1>Sorted From Newest To Oldest</font></font></center></TD></TR>");
}
}
}

$unpinned = mysql_query("SELECT * FROM ibb_replies WHERE tid='$TID' and fid<>'T' ORDER BY rid $orderby LIMIT $start, $perpage");
while ( $row = mysql_fetch_array($unpinned) ) { 
	$tid = $row["tid"]; 
	$rid = $row["rid"]; 
	$replytime= $row["time"];
	$name = $row["name"];
	$messege = $row["description"];
	if ($name == "Guest") {
		$status = "Guest";
		$title = "Guest";
	}

$resultt = mysql_query("SELECT * FROM ibb_onlineusers WHERE username='$name'") or die(mysql_error());
while ( $row = mysql_fetch_array($resultt) ) {
	$pagename2 = $row["pagename"];
	$onlinelocation2 = $row["location"];
	$onlineusername2 = $row["username"];
}

$result = mysql_query("SELECT * FROM ibb_members WHERE name='$name'") or die(mysql_error());
while ( $row = mysql_fetch_array($result) ) {
	$status = $row["status"];
	$title = $row["title"];
	$aviator = $row["aviator"];
	$postcounts = $row["posts"];
	$threadmid = $row["mid"];
	$threademail = $row["email"];
	$signature1 = $row["signature"];
	$membersince = $row["time"];
	$memberlocation = $row["location"];
	$replyusergroup = $row["groupname"];
	$topicavheight = $row["avheight"];
	$topicavwidth = $row["avwidth"];
	if (($topicavheight == "") || ($topicavwidth == "")) {
		$topicavheight = $savheight;
		$topicavwidth = $savwidth;
	}
}

$timetitle = substr($replytime, 0,12);

//gets rid of the beginning part of the date
$replytime = eregi_replace("Posted On: ", "", $replytime);
$replytime = eregi_replace("Editted On: ", "", $replytime);
$replytime = eregi_replace("Replied On: ", "", $replytime);

$servertime = $replytime;

$servertimemonth = substr($servertime, 0,2);
$servertimeday = substr($servertime, 3,2);
$servertimeyear = substr($servertime, 6,4);
$servertimehour = substr($servertime, 11,2);
$servertimemin = substr($servertime, 14,2);
$servertimesec = substr($servertime, 17,2);
$servertimehour = $servertimehour + $timepreference;

//does all the processing of the time to comply with the user's time offset
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

if ($servertimehour < "10") {
	$servertimehour = "0$servertimehour";
}

$time = "Date: $servertimemonth/$servertimeday/$servertimeyear $servertimehour:$servertimemin:$servertimesec";

if (!$membersince) {
	$membersince = "Forever";
}

if (!$signature) {
	$signature = "My signature.";
}

$messege = eregi_replace("<script([^\\[]*)</script>", "",$messege);

$query = "SELECT count(*) FROM ibb_threads WHERE name='$name'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$apost = $row[0];

$query = "SELECT image FROM ibb_threads WHERE tid='$TID'";
$toto = mysql_query($query);
$bob = mysql_fetch_row($toto);
$timage = $bob[0];

$query = "SELECT count(*) FROM ibb_replies WHERE name='$name'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$athecount = $row[0];

$apostcount = $athecount + $apost;

if ($name == "Guest") {
	$status = "Guest";
	$title = "Guest";
}
//if board doesn't allow html, this gets rid of the tags
if($allowhtml == "no") {
	$messege = eregi_replace("<([^\\[]*)>", "",$messege);
	$messege = eregi_replace("&lt;([^\\[]*)&lt;", "",$messege);
}

if($htmltitles == "no") {
	$title = eregi_replace("<([^\\[]*)>", "",$title);
	$title = eregi_replace("&lt;([^\\[]*)&lt;", "",$title);
}

if (($allowcode == "yes") || ($t == "a")) {
	$messege = str_replace(":)", "<img src='./images/smile.gif'>", $messege);
	$messege = str_replace(":(", "<img src='./images/sad.gif'>", $messege);
	$messege = str_replace(":butt:", "<img src='./images/butt.gif'>", $messege);
	$messege = str_replace(":D", "<img src='./images/biggrin.gif'>", $messege);
	$messege = str_replace(":-/", "<img src='./images/slant.gif'>", $messege);
	$messege = str_replace(";)", "<img src='./images/wink.gif'>", $messege);
	$messege = str_replace(":mad:", "<img src='./images/mad.gif'>", $messege);
	$messege = str_replace(":laugh:", "<img src='./images/laugh.gif'>", $messege);
	$messege = str_replace(":cool:", "<img src='./images/cool.gif'>", $messege);
	$messege = str_replace(":weird:", "<img src='./images/weird.gif'>", $messege);
	$messege = str_replace(":rolleyes:", "<img src='./images/rolleyes.gif'>", $messege);
	$messege = str_replace(":tongue:", "<img src='./images/tongue.gif'>", $messege);
	$messege = str_replace("[center]", "<center>", $messege);
	$messege = str_replace("[/center]", "</center>", $messege);
	$messege = str_replace("[b]", "<b>", $messege);
	$messege = str_replace("[/b]", "</b>", $messege);
	$messege = str_replace("[i]", "<i>", $messege);
	$messege = str_replace("[/i]", "</i>", $messege);
	$messege = str_replace("[u]", "<u>", $messege);
	$messege = str_replace("[/u]", "</u>", $messege);
	$messege = preg_replace("/(\[code\])(.*)(\[\/code\])/e","htmlentities(\"\\2\")", $messege);
	$messege = eregi_replace("\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]", "<font color=\\1>\\2</font>", $messege);
	$messege = eregi_replace("\\[size=([^\\[]*)\\]([^\\[]*)\\[/size\\]", "<font size=\\1>\\2</font>", $messege);
	$messege = eregi_replace("\\[url=www.([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>\\2</a>", $messege);
	$messege = eregi_replace("\\[url=http://([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://\\1\" target=_blank>\\2</a>", $messege);
	$messege = str_replace("[quote]", "<i>", $messege);
	$messege = str_replace("[/quote]", "</i><br><br>", $messege);
}

if ($htmlsig == "no") {
	$signature1 = eregi_replace("<([^\\[]*)>", "",$signature1);
	$signature1 = eregi_replace("&lt;([^\\[]*)&lt;", "",$signature1);
}

if ($codesig == "yes") {
	$signature1 = str_replace(":)", "<img src='./images/smile.gif'>", $signature1);
	$signature1 = str_replace(":(", "<img src='./images/sad.gif'>", $signature1);
	$signature1 = str_replace(":butt:", "<img src='./images/butt.gif'>", $signature1);
	$signature1 = str_replace(":D", "<img src='./images/biggrin.gif'>", $signature1);
	$signature1 = str_replace(":-/", "<img src='./images/slant.gif'>", $signature1);
	$signature1 = str_replace(";)", "<img src='./images/wink.gif'>", $signature1);
	$signature1 = str_replace(":mad:", "<img src='./images/mad.gif'>", $signature1);
	$signature1 = str_replace(":laugh:", "<img src='./images/laugh.gif'>", $signature1);
	$signature1 = str_replace(":cool:", "<img src='./images/cool.gif'>", $signature1);
	$signature1 = str_replace(":weird:", "<img src='./images/weird.gif'>", $signature1);
	$signature1 = str_replace(":rolleyes:", "<img src='./images/rolleyes.gif'>", $signature1);
	$signature1 = str_replace(":tongue:", "<img src='./images/tongue.gif'>", $signature1);
	$signature1 = str_replace("[center]", "<center>", $signature1);
	$signature1 = str_replace("[/center]", "</center>", $signature1);
	$signature1 = str_replace("[b]", "<b>", $signature1);
	$signature1 = str_replace("[/b]", "</b>", $signature1);
	$signature1 = str_replace("[i]", "<i>", $signature1);
	$signature1 = str_replace("[/i]", "</i>", $signature1);
	$signature1 = str_replace("[u]", "<u>", $signature1);
	$signature1 = str_replace("[/u]", "</u>", $signature1);
	$signature1 = eregi_replace("\\[code\\]([^\\[]*)\\[/code\\]", htmlentities("\\1"), $signature1);
	$signature1 = eregi_replace("\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]", "<font color=\\1>\\2</font>", $signature1);
	$signature1 = eregi_replace("\\[size=([^\\[]*)\\]([^\\[]*)\\[/size\\]", "<font size=\\1>\\2</font>", $signature1);
	$signature1 = eregi_replace("\\[url=www.([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>\\2</a>", $signature1);
	$signature1 = eregi_replace("\\[url=http://([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://\\1\" target=_blank>\\2</a>", $signature1);
	$signature1 = str_replace("[quote]", "<i>", $signature1);
	$signature1 = str_replace("[/quote]", "</i><br>", $signature1);
	$signature1 = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $signature1);
	$signature1 = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $signature1);
}

$messege = str_replace("[br]", "<br>", $messege);
$signature1 = str_replace("[br]", "<br>", $signature1);
$messege = eregi_replace("fuck ", "****", $messege);
$messege = eregi_replace("ass ", "***", $messege);
$messege = eregi_replace("dick", "****", $messege);
$messege = eregi_replace("shit", "****", $messege);
$messege = eregi_replace("damn", "****", $messege);

$messege = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $messege);
$messege = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $messege);
if (($threadmid == $imid) && ($name != "Guest") && ($name != "Administrator")) {
	?>
		<TR>
			<TD bgColor=<?php echo $topictopbarbgcolor; ?> colspan=2>
				<center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2><?php echo $name; ?> is on your ignore list. Message will not be shown.</font></center>
				<?php
				}else{
				?>
	    <TR>
                <TD vAlign=top noWrap width=175 bgColor=<?php echo $topicleftbgcolor; ?>>
					<FONT face=<?php echo $font; ?> color=<?php echo $topiclefttxtcolor; ?> size=2><STRONG><?php echo $name; ?></STRONG></FONT></FONT><BR>
					<?php if ($name != "Guest") { ?><FONT face=<?php echo $font; ?> color=<?php echo $topiclefttxtcolor; ?> size=1><?php echo $title; ?><BR><?php } ?>
					<?php 
								if ($name == "Guest") {
									  echo ("<img src='images/guestavatar.gif' height=64 width=64>");
								}else{
									if (($aviator == "") || ($aviator == "You do not have an avatar yet.")) {
									  echo ("<img src='images/noavatar.gif' height=64 width=64>");
									}else{
										echo ("<img src='$aviator' height=$topicavwidth width=$topicavheight>");
									} 
								}
					?>
				<?php if ($name == "Guest") { }else{ ?><BR></FONT><FONT face=<?php echo $font; ?> color=<?php echo $topiclefttxtcolor; ?> size=1>
				  Group: <?php echo $replyusergroup; ?>
				  <BR>Registered: <?php echo $membersince; ?>
				  <BR>Location: <?php echo $memberlocation; ?>
				  <BR>Total Posts: 
                  <?php echo $postcounts; ?><BR>Active Posts: <?php echo $apostcount; } ?></FONT></TD>
                <TD vAlign=top width="100%" bgColor=<?php echo $topicmainbgcolor; ?>>
                  <P><FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=2>
					<?php echo ("$messege"); if ($name != "Guest") { echo ("<BR><BR><BR>------------------------------------<BR>$signature1"); } ?></FONT></P>
            </TD></TR>
              <TR>
                <TD noWrap width=175 bgColor=<?php echo $topicbleftbgcolor; ?> height=16><FONT face=<?php echo $font; ?> color=<?php echo $topicblefttxtcolor; ?> size=1><?php echo $time; ?></FONT></TD>
                <TD vAlign=center width="100%" bgcolor=<?php echo $topicbrightbgcolor; ?> height=16>
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                    <TBODY>
                    <TR vAlign=bottom>
                      <TD bgcolor=<?php echo $topicbrightbgcolor; ?>>
					  <?php if ($name != "Guest" ) { ?>
					  <FONT face="<?php echo $font; ?>" color="<?php echo $topicbrighttxtcolor; ?>" size=1>
					  [<a href="javascript:void(0);" onclick="return overlib('<a href=\'<?php echo $onlinelocation2; ?>\'><?php echo $pagename2; ?></a>', STICKY, CAPTION, '<?php echo $name; ?>\'s Online Status', CENTER);" onmouseout="nd();"><font color=<?php echo $topiclinkcolor; ?>>User's Status</font></a>] [<a href="member.php?MID=<?php echo $threadmid; ?>">
						<font color=<?php echo $topiclinkcolor; ?>>View Profile</font></a>]</FONT><?php } ?></TD>
                      <TD noWrap align=right valign=top><FONT face="<?php echo $font; ?>" color="<?php echo $topicbrighttxtcolor; ?>" size=1><?php if (($sessionstatus == "admin") || ($sessionstatus == "Moderator")) 	{ ?>[<a href="topic.php?<?php echo ("FID=$FID&TID=$TID&RID=$rid&function=deletereply"); ?>"><font color=<?php echo $topiclinkcolor; ?>>Delete Reply</font></a>] <?php } if (($sessionstatus == "admin") || ($sessionstatus == "Moderator") || ($sessionuser == $name) && $sessionuser != "Guest") { ?>[<?php echo ("<A HREF='$PHP_SELF?TID=$TID&FID=$FID&editreply=$rid'><font color=$topiclinkcolor>Edit Reply</a>");  ?>]<?php } ?></FONT></TD></TR></TBODY></TABLE></TD></TR>
<?php
}
}
$actualtimeh = date("h");
$actualtimeht = $actualtimeh + $timepreference;
$actualtime = date("$actualtimeht:i:s:A");
?>
</TBODY></TABLE></TD></TR>
</TBODY></TABLE>
<?php 
} 
}
}
}
}
}
}
}
}
}
}
}
}
?>
          
<TR>
          <TD vAlign=top><FONT face="<?php echo $font; ?>" size=1 color="<?php echo $topictxtcolor; ?>">Page: <?php echo $pages; ?></FONT></TD><TD vAlign=bottom align=right><FONT face=Tahoma size=2><?php if (($gpostreplies == "yes" || $sessionstatus == "admin" || $sessionstatus == "Moderator") && $allowreplies != "no") { ?>
                         <A href="topic.php?<?php if ($t == "a") { ?>t=a&<?php } ?>FID=<?php echo "$FID&TID=$TID"; ?>&function=addreply""><img src="themes/<?php echo $theme1; ?>/images/newreply.gif" border=0></A><?php } ?></TD></tr>
<tr><TD align=right colspan=3><FONT face="Tahoma, Verdana, Arial" size=1>
</FONT>
<?php
}else{
?><br>
<TABLE cellSpacing=1 cellPadding=2 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
        <TBODY>
        <TR>
          <TD vAlign=top bgColor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2>This topic is either locked or you do not have the proper credentials to view it.</font></td></tr></tbody></table><br>
<?php
}
}else{
?><br>
<TABLE cellSpacing=1 cellPadding=2 width="100%" align=center border=0 bgcolor=<?php echo $topicbgcolor; ?>>
        <TBODY>
        <TR>
          <TD vAlign=top bgColor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" size=2>This topic is either locked or you do not have the proper credentials to view it.</font></td></tr></tbody></table><br>
<?php
}
include "footer.php";
echo $copyrights;


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>