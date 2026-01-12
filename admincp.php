<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


//gets the required file
require("header.php");

//sets the title correctly
$ptitle = "$boardname - AdminCP";
echo ("<title>$ptitle</title>");

//puts the title into DB
$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}

//makes sure the user is an administator in order to view it
if ($sessionstatus == "admin") {
?><STYLE type="text/css">
	A:link, A:visited, A:active {
	COLOR: #ffffff;
}
</style>
   <P>
      <CENTER>
      <TABLE 
      style="BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid" 
      cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=0 cellPadding=4 width="100%" border=0>
              <TBODY>
              <TR bgColor=#2c5588>
                <TD vAlign=top align=middle width="100%" bgColor=#2c5588>
		         <FONT face="verdana, arial, helvetica" size=2 colspan=8 color='#ffffff'><B>Adminstration 
                  Control Panel</B></FONT></TD></TR>
              <TR>
                <TD bgColor=#000000></TD></TR>
              <TR>
                <TD vAlign=top align=middle colSpan=2 bgcolor=#16416d>
                  <TABLE cellSpacing=0 cellPadding=2 width="98%" align=center 
                  background="" border=0>
                    <TBODY>
						<FONT face=Verdana color=#ffffff size=1>
<?php
if ($function == "modgroup") {
	if ($submitgroup == "Modify Group") {
			$grouptitle = $_POST['grouptitle'];
			$posttopics = $_POST['posttopics'];
			$postreplies = $_POST['postreplies'];
			$edittopics = $_POST['edittopics'];
			$editreplies = $_POST['editreplies'];
			$deletetopics = $_POST['deletetopics'];
			$deletereplies = $_POST['deletereplies'];
			$pinunpintopics = $_POST['pinunpintopics'];
			$editownposts = $_POST['editownposts'];
			$adminedit = $_POST['adminedit'];
			$uploadavatar = $_POST['uploadavatar'];
			$asize = $_POST['asize'];
			$movetopics = $_POST['movetopics'];
			$sql = "UPDATE ibb_groups SET " .
			"gtitle='$grouptitle'," .
			"posttopics='$posttopics'," .
			"postreplies='$postreplies'," . 
			"edittopics='$edittopics'," .
			"editreplies='$editreplies'," .
			"dtopics='$deletetopics'," .
			"dreplies='$deletereplies'," .
			"ptopics='$pinunpintopics'," .
			"editownposts='$editownposts'," .
			"adminedit='$adminedit'," .
			"uploadavatar='$uploadavatar'," .
			"amaxsize='$asize'," .
			"mtopics='$movetopics' WHERE gid='$groupname'";

			if (mysql_query($sql)) {
				?>
					<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Group editted. You are being redirected.
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
				<?php
			}else{
				?>
					<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Error editting group: <?php echo mysql_error(); ?>
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
				<?php
			}
	}else{
		?>
			<FORM action="admincp.php?function=modgroup" method=POST>
			<TR><TD>
							<TABLE cellSpacing=0 cellPadding=2 width="50%" border=0>
							<TBODY><TR><TD colspan=2><FONT face=Verdana color=#ffffff size=2>
							<strong>Modify Member Group:</strong><br></TD></TR>
							<TR><td width=15><TD width=100 colspan=2>
							<FONT face=Verdana color=#ffffff size=1>
							<strong>Basic Info:</strong>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Name: </td><td width=500>
<select name=groupname>
<?php
	$result = mysql_query("SELECT * FROM ibb_groups ORDER BY gname");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["gname"];
		$gid = $row["gid"];
		echo ("<option value=$gid>$name</option>");
	}
?></select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Title (max 250): </td><td width=500><input type=text name=grouptitle>
							</td></tr>
							<TR><td width=15><TD width=100 colspan=2>
							<FONT face=Verdana color=#ffffff size=1>
							<strong>Privileges:</strong>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Post Topics: </td><td width=500>
							<select name=posttopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Post Replies: </td><td width=500>
							<select name=postreplies>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Topics: </td><td width=500>
							<select name=edittopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Replies: </td><td width=500>
							<select name=editreplies>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Delete Topics: </td><td width=500>
							<select name=deletetopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Delete Replies: </td><td width=500>
							<select name=deletereplies>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Pin/Unpin Topics: </td><td width=500>
							<select name=pinunpintopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Move Topics: </td><td width=500>
							<select name=movetopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Own Posts: </td><td width=500>
							<select name=editownposts>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Admin Posts: </td><td width=500>
							<select name=adminedit>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Upload Avatar: </td><td width=500>
							<select name=uploadavatar>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select> <br><FONT face=Verdana color=#ffffff size=1>If Allowed, Maximum Size In Bytes: <input type=text name=asize>
							</td></tr>
							<TR><td width=15><TD width=100>
							<input type=submit name=submitgroup value="Modify Group">
							</td></tr>
							</tbody></table>
							<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
								<TBODY>
									<TR>
										<TD>
		<?php
	}
}else{

if ($function == "deletegroup") {
	if ($dthis == "Submit") {
		$dthisgroup = $_POST['dthisgroup'];
		$sql = "DELETE FROM ibb_groups WHERE gid='$dthisgroup'";
		if (mysql_query($sql)) {
			?>
				<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Group successfully deleted. You are being redirected.
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
			<?php
		}else{
			?>
				<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Error deleting group: <?php echo mysql_error(); ?>
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
			<?php
		}
	}else{
	?>
		<form action="admincp.php?function=deletegroup" method=POST>
		<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Select Group To Delete:<br>
						<select name="dthisgroup">
						<?php
	$result = mysql_query("SELECT * FROM ibb_groups ORDER BY gname");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["gname"];
		$gid = $row["gid"];
		echo ("<option value=$gid>$name</option>");
	}
						?>
						</select> <input type=submit name=dthis value=Submit>
					  </td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
	<?php
	}
}else{

if ($function == "addgroup") {
	if ($submitgroup == "Add Group") {
		$query = "select gname from ibb_groups where gname='$groupname'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$gname = $row[0];

		if ($gname == $groupname) {
			?>
				<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						That group name is already created. Please click the back button.
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
			<?php
		}else{
			$sql = "INSERT INTO ibb_groups SET " .
			"gname='$groupname'," .
			"gtitle='$grouptitle'," .
			"posttopics='$posttopics'," .
			"postreplies='$postreplies'," . 
			"edittopics='$edittopics'," .
			"editreplies='$editreplies'," .
			"dtopics='$deletetopics'," .
			"dreplies='$deletereplies'," .
			"ptopics='$pinunpintopics'," .
			"editownposts='$editownposts'," .
			"adminedit='$adminedit'," .
			"mtopics='$movetopics'";

			if (mysql_query($sql)) {
				?>
					<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Group created. You are being redirected.
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
				<?php
			}else{
				?>
					<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Error adding group: <?php mysql_error(); ?>
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
				<?php
			}
		}
	}else{
		?>
			<FORM action="admincp.php?function=addgroup" method=POST>
			<TR><TD>
							<TABLE cellSpacing=0 cellPadding=2 width="50%" border=0>
							<TBODY><TR><TD colspan=2><FONT face=Verdana color=#ffffff size=2>
							<strong>Add Member Group:</strong><br></TD></TR>
							<TR><td width=15><TD width=100 colspan=2>
							<FONT face=Verdana color=#ffffff size=1>
							<strong>Basic Info:</strong>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Name (max 50): </td><td width=50><input type=text name=groupname>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Title (max 250): </td><td width=50><input type=text name=grouptitle>
							</td></tr>
							<TR><td width=15><TD width=100 colspan=2>
							<FONT face=Verdana color=#ffffff size=1>
							<strong>Privileges:</strong>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Post Topics: </td><td width=50>
							<select name=posttopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Post Replies: </td><td width=50>
							<select name=postreplies>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Topics: </td><td width=50>
							<select name=edittopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Replies: </td><td width=50>
							<select name=editreplies>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Delete Topics: </td><td width=50>
							<select name=deletetopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Delete Replies: </td><td width=50>
							<select name=deletereplies>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Pin/Unpin Topics: </td><td width=50>
							<select name=pinunpintopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Move Topics: </td><td width=50>
							<select name=movetopics>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Own Posts: </td><td width=50>
							<select name=editownposts>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<FONT face=Verdana color=#ffffff size=1>
							Edit Admin Posts: </td><td width=50>
							<select name=adminedit>
							<option value=yes>Allow</option>
							<option value=no>Don't Allow</option>
							</select>
							</td></tr>
							<TR><td width=15><TD width=100>
							<input type=submit name=submitgroup value="Add Group">
							</td></tr>
							</tbody></table>
							<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
								<TBODY>
									<TR>
										<TD>
		<?php
	}
}else{

if ($function == "thchange") {
	if ($usethis == "Submit") {
		$sql = "UPDATE ibb_boardinfo SET theme='$usetheme' WHERE boardname='$boardname'";
		if (mysql_query($sql)) {
			?>
				<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Theme successfully changed. You are being redirected.
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
			<?php
		}else{
			?>
				<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Error changing theme: <?php echo mysql_error(); ?>
						</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
			<?php
		}
	}else{
	?>
		<form action="admincp.php?function=thchange" method=POST>
		<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Select Theme To Switch To:<br>
						<select name="usetheme">
						<?php
						if ($dir = @opendir("themes")) {
						  while (($file = readdir($dir)) !== false) {
							if (($file == ".") || ($file == "..")) {
							}else{
							echo "<option value='$file'>$file</option>";
							}
						  }  
						  closedir($dir);
						}
						?>
						</select> <input type=submit name=usethis value=Submit>
					  </td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
	<?php
	}
}else{
if ($function == "dtheme") {
	if ($deletethis == "Submit") {
		if (unlink("themes/$deletename/$deletename.php") === TRUE || file_exists("themes/$deletename/$deletename.php") === FALSE) {
		?>
			<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
		<?php
			if (rmdir("themes/$deletename/images") == TRUE && rmdir("themes/$deletename") == TRUE) {
				echo "Theme successfully deleted. You are being redirected.";
				?>
					<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
				<?php
			}else{
				echo "Error deleting theme.";
			}
		}else{
			echo "Error deleting theme1.";
		}
		?>
			</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
		<?php
	}else{
	?>
		<form action="admincp.php?function=dtheme" method=POST>
		<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Select Theme To Delete:<br>
						<select name="deletename">
						<?php
						if ($dir = @opendir("themes")) {
						  while (($file = readdir($dir)) !== false) {
							if (($file == ".") || ($file == "..")) {
							}else{
							echo "<option value='$file'>$file</option>";
							}
						  }  
						  closedir($dir);
						}
						?>
						</select> <input type=submit name=deletethis value=Submit>
					  </td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
	<?php
	}
}else{

if ($function == "thedit") {
	if (isset($themename)) {
		
		if ($submitedittedtheme == "Submit") {
include "$themename";

$update = ("<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copywrite © 2001-2002 IcrediBB Design Team         **
\***************************************************/


//general colors

\$bgcolor = \"$nbgcolor\";

\$font = \"$nfont\";

\$txtcolor = \"$ntxtcolor\";

\$linkcolor = \"$nlinkcolor\";

\$activelinkcolor = \"$nactivelinkcolor\";

\$hoverlinkcolor = \"$nhoverlinkcolor\";

//end of general colors

//header and footer colors

\$hbgcolor = \"$nhbgcolor\";

\$htopbarbgcolor = \"$nhtopbarbgcolor\";

\$htopbartxtcolor = \"$nhtopbartxtcolor\";

\$hboxbgcolor = \"$nhboxbgcolor\";

\$hboxtxtcolor = \"$nhboxtxtcolor\";

\$hlinkcolor = \"$nhlinkcolor\";

//end of header and footer colors

//index.php main category/forum colors

\$fcbgcolor = \"$nfcbgcolor\";

\$fclinkcolor = \"$nfclinkcolor\";

\$fctopbarbgcolor = \"$nfctopbarbgcolor\";

\$fctopbartxtcolor = \"$nfctopbartxtcolor\";

\$fccatbgcolor = \"$nfccatbgcolor\";

\$fccattxtcolor = \"$nfccattxtcolor\";

\$fccattxtsize = \"$nfccattxtsize\";

\$fcforumiconbgcolor = \"$nfcforumiconbgcolor\";

\$fcforumlinkcolor = \"$nfcforumlinkcolor\";

\$fcforumnamebgcolor = \"$nfcforumnamebgcolor\";

\$fcforumnametxtcolor = \"$nfcforumnametxtcolor\";

\$fcforumnametxtsize = \"$nfcforumnametxtsize\";

\$fcforumpostsbgcolor = \"$nfcforumpostsbgcolor\";

\$fcforumpoststxtcolor = \"$nfcforumpoststxtcolor\";

\$fcforumtopicsbgcolor = \"$nfcforumtopicsbgcolor\";

\$fcforumtopicstxtcolor = \"$nfcforumtopicstxtcolor\";

\$fcforumlpbgcolor = \"$nfcforumlpbgcolor\";

\$fcforumlptxtcolor = \"$nfcforumlptxtcolor\";

\$fcforummodsbgcolor = \"$nfcforummodsbgcolor\";

\$fcforummodstxtcolor = \"$nfcforummodstxtcolor\";

//end of index.php main category/forum colors

//member profile, usercp and admincp colors

\$muabgcolor = \"$nmuabgcolor\";

\$muatopbarbgcolor = \"$nmuatopbarbgcolor\";

\$muatopbartxtcolor = \"$nmuatopbartxtcolor\";

\$muaboxbgcolor = \"$nmuaboxbgcolor\";

\$muaboxtxtcolor = \"$nmuaboxtxtcolor\";

\$mualinkcolor = \"$nmualinkcolor\";

//end of member profile, usercp, and admincp colors

//view forum colors

\$forumbgcolor = \"$nforumbgcolor\";

\$forumlinkcolor = \"$nforumlinkcolor\";

\$forumtxtcolor = \"$nforumtxtcolor\";

\$forumtopbarbgcolor = \"$nforumtopbarbgcolor\";

\$forumtopbartxtcolor = \"$nforumtopbartxtcolor\";

\$forumiconbgcolor = \"$nforumiconbgcolor\";

\$forumtpbgcolor = \"$nforumtpbgcolor\";

\$forumtptxtcolor = \"$nforumtptxtcolor\";

\$forumusbgcolor = \"$nforumusbgcolor\";

\$forumustxtcolor = \"$nforumustxtcolor\";

\$forumrebgcolor = \"$nforumrebgcolor\";

\$forumretxtcolor = \"$nforumretxtcolor\";

\$forumviewsbgcolor = \"$nforumviewsbgcolor\";

\$forumviewstxtcolor = \"$nforumviewstxtcolor\";

\$forumlpbgcolor = \"$nforumlpbgcolor\";

\$forumlptxtcolor = \"$nforumlptxtcolor\";

//end of forum colors

//topic colors

\$topicbgcolor = \"$ntopicbgcolor\";

\$topiclinkcolor = \"$ntopiclinkcolor\";

\$topictxtcolor = \"$ntopictxtcolor\";

\$topictopbarbgcolor = \"$ntopictopbarbgcolor\";

\$topictopbartxtcolor = \"$ntopictopbartxtcolor\";

\$topicleftbgcolor = \"$ntopicleftbgcolor\";

\$topiclefttxtcolor = \"$ntopiclefttxtcolor\";

\$topicbleftbgcolor = \"$ntopicbleftbgcolor\";

\$topicblefttxtcolor = \"$ntopicblefttxtcolor\";

\$topicmainbgcolor = \"$ntopicmainbgcolor\";

\$topicmaintxtcolor = \"$ntopicmaintxtcolor\";

\$topicbrightbgcolor = \"$ntopicbrightbgcolor\";

\$topicbrighttxtcolor = \"$ntopicbrighttxtcolor\";

//end of topic colors

//member status colors for onlineusers and index.php

\$admincolor = \"$nadmincolor\";

\$modcolor = \"$nmodcolor\";

\$usercolor = \"$nusercolor\";

//end of member status colors

//scroll bar colors

\$scrollbasecolor = \"$nscrollbasecolor\";

\$scrolltrackcolor = \"$nscrolltrackcolor\";

\$scrollfacecolor = \"$nscrollfacecolor\";

\$scrollhighcolor = \"$nscrollhighcolor\";

\$scroll3dlight = \"$nscroll3dlight\";

\$scrolldscolor = \"$nscrolldscolor\";

\$scrollshadow = \"$nscrollshadow\";

\$scrollarrowcolor = \"$nscrollarrowcolor\";

//end of scroll bar colors

?>");
?>
<?php
		$file = @fopen("themes/$themename/$themename.php", "w+");
		if ($themename == "default" || $themename == "Greens") {
			echo "You can not edit the original themes.";
		}else{
			if (!$file) {
				?>
					<TR><TD>
							<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
							<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
							Unable to open theme file to edit. If this is an uploaded theme, you will not be able to edit it, therefore retaining the creator's work. Also, please make sure that the file is chmod 777.
						  </td></tr></tbody></table>
							<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
								<TBODY>
									<TR>
										<TD>
				<?php
				exit;
			}else{
			if (@fputs($file,$update) == TRUE) {
			?>
				<TR><TD>
							<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
							<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
							Theme editted. You are being redirected.
						  </td></tr></tbody></table>
							<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
								<TBODY>
									<TR>
										<TD>
											<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
			<?php
			}else{
				?>
					<TR><TD>
							<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
							<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
							Unable to edit theme. Please make sure the file is chmod 777.
						  </td></tr></tbody></table>
							<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
								<TBODY>
									<TR>
										<TD>
				<?php
				exit;
			}
		}
		}
		}else{
		if ($editthis == "Submit") {
			include("themes/$themename/$themename.php");
		}else{
			include("themes/default/default.php");
		}
		?>
		<form action="admincp.php?function=thedit&themename=<?php echo $themename; ?>" method=post>
		<TR><TD>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
			<strong>Edit Theme:</strong></td></tr><tr><td><br>
			<center><TABLE cellSpacing=1 cellPadding=5 width="98%" border=0 bgcolor=#000000>
			<TBODY>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit General Theme Information</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nbgcolor value="<?php echo $bgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nlinkcolor value="<?php echo $linkcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntxtcolor value="<?php echo $txtcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Font Face:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfont value="<?php echo $font; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Active Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nactivelinkcolor value="<?php echo $activelinkcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Hover Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nhoverlinkcolor value="<?php echo $hoverlinkcolor; ?>"></center></td></tr>
			</td></tr>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit Header And Footer Colors</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nhbgcolor value="<?php echo $hbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nhlinkcolor value="<?php echo $hlinkcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nhtopbarbgcolor value="<?php echo $htopbarbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nhtopbartxtcolor value="<?php echo $htopbartxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Box Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nhboxbgcolor value="<?php echo $hboxbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Box Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nhboxtxtcolor value="<?php echo $hboxtxtcolor; ?>"></center></td></tr>
			</td></tr>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit Forum And Category Colors</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcbgcolor value="<?php echo $fcbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfclinkcolor value="<?php echo $fclinkcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfctopbarbgcolor value="<?php echo $fctopbarbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfctopbartxtcolor value="<?php echo $fctopbartxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Category Background:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfccatbgcolor value="<?php echo $fccatbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Category Font Color / Size:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfccattxtcolor value="<?php echo $fccattxtcolor; ?>" style="WIDTH: 90px;"> / <input type=text name=nfccattxtsize value="<?php echo $fccattxtsize; ?>" style="WIDTH: 30px;"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Icon Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumiconbgcolor value="<?php echo $fcforumiconbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumlinkcolor value="<?php echo $fcforumlinkcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Name Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumnamebgcolor value="<?php echo $fcforumnamebgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Name Font Color / Size:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumnametxtcolor value="<?php echo $fcforumnametxtcolor; ?>" style="WIDTH: 90px;"> / <input type=text name=nfcforumnametxtsize value="<?php echo $fcforumnametxtsize; ?>" style="WIDTH: 30px;"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Posts Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumpostsbgcolor value="<?php echo $fcforumpostsbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Posts Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumpoststxtcolor value="<?php echo $fcforumpoststxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Topics Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumtopicsbgcolor value="<?php echo $fcforumtopicsbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Topics Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumtopicstxtcolor value="<?php echo $fcforumtopicstxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Latest Post Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumlpbgcolor value="<?php echo $fcforumlpbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Latest Post Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforumlptxtcolor value="<?php echo $fcforumlptxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Moderators Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforummodsbgcolor value="<?php echo $fcforummodsbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Forum Moderators Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nfcforummodstxtcolor value="<?php echo $fcforummodstxtcolor; ?>"></center></td></tr>
			</td></tr>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit View Forum, And Private Messaging Main Page Colors</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumbgcolor value="<?php echo $forumbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumlinkcolor value="<?php echo $forumlinkcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Icon Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumiconbgcolor value="<?php echo $forumiconbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumtxtcolor value="<?php echo $forumtxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumtopbarbgcolor value="<?php echo $forumtopbarbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumtopbartxtcolor value="<?php echo $forumtopbartxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Thread Name Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumtpbgcolor value="<?php echo $forumtpbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Thread Name Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumtptxtcolor value="<?php echo $forumtptxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			User Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumusbgcolor value="<?php echo $forumusbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			User Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumustxtcolor value="<?php echo $forumustxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Replies Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumrebgcolor value="<?php echo $forumrebgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Replies Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumretxtcolor value="<?php echo $forumretxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Views Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumviewsbgcolor value="<?php echo $forumviewsbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Views Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumviewstxtcolor value="<?php echo $forumviewstxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Last Post Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumlpbgcolor value="<?php echo $forumlpbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Last Post Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nforumlptxtcolor value="<?php echo $forumlptxtcolor; ?>"></center></td></tr>
			</td></tr>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit Topic, And View Private Message Colors</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicbgcolor value="<?php echo $topicbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopiclinkcolor value="<?php echo $topiclinkcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopictopbarbgcolor value="<?php echo $topictopbarbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopictopbartxtcolor value="<?php echo $topictopbartxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Left Box Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicleftbgcolor value="<?php echo $topicleftbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Left Box Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopiclefttxtcolor value="<?php echo $topiclefttxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Left Box Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicbleftbgcolor value="<?php echo $topicbleftbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Left Box Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicblefttxtcolor value="<?php echo $topicblefttxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Main Box Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicmainbgcolor value="<?php echo $topicmainbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Main Box Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicmaintxtcolor value="<?php echo $topicmaintxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Right Box Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicbrightbgcolor value="<?php echo $topicbrightbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Right Box Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopicbrighttxtcolor value="<?php echo $topicbrighttxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=ntopictxtcolor value="<?php echo $topictxtcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1></td>
			<td bgcolor=16416d width=140></td></tr>
			</td></tr>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit Member Profile, Online Users, and UserCP Colors</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nmuabgcolor value="<?php echo $muabgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Link Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nmualinkcolor value="<?php echo $mualinkcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nmuatopbarbgcolor value="<?php echo $muatopbarbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Top Bar Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nmuatopbartxtcolor value="<?php echo $muatopbartxtcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Box Background Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nmuaboxbgcolor value="<?php echo $muaboxbgcolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Bottom Box Font Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nmuaboxtxtcolor value="<?php echo $muaboxtxtcolor; ?>"></center></td></tr>
			</td></tr>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit Scroll Bar Colors</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Base Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscrollbasecolor value="<?php echo $scrollbasecolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Track Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscrolltrackcolor value="<?php echo $scrolltrackcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Face Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscrollfacecolor value="<?php echo $scrollfacecolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Highlight Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscrollhighcolor value="<?php echo $scrollhighcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			3D Light Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscroll3dlight value="<?php echo $scroll3dlight; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Dark Shadow Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscrolldscolor value="<?php echo $scrolldscolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Shadow Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscrollshadow value="<?php echo $scrollshadow; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Arrow Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nscrollarrowcolor value="<?php echo $scrollarrowcolor; ?>"></center></td></tr>
			</td></tr>
			<TR><TD bgcolor=#2c5588 colspan=4><FONT face=Verdana color=#ffffff size=1>
			<center><strong>Edit Member Status Colors</strong></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Administrator Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nadmincolor value="<?php echo $admincolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Moderator Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nmodcolor value="<?php echo $modcolor; ?>"></center></td></tr>
			<tr><td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Regular User Color:</td>
			<td bgcolor=16416d width=140><center>
			<input type=text name=nusercolor value="<?php echo $usercolor; ?>"></center>
			<td bgcolor=#16416d width=240><FONT face=Verdana color=#ffffff size=1>
			Finish:</td>
			<td bgcolor=16416d width=140><center>
			<input type=submit name=submitedittedtheme value="Submit"></center></td></tr>
			</td></tr>
			</tbody></table></center>
		</td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
		<?php
		}
	}else{
	?><form action="admincp.php" method=GET>
		<TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Select Theme To Edit:<br>
						<select name="themename">
						<?php
						if ($dir = opendir("themes")) {
						  while (($file = readdir($dir)) !== false) {
							if (($file == ".") || ($file == "..")) {
							}else{
							echo "<option value='$file'>$file</option>";
							}
						  }  
						  closedir($dir);
						}
						?>
						<input type=hidden name=function value=thedit>
						</select> <input type=submit name=editthis value=Submit>
					  </td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
		<?php
	}
}else{

if ($function == "newtheme") {
		  if ($submitnewthemename == "Submit") {
			  $oldum = umask(0);
			  if (mkdir("themes/$themename/", 0777) == TRUE) {
				  if (mkdir("themes/$themename/images/", 0777) == TRUE) {
				  umask($oldum);
				  ?>
					  <TR><TD>
						<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
						<TBODY><TR><TD><FONT face=Verdana color=#ffffff size=1>
						Theme created. You are being redirected to editting page.
					  </td></tr></tbody></table>
						<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
							<TBODY>
								<TR>
									<TD>
										<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php?function=thedit&themename=<?php echo $themename; ?>">
				<?php
				  }
			  }else{
				    echo "Error creating theme.";
			  }
		  }else{
		  ?>
			<TR><TD>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY><TR><TD>
			  <form action="admincp.php?function=newtheme" method=POST>
			  <FONT face=Verdana color=#ffffff size=1>Theme Name (will create a folder with this name):<br>
			  <input type=text name=themename></td><tr><tr><td>
			  <input type=submit name=submitnewthemename value=Submit>
			  </td></tr></tbody></table>
				<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
					<TBODY>
						<TR>
							<TD>
			 <?php
		  }
	  }else{
if ($function == "removemod") {
	?>
	Remove Forum Moderator:<br>
	<form action="admincp.php" method=POST>
	<SELECT name="dmfid">
	<?php
	echo ("<OPTION value=#>Select Forum To Remove From</OPTION>");
	echo ("<OPTION value=#>---------------------</OPTION>");
	$result = mysql_query("SELECT * FROM ibb_forums");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["name"];
		$fid = $row["fid"];
		echo ("<option value=$fid>$name</option>");
	}
	?></select><br><br>
	<input type=submit name=submitforumrms value=Submit>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
	<?php
}else{

if ($submitforumrms == "Submit") {
	?>
	<FONT face=Verdana color=#ffffff size=1>Remove Forum Moderator:<br>
	<form action="admincp.php" method=POST>
	<SELECT name="dmfid">
	<?php
	echo ("<OPTION value=#>Select Moderator To Remove From Forum</OPTION>");
	echo ("<OPTION value=#>---------------------</OPTION>");
	$result = mysql_query("SELECT * FROM ibb_mods WHERE fid='$dmfid'");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["name"];
		$fid = $row["fid"];
		echo ("<option value=$fid>$name</option>");
		?>
			<input type=hidden name=name value="<?php echo $name;?>">
		<?php
	}
	?></select><br><br>
	<input type=submit name=submitforumremove value=Submit>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
	<?php
}else{
	
if ($submitforumremove == "Submit") {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY><TR><TD><FONT color=#ffffff size=2 face=Tahoma>
		<?php
		$sql = "DELETE FROM ibb_mods WHERE fid='$dmfid' && name='$name'";
		if (mysql_query($sql)) {
			echo("Moderator is removed. You are being redirected.");
			?>
			<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
			<?php
		}else{
			echo mysql_error();
		}
		?>
		</font></td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
}else{

if ($function == "dannouncement") {
	?>
	<FONT face=Verdana color=#ffffff size=1>Delete Announcement:<br>
	<form action="admincp.php" method=POST>
	<SELECT name="daid">
	<?php
	echo ("<OPTION value=#>Select Announcement To Delete</OPTION>");
	echo ("<OPTION value=#>---------------------</OPTION>");
	$result = mysql_query("SELECT * FROM ibb_announcements");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["name"];
		$aid = $row["aid"];
		echo ("<option value=$aid>$name</option>");
	}
	?></select><br><br>
	<input type=submit name=submitdannouncement value=Submit>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
	<?php
}else{
	
if ($submitdannouncement == "Submit") {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY><TR><TD><FONT color=#ffffff size=2 face=Tahoma>
		<?php
		$sql = "DELETE FROM ibb_announcements WHERE aid='$daid'";
		if (mysql_query($sql)) {
			echo("Announcement is deleted.<br>");
			$sql = "DELETE FROM ibb_threads WHERE fid='a$daid'";
			if (mysql_query($sql)) {
				$sql = "DELETE FROM ibb_replies WHERE fid='a$daid'";
				if (mysql_query($sql)) {
					echo("Announcement's replies are deleted. You are being redirected.<br>");
					?>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
					<?php
				}else{
					echo mysql_error();
				}
			}else{
				echo mysql_error();
			}
		}else{
			echo mysql_error();
		}
		?>
		</font></td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
}else{

if ($function == "dcategory") {
	?>
	<FONT face=Verdana color=#ffffff size=1>Delete Forum:<br>
	<form action="admincp.php" method=POST>
	<SELECT name="dcid">
	<?php
	echo ("<OPTION value=#>Select Category To Delete</OPTION>");
	echo ("<OPTION value=#>---------------------</OPTION>");
	$result = mysql_query("SELECT * FROM ibb_categories");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["categories"];
		$cid = $row["cid"];
		echo ("<option value=$cid>$name</option>");
	}
	?></select><br><br>
	<input type=submit name=submitdcat value=Submit>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
	<?php
}else{
	
if ($submitdcat == "Submit") {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY><TR><TD><FONT color=#ffffff size=2 face=Tahoma>
		<?php
		$result = mysql_query("SELECT fid FROM ibb_forums WHERE cid='$dcid'");
		while ($row = mysql_fetch_array($result)) {
			$dfid = $row["fid"];
		}
		$sql = "DELETE FROM ibb_categories WHERE cid='$dcid'";
			if (mysql_query($sql)) {
				echo("Category is deleted.<br>");
				$sql = "DELETE FROM ibb_forums WHERE cid='$dcid'";
				if (mysql_query($sql)) {
					echo("Category's forums are deleted.<br>");
					$sql = "DELETE FROM ibb_threads WHERE fid='$dfid'";
					if (mysql_query($sql)) {
						echo("Category's forum's topics are deleted.<br>");
						$sql = "DELETE FROM ibb_replies WHERE fid='$dfid'";
						if (mysql_query($sql)) {
							echo("Category's forum's topic's replies are deleted. You are being redirected.<br>");
							?>
								<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
							<?php
						}else{
							echo mysql_error();
						}
					}else{
						echo mysql_error();
					}
				}else{
					echo mysql_error();
				}
			}else{
				echo mysql_error();
			}
		?>
		</font></td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
}else{

if ($function == "dforum") {
	?>
	<FONT face=Verdana color=#ffffff size=1>Delete Forum:<br>
	<form action="admincp.php" method=POST>
	<SELECT name="dfid">
	<?php
	echo ("<OPTION value=#>Select Forum To Delete</OPTION>");
	echo ("<OPTION value=#>---------------------</OPTION>");
	$result = mysql_query("SELECT * FROM ibb_forums");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["name"];
		$fid = $row["fid"];
		echo ("<option value=$fid>$name</option>");
	}
	?></select><br><br>
	<input type=submit name=submitdforum value=Submit>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
	<?php
}else{
	
if ($submitdforum == "Submit") {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY><TR><TD><FONT color=#ffffff size=2 face=Tahoma>
		<?php
		$sql = "DELETE FROM ibb_forums WHERE fid='$dfid'";
		if (mysql_query($sql)) {
			echo("Forum is deleted.<br>");
			$sql = "DELETE FROM ibb_threads WHERE fid='$dfid'";
			if (mysql_query($sql)) {
				echo("Forum's topics are deleted.<br>");
				$sql = "DELETE FROM ibb_replies WHERE fid='$dfid'";
				if (mysql_query($sql)) {
					echo("Forum's topic's replies are deleted. You are being redirected.<br>");
					?>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
					<?php
				}else{
					echo mysql_error();
				}
			}else{
				echo mysql_error();
			}
		}else{
			echo mysql_error();
		}
		?>
		</font></td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
}else{

if ($function == "editannouncement") {
	?>
	<FONT face=Verdana color=#ffffff size=1>Edit Announcement:<br>
	<form action="admincp.php" method=POST>
	<SELECT name="editaid">
	<?php
	echo ("<OPTION value=#>Select Announcement To Edit</OPTION>");
	echo ("<OPTION value=#>---------------------</OPTION>");
	$result = mysql_query("SELECT * FROM ibb_announcements");
	while ($row = mysql_fetch_array($result)) {
		$oldaname = $row["name"];
		$oldadescription = $row["description"];
		$oldaid = $row["aid"];
		echo ("<option value=$oldaid>$oldaname</option>");
	}
	?></select><br><br>
	<input type=submit name=submiteditaid value=Submit>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
	<?php
}else{

if ($submiteditaid == "Submit") {
	$result = mysql_query("SELECT * FROM ibb_announcements WHERE aid='$editaid'");
	while ($row = mysql_fetch_array($result)) {
		$name = $row["name"];
		$description = $row["description"];
	}

	$query = "SELECT description FROM ibb_threads WHERE fid='a$editaid'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$message = $row[0];
	?>
	</SELECT>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY><form action="admincp.php" method=POST>
							<TR>
                            <TD><FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
	                      <TR>
                            <TD>
						   <FONT face=Verdana color=#ffffff size=1>Annoucement Name:</FONT></TD></TR>
                          <TR>
                            <TD><INPUT name="aname" value="<?php echo $name; ?>"></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Announcement Description:</FONT></TD></TR>
                          <TR>
                            <TD><input type=text name=adescription value="<?php echo $description; ?>"></TD></TR>
						  <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Announcement:</FONT></TD></TR>
						  <TR>
                            <TD><TEXTAREA style="WIDTH: 254px; HEIGHT: 125px" name="amessage" rows=8 cols=50><?php echo $message; ?></TEXTAREA></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow Replies:</FONT></TD></TR>
                          <TR>
                            <TD>
							<select name="allowreplies">

									<option value="yes">Replies Allowed</option>

									<option value="no">Replies Not Allowed</option>

							</select></TD></TR><input type=hidden name=editaid value="<?php echo $editaid; ?>">
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>&nbsp;</FONT></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=2 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD>
                                <P align=center><INPUT type=submit value="Edit Announcement" name="editannouncement"><FONT 
                                face=Verdana color=#ffffff 
                                size=1></FONT></P></TD>
                                </TR></form></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
		<?php
}else{

if ($editannouncement == "Edit Announcement") {
		$sql = "UPDATE ibb_announcements SET allowreplies='$allowreplies', name='$aname', description='$adescription' WHERE aid='$editaid'";
		if (mysql_query($sql)) {
			?>
			<TR><TD>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
			<?php
			$amessage = str_replace("
				", "[br]", $amessage);
			$sql = "UPDATE ibb_threads SET " .
			"subject='$adescription'," .
			"description='$amessage' WHERE fid='a$editaid'";
			if (mysql_query($sql)) {
			}else{
			echo mysql_error();
			}
			echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Announcement is editted. You are now being redirected.</font></td></tr></tbody></table>");
			?>
			<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
				<TBODY>
					<TR>
						<TD>
							<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
			<?php
		}else{
			?>
			<TR><TD>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
				<TBODY>
					<TR>
						<TD>
			<?php
			}
			$amessage = str_replace("
				", "[br]", $amessage);
			$sql = "UPDATE ibb_threads SET " .
			"subject='$adescription'," .
			"description='$amessage' WHERE fid='a$editaid'";
			if (mysql_query($sql)) {
			}else{
			echo mysql_error();
			}
			echo mysql_error();
			?>
			</td></tr></tbody></table>
			<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
				<TBODY>
					<TR>
						<TD>
			<?php
}else{

if ($function == "addannouncement") {
	?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY><form action="admincp.php" method=POST>
							<TR>
                            <TD><FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
	                      <TR>
                            <TD>
						   <FONT face=Verdana color=#ffffff size=1>Annoucement Name:</FONT></TD></TR>
                          <TR>
                            <TD><INPUT name="aname"></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Announcement Description:</FONT></TD></TR>
                          <TR>
                            <TD><input type=text name=adescription></TD></TR>
						  <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Announcement:</FONT></TD></TR>
						  <TR>
                            <TD><TEXTAREA style="WIDTH: 254px; HEIGHT: 125px" name="message" rows=8 cols=50></TEXTAREA></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow Replies:</FONT></TD></TR>
                          <TR>
                            <TD>
							<select name="allowreplies">

									<option value="yes">Replies Allowed</option>

									<option value="no">Replies Not Allowed</option>

							</select></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>&nbsp;</FONT></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=2 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD>
                                <P align=center><INPUT type=submit value="Post Announcement" name="submitannouncement"><FONT 
                                face=Verdana color=#ffffff 
                                size=1></FONT></P></TD>
                                </TR></form></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
		<?php
}else{

if ($submitannouncement == "Post Announcement") {
		$sql = "INSERT INTO ibb_announcements SET allowreplies='$allowreplies', name='$aname', description='$adescription'";
		if (mysql_query($sql)) {
			?>
			<TR><TD>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
			<?php
			echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Announcement is added. You are now being redirected.</font></td></tr></tbody></table>");
			?>
			<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
				<TBODY>
					<TR>
						<TD>
							<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
			<?php
		}else{
			?>
			<TR><TD>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
				<TBODY>
					<TR>
						<TD>
			<?php
			mysql_error();
			?>
			</td></tr></tbody></table>
			<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
				<TBODY>
					<TR>
						<TD>
			<?php
		}
		$query = "SELECT aid FROM ibb_announcements WHERE name='$aname'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$newaid = $row[0];
		$message = str_replace("
				", "[br]", $message);
		$sql = "INSERT INTO ibb_threads SET " .
		"name='Administrator'," .
		"fid='a$newaid'," .
		"subject='$adescription'," .
		"time='Posted On: $thetime'," . 
		"image='images/smile.gif'," .
		"timeline='$ttime'," .
		"description='$message'";
		if (mysql_query($sql)) {
		}else{
		echo mysql_error();
		}
}else{
		

if ($function == "newmod") {
	?>
				    <TR>
                      <TD vAlign=top><FONT face=Verdana color=#ffffff 
                        size=1>Select forum to add moderator to:</FONT></TD></TR>
                    <TR>
                      <TD vAlign=top></TD></TR>
                    <TR>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        background="" border=0>
                          <TBODY><form action="admincp.php" method=POST>
                          <TR>
                            <TD><SELECT  name=forumtoaddmodto> 
							<OPTION value=-1 selected>Select Forum:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
							<?php
							$result = mysql_query("SELECT name FROM ibb_forums") or die (mysql_error());
							while ($row = mysql_fetch_array($result)) {
							$forumarray[] = $row ["name"];
							}
							foreach ($forumarray as $forumnames) {
							$result = mysql_query("SELECT fid FROM ibb_forums WHERE name='$forumnames'") or die (mysql_error());
							while ($row = mysql_fetch_array($result)) {
							$forumid = $row ["fid"];
							}
							echo ("<OPTION value=$forumid>$forumnames</OPTION>");
							}
							?>
							</SELECT>&nbsp;<INPUT type=submit value="Submit" name=submitforumstuff></TD></TR></form>
	<?php
}else{

if ($submitforumstuff == "Submit") {
	?>
	<form action="admincp.php" method=POST>
	<tr><td><FONT face=Verdana color=#ffffff size=1>New Forum Moderator:</font></td></tr>
	<tr><td><INPUT type=text name="newmod"></td></tr>
	<input type=hidden value="<?php echo $forumtoaddmodto; ?>" name="forumid">
	<tr><td><INPUT type=submit value="Add Moderator" name="newmodsubmit"></TD></TR></form><TR><TD>
	<TABLE cellSpacing=0 cellPadding=2 width=300 background="" border=0>
           <TBODY>
                <TR>
                      <TD>
	<?php
}else{
		
if ($newmodsubmit == "Add Moderator") {
	$query = "select mid from ibb_members where name ='$newmod'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$modid = $row[0];
	$sql = "INSERT INTO ibb_mods SET fid='$forumid', name='$newmod', mid='$modid'";
	if (mysql_query($sql)) {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY>
		<?php
		echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Moderator is added. You are now being redirected.</font></td></tr></tbody></table>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
	}else{
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
		mysql_error();
		?>
		</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
	}
}else{

if ($function == "deletemember") {
	?>
		<TR>
                      <TD vAlign=top><FONT face=Verdana color=#ffffff size=1>Delete Member:</FONT></TD></TR>
                    <TR>
                      <TD vAlign=top></TD></TR>
                    <TR>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        background="" border=0>
                          <TBODY><form action="admincp.php" method=POST>
                          <TR>
                            <TD><SELECT  name=mtodelete> 
<OPTION value=-1 selected>Select member to delete:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
<?php
$result = mysql_query("SELECT mid FROM ibb_members") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$memberarray[] = $row ["mid"];
}
foreach ($memberarray as $memberid) {
$result = mysql_query("SELECT name FROM ibb_members WHERE mid='$memberid'") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$membername = $row ["name"];
}
echo ("<OPTION value=$memberid>$membername</OPTION>");
}
?>
</SELECT></td></tr>
<tr><td><INPUT type=submit value="Delete Member" name="deletemember"></TD></TR></form>
<?php
}else{

if ($deletemember == "Delete Member") {
	$sql = "DELETE FROM ibb_members WHERE mid = '$mtodelete'";
	if (mysql_query($sql)) {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY>
		<?php
		echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The member has been deleted. You are now being redirected.</font></td></tr></tbody></table>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
	}else{
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
		mysql_error();
		?>
		</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
	}
}else{

if ($function == "emailmembers") {
	if ($submitemail == "Send Email") {
		if ($gname == "all") {
			$to = "";
		}else{
			$to = "WHERE gname='$gname'";
		}
		$result = mysql_query("SELECT email FROM ibb_members $to");
		while ($row = mysql_fetch_array($result)) {
			$memberemailarray[] = $row["email"];
		}
		foreach ($memberemailarray as $memberemails) {
			mail ($memberemails, $subject, stripslashes($message), "$boardname\r\n");
		}
		echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Emails Sent Successfully. You Are Now Being Redirected.</center></td></TR></TBODY></TABLE>");
				?>
				<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
					<TBODY>
						<TR>
						<TD>
							<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
	}else{
			?>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor=#000000 background="" border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
	<form action="admincp.php?function=emailmembers" method=POST name=newpm>
        <TR bgColor=#16416d>
          <TD bgColor=#16416d><FONT face="Tahoma, Verdana, Arial" 
            size=2><B>Subject:</B></FONT></TD>
          <TD bgColor=#16416d><FONT face="Tahoma, Verdana, Arial" 
            size=2><INPUT class=bginput tabIndex=1 maxLength=85 size=40 
            name=subject></FONT></TD></TR>
		<TR bgColor=#2c5588>
          <TD bgColor=#2c5588><FONT face="Tahoma, Verdana, Arial" 
            size=2><B>Recipients:</B></FONT></TD>
          <TD bgColor=#2c5588><FONT face="Tahoma, Verdana, Arial" 
            size=2>
			<select name=gname>
<?php
echo "<option value=\"all\">All Members</option>";
$result = mysql_query("SELECT distinct gname FROM ibb_groups WHERE gname <> 'Guests' ORDER BY gname");
while ($row = mysql_fetch_array($result)) {
	$groupname = $row["gname"];
	echo "<option value=\"$groupname\">$groupname</option>";
}
?></select>
			</FONT></TD></TR>
        <TR>
          <TD noWrap bgColor=#16416d>
            <P><center>
<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="#000000">
<TR>
<TD height=10 width="65" bgcolor=#2c5588><center><FONT face="Tahoma, Verdana, Arial" size=2>Emoticons</center>
</TD>
</TR>
<TR>
<TD height=90 width="65" bgcolor=#2c5588 valign=center>
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
          <TD bgColor=#16416d>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=message rows=10 wrap=virtual cols=60>
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
			<TR><TD bgColor=#2c5588 colspan=2><center>
          <INPUT type=submit value="Send Email" name=submitemail></center></td></TR>
<?php
	}
}else{

if ($function == "pmmembers") {
	if ($submitpm == "Submit PM") {
		if ($gname == "all") {
			$to = "";
		}else{
			$to = "WHERE gname='$gname'";
		}
		$result = mysql_query("SELECT mid FROM ibb_members $to");
		while ($row = mysql_fetch_array($result)) {
			$memberidarray[] = $row["mid"];
		}
		foreach ($memberidarray as $pmmemberid) {
			$sql = "INSERT INTO ibb_priv_msgs SET " .
			"fmid='1'," .
			"subject='$subject'," .
			"mid='$pmmemberid'," .
			"time='$ttime'," . 
			"pmimage='$images'," .
			"date='$servertime'," .
			"messege='$message'";

			if (mysql_query($sql)) {
				echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>PMs Sent Successfully. You Are Now Being Redirected.</center></td></TR></TBODY></TABLE>");
				?>
				<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
					<TBODY>
						<TR>
						<TD>
							<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
				<?php
			} else {
				echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Error Sending PMs: " .
				mysql_error() . "</FONT></center></td></TR></TBODY></TABLE>");
				?>
				<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
					<TBODY>
						<TR>
						<TD>
				<?php
			}
		}
	}else{
			?>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center 
      bgColor=#000000 background="" border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0>
              <TBODY>
	<form action="admincp.php?function=pmmembers" method=POST name=newpm>
        <TR bgColor=#16416d>
          <TD bgColor=#16416d><FONT face="Tahoma, Verdana, Arial" 
            size=2><B>Subject:</B></FONT></TD>
          <TD bgColor=#16416d><FONT face="Tahoma, Verdana, Arial" 
            size=2><INPUT class=bginput tabIndex=1 maxLength=85 size=40 
            name=subject></FONT></TD></TR>
		<TR bgColor=#2c5588>
          <TD bgColor=#2c5588><FONT face="Tahoma, Verdana, Arial" 
            size=2><B>Recipients:</B></FONT></TD>
          <TD bgColor=#2c5588><FONT face="Tahoma, Verdana, Arial" 
            size=2>
			<select name=gname>
<?php
echo "<option value=\"all\">All Members</option>";
$result = mysql_query("SELECT distinct gname FROM ibb_groups WHERE gname <> 'Guests' ORDER BY gname");
while ($row = mysql_fetch_array($result)) {
	$groupname = $row["gname"];
	echo "<option value=\"$groupname\">$groupname</option>";
}
?></select>
			</FONT></TD></TR>
        <TR>
          <TD vAlign=top bgColor=#2c5588><FONT face="Tahoma, Verdana, Arial" 
            size=2><B>Mood:</B></FONT></TD>
          <TD bgColor=#2c5588><FONT face="Tahoma, Verdana, Arial" 
            size=1>
<input type="radio" name="images" value="images/smile.gif" checked><img src="images/smile.gif"> 
<input type="radio" name="images" value="images/sad.gif"><img src="images/sad.gif"> 
<input type="radio" name="images" value="images/mad.gif"><img src="images/mad.gif"> 
<input type="radio" name="images" value="images/biggrin.gif"><img src="images/biggrin.gif"> 
<input type="radio" name="images" value="images/slant.gif"><img src="images/slant.gif"> 
<input type="radio" name="images" value="images/wink.gif"><img src="images/wink.gif"> </FONT></TD></TR>
        <TR>
          <TD noWrap bgColor=#16416d>
            <P><center>
<TABLE cellSpacing=1 cellPadding=3 border=0 bgcolor="#000000">
<TR>
<TD height=10 width="65" bgcolor=#2c5588><center><FONT face="Tahoma, Verdana, Arial" size=2>Emoticons</center>
</TD>
</TR>
<TR>
<TD height=90 width="65" bgcolor=#2c5588 valign=center>
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
          <TD bgColor=#16416d>
            <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR vAlign=top>
                <TD><TEXTAREA tabIndex=2 name=message rows=10 wrap=virtual cols=60>
Enter Your PM Here
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
			<TR><TD bgColor=#2c5588 colspan=2><center>
          <INPUT type=submit value="Submit PM" name=submitpm></center></td></TR>
<?php
	}
}else{

if ($function == "removebanip") {
	?>
		<TR>
                      <TD vAlign=top><FONT face=Verdana color=#ffffff size=1>Remove Banned IP:</FONT></TD></TR>
                    <TR>
                      <TD vAlign=top></TD></TR>
                    <TR>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        background="" border=0>
                          <TBODY><form action="admincp.php" method=POST>
                          <TR>
                            <TD><SELECT  name=iptoremove> 
<OPTION value=-1 selected>Select IP to unban:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
<?php
$result = mysql_query("SELECT * FROM ibb_bannedip") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$IParray[] = $row ["IP"];
}
foreach ($IParray as $IPnumbers) {
echo ("<OPTION value=$IPnumbers>$IPnumbers</OPTION>");
}
?>
</SELECT></td></tr>
<tr><td><INPUT type=submit value="Remove Banned IP" name="submitremovedip"></TD></TR></form>
<?php
}else{

if ($submitremovedip == "Remove Banned IP") {
	$sql = "DELETE FROM ibb_bannedip WHERE IP = '$iptoremove'";
	if (mysql_query($sql)) {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY>
		<?php
		echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The banned IP has been removed. You are now being redirected.</font></td></tr></tbody></table>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
	}else{
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
		mysql_error();
		?>
		</td></tr></tbody></table>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
		<?php
	}
}else{

if ($function == "changepass") {
	?>
		<TR>
                      <TD vAlign=top><FONT face=Verdana color=#ffffff size=1>Change member password:</FONT></TD></TR>
                    <TR>
                      <TD vAlign=top></TD></TR>
                    <TR>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        background="" border=0>
                          <TBODY><form action="admincp.php" method=POST>
                          <TR>
                            <TD><SELECT  name=passtoedit> 
<OPTION value=-1 selected>Select Member To Edit:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
<?php
$result = mysql_query("SELECT name FROM ibb_members ORDER BY name") or mysql_error();
while ($row = mysql_fetch_array($result)) {
$memberarray[] = $row ["name"];
}
foreach ($memberarray as $membernames) {
$membernames = str_replace("'", "\\'", $membernames);
$result = mysql_query("SELECT mid FROM ibb_members WHERE name='$membernames'") or mysql_error();
while ($row = mysql_fetch_array($result)) {
$memberid = $row ["mid"];
}
echo ("<OPTION value=$memberid>$membernames</OPTION>");
}
?>
</SELECT></td></tr>
<tr><td><FONT face=Verdana color=#ffffff size=1>New Password:</font></td></tr>
<tr><td><INPUT type=text name="newpassword"></td></tr>
<tr><td><INPUT type=submit value="Change Password" name="editpasswordsubmit"></TD></TR></form>
<?php
}else{

$newpassword = md5($newpassword);
if ($editpasswordsubmit == "Change Password") {
	$sql = "UPDATE ibb_members SET password='$newpassword' WHERE mid='$passtoedit'";
	if (mysql_query($sql)) {
?>
<TR><TD>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<?php
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The member's password has been editted. You are now being redirected.</font></td></tr>");
?>
<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
<TBODY>
<TR>
<TD>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<?php
	}else{
	echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>");
	mysql_error();
	echo("</font></td></tr>");
	}
}else{

if ($function == "addmodforum") {
	?>
<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY><form action="admincp.php" method=POST>
							<TR>
                            <TD><FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
		                    <TR>
                            <TD>
						    <FONT face=Verdana color=#ffffff size=1>Category:</FONT></TD></TR>
                            <TR>
							<TR>
                            <TD>
							<SELECT  name=belongcategory> 
							<OPTION value=-1 selected>Select Category:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
							<?php
							$result = mysql_query("SELECT * FROM ibb_categories") or die (mysql_error());
							while ($row = mysql_fetch_array($result)) {
								$catarray[] = $row ["cid"];
							}
							foreach ($catarray as $catid) {
								$result = mysql_query("SELECT categories FROM ibb_categories WHERE cid='$catid'") or die(mysql_error());
								while ($row = mysql_fetch_array($result)) {
									$catnames = $row ["categories"];
								}
								echo ("<OPTION value=$catid>$catnames</OPTION>");
							}
							?>
							</SELECT></TD></TR>
	                      <TR>
                            <TD>
						   <FONT face=Verdana color=#ffffff size=1>Forum Name:</FONT></TD></TR>
                          <TR>
                            <TD><INPUT name="forumname"></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Forum 
                              Description:</FONT></TD></TR>
                          <TR>
                            <TD><TEXTAREA style="WIDTH: 254px; HEIGHT: 125px" name="thesubject" rows=6 cols=34></TEXTAREA><FONT 
                              face=Verdana color=#ffffff size=1> </FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              HTML:</FONT></TD></TR>
                          <TR>
                            <TD>
							<select name="allowhtml">

									<option value="yes">HTML Allowed</option>

									<option value="no">HTML Not Allowed</option>

							</select>
							<FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              IcrediCode:</FONT></TD></TR>
                          <TR>
                            <TD>
							<select name="allowcode">

									<option value="yes">IcrediCode Allowed</option>

									<option value="no">IcrediCode Not Allowed</option>

							</select>
								<FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>

							<input type=hidden value="Moderator,admin" name="viewableto">

							<input type=hidden value="Moderator,admin" name="whocanpost">

                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>&nbsp;</FONT></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=2 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD>
                                <P align=center><INPUT type=submit value="Add Moderator Forum" name="submitmodforum"><FONT 
                                face=Verdana color=#ffffff 
                                size=1></FONT></P></TD>
                                </TR></form></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
<?php
}else{

if ("Add Moderator Forum" == $submitmodforum) {
$forumname = str_replace("'", "", $forumname);
$forumname = str_replace("\"", "", $forumname);
$thesubject = str_replace("'", "", $thesubject);
$thesubject = str_replace("\"", "", $thesubject);
$sql = "INSERT INTO ibb_forums SET " .
"name='$forumname'," .
"fid='$fid'," .
"cid='$belongcategory'," .
"allowhtml='$allowhtml'," .
"allowcode='$allowcode'," .
"viewableto='$viewableto'," .
"whocanpost='$whocanpost'," .
"description='$thesubject', " .
"date=CURDATE()";
if (mysql_query($sql)) {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The moderator forum \"$forumname\" has been added. You are now being redirected.</font></td></tr>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<?php
} else {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Error adding moderator forum \"$forumname\": " .
mysql_error() . "</font></td></tr>");
}
}else{

if ($function == "addadminforum") {
	?>
<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY><form action="admincp.php" method=POST>
							<TR>
                            <TD><FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
		                    <TR>
                            <TD>
						    <FONT face=Verdana color=#ffffff size=1>Category:</FONT></TD></TR>
                            <TR>
							<TR>
                            <TD>
<SELECT  name=belongcategory> 
<OPTION value=-1 selected>Select Category:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
<?php
$result = mysql_query("SELECT * FROM ibb_categories") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$catarray[] = $row ["cid"];
}
foreach ($catarray as $catid) {
$result = mysql_query("SELECT categories FROM ibb_categories WHERE cid='$catid'") or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
$catnames = $row ["categories"];
}
echo ("<OPTION value=$catid>$catnames</OPTION>");
}
?>
</SELECT></TD></TR>
	                      <TR>
                            <TD>
						   <FONT face=Verdana color=#ffffff size=1>Forum Name:</FONT></TD></TR>
                          <TR>
                            <TD><INPUT name="forumname"></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Forum 
                              Description:</FONT></TD></TR>
                          <TR>
                            <TD><TEXTAREA style="WIDTH: 254px; HEIGHT: 125px" name="thesubject" rows=6 cols=34></TEXTAREA><FONT 
                              face=Verdana color=#ffffff size=1> </FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              HTML:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="allowhtml">

        <option value="yes">HTML Allowed</option>

		<option value="no">HTML Not Allowed</option>

</select>
<FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              IcrediCode:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="allowcode">

        <option value="yes">IcrediCode Allowed</option>

		<option value="no">IcrediCode Not Allowed</option>

</select>
								<FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>

<input type=hidden value="admin" name="viewableto">

<input type=hidden value="admin" name="whocanpost">

                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>&nbsp;</FONT></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=2 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD>
                                <P align=center><INPUT type=submit value="Add Admin Forum" name="submitadminforum"><FONT 
                                face=Verdana color=#ffffff 
                                size=1></FONT></P></TD>
                                </TR></form></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
<?php
}else{

if ("Add Admin Forum" == $submitadminforum) {
$sql = "INSERT INTO ibb_forums SET " .
"name='$forumname'," .
"fid='$fid'," .
"cid='$belongcategory'," .
"allowhtml='$allowhtml'," .
"allowcode='$allowcode'," .
"viewableto='$viewableto'," .
"whocanpost='$whocanpost'," .
"description='$thesubject', " .
"date=CURDATE()";
if (mysql_query($sql)) {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The admin forum \"$forumname\" has been added. You are now being redirected.</font></td></tr>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<?php
} else {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Error adding admin forum \"$forumname\": " .
mysql_error() . "</font></td></tr>");
}
}else{

if ($function == "editcategory") {
	?>
		<TR>
                      <TD vAlign=top><FONT face=Verdana color=#ffffff 
                        size=1>Select category to edit:</FONT></TD></TR>
                    <TR>
                      <TD vAlign=top></TD></TR>
                    <TR>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        background="" border=0>
                          <TBODY><form action="admincp.php" method=POST>
                          <TR>
                            <TD><SELECT  name=cattoedit> 
<OPTION value=-1 selected>Select Category To Edit:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
<?php
$result = mysql_query("SELECT categories FROM ibb_categories") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$catarray[] = $row ["categories"];
}
foreach ($catarray as $catnames) {
$result = mysql_query("SELECT cid FROM ibb_categories WHERE categories='$catnames'") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$catid = $row ["cid"];
}
echo ("<OPTION value=$catid>$catnames</OPTION>");
}
?>
</SELECT>&nbsp;<INPUT type=submit value="Go Edit" name="editcatsubmit"></TD></TR></form>
	<?php
}else{

if ($editcatsubmit == "Go Edit") {
$result = mysql_query("SELECT categories FROM ibb_categories WHERE cid='$cattoedit'") or mysql_error();
while ($row = mysql_fetch_array($result)) {
	$categoryname = $row["categories"];
}
	?>
		<form action="admincp.php" method=POST>
		<TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Category Name:</FONT></TD></TR>
                          <TR><input type=hidden name=cattoeditid value="<?php echo $cattoedit; ?>">
                            <TD><INPUT value="<?php echo $categoryname; ?>" name="newcatname">&nbsp;
		<INPUT type=submit name=submiteditcat value="Edit Category"></TD></TR></form>
						  <tr><td>
<TABLE cellSpacing=0 cellPadding=2 width=300 border=0>
<TBODY>
	<?php
}else{

if ($submiteditcat == "Edit Category") {
	$sql = "UPDATE ibb_categories SET categories='$newcatname' WHERE cid='$cattoeditid'";
	if (mysql_query($sql)) {
		echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The category \"$newcatname\" has been editted. You are now being redirected.</font></td></tr>");
	?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<TR><TD>
<TABLE cellSpacing=0 cellPadding=2 width=300 border=0>
<TBODY>
	<?php
	}else{
	}
}else{

if ($function == "editforum") {
	?>
		<TR>
                      <TD vAlign=top><FONT face=Verdana color=#ffffff 
                        size=1>Select forum to edit:</FONT></TD></TR>
                    <TR>
                      <TD vAlign=top></TD></TR>
                    <TR>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        background="" border=0>
                          <TBODY><form action="admincp.php" method=POST>
                          <TR>
                            <TD><SELECT  name=forumtoedit> 
<OPTION value=-1 selected>Select Forum To Edit:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
<?php
$result = mysql_query("SELECT name FROM ibb_forums") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$forumarray[] = $row ["name"];
}
foreach ($forumarray as $forumnames) {
$result = mysql_query("SELECT fid FROM ibb_forums WHERE name='$forumnames'") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$forumid = $row ["fid"];
}
echo ("<OPTION value=$forumid>$forumnames</OPTION>");
}
?>
</SELECT>&nbsp;<INPUT type=submit value="Go Edit" name="editforumsubmit"></TD></TR></form>
	<?php
}else{

if ($editforumsubmit == "Go Edit") {
//gets the forum information to edit
$result = mysql_query("SELECT * FROM ibb_forums WHERE fid='$forumtoedit'") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$forumname = $row ["name"];
$forumdescription = $row ["description"];
$forumhtml = $row ["allowhtml"];
$forumcode = $row ["allowcode"];
$canpost = $row ["whocanpost"];
$canview = $row ["viewableto"];
}

if ($canpost == "all") {
	$canpost = "All Users";
	$value2 = "all";
}

if ($canpost == "member,Moderator,admin") {
	$canpost = "Members and Up";
	$value2 = "member,Moderator,admin";
}

if ($canpost == "Moderator,admin") {
	$canpost = "Moderators and Up";
	$value2 = "Moderator,admin";
}

if ($canpost == "admin") {
	$canpost = "Administrators";
	$value2 = "admin";
}


if ($canview == "all") {
	$canview = "All Users";
	$value3 = "all";
}

if ($canview == "member,Moderator,admin") {
	$canview = "Members and Up";
	$value3 = "member,Moderator,admin";
}

if ($canview == "Moderator,admin") {
	$canview = "Moderators and Up";
	$value3 = "Moderator,admin";
}

if ($canview == "admin") {
	$canview = "Administrators";
	$value3 = "admin";
}
	?><form action="admincp.php" method=POST>
		<TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Forum 
                              Name:</FONT></TD></TR>
                          <TR>
                            <TD><INPUT value="<?php echo $forumname; ?>" name="newforumname"><FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Forum 
                              Description:</FONT></TD></TR>
                          <TR>
                            <TD><TEXTAREA style="WIDTH: 254px; HEIGHT: 125px" name="thesubject" rows=6 cols=34><?php echo $forumdescription; ?></TEXTAREA><FONT 
                              face=Verdana color=#ffffff size=1> </FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              HTML:</FONT></TD></TR>
                          <TR>
                            <TD>
<SELECT size=1 name="formallowhtml"> 
		<OPTION value="yes">Allow HTML</OPTION>
		<OPTION value="no">Do Not Allow HTML</OPTION>
</SELECT><FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              IcrediCode:</FONT></TD></TR>
                          <TR>
                            <TD>
<SELECT size=1 name="formallowcode"> 
		<OPTION value="yes">Allow IcrediCode</OPTION>
		<OPTION value="no">Do Not Allow IcrediCode</OPTION>
</SELECT><FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>Viewable For:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="viewableto">

        <option value="<?php 
		echo($value3);
		?>"><?php echo($canview); ?></option>

        <?php if($canview == "All Users") {
		}else{
		?>
		<option value="all">All Users</option>
		<?php 
		}
		
		if ($canview == "member,Moderator,admin") {
		}else{
		?>
		<option value="member,Moderator,admin">Members and Up</option>
		<?php
		}
		
		if ($canview == "Moderator,admin") {
		}else{
		?>
		<option value="Moderator,admin">Moderators and Up</option>
		<?php
		}
		
		if ($canview == "admin") {
		}else{
		?>
		<option value="admin">Administrators</option>
		<?php
		}
		?>

</select>			
		<FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>Posting Ability:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="whocanpost">

        <option value="<?php 
		echo($value2);
		?>"><?php echo($canpost); ?></option>

        <?php if($canpost == "All Users") {
		}else{
		?>
		<option value="all">All Users</option>
		<?php 
		}
		
		if ($canpost == "member,Moderator,admin") {
		}else{
		?>
		<option value="member,Moderator,admin">Members and Up</option>
		<?php
		}
		
		if ($canpost == "Moderator,admin") {
		}else{
		?>
		<option value="Moderator,admin">Moderators and Up</option>
		<?php
		}
		
		if ($canpost == "admin") {
		}else{
		?>
		<option value="admin">Administrators</option>
		<?php
		}
		?>

</select>
<FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>&nbsp;</FONT></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=2 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD><input type=hidden name="FID" value="<?php echo $forumtoedit; ?>">
                                <P align=center><INPUT type=submit value="Edit Forum" name="edittedforumstuff"><FONT 
                                face=Verdana color=#ffffff 
                                size=1></FONT></P></TD></TR></form>
	<?php
}else{

if ($edittedforumstuff == "Edit Forum") {
if ($viewableto == "admin") {
	if ($whocanpost == "admin") {
		$locked = "yes";
	}
}else{
	$locked = "no";
}
$newforumname = str_replace("'", "", $newforumname);
$newforumname = str_replace("\"", "", $newforumname);
$thesubject = str_replace("'", "", $thesubject);
$thesubject = str_replace("\"", "", $thesubject);
$sqlforum = "UPDATE ibb_forums SET " .
"name='$newforumname'," .
"allowhtml='$formallowhtml'," .
"allowcode='$formallowcode'," .
"viewableto='$viewableto'," .
"whocanpost='$whocanpost'," .
"locked='$locked'," .
"description='$thesubject' " . "WHERE fid='$FID'";

if (mysql_query($sqlforum)) {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The forum \"$newforumname\" has been editted. You are now being redirected.</font></td></tr>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<?php
} else {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Error editting forum \"$newforumname\": " .
mysql_error() . "</font></td></tr>");
}
}else{

if ($function == "banip") {
	?>
		<form action="admincp.php" method=POST>
		<TR>
                            <TD vAlign=top>
                              <P><FONT face=Verdana color=#ffffff size=1>Block 
                              IP:<br><INPUT name="banip">&nbsp;<INPUT type=submit value="Ban IP" name="submitbanip"></FONT></TD></TR></form>
	<?php
}else{

//if a banned IP has been submitted, this puts it in the DB
if ($submitbanip == "Ban IP") {
$sql = "INSERT INTO ibb_bannedip SET " .
"IP='$banip'," .
"time='$ttime'";
if (mysql_query($sql)) {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The IP \"$banip\" has been banned. You are now being redirected.</font></td></tr>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<?php
} else {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Error banning IP \"$banip\": " .
mysql_error() . "</font></td></tr>");
}
}else{

//if the user selected to add forum or category, this shows up
if ($function == "newcatforum") {
	?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY><form action="admincp.php" method=POST>
							<TR>
                            <TD><FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
		                    <TR>
                            <TD>
						    <FONT face=Verdana color=#ffffff size=1>Category:</FONT></TD></TR>
                            <TR>
							<TR>
                            <TD>
<SELECT  name=belongcategory> 
<OPTION value=-1 selected>Select Category:</OPTION> <OPTION value=<?php echo $FID; ?>>--------------------</OPTION>
<?php
$result = mysql_query("SELECT * FROM ibb_categories") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
$catarray[] = $row ["cid"];
}
foreach ($catarray as $catid) {
$result = mysql_query("SELECT categories FROM ibb_categories WHERE cid='$catid'") or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
$catnames = $row ["categories"];
}
echo ("<OPTION value=$catid>$catnames</OPTION>");
}
?>
</SELECT></TD></TR>
	                      <TR>
                            <TD>
						   <FONT face=Verdana color=#ffffff size=1>Forum Name:</FONT></TD></TR>
                          <TR>
                            <TD><INPUT name="forumname"></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Forum 
                              Description:</FONT></TD></TR>
                          <TR>
                            <TD><TEXTAREA style="WIDTH: 254px; HEIGHT: 125px" name="thesubject" rows=6 cols=34></TEXTAREA><FONT 
                              face=Verdana color=#ffffff size=1> </FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              HTML:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="allowhtml">

        <option value="yes">HTML Allowed</option>

		<option value="no">HTML Not Allowed</option>

</select>
<FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1>Allow 
                              IcrediCode:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="allowcode">

        <option value="yes">IcrediCode Allowed</option>

		<option value="no">IcrediCode Not Allowed</option>

</select>
								<FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>Viewable For:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="viewableto">

        <option value="all">All Users</option>

		<option value="member,Moderator,admin">Members and Up</option>

		<option value="Moderator,admin">Moderators and Up</option>

		<option value="admin">Administrators</option>

</select>
								<FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>Posting Ability:</FONT></TD></TR>
                          <TR>
                            <TD>
<select name="whocanpost">

        <option value="all">All Users</option>

		<option value="member,Moderator,admin">Members and Up</option>

		<option value="Moderator,admin">Moderators and Up</option>

		<option value="admin">Administrators</option>

</select>
								<FONT 
                              face=Verdana color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>&nbsp;</FONT></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=2 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD>
                                <P align=center><INPUT type=submit value="Add Forum" name="submitforum"><FONT 
                                face=Verdana color=#ffffff 
                                size=1></FONT></P></TD>
                                </TR></form></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
                      <TD vAlign=top>
                        <TABLE cellSpacing=0 cellPadding=2 width=300 
                        align=center background="" border=0>
                          <TBODY><form action="admincp.php" method=POST>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>Category&nbsp;Name:</FONT></TD></TR>
                          <TR>
                            <TD><INPUT name="catname"><FONT face=Verdana 
                              color=#ffffff size=1></FONT></TD></TR>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff 
                              size=1>&nbsp;</FONT></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=2 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD>
                                <P align=center><INPUT type=submit value="Add Category" name="submitcat"><FONT 
                                face=Verdana color=#ffffff 
                                size=1></FONT></P></TD></TR></form></TBODY></TABLE></TD></TR>
		<?php
}else{

// if a forum has been submitted, this adds it to the database
if ("Add Forum" == $submitforum) {
$forumname = str_replace("'", "", $forumname);
$forumname = str_replace("\"", "", $forumname);
$thesubject = str_replace("'", "", $thesubject);
$thesubject = str_replace("\"", "", $thesubject);
$sql = "INSERT INTO ibb_forums SET " .
"name='$forumname'," .
"fid='$fid'," .
"cid='$belongcategory'," .
"allowhtml='$allowhtml'," .
"allowcode='$allowcode'," .
"viewableto='$viewableto'," .
"whocanpost='$whocanpost'," .
"description='$thesubject', " .
"date=CURDATE()";
if (mysql_query($sql)) {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The forum \"$forumname\" has been added. You are now being redirected.</font></td></tr>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<?php
} else {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Error adding forum \"$forumname\": " .
mysql_error() . "</font></td></tr>");
}
}else{

//if a user submitted a category, this adds it to the database
if ("Add Category" == $submitcat) {
$catname = str_replace("'", "", $catname);
$catname = str_replace("\"", "", $catname);
$sql = "INSERT INTO ibb_categories SET categories='$catname'" or die(mysql_error());
if (mysql_query($sql)) {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>The category \"$catname\" has been added. You are now being redirected.</font></td></tr>");
?>
<META HTTP-EQUIV="Refresh" 
CONTENT="2;URL=admincp.php">
<?php
} else {
echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Error adding category \"$catname\": " .
mysql_error() . "</font></td></tr>");
}
}else{

if ($function == "ftedit") {
	?>
	<form action="admincp.php" method=POST>
	<TR>
		<TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Edit Footer HTML</STRONG></FONT></TD></TR>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
                              <P align=left><TEXTAREA style="WIDTH: 675px; HEIGHT: 208px" name="newfilestuff" rows=10 cols=92>
<?php 
$fcontents = file ("footer.php");
while (list ($line_num, $line) = each ($fcontents)) {
    echo htmlspecialchars ($line);
}
?>
						</TEXTAREA></P></TD></TR>
                          <TR>
                            <TD>
                              <P align=left><FONT color=#ffffff size=1><U><INPUT type=submit value=Submit name=editfooter></U></FONT></P></TD></TR></form>
	<?php
}else{

if ($editfooter == "Submit") {
	?>
		<TR><TD><FONT color=#ffffff size=2 face=Tahoma>
	<?php
	$filechange = @fopen("footer.php", "w+");
	@fputs($filechange,stripslashes($newfilestuff));
	@fclose($filechange);
		echo("Footer editted. You are now being redirected.");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
}else{

if ($function == "hdedit") {
	?>
	<form action="admincp.php" method=POST>
	<TR>
		<TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Edit Header HTML</STRONG></FONT></TD></TR>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
                              <P align=left><TEXTAREA style="WIDTH: 675px; HEIGHT: 208px" name="newfilestuff" rows=10 cols=92>
<?php 
$fcontents = file ("header.php");
while (list ($line_num, $line) = each ($fcontents)) {
    echo htmlspecialchars ($line);
}
?>
						</TEXTAREA></P></TD></TR>
                          <TR>
                            <TD>
                              <P align=left><FONT color=#ffffff size=1><U><INPUT type=submit value=Submit name=editheader></U></FONT></P></TD></TR></form>
	<?php
}else{

if ($editheader == "Submit") {
	?>
		<TR><TD><FONT color=#ffffff size=2 face=Tahoma>
	<?php
	$filechange = @fopen("header.php", "w+");
	@fputs($filechange,stripslashes($newfilestuff));
	@fclose($filechange);
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY>
		<?php
		echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Header editted. You are now being redirected.</TD></TR>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
}else{

if ($function == "binfo") {
	?>
		<TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Board&nbsp;Control</STRONG></FONT></TD>
                      <TD width="49%"><FONT face=Verdana></FONT></TD></TR>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
		 <TR>
                            <TD><FONT color=#ffffff size=1><U>
                              <TABLE cellSpacing=0 cellPadding=0 width=100 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=1 cellPadding=4 width=400 
                                background="" border=0>
                                <TBODY>
								<form action="admincp.php" method=POST>
                                <TR>
                                <TD bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                color=#ffffff size=1><STRONG>Change Home 
                                URL:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD bgColor=#16416d><INPUT 
                                name=changeurl value="<?php echo $boardurl; ?>"></TD></TR>
                                <TR>
                                <TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Change Board 
                                Name:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD bgColor=#16416d><INPUT 
                                name=changename value="<?php echo $boardname; ?>"></TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Topics Per Forum Page:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD bgColor=#16416d><INPUT 
                                name=changetpfp value="<?php echo $forumspage; ?>"></TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Replies Per Topic Page:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD bgColor=#16416d><INPUT 
                                name=changerptp value="<?php echo $threadspage; ?>"></TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Max Poll Options:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD bgColor=#16416d><INPUT 
                                name=maxpolloptions value="<?php echo $maxpolloptions; ?>"></TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Avatar Height:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD bgColor=#16416d><INPUT 
                                name=changeavh value="<?php echo $avheight1; ?>"></TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Avatar Width:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD bgColor=#16416d><INPUT 
                                name=changeavw value="<?php echo $avwidth1; ?>"></TD></TR>
							    <TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Allow HTML In User Titles:</STRONG><br></FONT></TD></TR>
                                <TR><TD bgColor=#16416d>
									<select name="htmltitleschange">
											<option value="yes">Allow</option>
											<option value="no">Don't Allow</option>
									</select>                                
								</TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Allow HTML In Signatures:</STRONG><br></FONT></TD></TR>
								<TR><TD bgColor=#16416d>
									<select name="htmlsigschange">
											<option value="yes">Allow</option>
											<option value="no">Don't Allow</option>
									</select>      
								</TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Allow IcrediCode In Signatures:</STRONG><br></FONT></TD></TR>
								<TR><TD bgColor=#16416d>
									<select name="codesigschange">
											<option value="yes">Allow</option>
											<option value="no">Don't Allow</option>
									</select>      
								</TD></TR>
								<TD background="" bgColor=#16416d><FONT 
                                style="BACKGROUND-COLOR: #16416d" face=Verdana 
                                size=1><STRONG>Board Logo URL:</STRONG><br></FONT></TD></TR>
								<TR><TD bgColor=#16416d>
									<input type=text name=nlogo value='<?php echo $boardlogo; ?>'>      
								</TD></TR>
                                <TR>
                                <TD background="" bgColor=#16416d><FONT 
                                face=Verdana><INPUT type=submit value=Submit name=changebinfo></FONT></TD></TR></form></TBODY></TABLE></TD></TR></TBODY></TABLE></U></FONT></TD></TR>
	
	<?php

}else{

if ("Submit" == $changebinfo) {
	?>
		<TR><TD><FONT color=#ffffff size=2 face=Tahoma>
	<?php
	$changename = str_replace("'", "", $changename);
	$changename = str_replace("\"", "", $changename);
	$sql = "UPDATE ibb_boardinfo SET " .
	"boardname='$changename'," .
	"threadspage='$changerptp'," .
	"forumspage='$changetpfp'," .
	"avwidth='$changeavw'," .
	"avheight='$changeavh'," .
	"htmltitles='$htmltitleschange'," .
	"htmlsig='$htmlsigschange'," .
	"codesig='$codesigschange'," .
	"maxpolloptions='$maxpolloptions'," .
	"logo='$nlogo'," .
	"boardurl='$changeurl'";
	if (mysql_query($sql)) {
		?>
		<TR><TD>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY>
		<?php
		echo("<TR><TD><FONT color=#ffffff size=2 face=Tahoma>Board info changed. You are now being redirected.</td></tr>");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
	} else {
		echo("<P>Error changing board info: " .
		mysql_error() . "</P>");
	}
	?>
		</FONT></TD></TR>
	<?php
}else{

if ($function == "editmembers") {
	if ($mid) {
	
	//gets the information about the selected user
	$query = mysql_query("select * from ibb_members where mid='$mid'");
	while ($row = mysql_fetch_array($query)) {
		$yourname = $row["name"];
		$youremail = $row["email"];
		$birthday = $row["birthday"];
		$location = $row["location"];
		$occupation = $row["occupation"];
		$msn = $row["msn"];
		$aim = $row["aim"];
		$icq = $row["icq"];
		$yahoo = $row["yahoo"];
		$avatar = $row["aviator"];
		$signature = $row["signature"];
		$status = $row["status"];
		$title = $row["title"];
		$group = $row["groupname"];
	}

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

		?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
	<TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Edit Members</STRONG></FONT></TD></TR>
<?php
if ($function2 == "changetitle") {
	$yourname = str_replace("'", "\\'", $yourname);
	if ($submitnewtitle == "Submit") {
	$sql = "UPDATE ibb_members SET title='$newtitle' WHERE name='$yourname'";
			if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Title updated. You are being redirected.</td></tr></tbody></table>
	<?php
			}else{
				mysql_error();
			}
	}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changetitle" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Title:</b><br>
<input type=text name=newtitle value="<?php echo $title; ?>">
<input type=submit name="submitnewtitle" value="Submit"></td></tr></form></tbody></table>
	<?php
	}
}else{

if ($function2 == "changestatus") {
	$yourname = str_replace("'", "\\'", $yourname);
	if ($submitnewstatus == "Submit") {
	$sql = "UPDATE ibb_members SET status='$newstatus' WHERE name='$yourname'";
			if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Status updated. You are being redirected.</td></tr></tbody></table>
	<?php
			}else{
				mysql_error();
			}
	}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changestatus" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Status:</b><br>
<SELECT name=newstatus> 
<OPTION value=Member>Member</OPTION>
<OPTION value=Moderator>Moderator</OPTION>
<OPTION value=admin>Administrator</OPTION>
</SELECT>
<input type=submit name="submitnewstatus" value="Submit"></td></tr></form></tbody></table>
	<?php
	}
}else{

if ($function2 == "changesig") {
	$yourname = str_replace("'", "\\'", $yourname);
	if ($submitnewsig == "Submit") {
	$sql = "UPDATE ibb_members SET signature='$newsig' WHERE name='$yourname'";
			if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Signature updated. You are being redirected.</td></tr></tbody></table>
	<?php
			}else{
				mysql_error();
			}
	}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changesig" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Signature:</b><br>
<textarea name="newsig" rows="8" cols="50"><?php echo $signature; ?></textarea>
<input type=submit name="submitnewsig" value="Submit"></td></tr></form></tbody></table>
	<?php
	}
}else{

if ($function2 == "changegroup") {
	$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewgroup == "Submit") {
$sql = "UPDATE ibb_members SET groupname='$newgroup' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Group updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><?php echo $yourname; ?>Error updating group: <?php echo mysql_error(); ?></td></tr></tbody></table><?php
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changegroup" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Group:</b><br>
<select name=newgroup>
<?php
$result = mysql_query("SELECT gname FROM ibb_groups WHERE gname <> 'Guests' ORDER BY gname");
while ($row = mysql_fetch_array($result)) {
	$groupname = $row["gname"];
	echo "<option value=\"$groupname\">$groupname</option>";
}
?></td></tr><tr><td>
<input type=submit name="submitnewgroup" value="Submit">
</td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changeoccu") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewoccupation == "Submit") {
$sql = "UPDATE ibb_members SET occupation='$newoccupation' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Occupation updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeoccu" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Occupation:</b><br>
<input type=text name="newoccupation" value="<?php echo $occupation; ?>">
<input type=submit name="submitnewoccupation" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changelocal") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewlocation == "Submit") {
$sql = "UPDATE ibb_members SET location='$newlocation' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Location updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changelocal" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Location:</b><br>
<input type=text name="newlocation" value="<?php echo $location; ?>">
<input type=submit name="submitnewlocation" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changebday") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewbday == "Submit") {
$sql = "UPDATE ibb_members SET birthday='$newbday' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Birthdate updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changebday" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Birthdate:</b><br>
<input type=text name="newbday" value="<?php echo $birthday; ?>">
<input type=submit name="submitnewbday" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changeyahoo") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewyahoo == "Submit") {
$sql = "UPDATE ibb_members SET yahoo='$newyahoo' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Yahoo screen name updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeyahoo" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Yahoo Screen Name:</b><br>
<input type=text name="newyahoo" value="<?php echo $yahoo; ?>">
<input type=submit name="submitnewyahoo" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changemsn") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewmsn == "Submit") {
$sql = "UPDATE ibb_members SET msn='$newmsn' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>MSN screen name updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changemsn" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change MSN Screen Name:</b><br>
<input type=text name="newmsn" value="<?php echo $msn; ?>">
<input type=submit name="submitnewmsn" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changeaim") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewaim == "Submit") {
$sql = "UPDATE ibb_members SET aim='$newaim' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>AIM screen name updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeaim" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change AIM Screen Name:</b><br>
<input type=text name="newaim" value="<?php echo $aim; ?>">
<input type=submit name="submitnewaim" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changeicq") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewicq == "Submit") {
$sql = "UPDATE ibb_members SET icq='$newicq' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>ICQ number updated. You are being redirected.</td></tr></tbody></table>
	<?php
}else{
	mysql_error();
}
}else{
	?>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeicq" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change ICQ Number:</b><br>
<input type=text name="newicq" value="<?php echo $icq; ?>">
<input type=submit name="submitnewicq" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{

if ($function2 == "changeemail") {
$yourname = str_replace("'", "\\'", $yourname);
if ($submitnewemail == "Submit") {
$sql = "UPDATE ibb_members SET email='$newemailaddress' WHERE name='$yourname'";
if (mysql_query($sql)) {
			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=admincp.php?function=editmembers&mid=<?php echo $mid; ?>">
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		<TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1>Email address updated. You are being redirected.</td></tr></tbody></table></td>
	<?php
}else{
	mysql_error();
}
}else{
?>

<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
		              <TR>
                <TD width="20%" bgColor=#2c5588><B><FONT color=#ffffff size=1>
                  <P align=center>
                  <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
                    <TBODY><form action="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeemail" method=POST>
                    <TR>
                      <TD><FONT face=Verdana color=#ffffff 
                              size=1><B>Change Email Address:</b><br>
<input type=text name="newemailaddress" value="<?php echo $youremail; ?>">
<input type=submit name="submitnewemail" value="Submit"></td></tr></form></tbody></table>
<?php
}
}else{
?>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
			  			  <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Name</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $yourname; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changename">Change</a> ]</FONT></TD></TR>		
			 <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Status</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $status; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changestatus">Change</a> ]</FONT></TD></TR>	
			 <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Title</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $title; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changetitle">Change</a> ]</FONT></TD></TR>	
			 <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Group</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $group; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changegroup">Change</a> ]</FONT></TD></TR>	
			 <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>E-Mail 
                Adress</FONT></B></TD>
                <TD width="80%" background=""><FONT 
                  face=Verdana color=#ffffff size=1><?php echo $youremail; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeemail">Change</a> ]</FONT></TD></TR>
			  <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Birthday</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $birthday; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changebday">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Location</FONT></B></TD>
                <TD width="80%" ><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $location; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changelocal">Change</a> ]</FONT></TD></TR>
			  <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Occupation</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $occupation; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeoccu">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>ICQ</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $icq; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeicq">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>AIM</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $aim; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeaim">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>MSN</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $msn; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changemsn">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Yahoo</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $yahoo; ?> [ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changeyahoo">Change</a> ]</FONT></TD></TR>
		      <TR>
                <TD width="20%"><B><FONT face=Verdana 
                  color=#ffffff size=1>Signature</FONT></B></TD>
                <TD width="80%"><FONT face=Verdana 
                  color=#ffffff size=1><?php echo $signature; ?><br>[ <a href="admincp.php?function=editmembers&mid=<?php echo $mid; ?>&function2=changesig">Change</a> ]</FONT></TD></tr>
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
?>
</TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
		<?php
	}else{
	?>     
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
	<TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Edit Members</STRONG></FONT></TD></TR>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD></TD></TR>
                          <TR>
                            <TD>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              background="" border=0>
                                <TBODY>
                                <TR>
                                <TD background="" bgColor=#000000>
                                <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>		
	<TR align=middle>
                                <TD>
	<FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=a">A</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=b">B</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=c">C</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=d">D</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=e">E</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=f">F</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=g">G</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=h">H</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=i">I</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=j">J</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=k">K</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=l">L</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=m">M</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=n">N</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=o">O</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=p">P</a></FONT></TD>
                                <TD background=""><FONT 
                                face="verdana, arial, helvetica" color=#ffffff 
                                size=2><a href="admincp.php?function=editmembers&l=q">Q</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=r">R</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=s">S</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=t">T</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=u">U</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=v">V</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=w">W</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=x">X</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff size=2><a href="admincp.php?function=editmembers&l=y">Y</a></FONT></TD>
                                <TD><FONT face="verdana, arial, helvetica" 
                                color=#ffffff 
                                size=2><a href="admincp.php?function=editmembers&l=z">Z</a></FONT></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
                          <TR>
                            <TD>
                              <P>
                              <TABLE cellSpacing=0 cellPadding=1 width="100%" 
                              bgColor=#000000 background="" border=0>
                                <TBODY>
                                <TR>
                                <TD>
                                <TABLE cellSpacing=1 cellPadding=2 width="100%" 
                                bgColor=#16416d background="" border=0>
                                <TBODY>
                                <TR>
                                <TD width="20%">
                                <P align=left><FONT face=Verdana color=#ffffff 
                                size=1><STRONG>Find User to 
                                Edit:</STRONG></FONT></P></TD></TR>
                                <TR><form action="admincp.php?function=editmembers" method=POST>
                                <TD width="20%"><INPUT name=find>&nbsp;<INPUT type=submit value=Submit name=finduser></TD></TR></form>
                                <TR>
                                <TD width="20%"><STRONG><FONT face=Verdana 
                                size=1>&nbsp;</FONT></STRONG></TD></TR>
								<?php
								if (isset($l)) {
								?>
								<TR>
                                <TD width="20%">
                                <P align=left><FONT face=Verdana color=#ffffff 
                                size=1><STRONG>Results:</STRONG></FONT></P></TD></TR>
                                <TR>
                                <TD width="20%">
                                <TABLE cellSpacing=0 cellPadding=2 width=400 
                                background="" border=0>
                                <TBODY>
								<?php
								$result = mysql_query("SELECT * FROM ibb_members WHERE name LIKE '$l%'");
								while ($row = mysql_fetch_array($result)) {
								$mid = $row["mid"]; 
								$user = $row["name"];
								?>
								<TR>
                                <TD width="50%"><FONT face=Verdana color=#ffffff 
                                size=1><?php echo "<a href=\"member.php?MID=$mid\">$user</a>"; ?></FONT></TD>
                                <TD width="50%"><FONT face=Verdana color=#ffffff size=1>[ <a href="admincp.php?function=editmembers&mid=<?php echo ("$mid"); ?>">Edit User</a> ]</FONT>
								</TD></TR>
								<?php
								}
								?>
								</tbody></table>
								<?php
								}
								if ($finduser == "Submit") {
								?>
								<TR>
                                <TD width="20%">
                                <P align=left><FONT face=Verdana color=#ffffff 
                                size=1><STRONG>Results:</STRONG></FONT></P></TD></TR>
                                <TR>
                                <TD width="20%">
                                <TABLE cellSpacing=0 cellPadding=2 width=400 
                                background="" border=0>
                                <TBODY>
								<?php
								$result = mysql_query("SELECT * FROM ibb_members WHERE name LIKE '%$find%'");
								while ($row = mysql_fetch_array($result)) {
								$mid = $row["mid"]; 
								$user = $row["name"];
								?>
								<TR>
                                <TD width="50%"><FONT face=Verdana color=#ffffff 
                                size=1><?php echo "<a href=\"member.php?MID=$mid\">$user</a>"; ?></FONT></TD>
                                <TD width="50%"><FONT face=Verdana color=#ffffff size=1>[ <a href="admincp.php?function=editmembers&mid=<?php echo ("$mid"); ?>">Edit User</a> ]</FONT></td></tr>
								<?php
								}
								?>
								</tbody></table>
								<?php
								}
	?>
	</TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
	<?php
	}
}else{

if ($function == "btedit") {
	?>
	<TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Change Time Zone</STRONG></FONT></TD></TR>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=2 width="98%" 
                        align=center background="" border=0>
                          <TBODY>
                          <TR>
                            <TD>
                              <P align=left>
                              <TABLE cellSpacing=0 cellPadding=0 width=400 
                              background="" border=0>
                                <TBODY>
                                <TR><form action="admincp.php" method=POST>
                                <TD><STRONG><FONT face=Verdana size=1>Current 
                                Server Time:</FONT></STRONG></TD></TR>
                                <TR>
                                <TD><FONT face=Verdana color=#ffffff 
                                size=1><?php echo $servertime; ?></FONT></TD></TR>
                                <TR>
                                <TD><STRONG><FONT face=Verdana 
                                size=1>&nbsp;</FONT></STRONG></TD></TR>
                                <TR>
                                <TD><FONT face=Verdana color=#ffffff 
                                size=1><STRONG>Hours offset from 
                                server:</STRONG></FONT></TD></TR>
                                <TR>
                                <TD><INPUT name=newoffset>&nbsp;<INPUT type=submit value=Submit name=submitoffset></TD></TR></form>
						        <TR>
                                <TD><STRONG><FONT face=Verdana size=1><br>Note:</FONT></STRONG></TD></TR>
                                <TR>
                                <TD><FONT face=Verdana color=#ffffff 
                                size=1>This will not change the time on any posts made previously.<BR>Only future posts will contain the new time.</FONT></TD></TR>
						</TBODY></TABLE></P></TD></TR>
	<?php
}else{

if ($submitoffset == "Submit") {
	?>
		<TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2>
	<?php
	$sql = "UPDATE ibb_boardinfo SET " .
	"offset='$newoffset'";
	if (mysql_query($sql)) {
		echo("Offset changed. You are now being redirected.");
		?>
		<TABLE cellSpacing=0 cellPadding=2 width=300 align=center background="" border=0>
			<TBODY>
				<TR>
					<TD>
						<META HTTP-EQUIV="Refresh" CONTENT="2;URL=admincp.php">
		<?php
	} else {
		echo("<P>Error changing offset: " .
		mysql_error() . "</P>");
	}
	?>
	</FONT></TD></TR>
	<?php
}else{

	?>
		<TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Board&nbsp;Control</STRONG></FONT></TD>
                      <TD width="49%"><FONT face=Verdana></FONT></TD></TR>
                    <TR>
<TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
                          <TR>
                            <TD bgcolor=#16416d><FONT face=Verdana color=#ffffff size=1><U>
							<a href="admincp.php?function=binfo">Change Board Preferences</a><BR>
							<a href="admincp.php?function=newtheme">Create New Color Theme</a><BR>
							<a href="admincp.php?function=dtheme">Delete A Color Theme</a><BR>
							<a href="admincp.php?function=thchange">Change Color Theme</a>
							</U></FONT></TD></TR></TBODY></TABLE></FONT></TD>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
                          <TR>
                            <TD><FONT face=Verdana color=#ffffff size=1><U>
							<a href="admincp.php?function=thedit">Edit Theme Colors</a><BR>
							<a href="admincp.php?function=hdedit">Edit Header</a><BR>
							<a href="admincp.php?function=ftedit">Edit Footer</a><BR>
							<a href="admincp.php?function=btedit">Edit Board Time</a>
						    </U></FONT></TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR>
              <TR>
                <TD vAlign=top align=middle colSpan=2 bgcolor=#16416d>
                  <TABLE cellSpacing=0 cellPadding=2 width="98%" align=center 
                  background="" border=0>
                    <TBODY>
                    <TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Member Control</STRONG></FONT></TD>
                      <TD width="49%"><FONT face=Verdana></FONT></TD></TR>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
                          <TR>
                            <TD>
							<FONT face=Verdana color=#ffffff size=1><U>
							<a href="admincp.php?function=editmembers">Edit Members</a><BR>
							<a href="admincp.php?function=emailmembers">Email Members</a><BR>
							<a href="admincp.php?function=pmmembers">PM Members</a><BR>
							<a href="admincp.php?function=addgroup">Add Group</a><BR>
							<a href="admincp.php?function=deletegroup">Delete Group</a><BR>
							<a href="admincp.php?function=modgroup">Modfiy Group</a>
							</U></FONT></TD></TR></TBODY></TABLE></FONT></TD>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
                          <TR>
                            <TD>
							<FONT face=Verdana color=#ffffff size=1><U>
							<a href="admincp.php?function=deletemember">Delete Members</a><br>
							<a href="admincp.php?function=banip">Block Member IP</a><BR>
							<a href="admincp.php?function=removebanip">Remove Banned IP</a><BR>
							<a href="admincp.php?function=changepass">Change Member Password</a><BR>
							<a href="index.php?function=register">Register New Member</a>
							</U></FONT></TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR>
              <TR>
                <TD vAlign=top align=middle colSpan=2 bgcolor=#16416d>
                  <P align=left><FONT size=2>
                  <TABLE cellSpacing=0 cellPadding=2 width="98%" align=center 
                  background="" border=0>
                    <TBODY>
                    <TR>
                      <TD width="49%"><FONT face=Verdana color=#ffffff 
                        size=2><STRONG>Forum Control</STRONG></FONT></TD>
                      <TD width="49%"><FONT face=Verdana></FONT></TD></TR>
                    <TR>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
                          <TR>
                            <TD>
							<FONT face=Verdana color=#ffffff size=1><U>
							<a href="admincp.php?function=newcatforum">Add New Category</a><BR>
							<a href="admincp.php?function=newcatforum">Add New Forum</a><BR>
							<a href="admincp.php?function=newmod">Add Forum Moderator</a><BR>
							<a href="admincp.php?function=removemod">Remove Forum Moderator</a><BR>
							<a href="admincp.php?function=editcategory">Modify Category</a><BR>
							<a href="admincp.php?function=editforum">Modify Forum</a><BR>
							<a href="index.php?function=jerklist">View Jerk List</a>
							</U></FONT>
							</TD>
						  </TR>
						  </TBODY>
						</TABLE>
					  </TD>
                      <TD vAlign=top width="49%"><FONT size=2>
                        <TABLE cellSpacing=0 cellPadding=0 width="96%" 
                        align=center border=0>
                          <TBODY>
                          <TR>
                            <TD>
							<FONT face=Verdana color=#ffffff size=1><U>
							<a href="admincp.php?function=dcategory">Delete Category</a><BR>
							<a href="admincp.php?function=dforum">Delete Forum</a><BR>
							<a href="admincp.php?function=addadminforum">Add Admin Forum</a><BR>
							<a href="admincp.php?function=addmodforum">Add Moderator Forum</a><BR>
							<a href="admincp.php?function=addannouncement">Post Announcement<BR>
							<a href="admincp.php?function=editannouncement">Edit Announcements</a><BR>
							<a href="admincp.php?function=dannouncement">Delete Announcements</a></U></FONT></TD>

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
}
}
}
}
}
}
}
}
?>
</TR></TBODY></TABLE>
</FONT></TD></TR></TBODY></TABLE></FONT></TD>
</TR></TBODY></TABLE>
<?php
if ($function == "banip" or $submitbanip == "Ban IP") { }else{ ?>
</TD></TR></TBODY></TABLE></CENTER>
<?php } ?>
      <P>
<?php
}else{
	?>
<P>
      <CENTER>
      <TABLE 
      style="BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid" 
      cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=0 cellPadding=4 width="100%" border=0>
              <TBODY>
				<TR><TD bgcolor=#2c5588>
					<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
					<TBODY><TR><TD><FONT color=#ffffff size=2 face=Tahoma><center>You are not permitted to enter this area.</center></font></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><br>
	<?php
}
include "footer.php";
echo $copyrights;


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>