<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


//includes the header.php
include "header.php";

//gets forum restrictions
$variables = mysql_query("SELECT * FROM ibb_forums WHERE fid='$FID'");
while ( $row = mysql_fetch_array($variables) ) {
$viewableto = $row["viewableto"]; 
$whocanpost = $row["whocanpost"]; 
$forumname = $row["name"];
$allowcode = $row["allowcode"];
$allowhtml = $row["allowhtml"];
}

//finds out how many topics are allowed per forum page
$query = "SELECT forumspage FROM ibb_boardinfo";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$forumspage = $row[0];

$query = "SELECT maxpolloptions FROM ibb_boardinfo";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$maxpolloptions = $row[0];

//if $forumspage doesn't exist, this will set 10 as default
if (!$forumspage) {
$forumspage = "10";
}

//if $start doesn't exist, this will set it at 0, don't change this
if(!isset($start)) {
$start="0";
}

//if $perpage doesn't exist, this will set it equal to $forumspage
if(!isset($perpage)) {
$perpage="$forumspage";
}

//gets the number of topics
$query = mysql_query("SELECT * FROM ibb_threads WHERE fid='$FID' ORDER BY tid"); 
$newnum = mysql_num_rows($query); 

$newnum = $newnum + 1;

//doesn't alittle math :)
$numpages = ceil($newnum/$perpage);

//does the page separating
for($i=0; $i<$numpages; $i++){ 
    $startrow = $perpage*$i; 
    $page = $i+1; 
    if($startrow == $start){ 
        $pages .= " [ $page ] "; 
    }else{ 
        $pages .= " [ <a href='$PHP_SELF?FID=$FID&start=$startrow&perpage=$perpage'>$page</a> ] "; 
    } 
} 

//gets the amount of pinned topics
$query = "SELECT count(*) FROM ibb_threads WHERE pin='yes' AND fid='$FID'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$numberptopics = $row[0];

if ($start > 0) {
	$start = $start - 1;
}

//unpinned topic start thing (I understand what i mean ;))
$nptopicstart = $forumspage - $numberptopics;

//gets the forum's name
$query = "SELECT name FROM ibb_forums WHERE fid='$FID'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$forumname = $row[0];


//sets the title
$ptitle = "$boardname - $forumname";
echo ("<title>$ptitle</title>");

//updates online user info
$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}

//gets the number of people on this forum
$query = "SELECT count(*) FROM ibb_onlineusers WHERE pagename='$ptitle'";
$toto = mysql_query($query);
$bob = mysql_fetch_row($toto);
$pageviewers = $bob[0];

//if it is an announcement, it does this
if ($t == "a") {
	$viewableto = "all";
}

//makes sure the user can view the forum
if((strstr($viewableto, $sessionstatus)) || ($viewableto == "all")) {
?>
	<br>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD vAlign=top><FONT face="<?php echo $font; ?>" color=<?php echo $forumtxtcolor; ?> size=2><B><?php echo("<A href=\"index.php\"><font color=$forumlinkcolor>$boardname</font></A> >> <A href=\"viewforum.php?FID=$FID\"><font color=$forumlinkcolor>$forumname</font></A>"); ?></B></FONT><FONT 
            face=<?php echo $font; ?> size=1><BR>(Users Browsing this Forum: 
            <?php echo $pageviewers; ?>)</FONT></TD>
          <TD vAlign=bottom align=right><FONT face="<?php echo $font; ?>" color=<?php echo $forumtxtcolor; ?> size=3><NOBR><?php if ($gposttopics == "yes") { ?><A href="viewforum.php?FID=<?php echo $FID; ?>&function=addpoll"><img src="themes/<?php echo $theme1; ?>/images/newpoll.gif" border=0></A></A> <?php } ?><?php if ($gposttopics == "yes") { ?><A href="viewforum.php?FID=<?php echo $FID; ?>&function=addtopic"><img src="themes/<?php echo $theme1; ?>/images/newthread.gif" border=0></A><?php } ?></NOBR>&nbsp;</FONT></TD></TR>
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
		  </TD></TR></tbody></table>
<?php
if ($function == "addpoll") {
?>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=<?php echo $forumbgcolor; ?> 
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><B>Your Username:</B></FONT></TD>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><?php 
		if ($sessionuser == "Guest") {
			echo "A Guest";
		}else{
			echo $sessionuser; } ?></FONT></TD></TR>
        <TR bgColor=<?php echo $forumtopbarbgcolor; ?>>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FORM ACTION="<?php echo("viewforum.php?FID=$FID"); ?>" METHOD=POST name=newtopic><FONT face=<?php echo $font; ?> 
            size=2><B>Question:</B></FONT></TD>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><INPUT class=bginput tabIndex=1 maxLength=125 size=40 name=subject></FONT></TD></TR>
		<TR bgColor=<?php echo $forumtopbarbgcolor; ?>>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FORM ACTION="<?php echo("viewforum.php?FID=$FID"); ?>" METHOD=POST><FONT face=<?php echo $font; ?> 
            size=2><B>Poll End (Days, forever=forever):</B></FONT></TD>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><INPUT class=bginput tabIndex=1 maxLength=10 size=10 
            name=destruct></FONT></TD></TR>
        <TR>
          <TD noWrap bgColor=<?php echo $forumtopbarbgcolor; ?> valign=top>
          <FONT face=<?php echo $font; ?> 
            size=2><b>Options:</TD>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD>
			<FONT face=<?php echo $font; ?> 
            size=1>Allow Replies: 
			 <select name="allowpollreplies">
			  <option value="yes">Yes</option><option value="no">No</option></select><br>Number Of Choices: <select name="polloptions">
<?php
if ($maxpolloptions == "") {
	$maxpolloptions = 15;
}
for ($y = 1; $y <= $maxpolloptions; $y++) {
echo "<option value=\"$y\">$y</option>";
}
?></select>
			</TD></TR>
			</TBODY></TABLE></TD></TR>
			<TR>
          <TD noWrap bgColor=<?php echo $forumtopbarbgcolor; ?>>
            <P><center>
<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="#000000">
<TR>
<TD height=10 width="65" bgcolor=<?php echo $forumtopbarbgcolor; ?>><center><FONT face=<?php echo $font; ?> size=2>Emoticons</center>
</TD>
</TR>
<TR>
<TD height=90 width="65" bgcolor=<?php echo $forumtopbarbgcolor; ?> valign=center>
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
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=message rows=10 wrap=virtual cols=60></TEXTAREA>
			</TD></TR>
			</TBODY></TABLE></TD></TR>
			<TR><TD bgColor=<?php echo $forumtopbarbgcolor; ?> colspan=2><center>
          <INPUT type=submit value="Enter Choices" name=newpoll></center></TR></TD></TR></TBODY></TABLE></TD></TR>
<?php
}else{

if ($newpoll == "Enter Choices") {
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
	$sql = "INSERT INTO ibb_threads SET " .
	"name='$sessionuser'," .
	"fid='$FID'," .
	"subject='$subject'," .
	"pin='no'," .
	"time='Posted On: $thetime'," . 
	"image='themes/$theme1/images/poll.gif'," .
	"timeline='$ttime'," .
	"poll='yes'," .
	"description='$message'";
	if (mysql_query($sql)) {
		$sql = "INSERT INTO ibb_polls SET " .
		"question='$subject'," .
		"numberchoices='$polloptions'," .
		"time='$ttime'," . 
		"destruct='$destruct'," .
		"allowreplies='$allowpollreplies'";
		if (mysql_query($sql)) {
		$query = "SELECT pollid FROM ibb_polls WHERE question='$subject' && time='$ttime'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$PID = $row[0];
		?>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=<?php echo $forumbgcolor; ?> 
			border=0>
			  <TBODY>
			  <TR>
				<TD>
				  <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
					<TBODY>
					<FORM ACTION="<?php echo("viewforum.php?FID=$FID&PID=$PID"); ?>" METHOD=POST>
					<input type=hidden value=<?php echo $polloptions; ?>>
					<?php
					for ($y = 1; $y <= $polloptions; $y++) {
						?>
							<TR>
							  <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
								size=2><B>Option <?php echo $y; ?>:</B></FONT></TD>
							  <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
								size=2><INPUT class=bginput tabIndex=1 size=40 name=option<?php echo $y; ?>></FONT></TD></TR>
						<?php
					}
					?>
					</TBODY></TABLE></TD></TR>
			<TR><TD bgColor=<?php echo $forumtopbarbgcolor; ?> colspan=2><center>
          <INPUT type=submit value="Submit New Poll" name=newpoll></center></TR></TD></TR></TBODY></TABLE></TD></TR></form><tr><td>
		<?php
		}else{
			echo("<TR><TD width=\"100%\" bgColor=$forumtopbarbgcolor colSpan=2><center><FONT face=\"$font\" size=2>Error adding submitted poll: " .
			mysql_error() . "</FONT></center></TD></TR>");
			?>
			<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
			<TBODY>
			<TR>
			<TD vAlign=top>
			<?php
		}
	}else{
		echo("<TR><TD width=\"100%\" bgColor=$forumtopbarbgcolor colSpan=2><center><FONT face=\"$font\" size=2>Error adding submitted poll: " .
		mysql_error() . "</FONT></center></TD></TR>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
		<?php
	}
	$query = "select max(lpid) from ibb_threads";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$newtid = $row[0];

	$newtid++;

	$sql = "UPDATE ibb_threads SET lpid='$newtid' WHERE subject='$subject' and description='$message' and time='Posted On: $thetime' and timeline='$ttime'";
	if (mysql_query($sql)) {
	}else{
		echo mysql_error();
	}
}else{

if ($newpoll == "Submit New Poll") {
	foreach($HTTP_POST_VARS as $key => $val){ $foo[] = $val; } $choices = join("*-*!!*-*",$foo);
	$choices = str_replace("*-*!!*-*Submit New Poll", "", $choices);
	$sql = "UPDATE ibb_polls SET choices='$choices' WHERE pollid='$PID'";
	if (mysql_query($sql)) {
		?>
			<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
			  bgColor=<?php echo $forumbgcolor; ?> border=0>
				<TBODY>
				<TR>
				  <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> size=2 color=#FFFFFF><center>Poll Added Successfully. You Are Now Being Redirected.</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
		<META HTTP-EQUIV="Refresh" 
		CONTENT="2;URL=viewforum.php?FID=<?php echo($FID); ?>">
		<?php
	} else {
		echo("<TR><TD width=\"100%\" bgColor=$forumtopbarbgcolor colSpan=2><center><FONT face=\"$font\" 
					size=2>Error adding submitted poll: " .
		mysql_error() . "</FONT></center></TD></TR>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
		<?php
	}
}else{

if ($function == "addtopic") {
if ($gposttopics == "yes") {
?>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=<?php echo $forumbgcolor; ?> 
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><B>Your Username:</B></FONT></TD>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><?php 
		if ($sessionuser == "Guest") {
			echo "A Guest";
		}else{
			echo $sessionuser; } ?></FONT></TD></TR>
        <TR bgColor=<?php echo $forumtopbarbgcolor; ?>>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FORM ACTION="<?php echo("viewforum.php?FID=$FID"); ?>" METHOD=POST name=newtopic><FONT face=<?php echo $font; ?> 
            size=2><B>Subject:</B></FONT></TD>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><INPUT class=bginput tabIndex=1 maxLength=85 size=40 
            name=subject></FONT></TD></TR>
        <TR>
          <TD vAlign=top bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=2><B>Mood:</B></FONT></TD>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
            size=1>
			<input type="radio" name="images" value="images/smile.gif" checked><img src="images/smile.gif"> 
			<input type="radio" name="images" value="images/sad.gif"><img src="images/sad.gif"> 
			<input type="radio" name="images" value="images/mad.gif"><img src="images/mad.gif"> 
			<input type="radio" name="images" value="images/biggrin.gif"><img src="images/biggrin.gif"> 
			<input type="radio" name="images" value="images/slant.gif"><img src="images/slant.gif"> 
			<input type="radio" name="images" value="images/wink.gif"><img src="images/wink.gif"> </FONT></TD></TR>
        <TR>
          <TD noWrap bgColor=<?php echo $forumtopbarbgcolor; ?>>
            <P><center>
			<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="#000000">
			<TR>
			<TD height=10 width="65" bgcolor=<?php echo $forumtopbarbgcolor; ?>><center><FONT face=<?php echo $font; ?> size=2>Emoticons</center>
			</TD>
			</TR>
			<TR>
			<TD height=90 width="65" bgcolor=<?php echo $forumtopbarbgcolor; ?> valign=center>
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
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=message rows=10 wrap=virtual cols=60></TEXTAREA>
			</TD></TR>
			</TBODY></TABLE></TD></TR>
			<TR><TD bgColor=<?php echo $forumtopbarbgcolor; ?> colspan=2><center>
          <INPUT type=submit value="Submit Thread" name=submitinput></center></TR></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><br>
<?php
}else{
	?>
		<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
      bgColor=<?php echo $forumbgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> size=2 color=<?php echo $forumtopbartxtcolor; ?>><center>You do not have the proper credentials to post topics. Redirecting to forum.</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
		<META HTTP-EQUIV="Refresh" 
		CONTENT="2;URL=viewforum.php?FID=<?php echo($FID); ?>">
	<?php
}
}else{

// If a topic has been submitted,
// add it to the database.
if ($submitinput == "Submit Thread") {
if ($subject == "") {
	?>
		<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
		  bgColor=<?php echo $forumbgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> size=2 color=<?php echo $forumtopbartxtcolor; ?>><center>You left the subject field blank. Please click the back button.</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
	<?php
}else{
if ($message == "") {
	?>
		<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
      bgColor=<?php echo $forumbgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> size=2 color=<?php echo $forumtopbartxtcolor; ?>><center>You left the message field blank. Please click the back button.</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
	<?php
}else{
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

	$message = str_replace("
	", "[br]", $message);

	$sql = "INSERT INTO ibb_threads SET " .
	"name='$sessionuser'," .
	"fid='$FID'," .
	"subject='$subject'," .
	"pin='no'," .
	"time='Posted On: $thetime'," . 
	"image='$images'," .
	"timeline='$ttime'," .
	"description='$message'";

	if (mysql_query($sql)) {
		?>
			<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
			  bgColor=<?php echo $forumbgcolor; ?> border=0>
				<TBODY>
				<TR>
				  <TD bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> size=2 color=#FFFFFF><center>Topic Added Successfully. You Are Now Being Redirected.</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
		<META HTTP-EQUIV="Refresh" 
		CONTENT="2;URL=viewforum.php?FID=<?php echo($FID); ?>">
		<?php
	} else {
		echo("<TR><TD width=\"100%\" bgColor=$forumtopbarbgcolor colSpan=2><center><FONT face=\"$font\" 
					size=2>Error adding submitted topic: " .
		mysql_error() . "</FONT></center></TD></TR>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width="760" align=center border=0>
		<TBODY>
		<TR>
		<TD vAlign=top>
		<?php
	}
	$query = "select max(lpid) from ibb_threads";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$newtid = $row[0];

	$newtid++;

	$sql = "UPDATE ibb_threads SET lpid='$newtid' WHERE subject='$subject' and pin='no' and time='Posted On: $thetime' and timeline='$ttime'";
	if (mysql_query($sql)) {
	}else{
	echo mysql_error();
	}
}
}
}else{
?>
	<TABLE cellSpacing=0 cellPadding=2 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD vAlign=top><FONT face=<?php echo $font; ?> color=<?php echo $forumtxtcolor; ?> size=1>Page: <?php echo $pages; ?></FONT></TD></tr></TBODY></TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor=<?php echo $forumbgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
              <TR id=cat align=middle bgColor=<?php echo $forumtopbarbgcolor; ?>>
                <TD noWrap align=middle bgColor=<?php echo $forumtopbarbgcolor; ?> colSpan=2><FONT 
                  face=<?php echo $font; ?> size=1><FONT 
                  color=<?php echo $forumtopbartxtcolor; ?>>Thread</FONT> </FONT></TD>
                <TD noWrap bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
                  size=1><FONT 
                  color=<?php echo $forumtopbartxtcolor; ?>>User ID</FONT></TD>
                <TD noWrap bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
                  size=1><FONT 
                  color=<?php echo $forumtopbartxtcolor; ?>>Replies</FONT></FONT></TD>
                <TD noWrap bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
                  size=1><FONT 
                  color=<?php echo $forumtopbartxtcolor; ?>>Views</FONT></FONT></TD>
                <TD noWrap bgColor=<?php echo $forumtopbarbgcolor; ?>><FONT face=<?php echo $font; ?> 
                  size=1><FONT 
                  color=<?php echo $forumtopbartxtcolor; ?>>Last Post</FONT></FONT></TD></TR>
				<?php
				$pinned = mysql_query("SELECT * FROM ibb_threads WHERE fid='$FID' and pin='yes' ORDER BY lpid desc LIMIT $start, $perpage");
				while ( $row = mysql_fetch_array($pinned) ) { 
				$fid = $row["fid"];
				$tid = $row["tid"];
				$email = $row["email"];
				$author = $row["name"];
				$date = $row["time"];
				$subject = $row["subject"]; 
				$messege = $row["description"];
				$views = $row["views"];
				$mods = $row["mods"];

				$query = "SELECT count(rid) FROM ibb_replies WHERE tid='$tid'";
				$toto = mysql_query($query);
				$bob = mysql_fetch_row($toto);
				$replycount = $bob[0];

				$query = "SELECT image FROM ibb_threads WHERE tid='$tid'";
				$toto = mysql_query($query);
				$bob = mysql_fetch_row($toto);
				$timage = $bob[0];

				$query = "SELECT mid FROM ibb_members WHERE name='$author'";
				$toto = mysql_query($query);
				$bob = mysql_fetch_row($toto);
				$threadmid = $bob[0];

				$query = "SELECT timeline FROM `ibb_threads` WHERE (tid='$tid' && fid='$FID') ORDER BY timeline DESC LIMIT 1";
				$result = mysql_query($query);
				$row = mysql_fetch_row($result);
				$lastpostert = $row[0];

				$query = "SELECT timeline FROM `ibb_replies` WHERE (tid='$tid' && fid='$FID') ORDER BY timeline DESC LIMIT 1";
				$result = mysql_query($query);
				$row = mysql_fetch_row($result);
				$lastposterr = $row[0];

				if ($lastpostert > $lastposterr) {
					$lastpostertime = $lastpostert;
					$query = "SELECT name FROM ibb_threads WHERE (tid='$tid	' && timeline='$lastpostertime')";
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
					$lastposter = $row[0];

					$query = "SELECT time FROM ibb_threads WHERE (tid='$tid' && timeline='$lastpostertime')";
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
					$lastposterd = $row[0];
				}else{
					$lastpostertime = $lastposterr;
					$query = "SELECT name FROM ibb_replies WHERE (tid='$tid' && timeline='$lastpostertime')";
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
					$lastposter = $row[0];

					$query = "SELECT time FROM ibb_replies WHERE (tid='$tid' && timeline='$lastpostertime')";
					$result = mysql_query($query);
					$row = mysql_fetch_row($result);
					$lastposterd = $row[0];
				}

				$query = "select mid from ibb_members where name='$lastposter'";
				$result = mysql_query($query);
				$row = mysql_fetch_row($result);
				$lastpostermid = $row[0];

				$query = mysql_query("SELECT * FROM ibb_replies WHERE tid='$tid' ORDER BY rid"); 
				$newnum = mysql_num_rows($query); 

				//gets rid of the beginning part of the date
				$lastposterd = eregi_replace("Posted On: ", "", $lastposterd);
				$lastposterd = eregi_replace("Editted On: ", "", $lastposterd);
				$lastposterd = eregi_replace("Replied On: ", "", $lastposterd);

				$servertime = $lastposterd;

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

				$lastposterdend = "$servertimemonth/$servertimeday/$servertimeyear $servertimehour:$servertimemin:$servertimesec";
				?>
              <TR align=middle>
                <TD bgColor=<?php echo $forumiconbgcolor; ?>>
				<img src="<?php echo($timage); ?>"></center></TD>
                <TD align=left width="70%" bgColor=<?php echo $forumtpbgcolor; ?>>
				<FONT face=<?php echo $font; ?> color=<?php echo $forumtptxtcolor; ?> size=2>&nbsp;[Pinned] <A 
                  href="topic.php?<?php echo("TID=$tid&FID=$FID"); ?>"><font color=<?php echo $forumlinkcolor; ?>><?php echo "$subject"; ?></font></A><?php
				  echo " $pages2"; ?></FONT> </TD>
                <TD noWrap width="30%" bgColor=<?php echo $forumusbgcolor; ?>>
				<FONT face=<?php echo $font; ?> color=<?php echo $forumustxtcolor; ?> size=2><?php echo $author; ?></FONT></TD>
                <TD bgColor=<?php echo $forumrebgcolor; ?>>
				<FONT face=<?php echo $font; ?> color=<?php echo $forumretxtcolor; ?> size=2><?php echo $replycount; ?></FONT></TD>
                <TD bgColor=<?php echo $forumviewsbgcolor; ?>>
				<FONT face=<?php echo $font; ?> color=<?php echo $forumviewstxtcolor; ?> size=2><?php echo $views; ?></FONT></TD>
                <TD bgColor=<?php echo $forumlpbgcolor; ?>>
                  <TABLE id=ltlink cellSpacing=0 cellPadding=0 width="100%" 
                  border=0>
                    <TBODY>
                    <TR align=right>
                      <TD noWrap><FONT face=<?php echo $font; ?>
                        size=1><?php echo $lastposterdend; ?><BR>by 
                        <B><?php if ($lastposter == "Guest") {
						echo("<font color='$forumlptxtcolor'>$lastposter</font>");
						}else{
						echo("<a href='member.php?MID=$lastposterid'><font color='$forumlinkcolor'>$lastposter</font></a>"); 
						} 
						?></B></FONT></TD></TR></TBODY></TABLE></TD></TR>
						<?php
						}

						$unpinned = mysql_query("SELECT * FROM ibb_threads WHERE fid='$FID' and pin='no' ORDER BY lpid desc LIMIT $start, $nptopicstart");
						while ( $row = mysql_fetch_array($unpinned) ) { 
						$fid = $row["fid"];
						$tid = $row["tid"];
						$email = $row["email"];
						$author = $row["name"];
						$date = $row["date"];
						$subject = $row["subject"]; 
						$messege = $row["description"];
						$views = $row["views"];
						$mods = $row["mods"];

						$query = "SELECT count(rid) FROM ibb_replies WHERE tid='$tid'";
						$toto = mysql_query($query);
						$bob = mysql_fetch_row($toto);
						$replycount = $bob[0];

						$query = "SELECT image FROM ibb_threads WHERE tid='$tid'";
						$toto = mysql_query($query);
						$bob = mysql_fetch_row($toto);
						$timage = $bob[0];

						$query = "SELECT mid FROM ibb_members WHERE name='$author'";
						$toto = mysql_query($query);
						$bob = mysql_fetch_row($toto);
						$threadmid = $bob[0];

						$query = "SELECT timeline FROM `ibb_threads` WHERE (tid='$tid' && fid='$FID') ORDER BY timeline DESC LIMIT 1";
						$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						$lastpostert = $row[0];

						$query = "SELECT timeline FROM `ibb_replies` WHERE (tid='$tid' && fid='$FID') ORDER BY timeline DESC LIMIT 1";
						$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						$lastposterr = $row[0];

						if ($lastpostert > $lastposterr) {
							$lastpostertime = $lastpostert;
							$query = "SELECT name FROM ibb_threads WHERE (tid='$tid	' && timeline='$lastpostertime')";
							$result = mysql_query($query);
							$row = mysql_fetch_row($result);
							$lastposter = $row[0];

							$query = "SELECT time FROM ibb_threads WHERE (tid='$tid' && timeline='$lastpostertime')";
							$result = mysql_query($query);
							$row = mysql_fetch_row($result);
							$lastposterd = $row[0];
						}else{
							$lastpostertime = $lastposterr;
							$query = "SELECT name FROM ibb_replies WHERE (tid='$tid' && timeline='$lastpostertime')";
							$result = mysql_query($query);
							$row = mysql_fetch_row($result);
							$lastposter = $row[0];

							$query = "SELECT time FROM ibb_replies WHERE (tid='$tid' && timeline='$lastpostertime')";
							$result = mysql_query($query);
							$row = mysql_fetch_row($result);
							$lastposterd = $row[0];
						}

						$query = "select mid from ibb_members where name='$lastposter'";
						$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						$lastposterid = $row[0];

						//gets rid of the beginning part of the date
						$lastposterd = eregi_replace("Posted On: ", "", $lastposterd);
						$lastposterd = eregi_replace("Editted On: ", "", $lastposterd);
						$lastposterd = eregi_replace("Replied On: ", "", $lastposterd);

						$servertime = $lastposterd;

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

						$lastposterdend = "$servertimemonth/$servertimeday/$servertimeyear $servertimehour:$servertimemin:$servertimesec";
						?>
			<TR align=middle>
                <TD bgColor=<?php echo $forumiconbgcolor; ?>><img src="<?php echo($timage); ?>"></TD>
                <TD align=left width="70%" bgColor=<?php echo $forumtpbgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $forumtptxtcolor; ?> size=2>&nbsp;<A 
                  href="topic.php?<?php echo("TID=$tid&FID=$FID"); ?>"><?php echo $subject; ?></A>
				<?php
				echo "<BR>$pages2"; ?>
				</FONT></TD>
                <TD noWrap width="30%" bgColor=<?php echo $forumusbgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $forumustxtcolor; ?> size=2><?php echo $author; ?></FONT></TD>
                <TD bgColor=<?php echo $forumrebgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $forumretxtcolor; ?> size=2><?php echo $replycount; ?></FONT></TD>
                <TD bgColor=<?php echo $forumviewsbgcolor; ?>><FONT face=<?php echo $font; ?> color=<?php echo $forumviewstxtcolor; ?> size=2><?php echo $views; ?></FONT></TD>
                <TD bgColor=<?php echo $forumlpbgcolor; ?>>
                  <TABLE id=ltlink cellSpacing=0 cellPadding=0 width="100%" 
                  border=0>
                    <TBODY>
                    <TR align=right>
                      <TD noWrap><FONT face="<?php echo $font; ?>" 
                        size=1><?php echo $lastposterdend; ?><BR>by 
                        <B><?php if ($lastposter == "Guest") {
						echo("<font color='$forumlptxtcolor'>$lastposter</font>");
						}else{
						echo("<a href='member.php?MID=$lastposterid'><font color='$forumlinkcolor'>$lastposter</font></a>"); 
						} 
						?></B></FONT></TD></TR></TBODY></TABLE>
						<?php
						}
						?>
						</TD></TR></TBODY></TABLE>
						<?php
						}
						?>
						</TD></TR></TBODY></TABLE><br>
						<?php
						}
						}
						}
						}

						}else{
						?><br>
						<TABLE cellSpacing=1 cellPadding=2 width="100%" align=center border=0 bgcolor=#000000>
								<TBODY>
								<TR>
								  <TD vAlign=top bgColor=#16416d><center><FONT face=<?php echo $font; ?> 
									size=2>This forum is either locked or you do not have the proper credentials to view it.</font></td></tr></tbody></table><br>
<?php
}
include "footer.php";
echo $copyrights;


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>