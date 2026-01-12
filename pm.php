<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


include ("header.php");

//sets the title correctly and puts it in the onlineusers table
$ptitle = "$boardname - Private Messenging";
echo ("<title>$ptitle</title>");
$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}

?>
<br>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" bgColor=<?php echo $forumbgcolor; ?> 
      background="" border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD background="" bgColor=<?php echo $forumtopbarbgcolor; ?>>
                  <TABLE cellSpacing=0 cellPadding=3 width="90%" align=center 
                  background="" border=0>
                    <TBODY>
                    <TR>
                      <TD width="33.333333333%">
                        <P align=center><STRONG><FONT face=<?php echo $font; ?> color=<?php echo $forumtopbartxtcolor; ?> 
                        size=1><a href="pm.php?function=inbox"><FONT face=<?php echo $font; ?> color=<?php echo $linkcolor; ?> 
                        size=1>Inbox</a></FONT></STRONG></P></TD>
                      <TD width="33.333333333%">
                        <P align=center><STRONG><FONT face=<?php echo $font; ?> color=<?php echo $forumtopbartxtcolor; ?> 
                        size=1><a href="pm.php?function=sendpm"><FONT face=<?php echo $font; ?> color=<?php echo $linkcolor; ?> 
                        size=1>Send New PM</a></FONT></STRONG></P></TD>
                      <TD width="*">
                        <P align=center><STRONG><FONT face=<?php echo $font; ?> color=<?php echo $forumtopbartxtcolor; ?> 
                        size=1>Return to <a href="index.php"><FONT face=<?php echo $font; ?> color=<?php echo $linkcolor; ?> 
                        size=1><?php echo$boardname; ?></a></FONT></STRONG></P></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor=<?php echo $forumbgcolor; ?> background="" border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
              <TR bgColor=<?php echo $forumtopbarbgcolor; ?>>

<?php
if ($sessionuser == "Guest") {
	?>
		<TD id=titlelarge colSpan=2><B><FONT face=<?php echo $font; ?> color=<?php echo $forumtopbartxtcolor; ?> 
                        size=1>You are not logged in. Please <a href="index.php?function=login">login</a> to <?php echo $boardname; ?>.</font></b></td></tr></TBODY></TABLE>
	<?php
}else{

if (isset($deletepm)) {
	$sql = "DELETE FROM ibb_priv_msgs WHERE pid='$deletepm'";
	if (mysql_query($sql)) {
		echo("<TD bgColor=$topbargbcolor><center><FONT face=\"$font\" color=$forumtopbartxtcolor 
            size=2>PM Deleted Successfully. You Are Now Being Redirected.</center></td></TR></TBODY></TABLE>");
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="0;URL=pm.php?function=inbox">
			<?php
	}else{
		mysql_error();
	}
}else{

if ($function == "deletepm") {
	?>
<TD width="100%" bgColor=<?php echo $forumtopbarbgcolor; ?> colSpan=2>
<center><br>
<form action="<?php echo("pm.php?deletepm=$pid"); ?>" method=POST>
<input type=submit name="dpm" value="Delete PM">
</form>
<form action="<?php echo("pm.php?function=view&pid=$pid"); ?>" method=POST>
<input type=submit name="kpm" value="Keep PM">
</form>
</center></TD></TR></TBODY></TABLE>
	<?php
}else{

if ($function == "view") {
$result = mysql_query("SELECT * FROM ibb_priv_msgs WHERE pid=$pid");
while ( $row = mysql_fetch_array($result) ) {
$pid = $row["pid"];
$tid = $row["tid"];
$fmid = $row["fmid"];
$time = $row["time"];
$subject = $row["subject"];
$messege = $row["messege"];
$pmstatus = $row["status"];
$pmdate = $row["date"];
$pmimage = $row["pmimage"];
}

$subject = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $subject);
$subject = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $subject);
$subject = eregi_replace("javascript:", "", $subject);

if ($pmstatus == "no") {
	$sql = "UPDATE ibb_priv_msgs SET status='yes' WHERE pid='$pid'";
	if (mysql_query($sql)) {
	}
}

$result = mysql_query("SELECT * FROM ibb_members WHERE mid='$fmid'") or die(mysql_error());
while ( $row = mysql_fetch_array($result) ) {
$status = $row["status"];
$name = $row["name"];
$title = $row["title"];
$avatar = $row["aviator"];
$apostcounts = $row["posts"];
$threadmid = $row["mid"];
$threademail = $row["email"];
$signature = $row["signature"];
$membersince = $row["time"];
$location = $row["location"];
}

if ($fmid == $imid) { 
	?>
		<TD bgColor=<?php echo $forumtopbarbgcolor; ?> colspan=1><FONT face="<?php echo $font; ?>" color="<?php echo $forumtopbartxtcolor; ?>" size=2>
		<center><?php echo $name; ?> is on your ignore list. PM will not be shown.</center>
		</TD></TR></tbody></table>
	<?php
}else{

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

$query = "SELECT image FROM ibb_threads WHERE tid='$TID'";
$toto = mysql_query($query);
$bob = mysql_fetch_row($toto);
$timage = $bob[0];

//does all the processing of the time to comply with the user's time offset
$pmdatedst = substr($pmdate, 0,11);
$pmdatedendst = substr($pmdate, -9);
$hoursoffsetbg = substr($pmdatedendst, -8,2);
$hoursoffset = $hoursoffsetbg + $timepreference;
$hoursoffsetend = substr($pmdatedendst, -6);
$pmdateend = "$pmdatedst$hoursoffset$hoursoffsetend";
$pmdate = "$pmdateend";

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
	$messege = str_replace("
", "<br>", $messege);
	$messege = str_replace("[center]", "<center>", $messege);
	$messege = str_replace("[/center]", "</center>", $messege);
	$messege = str_replace("[b]", "<b>", $messege);
	$messege = str_replace("[/b]", "</b>", $messege);
	$messege = str_replace("[color=red]", "<font color=red>", $messege);
	$messege = str_replace("[/color]", "</font>", $messege);
	$messege = str_replace(" fuck ", "****", $messege);
	$messege = str_replace(" ass ", "***", $messege);
	$messege = str_replace(" dick ", "****", $messege);
	$messege = str_replace(" shit ", "****", $messege);
	$messege = str_replace(" damn ", "****", $messege);
	$messege = eregi_replace("\\[url\\]www.([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>\\1</a>",$messege);
	$messege = eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=_blank>\\1</a>",$messege);
	$messege = eregi_replace("\\[url=([^\"]*)\\]([^\\[]*)\\[\\/url\\]","<a href=\"\\1\" target=_blank>\\2</a>",$messege);
	$messege = str_replace("[quote]", "<i>", $messege);
	$messege = str_replace("[/quote]", "</i><br>", $messege);
	$messege = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $messege);
	$messege = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $messege);

	//icredicode for signature
	$signature = str_replace("[b]", "<b>", $signature);
	$signature = str_replace("[/b]", "</b>", $signature);
	$signature = str_replace("[i]", "<i>", $signature);
	$signature = str_replace("[/i]", "</i>", $signature);
	$signature = str_replace("[u]", "<u>", $signature);
	$signature = str_replace("[/u]", "</u>", $signature);
	$signature = str_replace("[center]", "<center>", $signature);
	$signature = str_replace("[/center]", "</center>", $signature);
	$signature = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $signature);
	$signature = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $signature);

?>
                <TD bgColor=<?php echo $topictopbarbgcolor; ?> colspan=3><p align=right><FONT 
                  face=<?php echo $font; ?> color=<?php echo $topictopbartxtcolor; ?> size=2><a href="pm.php?function=sendpm&to=<?php echo $name; ?>&msg=<?php echo $messege; ?>"><FONT 
                  face=<?php echo $font; ?> color=<?php echo $topiclinkcolor; ?> size=2>Send A Reply</a> | <a href="pm.php?function=sendpm&msg=<?php echo $messege; ?>"><FONT 
                  face=<?php echo $font; ?> color=<?php echo $topiclinkcolor; ?> size=2>Forward PM</a> | <a href="pm.php?<?php echo ("pid=$pid&function=deletepm"); ?>"><FONT 
                  face=<?php echo $font; ?> color=<?php echo $topiclinkcolor; ?> size=2>Delete PM</a></FONT></TD></tr>
				<tr>
                <TD vAlign=top noWrap width=175 bgColor=<?php echo $topicleftbgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $topiclefttxtcolor; ?> 
                  size=2><STRONG><?php echo $name; ?></STRONG><BR><FONT size=1><?php echo $title; ?><BR>

			    <?php 
				if ($name == "Guest") {
					  echo ("<img src='images/guestavatar.gif'>");
				}else{
					if (($avatar == "") || ($avatar == "You do not have an avatar yet.")) {
						  echo ("<img src='images/noavatar.gif' height=64 width=64>");
					}else{
						  echo ("<img src='$avatar' height=80 width=80 height=$avwidth width=$avheight>");
					} 
				}
				?>
					
				<BR></FONT></td>
                <TD vAlign=top width="100%" bgColor=<?php echo $topicmainbgcolor; ?>>
				<FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=1>
<?php
if ($pmimage == "") {
}else{
?>
<img src="<?php echo($pmimage); ?>">
<? } ?>&nbsp;<STRONG><FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=1><?php echo $subject; ?></STRONG></FONT> 
                  <P><FONT face="<?php echo $font; ?>" color="<?php echo $topicmaintxtcolor; ?>" size=2><?php echo ("$messege<BR><BR><BR>------------------------------------<BR>$signature"); ?></FONT></P></TD></TR></tbody></table>
<?php
}
}
if ($function == "sendpm") {
if ($submitpm == "Submit PM") {
$query = "SELECT mid FROM ibb_members WHERE name='$to'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$rec = $row[0];
$time = time();

if (isset($msg)) {
	$subject = "RE: $subject";
}
$subject = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $subject);
$subject = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $subject);
$subject = eregi_replace("javascript:", "", $subject);
$message = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $message);
$message = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $message);
$message = eregi_replace("javascript:", "", $message);
$images = preg_replace("/(<script)(.*)(<\/script>)/e","htmlentities(\"\\2\")", $images);
$images = preg_replace("/(&lt;script)(.*)(&lt;\/script&gt;)/e","htmlentities(\"\\2\")", $images);
$images = eregi_replace("javascript:", "", $images);
$sql = "INSERT INTO ibb_priv_msgs SET " .
"fmid='$usermid'," .
"subject='$subject'," .
"mid='$rec'," .
"time='$time'," . 
"pmimage='$images'," .
"date='$thetime'," .
"messege='$message'";

if (mysql_query($sql)) {
echo("<TD bgColor=$topictopbargbcolor><center><FONT face=\"$font\" 
            size=2>PM Sent Successfully. You Are Now Being Redirected.</center></td></TR></TBODY></TABLE>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="0;URL=pm.php?function=inbox">
<?php
} else {
echo("<TD bgColor=$topictopbargbcolor><center><FONT face=\"$font\" 
            size=2>Error Sending PM: " .
mysql_error() . "</FONT></center></td></TR></TBODY></TABLE>");
}
}else{
	?>
		<form action="pm.php?function=sendpm" method=POST name=newpm>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=2><B>Your Username:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=2><?php 
		if ($sessionuser == "Guest") {
			echo "A Guest";
		}else{
			echo $sessionuser; } ?></FONT></TD></TR>
        <TR bgColor=<?php echo $topictopbarbgcolor; ?>>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=2><B>To:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=2><INPUT class=bginput tabIndex=1 maxLength=85 size=40 
            name=to value="<?php echo $to; ?>"></FONT></TD></TR>
        <TR bgColor=<?php echo $topictopbarbgcolor; ?>>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=2><B>Subject:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=2><INPUT class=bginput tabIndex=1 maxLength=85 size=40 
            name=subject></FONT></TD></TR>
        <TR>
          <TD vAlign=top bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" face="<?php echo $topictopbartxtcolor; ?>" 
            size=2><B>Mood:</B></FONT></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=1>
<input type="radio" name="images" value="images/smile.gif" checked><img src="images/smile.gif"> 
<input type="radio" name="images" value="images/sad.gif"><img src="images/sad.gif"> 
<input type="radio" name="images" value="images/mad.gif"><img src="images/mad.gif"> 
<input type="radio" name="images" value="images/biggrin.gif"><img src="images/biggrin.gif"> 
<input type="radio" name="images" value="images/slant.gif"><img src="images/slant.gif"> 
<input type="radio" name="images" value="images/wink.gif"><img src="images/wink.gif"> </FONT></TD></TR>
        <TR>
          <TD noWrap bgColor=<?php echo $topictopbarbgcolor; ?>>
            <P><center>
<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="#000000">
<TR>
<TD height=10 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?>><center><FONT face="<?php echo $font; ?>" color="<?php echo $topictopbartxtcolor; ?>" 
            size=2>Emoticons</center>
</TD>
</TR>
<TR>
<TD height=90 width="65" bgcolor=<?php echo $topictopbarbgcolor; ?> valign=center>
<center>
<a href="javascript:void(0);" onclick="newpm.message.value=newpm.message.value +':)';"><img src="images/smile.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newpm.message.value=newpm.message.value +':(';"><img src="images/sad.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="newpm.message.value=newpm.message.value +':mad:';"><img src="images/mad.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newpm.message.value=newpm.message.value +':D';"><img src="images/biggrin.gif" border=0></a><br>
<a href="javascript:void(0);" onclick="newpm.message.value=newpm.message.value +':-/';"><img src="images/slant.gif" border=0></a> 
<a href="javascript:void(0);" onclick="newpm.message.value=newpm.message.value +';)';"><img src="images/wink.gif" border=0></a>
</center>
</TD>
</TR>
</Table></center></FONT></P></TD>
          <TD bgColor=<?php echo $topictopbarbgcolor; ?>>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=message rows=10 wrap=virtual cols=60>
<?php
if (isset($msg)) {
	?>[quote]<?php
	echo ("$msg");
	?>[/quote]<?php
}else{
}
?>
</TEXTAREA>
<?php 
if (isset($msg)) {
	?>
		<input type=hidden name=msg value=nothing>
	<?php
}
?>
			</TD></TR>
			</TBODY></TABLE></TD></TR>
			<TR><TD bgColor=<?php echo $topictopbarbgcolor; ?> colspan=2><center>
          <INPUT type=submit value="Submit PM" name=submitpm></center></td></TR></form></TBODY></TABLE>
<?php
}
}else{

if ($function == "inbox") {
?>
	                <TD bgColor=<?php echo $topictopbarbgcolor; ?> id=titlelarge colSpan=2><B><FONT face=<?php echo $font; ?> 
                  color=<?php echo $forumtopbartxtcolor; ?> size=1>Welcome to your Inbox, 
                  <?php echo $sessionuser; ?></FONT></B></TD></TR>
<TR>
                <TD background="" bgColor=<?php echo $forumtpbgcolor; ?> colSpan=2>
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" 
                  bgColor=<?php echo $forumbgcolor; ?> background="" border=0>
                    <TBODY>
                    <TR>
                      <TD>
                        <TABLE cellSpacing=1 cellPadding=4 width="100%" 
                        background="" border=0>
                          <TBODY>
                          <TR vAlign=bottom>
                            <TD align=middle background="" bgColor=<?php echo $forumtopbarbgcolor; ?> 
                            colSpan=3><FONT face=<?php echo $font; ?> color=<?php echo $forumtopbartxtcolor; ?>
                              size=1><B>Message Title</B></FONT></TD>
                            <TD noWrap align=middle background="" 
                            bgColor=<?php echo $forumtopbarbgcolor; ?> ><FONT face=<?php echo $font; ?> color=<?php echo $forumtopbartxtcolor; ?>
                              size=1><B>Sent By</B></FONT></TD>
                            <TD noWrap align=middle background="" 
                            bgColor=<?php echo $forumtopbarbgcolor; ?> ><FONT face=<?php echo $font; ?> color=<?php echo $forumtopbartxtcolor; ?>
                              size=1><B>Date/Time Sent</B></FONT></TD></TR>
<?php
$result = mysql_query("select * from ibb_priv_msgs where mid='$usermid' order by status, time desc");
while ($row = mysql_fetch_array($result)) {
	$pmpida[] = $row["pid"];
}
foreach ($pmpida as $pmpid) {
$result = mysql_query("select * from ibb_priv_msgs where pid='$pmpid'") or mysql_error();
while ($row = mysql_fetch_array($result)) {
	$pmsendermid = $row["fmid"];
	$pmmessege = $row["messege"];
	$pmstatus = $row["status"];
	$pmsubject = $row["subject"];
	$pmdate = $row["date"];
	$pmtime = $row["time"];
	$pmimage = $row["pmimage"];
}

if (!$pmimage) {
	$pmimage = "images/smile.gif";
}

$query = "select name from ibb_members where mid='$pmsendermid'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$pmsendername = $row[0];
?>
					<TR align=middle>
                            <TD background="" bgColor=<?php echo $forumtpbgcolor; ?>></TD>
                            <TD background="" bgColor=<?php echo $forumiconbgcolor; ?>><img src="<?php echo $pmimage; ?>"></TD>
                            <TD align=left width="75%" background="" 
                            bgColor=<?php echo $forumtpbgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $forumtptxtcolor; ?>
                              size=1><U><a href="pm.php?function=view&pid=<?php echo $pmpid; ?>"><FONT face=<?php echo $font; ?> color=<?php echo $forumlinkcolor; ?>
                              size=1><?php if ($pmstatus == "no") 	{ echo "<b>"; } echo $pmsubject; if ($pmstatus == "no") { echo "</b>"; } ?></a></U> <?php if ($pmsendermid == $imid) { echo "[Message will not be shown. (User Ignored)]"; } ?></FONT></TD>
                            <TD align=middle width="25%" background="" 
                            bgColor=<?php echo $forumusbgcolor; ?>><U><a href="member.php?MID=<?php echo $pmsendermid; ?>"><FONT face=<?php echo $font; ?> color=<?php echo $forumlinkcolor; ?>
                              size=1><?php echo $pmsendername; ?></a></U></FONT></TD>
                            <TD noWrap align=left background="" 
                              bgColor=<?php echo $forumlpbgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $forumlptxtcolor; ?>
                              size=1><?php echo $pmdate; ?></FONT></TD></tr>
<?php
}
?>
</TD></tr></TBODY></TABLE></TD></tr></TBODY></TABLE></td></tr></TBODY></TABLE>
<?php
}else{
}
}
}
}
}
?>
</TD></TR></tbody></table><br>
<?php
include "footer.php";
echo $copyrights;


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>