<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


//includes the header.php file
include "header.php";

//gets the information about the user from the DB
$query = mysql_query("select * from ibb_members where name='$sessionuser'");
while ($row = mysql_fetch_array($query)) {
	$youremail = $row["email"];
	$totalposts = $row["posts"];
	$registrationdate = $row["time"];
	$birthday = $row["birthday"];
	$location = $row["location"];
	$occupation = $row["occupation"];
	$msn = $row["msn"];
	$aim = $row["aim"];
	$icq = $row["icq"];
	$yahoo = $row["yahoo"];
	$avatar = $row["aviator"];
	$signature = $row["signature"];
	$avwidth2 = $row["avwidth"];
	$avheight2 = $row["avheight"];
	$interests = $row["interests"];
	$website2 = $row["website"];
}

//if nothing has been entered posts in the DB, this sets totalposts to 0
if ($totalposts == "") {
	$totalposts = "0";
}

//gets the count of how many topics the user has posted
$query = "select count(*) from ibb_threads where name='$sessionuser'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$totalthreads = $row[0];

//gets the count of how many replies the user has done
$query = "select count(*) from ibb_replies where name='$sessionuser'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$totalreplies = $row[0];

//adds up the topics and replies made for the alive posts
$totalaliveposts = $totalthreads + $totalreplies;

//sets the title correctly and puts it in the onlineusers table
$ptitle = "$boardname - User Control Panel";
echo ("<title>$ptitle</title>");
$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}
?><br>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" bgColor=<?php echo $muabgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD background="" bgColor=<?php echo $muatopbarbgcolor; ?>>
                  <TABLE cellSpacing=0 cellPadding=4 width="90%" align=center border=0>
                    <TBODY>
                    <TR>
                      <TD width="23.333333333333333333%">
                        <P align=center><STRONG><a href="usercp.php"><font color=<?php echo $mualinkcolor; ?> face=<?php echo $font; ?> size=1>Personal Information</FONT></a></STRONG></P></TD>
                      <TD width="23.333333333333333333%">
                        <P align=center><STRONG><a href="usercp.php?function=ignoreoptions"><font color=<?php echo $mualinkcolor; ?> face=<?php echo $font; ?> size=1>Ignore Options</a></FONT></STRONG></P></TD>
					  <TD width="23.333333333333333333%">
                        <P align=center><STRONG><a href="usercp.php?function=avataroptions"><font color=<?php echo $mualinkcolor; ?> face=<?php echo $font; ?> size=1>Avatar Options</a></FONT></STRONG></P></TD>
                      <TD width="*">
                        <P align=center><STRONG><font color=<?php echo $muatopbartxtcolor; ?> face=<?php echo $font; ?> size=1>Return to 
                    <a href="index.php"><font color=<?php echo $mualinkcolor; ?> face=<?php echo $font; ?> size=1><?php echo$boardname; ?></a></FONT></STRONG></P></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor=#000000 background="" border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
              <TR bgColor=<?php echo $muatopbarbgcolor; ?>>
<?php
if ($sessionuser == "Guest") {
	?>
		<TD id=titlelarge colSpan=2><B><FONT face="<?php echo $font; ?>" color="<?php echo $muatopbartxtcolor; ?>" size=1>You are not logged in. Please <a href="index.php?function=login">login</a> to <?php echo $boardname; ?>.</font></b></td></tr>
	<?php
}else{
	?>
                <TD id=titlelarge colSpan=2><B><FONT face="<?php echo $font; ?>" color="<?php echo $muatopbartxtcolor; ?>" size=1>Welcome to your control panel, 
                  <?php echo $sessionuser; ?></FONT></B></TD></TR>
<?php
if ($function == "changeinterests") {
if ($submitnewinterests == "Submit") {
$newinterest = $_POST['newinterests'];
$sql = "UPDATE ibb_members SET interests='$newinterest' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Interests updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changeinterests" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Interests (250 chars max):</b><br>
<input type=text name="newinterests" value="<?php echo $interests; ?>">
<input type=submit name="submitnewinterests" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "ignoreoptions") {
	if ($thing == "length") {
		?>
			<TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
							<FORM action="usercp.php?function=ignoreoptions" method=POST>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Change Length Of Ignore:</td></tr><tr><td>
							<SELECT  name=removethisid> 
							<OPTION value=-1 selected>Select User:</OPTION>
							<OPTION value=-1>--------------------</OPTION>
							<?php
							$result = mysql_query("SELECT imid FROM ibb_ignores WHERE mid='$usermid'");
							while ($row = mysql_fetch_array($result)) {
								$ignoremid[] = $row["imid"];
							}
							foreach ($ignoremid as $imid) {
							$query = "select name from ibb_members where mid='$imid'";
							$result = mysql_query($query);
							$row = mysql_fetch_row($result);
							$ignorename = $row[0];
							echo ("<OPTION value=$imid>$ignorename</OPTION>");
							}
							?>
							</SELECT></td></tr><tr><td>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>New Length Of Ignore (forever=forever):</td></tr><tr><td>
							<input type=text name="length"></td></tr><tr><td>
							<input type=submit name="submitlengthchange" value="Submit"></td></tr></tbody></table>
		<?php
	}else{
	if ($thing == "delete") {
		?>
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
							<FORM action="usercp.php?function=ignoreoptions" method=POST>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Remove User From Ignore List:</td></tr><tr><td>
							<SELECT  name=removethisid> 
							<OPTION value=-1 selected>Select User To Remove:</OPTION>
							<OPTION value=-1>--------------------</OPTION>
							<?php
							$result = mysql_query("SELECT imid FROM ibb_ignores WHERE mid='$usermid'");
							while ($row = mysql_fetch_array($result)) {
								$ignoremid[] = $row["imid"];
							}
							foreach ($ignoremid as $imid) {
							$query = "select name from ibb_members where mid='$imid'";
							$result = mysql_query($query);
							$row = mysql_fetch_row($result);
							$ignorename = $row[0];
							echo ("<OPTION value=$imid>$ignorename</OPTION>");
							}
							?>
							</SELECT></td></tr><tr><td>
							<input type=submit name="removeignore" value="Submit"></td></tr></tbody></table>
		<?php
	}else{
	
	if ($removeignore == "Submit") {
		$sql = "DELETE FROM ibb_ignores WHERE imid='$removethisid' && mid='$usermid'";
		if (mysql_query($sql)) {
			?>
				<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>User removed from ignore list. You are being redirected.</font></td></tr></form></tbody></table>
							<META HTTP-EQUIV="Refresh" CONTENT="2;URL=usercp.php?function=ignoreoptions">
			<?php
		}else{
			?>
				<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
							<center><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Error removing user from ignore list: <?php echo mysql_error(); ?></font></center></td></tr></form></tbody></table>
			<?php
		}
	}else{

	if ($thing == "addnew") {
		?>
			<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
							<FORM action="usercp.php?function=ignoreoptions" method=POST>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Add Member To Ignore List:</td></tr><tr><td>
							<input type=text name="newignore"></td></tr><tr><td>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Number Of Days To Ignore (forever=forever):</b></td></tr><tr><td>
							<input type=text name="length"></td></tr><tr><td>
							<input type=submit name="submitnewignore" value="Submit"></td></tr></tbody></table>
		<?php
	}else{
	if ($submitnewignore == "Submit") {
		$query = "select mid from ibb_members where name='$newignore'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$ignoremid = $row[0];

		$sql = "INSERT INTO ibb_ignores SET imid='$ignoremid', mid='$usermid', length='$length', time='$ttime'";
		if (mysql_query($sql)) {
			?>
				<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>User added to ignore list. You are being redirected.</font></td></tr></form></tbody></table>
							<META HTTP-EQUIV="Refresh" CONTENT="2;URL=usercp.php?function=ignoreoptions">
			<?php
		}else{
			?>
				<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
							<center><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Error adding user to ignore list: <?php echo mysql_error(); ?></font></center></td></tr></form></tbody></table>
			<?php
		}
	}else{
	?>
			<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?> align=top><B><FONT color=#ffffff size=1>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0 align=top>
                    <TBODY>
                    <TR>
                      <TD align=top>
						<center><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Ignore List</FONT></center>
						</TD></TR>
					<TR>
					  <TD>

<?php
$result = mysql_query("SELECT imid FROM ibb_ignores WHERE mid='$usermid'");
while ($row = mysql_fetch_array($result)) {
	$ignoremid[] = $row["imid"];
}
foreach ($ignoremid as $imid) {
$query = "select name from ibb_members where mid='$imid'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$ignorename = $row[0];
	?>
	<tr><td><FONT face=Verdana size=1 color=#ffffff>• <a href="member.php?MID=<?php echo $imid; ?>"><?php echo $ignorename; ?></a></FONT></td></tr>
	<?php
}
?>
					  </TD></TR></TBODY></TABLE></P></FONT></B></TD>
                <TD vAlign=top width="80%" bgcolor=<?php echo $muaboxbgcolor; ?>>
				<a href="usercp.php?function=ignoreoptions&thing=addnew"><font color=<?php echo $mualinkcolor; ?> face=<?php echo $font; ?> size=1>Add User To Ignore List</a></U><BR>
				<U><a href="usercp.php?function=ignoreoptions&thing=delete"><font color=<?php echo $mualinkcolor; ?> face=<?php echo $font; ?> size=1>Remove User From Ignore List</a><BR>
				<a href="usercp.php?function=ignoreoptions&thing=length"><font color=<?php echo $mualinkcolor; ?> face=<?php echo $font; ?> size=1>Change Length Of Ignore</a></U>
				</FONT></TD></TR>
	<?php
	}
	}
	}
	}
	}
}else{

if ($function == "changepass") {
if ($submitnewpass == "Submit") {
if ($newpassword == $passverify) {
$newpassword = $_POST['newpassword'];
$newpassword = md5($newpassword);
$sql = "UPDATE ibb_members SET password='$newpassword' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Password updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changepass" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Password:</b><br>
Password: <input type=password name="newpassword">
Verify: <input type=password name="passverify">
<input type=submit name="submitnewpass" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changetpref") {
if ($submitnewtpref == "Submit") {
$newtimepreference = $_POST['newtimepreference'];
$sql = "UPDATE ibb_members SET timepref='$newtimepreference' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Time offset updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changetpref" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Time Offset:</b><br>
<input type=text name="newtimepreference" value="<?php echo $timepreference; ?>">
<input type=submit name="submitnewtpref" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changesig") {
	if ($submitnewsig == "Submit") {
	$newsig = eregi_replace("
", "[br]", $newsig);
	$newsig = $_POST['newsig'];
	$sql = "UPDATE ibb_members SET signature='$newsig' WHERE name='$sessionuser'";
			if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Signature updated. You are being redirected.</td></tr></tbody></table>
	<?php
			}else{
				mysql_error();
			}
	}else{
		if ($codesig == "yes") {
			$allowscode = "Allowed";
		}else{
			$allowscode = "Not Allowed";
		}
		if ($htmlsig == "yes") {
			$allowshtml = "Allowed";
		}else{
			$allowshtml = "Not Allowed";
		}
	?>
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changesig" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Signature:</b><br>HTML is <b><?php echo $allowshtml; ?></b><br>IcrediCode is <b><?php echo $allowscode; ?></b><br>
<textarea name="newsig" rows="8" cols="50"><?php echo $signature; ?></textarea>
<input type=submit name="submitnewsig" value="Submit"></td></tr></form></tbody></table>
	<?php
	}
}else{

if ($function == "changeoccu") {
if ($submitnewoccupation == "Submit") {
$newoccupation = $_POST['newoccupation'];
$sql = "UPDATE ibb_members SET occupation='$newoccupation' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Occupation updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changeoccu" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Occupation:</b><br>
<input type=text name="newoccupation" value="<?php echo $occupation; ?>">
<input type=submit name="submitnewoccupation" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changelocal") {
if ($submitnewlocation == "Submit") {
$newlocation = $_POST['newlocation'];
$sql = "UPDATE ibb_members SET location='$newlocation' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Location updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changelocal" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Location:</b><br>
<input type=text name="newlocation" value="<?php echo $location; ?>">
<input type=submit name="submitnewlocation" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changewebsite") {
if ($submitnewsite == "Submit") {
$newsite = $_POST['newsite'];
$sql = "UPDATE ibb_members SET website='$newsite' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Website updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changewebsite" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Website URL:</b><br>
<input type=text name="newsite" value="<?php echo $website2; ?>">
<input type=submit name="submitnewsite" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changebday") {
if ($submitnewbday == "Submit") {
$newbdaymonth = $_POST['newbdaymonth'];
$newbdayday = $_POST['newbdayday'];
$newbdayyear = $_POST['newbdayyear'];
$newbday = "$newbdaymonth / $newbdayday / $newbdayyear";
$sql = "UPDATE ibb_members SET birthday='$newbday' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Birthdate updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changebday" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Birthdate:</b><br>
<select name="newbdaymonth">
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select> / 
<select name="newbdayday">
<?php
for ($y = 0; $y <= 31; $y++) {
echo "<option value=\"$y\">$y</option>";
}
?>
</select> / 
<select name="newbdayyear">
<?php
$thisyear = date("Y");
for ($y = $thisyear; $y >= 1900; $y--) {
echo "<option value=\"$y\">$y</option>";
}
?>
</select><br>
<input type=submit name="submitnewbday" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changeyahoo") {
if ($submitnewyahoo == "Submit") {
$newyahoo = $_POST['newyahoo'];
$sql = "UPDATE ibb_members SET yahoo='$newyahoo' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Yahoo screen name updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changeyahoo" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Yahoo Screen Name:</b><br>
<input type=text name="newyahoo" value="<?php echo $yahoo; ?>">
<input type=submit name="submitnewyahoo" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changemsn") {
if ($submitnewmsn == "Submit") {
$newmsn = $_POST['newmsn'];
$sql = "UPDATE ibb_members SET msn='$newmsn' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>MSN screen name updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changemsn" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change MSN Screen Name:</b><br>
<input type=text name="newmsn" value="<?php echo $msn; ?>">
<input type=submit name="submitnewmsn" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changeaim") {
if ($submitnewaim == "Submit") {
$newaim = $_POST['newaim'];
$sql = "UPDATE ibb_members SET aim='$newaim' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>AIM screen name updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changeaim" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change AIM Screen Name:</b><br>
<input type=text name="newaim" value="<?php echo $aim; ?>">
<input type=submit name="submitnewaim" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changeicq") {
if ($submitnewicq == "Submit") {
$newicq = $_POST['newicq'];
$sql = "UPDATE ibb_members SET icq='$newicq' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>ICQ number updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changeicq" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change ICQ Number:</b><br>
<input type=text name="newicq" value="<?php echo $icq; ?>">
<input type=submit name="submitnewicq" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "changeemail") {
if ($submitnewemail == "Submit") {
$newemailaddress = $_POST['newemailaddress'];
$sql = "UPDATE ibb_members SET email='$newemailaddress' WHERE name='$sessionuser'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Email address updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
		              <TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=changeemail" method=POST>
                    <TR>
                      <TD><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Email Address:</b><br>
<input type=text name="newemailaddress" value="<?php echo $youremail; ?>">
<input type=submit name="submitnewemail" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function == "avataroptions") {
	if ($thing == "upload") {
		if ($submit == "Upload File") {
			?>
			<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form enctype="multipart/form-data" action="usercp.php?function=avataroptions&thing=upload" method="post">
                    <TR>
                      <TD bgcolor=<?php echo $muaboxbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Upload Avatar To Server:</b></td></tr><tr><td>
					  <FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>
					<?php
					$userfile = $HTTP_POST_FILES['userfile'] ['tmp_name'];
					$userfile_name = $HTTP_POST_FILES['userfile'] ['name'];
					$userfile_size = $HTTP_POST_FILES['userfile'] ['size'];
					$userfile_type = $HTTP_POST_FILES['userfile'] ['type'];
					if ($userfile_type == "image/gif") {
						$fileend = ".gif";
					}else if ($userfile_type == "image/jpeg") {
						$fileend = ".jpeg";
					}else if ($userfile_type == "image/png") {
						$fileend = ".png";
					}else if ($userfile_type == "image/bmp") {
						$fileend = ".bmp";
					}
					$userfile_name = $sessionuser . $fileend;
					$MAX_FILE_SIZE2 = "5000";
					if (is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'])) {
						if ($userfile_size > $MAX_FILE_SIZE2) {
							echo "File Is Too Large. Maximum File Size: $MAX_FILE_SIZE2";
						}else{
						if ($userfile_type == "image/gif" || $userfile_type == "image/jpeg" || $userfile_type == "image/png" || $userfile_type == "image/bmp") {
							if (move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], "avatars/users/" . $userfile_name) == TRUE) {
								echo "Avatar is uploaded, you are being redirected.";
								?>
								<META HTTP-EQUIV="Refresh" CONTENT="2;URL=usercp.php?function=avataroptions">
								<?php
							}else{
								echo "Error uploading avatar.";
							}
						}else{
							echo "Wrong File Type";
						}
						}
					} else {
						echo "Possible file upload attack. Filename: " . $HTTP_POST_FILES['userfile']['name'];
					}
					?>
			</td></tr></form></tbody></table>
			<?php
		}else{
		?>
			<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form enctype="multipart/form-data" action="usercp.php?function=avataroptions&thing=upload" method="post">
                    <TR>
                      <TD bgcolor=<?php echo $muaboxbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Upload Avatar To Server:</b></td></tr><tr><td>
					<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>
					<?php
					if ((is_file("avatars/users/$sessionuser.gif") == TRUE) || (is_file("avatars/users/$sessionuser.jpg") == TRUE) || (is_file("avatars/users/$sessionuser.png") == TRUE) || (is_file("avatars/users/$sessionuser.bmp") == TRUE)) {
						echo "You already have an avatar uploaded. If you wish to change it, please delete it first.";
					}else{
					?>
					<input name="userfile" type="file">
					<input type="submit" name="submit" value="Upload File">
					<?php
					}
					?>
					</td></tr></form></tbody></table>
		<?php
		}
	}else{
	if ($thing == "changes") {
		if ($submitnewavatarh == "Submit") {
			$newavatarh = $_POST['newavatarh'];
			$sql = "UPDATE ibb_members SET avheight='$newavatarh', avwidth='$newavatarw' WHERE name='$sessionuser'";
			if (mysql_query($sql)) {
				?>
				<TR>
                <TD bgcolor=<?php echo $muaboxbgcolor; ?>>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD bgcolor=<?php echo $muaboxbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Avatar dimensions updated. You are being redirected.</font></td></tr></tbody></table>
					  <META HTTP-EQUIV="Refresh" CONTENT="2;URL=usercp.php?function=avataroptions">
				<?php
			}else{
				?>
				<TR>
                <TD bgcolor=<?php echo $muaboxbgcolor; ?>>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD bgcolor=<?php echo $muaboxbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Error updating avatar dimensions: <?php echo mysql_error(); ?></font></td></tr></tbody></table>
				<?php
			}
		}else{
		?>
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=avataroptions&thing=changes" method=POST>
                    <TR>
                      <TD bgcolor=<?php echo $muaboxbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Avatar Height:</b></td></tr><tr><td>
								<input type=text name="newavatarh" value="<?php echo $avheight2; ?>"></td></tr><tr><td>
								<input type=text name="newavatarw" value="<?php echo $avwidth2; ?>"></td></tr><tr><td>
								<input type=submit name="submitnewavatarh" value="Submit"></td></tr></form></tbody></table>
		<?php
		}
	}else{

	if ($thing == "delete") {
		?>
		<TR>
					<TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
					  <P align=center>
					  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
						<TBODY>
						<TR>
						  <TD bgcolor=<?php echo $muaboxbgcolor; ?>>
							<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>
		<?php
		error_reporting(E_ALL);
		if (is_file("avatars/users/$sessionuser.gif") == TRUE) {
			$filetodelete = "avatars/users/$sessionuser.gif";
		}else if (is_file("avatars/users/$sessionuser.jpg") == TRUE) {
			$filetodelete = "avatars/users/$sessionuser.jpg";
		}else if (is_file("avatars/users/$sessionuser.png") == TRUE) {
			$filetodelete = "avatars/users/$sessionuser.png";
		}else if (is_file("avatars/users/$sessionuser.bmp") == TRUE) {
			$filetodelete = "avatars/users/$sessionuser.bmp";
		}
			if (unlink("$filetodelete") == TRUE) {
				?>
				<META HTTP-EQUIV="Refresh" 
				CONTENT="2;URL=usercp.php?function=avataroptions">
				Avatar deleted. You are being redirected.
				<?php
				}else{
					echo "Error deleting avatar.";
				}
				?>
				</td></tr></tbody></table>		
				<?php
	}else{
	if ($thing == "addnew") {
		if ($submitnewavatar == "Submit") {
		if ($achoice == "useuploaded") {
			$newavatar = "avatars/users/" . $sessionuser . $filetype;
		}
		$newavatar = $_POST['newavatar'];
		$sql = "UPDATE ibb_members SET aviator='$newavatar' WHERE name='$sessionuser'";
		if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=usercp.php?function=avataroptions">
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD bgcolor=<?php echo $muaboxbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Avatar URL changed. You are being redirected.</td></tr></tbody></table>
		<?php
		}else{
			mysql_error();
		}
}else{
		?>
		<TR>
                <TD width="20%" bgcolor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="usercp.php?function=avataroptions&thing=addnew" method=POST>
                    <TR>
                      <TD bgcolor=<?php echo $muaboxbgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><B>Change Avatar:</b></td></tr><tr><td>
					<FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>
					<?php
					if ($guploadavatar == "yes") {
					?>
					Change URL<INPUT TYPE="radio" NAME="achoice" VALUE="change" checked>
					Use Uploaded<INPUT TYPE="radio" NAME="achoice" VALUE="useuploaded"><br>
					If Changing: 
					<?php
					}
					?><input type=text name="newavatar" value="<?php echo $avatar; ?>"><br>
					<?php
					if ($guploadavatar == "yes") {
					?>
					If Using Uploaded: <select name="filetype">
					<option value=#>File Type Of Your Avatar</option>
					<option value=".gif">Gif</option>
					<option value=".jpg">Jpg</option>
					<option value=".png">Png</option>
					<option value=".bmp">Bmp</option>
					</select>
					<?php
					}
					?>
					</td></tr><tr><td>
					<input type=submit name="submitnewavatar" value="Submit"></td></tr></form></tbody></table>
	<?php
}
	}else{
	?>
		              <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD>
                        <P align=center>

			<?php 
				  //EDIT AT YOUR OWN RISK
				  if ($sessionuser == "Guest") {
				  echo ("<img src='images/guestavatar.gif'>");
			}else{
				if (($avatar == "") || ($avatar == "You do not have an avatar yet.")) {
				  echo ("<img src='images/noavatar.gif'>");
				}else{
					echo ("<img src='$avatar'>");
				}
				//HTML HERE ON OUT IS EDITABLE
			}?>

	                </FONT></P></TD></TR>
                    <TR>
                      <TD>
                        <P align=center><FONT face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Current 
                  Avatar</FONT></P></TD></TR></TBODY></TABLE></P></FONT></B></TD>
                <TD vAlign=top width="80%" bgColor=<?php echo $muaboxbgcolor; ?>>
				<?php
				if ($guploadavatar == "yes") {
				?>
				<a href="usercp.php?function=avataroptions&thing=delete"><font face=<?php echo $font; ?> color=<?php echo $mualinkcolor; ?> size=1>Delete Uploaded Avatar</a>
				<?php
				if ((is_file("avatars/users/$sessionuser.gif") == TRUE) || (is_file("avatars/users/$sessionuser.jpg") == TRUE) || (is_file("avatars/users/$sessionuser.png") == TRUE) || (is_file("avatars/users/$sessionuser.bmp") == TRUE)) {
					echo "<BR>You have an avatar uploaded<BR>";
				}else{
				?>
				<BR>
				<a href="usercp.php?function=avataroptions&thing=upload"><font face=<?php echo $font; ?> color=<?php echo $mualinkcolor; ?> size=1>Upload Avatar To Server</a></U>
				<BR>
				<?php
				}
				}
				?>
				<a href="usercp.php?function=avataroptions&thing=addnew"><font face=<?php echo $font; ?> color=<?php echo $mualinkcolor; ?> size=1>Change Avatar</a></U><br>
				<a href="usercp.php?function=avataroptions&thing=changes"><font face=<?php echo $font; ?> color=<?php echo $mualinkcolor; ?> size=1>Change Avatar's Dimensions</a></U>
				</FONT></TD></TR>
	<?php
		}
		}
		}
		}
}else{
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
$signature = eregi_replace("\\[url\\]www.([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>\\1</a>",$signature);
$signature = eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=_blank>\\1</a>",$signature);
$signature = eregi_replace("\\[url=([^\"]*)\\]([^\\[]*)\\[\\/url\\]","<a href=\"\\1\" target=_blank>\\2</a>",$signature);
$signature = str_replace("[quote]", "<i>", $signature);
$signature = str_replace("[/quote]", "</i><br>", $signature);
}
	?>
              <TR>
                <TD width="20%" background="" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Your E-Mail 
                Address</FONT></B></TD>
                <TD width="80%" background="" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $youremail; ?> [ <a href="usercp.php?function=changeemail">Change</a> ]</FONT></TD></TR>
			  <TR>
                <TD width="20%" background="" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Password</FONT></B></TD>
                <TD width="80%" background="" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>[ <a href="usercp.php?function=changepass">Change</a> ]</FONT></TD></TR>
              <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Total Posts</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $totalposts; ?></FONT></TD></TR>
              <TR>
                <TD width="20%" background="" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Total Active 
                Posts</FONT></B></TD>
                <TD width="80%" background="" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $totalaliveposts; ?></FONT></TD></TR>
              <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Registration date</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $registrationdate; ?></FONT></TD></TR>
			  <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Time Offset</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $timepreference; ?> [ <a href="usercp.php?function=changetpref">Change</a> ]</FONT></TD></TR>
			  <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Birthday</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $birthday; ?> [ <a href="usercp.php?function=changebday">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Location</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $location; ?> [ <a href="usercp.php?function=changelocal">Change</a> ]</FONT></TD></TR>
			  <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Occupation</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $occupation; ?> [ <a href="usercp.php?function=changeoccu">Change</a> ]</FONT></TD></TR>
			  <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Website</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><a href="<?php echo $website2; ?>"><?php echo $website2; ?></a> [ <a href="usercp.php?function=changewebsite">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>ICQ</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $icq; ?> [ <a href="usercp.php?function=changeicq">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>AIM</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $aim; ?> [ <a href="usercp.php?function=changeaim">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>MSN</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $msn; ?> [ <a href="usercp.php?function=changemsn">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Yahoo</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $yahoo; ?> [ <a href="usercp.php?function=changeyahoo">Change</a> ]</FONT></TD></TR>
			  <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Interests</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $interests; ?><br>[ <a href="usercp.php?function=changeinterests">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%" bgColor=<?php echo $muaboxbgcolor; ?>><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1>Signature</FONT></B></TD>
                <TD width="80%" bgColor=<?php echo $muaboxbgcolor; ?>><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size=1><?php echo $signature; ?><br>[ <a href="usercp.php?function=changesig">Change</a> ]</FONT></TD></TR>
              <TR bgColor=<?php echo $muatopbarbgcolor; ?>>
                <TD id=titlelarge colSpan=2><B><FONT 
                  face="<?php echo $font; ?>" color="<?php echo $muatopbartxtcolor; ?>" size=1>This is a summary of your account here at <?php echo $boardname; ?></FONT></B></TD></TR>
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
}
}
}
?>
</TBODY></TABLE></TD></TR></TBODY></TABLE></P>
<?php
include "footer.php";
echo $copyrights;


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>