<HTML><HEAD><TITLE>IcrediBB Installer</TITLE>
<STYLE type=text/css>
BODY {
	SCROLLBAR-BASE-COLOR: #16416D;
	SCROLLBAR-ARROW-COLOR: #ffffff;
}
SELECT {
	FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif;
	FONT-SIZE: 11px;
	COLOR: #000000;
	BACKGROUND-COLOR: #FFFFFF
}
TEXTAREA, .bginput {
	FONT-SIZE: 12px;
	FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif;
	COLOR: #000000;
	BACKGROUND-COLOR: #FFFFFF
}
A:link, A:visited, A:active {
	COLOR: <?php echo $linkcolor; ?>;
}
A:hover {
	COLOR: <?php echo $hoverlinkcolor; ?>;
}
#cat A:link, #cat A:visited, #cat A:active {
	COLOR: #ffffff;
	TEXT-DECORATION: none;
}
#cat A:hover {
	COLOR: #ffffff;
	TEXT-DECORATION: underline;
}
#ltlink A:link, #ltlink A:visited, #ltlink A:active {
	COLOR: #ffffff;
	TEXT-DECORATION: none;
}
#ltlink A:hover {
	COLOR: BEC8D1;
	TEXT-DECORATION: underline;
}
.thtcolor {
	COLOR: #ffffff;
}
</STYLE>

<META content="MSHTML 6.00.2600.0" name=GENERATOR></HEAD>
<BODY id=all text="#ffffff" vLink=#000020 aLink="#ffffff" link="#ffffff" bgColor="#16416d" topMargin=10 marginheight="10" marginwidth="10">
<CENTER>
<TABLE cellSpacing=1 cellPadding=5 width="760" bgColor=#000000 border=0>
  <TBODY>
  <TR>
	<TD bgColor=#2c5588>
	<center><FONT face=Verdana color="#ffffff" size=2>IcrediBB Installer For Up To Version 1.1</font></center>
  <TR>
	<TD bgColor=#16416d>
	<FONT face=Verdana color="#ffffff" size=1>
		<?php
	if ($db_submit == "Submit") {
		include "database.php";
		
		if ($db_Database) {
			echo "Database information has already been set.";
		}else{
		
		$fileadd = ("<?php

\$db_Database = '$db_name';

\$db_UserName = '$db_username';

\$db_Password = '$db_password';

\$db_Hostname = '$db_server';

?>");
		?><?
		$mysqlchange = @fopen("database.php", "w");
		if (!$mysqlchange) {
			echo "Unable To Open Database.php.";
		}else{
		@fputs($mysqlchange,stripslashes($fileadd));
		fclose($mysqlchange);
		echo "MySQL Information set.";
		}
		}
		echo "<br><br><b>Move onto <a href=\"installer.php?step=2\">next step</a>.</b>";
	}else{

	if ($step == "2") {
		include ("database.php");
		mysql_connect($db_Hostname, $db_UserName, $db_Password);
		mysql_select_db($db_Database);
		?>
		<b>Step TWO:</b> MySQL Table/Groups Creations<br><br>
		Creating Annoucement Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/announcements.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_announcements' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Banned IP Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/bannedip.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_bannedip' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
	    <br>----------------------
		<br>
		Creating Board Info Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/boardinfo.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_boardinfo' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Categories Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/categories.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_categories' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Forums Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/forums.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_forums' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Groups Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/groups.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_groups' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Adding 'Guests' group...
			<?php 
			$result = mysql_query("SELECT gname FROM ibb_groups WHERE gname='Guests'");
			while ($row = mysql_fetch_array($result)) {
				$gname = $row["gname"];
			}
			if ($gname != "Guests") {
				$query = mysql_query("INSERT INTO ibb_groups SET " .
				"gname='Guests'," .
				"gtitle='Guest'," .
				"posttopics='yes'," .
				"postreplies='yes'," . 
				"edittopics='no'," .
				"editreplies='no'," .
				"dtopics='no'," .
				"dreplies='no'," .
				"ptopics='no'," .
				"editownposts='no'," .
				"adminedit='no'," .
				"mtopics='no'");
				if ($query) {
					echo "DONE";
				}else{
					echo mysql_error();
				}
			}else{
				echo "Guests group already exists. It is safe to continue on.";
			}
			?>
			<br>
			Adding 'Members' group...
			<?php 
			$result = mysql_query("SELECT gname FROM ibb_groups WHERE gname='Members'");
			while ($row = mysql_fetch_array($result)) {
				$gname = $row["gname"];
			}
			if ($gname != "Members") {
				$query = mysql_query("INSERT INTO ibb_groups SET " .
				"gname='Members'," .
				"gtitle='Members'," .
				"posttopics='yes'," .
				"postreplies='yes'," . 
				"edittopics='no'," .
				"editreplies='no'," .
				"dtopics='no'," .
				"dreplies='no'," .
				"ptopics='no'," .
				"editownposts='no'," .
				"adminedit='no'," .
				"mtopics='no'");
				if ($query) {
					echo "DONE";
				}else{
					echo mysql_error();
				}
			}else{
				echo "Members group already exists. It is safe to continue on.";
			}
			?>
			<br>
			Adding 'Moderators' group...
			<?php 
			$result = mysql_query("SELECT gname FROM ibb_groups WHERE gname='Moderators'");
			while ($row = mysql_fetch_array($result)) {
				$gname = $row["gname"];
			}
			if ($gname != "Moderators") {
				$query = mysql_query("INSERT INTO ibb_groups SET " .
				"gname='Moderators'," .
				"gtitle='Moderator'," .
				"posttopics='yes'," .
				"postreplies='yes'," . 
				"edittopics='yes'," .
				"editreplies='yes'," .
				"dtopics='yes'," .
				"dreplies='yes'," .
				"ptopics='yes'," .
				"editownposts='yes'," .
				"adminedit='no'," .
				"mtopics='yes'");
				if ($query) {
					echo "DONE";
				}else{
					echo mysql_error();
				}
			}else{
				echo "Moderators group already exists. It is safe to continue on.";
			}
			?>
			<br>
			Adding 'Administrators' group...
			<?php 
			$result = mysql_query("SELECT gname FROM ibb_groups WHERE gname='Administrators'");
			while ($row = mysql_fetch_array($result)) {
				$gname = $row["gname"];
			}
			if ($gname != "Administrators") {
				$query = mysql_query("INSERT INTO ibb_groups SET " .
				"gname='Administrators'," .
				"gtitle='Administrator'," .
				"posttopics='yes'," .
				"postreplies='yes'," . 
				"edittopics='yes'," .
				"editreplies='yes'," .
				"dtopics='yes'," .
				"dreplies='yes'," .
				"ptopics='yes'," .
				"editownposts='yes'," .
				"adminedit='yes'," .
				"mtopics='yes'");
				if ($query) {
					echo "DONE";
				}else{
					echo mysql_error();
				}
			}else{
				echo "Moderators group already exists. It is safe to continue on.";
			}
			?>
		<br>----------------------
		<br>
		Creating Ignores Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/ignores.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_ignores' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Members Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/members.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_members' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Moderator Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/mods.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_mods' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Online Users Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/onlineusers.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_onlineusers' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Private Messages Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/priv_msgs.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_priv_msgs' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Replies Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/replies.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_replies' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		?>
		<br>----------------------
		<br>
		Creating Threads Table...
		<?php 
			$fcontents = join('', file ('mysqlfiles/threads.sql')); 
			$query = mysql_query("$fcontents");

			if ($query) {
				echo "DONE";
			}else{
				if (mysql_error() == "Table 'ibb_threads' already exists") {
					echo "Table exists already. If it is for another script, please rename it, or continue on if for IcrediBB.";
				}else{
					echo mysql_error();
				}
			}
		echo "<br><br><b>Move onto <a href=\"installer.php?step=3\">next step</a>.</b>";
	}else{

	if ($step == "3") {
		include ("database.php");
		mysql_connect($db_Hostname, $db_UserName, $db_Password);
		mysql_select_db($db_Database);
		if ($bisubmit == "Submit") {
			if (($boardname != "") || ($avheight != "") || ($avwidth != "")) {
			$result = mysql_query("SELECT boardname FROM ibb_boardinfo");
			while ($row = mysql_fetch_array($result)) {
				$oldboardname = $row["boardname"];
			}
			$boardname = htmlspecialchars($boardname);
			if ($oldboardname == "") {
			$sql = ("INSERT INTO ibb_boardinfo SET boardname='$boardname', avwidth='$avwidth', avheight='$avheight', theme='default'");
			if (mysql_query($sql)) {
				echo "Board Information set.<br><br><b>Move onto <a href=\"installer.php?step=4\">next step</a>.</b>";
			}else{
				echo mysql_error();
			}
			}else{
				echo "Board Information is already set.<br><br><b>Move onto <a href=\"installer.php?step=4\">next step</a>.</b>";
			}
			}else{
				echo "One or more fields were left blank.<br><br><b>Go back the <a href=\"installer.php?step=3\">last step</a>.</b>";
			}
		}else{
		?>
		<FORM action="installer.php?step=3" method="post">
		<b>Step THREE:</b> Setting Board Information (All Required)<br><br>
			Board Name:<br>
			<input type=text name="boardname"><br><br>
			Avatar Width:<br>
			<input type=text name="avheight"><br><br>
			Avatar Height:<br>
			<input type=text name="avwidth"><br><br>
			Board Logo:<br>
			<input type=text name="logo" value="images/logo5.gif"><br><br>
			<input type=submit name="bisubmit" value="Submit"></font></form>
		<?php 
		}
	}else{

	if ($step == "4") {
		include ("database.php");
		mysql_connect($db_Hostname, $db_UserName, $db_Password);
		mysql_select_db($db_Database);
		if ($adminsubmit == "Submit") {
			$thetime=date("m/d/Y");
			$status = "admin";
			if (($username != "") || ($password != "")) {
			$result = mysql_query("SELECT name FROM ibb_members WHERE status='admin'");
			while ($row = mysql_fetch_array($result)) {
				$adminusers = $row["name"];
			}
			if ($adminusers == "") {
				$password = md5($password);
			$sql = ("INSERT INTO ibb_members SET name='$username', password='$password', status='$status', groupname='Administrators', time='$thetime'");
			if (mysql_query($sql)) {
				echo "Admin account created.<br><br><b>Move onto <a href=\"installer.php?step=5\">next step</a>.</b>";
			}else{
				echo mysql_error();
			}
			}else{
				echo "An admin account has already been created.<br><br><b>Move onto <a href=\"installer.php?step=5\">next step</a>.</b>";
			}
			}else{
				echo "One or more fields were left blank.<br><br><b>Go back the <a href=\"installer.php?step=4\">last step</a>.</b>";
			}
		}else{
		?>
		<FORM action="installer.php?step=4" method="post">
		<b>Step FOUR:</b> Creating Admin Account (All Required)<br><br>
			Username:<br>
			<input type=text name="username"><br><br>
			Password:<br>
			<input type=text name="password"><br><br>
			<input type=submit name="adminsubmit" value="Submit"></font></form>
		<?php 
		}
	}else{

	if ($step == "5") {
		?>
		Congratulations on your new IcrediBB!<br>Please delete this file immediately (VERY IMPORTANT)!<br>You may now continue onto your forum. <br><br><b><a href="index.php">Click Here To Go To It</a>
		<?php 
	}else{
	?>
	<FORM action="installer.php" method="post">
	<b>Step ONE:</b> MySQL Database Information<br><br>
	<u>Note</u>: The installer will not create a database for you, you must have it created yourself.<br>The installer will only create the tables inside the database.<br><br>
	Database Username:<br>
	<input type=text name="db_username"><br><br>
	Database Password:<br>
	<input type=password name="db_password"><br><br>
	Database Server:<br>
	<input type=text name="db_server"><br><br>
	Database Name:<br>
	<input type=text name="db_name"><br><br>
	<input type=submit name="db_submit" value="Submit"></font></form>
	<?php
	}
	}
	}
	}
	}
	?>