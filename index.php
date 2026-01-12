<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


//includes the header file
include("header.php");



//sets the title correctly and puts it in the onlineusers table
$ptitle = "$boardname";
echo ("<title>$ptitle</title>");
$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}


if (strstr($fccatbgcolor, "#")) {
	$bgimage = "bgcolor=$fccatbgcolor";
}else{
	$bgimage = "background=\"$fccatbgcolor\"";
}


//if the user selected to logout, this is what removes the cookies and session
if ($function == "logout") {
	
	//changes the username of the person logging out to Guest
	$sql = "UPDATE ibb_onlineusers SET username = 'Guest' WHERE IP='$IP'";
	if (mysql_query($sql)) { 
	} else { 
		echo(mysql_error()); 
	} 

	?>
	<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center bgColor=<?php echo $fcbgcolor; ?> border=0>
	<TBODY>
	<TR>
	<TD bgColor=<?php echo $fctopbarbgcolor; ?>>
	<center>
	<FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2>
	You are logged out. Redirecting...</center>
		  </td></tr></tbody></table><br>
		  <META HTTP-EQUIV="Refresh" CONTENT="1;URL=index.php">
	<?php
	
	//gets rid of the current cookies
	setcookie("userstuffid", "", "");
	setcookie("sessionuser", "", "");
	setcookie("sessionstatus", "", "");
	
	//destroys the session and starts a new one with guest as the username and userstatus
	session_destroy();
	session_set_cookie_params(time()+20000000, $HTTP_SERVER_VARS['PATH_TRANSLATED']);
	ini_set('session.cookie_path',$HTTP_SERVER_VARS['PATH_TRANSLATED']);
	session_start();
	session_register("sessionuser");
	session_register("sessionstatus");
	session_register('usergroup');	
	$sessionuser = "Guest";
	$sessionstatus = "Guest";
	$usergroup = "Guests";

	//deletes the user from the onlineusers table
	$sql = "DELETE FROM ibb_onlineusers WHERE IP='$IP'";
	if (mysql_query($sql)) { 
	} else { 
			echo(mysql_error()); 
	} 
} else {

?>
<BR>
<?php
//if the admin selected to view the jerk list, this does it's stuff
if ($function == "jerklist") {
	?>
		<TABLE cellSpacing=1 cellPadding=4 width="100%" align=center bgColor=<?php echo $fcbgcolor; ?> border=0>
					<TBODY>
							<TR><TD bgColor=<?php echo $fctopbarbgcolor; ?> colspan=3><center><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2>
							<?php echo $boardname; ?>'s Jerk List</td></tr>
							<?php
							//makes sure the user is an admin to view it
							if ($sessionstatus == "admin") {

							//gets everything from the ibb_ignores table grouped by the column imid
							$result = mysql_query("select * from ibb_ignores group by imid");
							while ($row = mysql_fetch_array($result)) {
								$imidsindba[] = $row["imid"];
							}

								//for each entry in the database, it will do this
								foreach ($imidsindba as $imidsindb) {
								
								//gets the count from ibb_ignores where the imid is the same as $imidsindb
								$query = "select count(*) from ibb_ignores where imid='$imidsindb'";
								$result = mysql_query($query);
								$row = mysql_fetch_row($result);
								$countofimid = $row[0];

								//if it appears more than five times, it will show them on the list
								if ($countofimid > "5") {

									//gets the name of the "jerk" from ibb_members
									$query = "select name from ibb_members where mid='$imidsindb'";
									$result = mysql_query($query);
									$row = mysql_fetch_row($result);
									$username = $row[0];	
										?>
										<TR><TD bgColor=<?php echo $fcforumnamebgcolor; ?> width=400><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=2>Name:
										<?php echo $username; ?></td>
										<TD bgColor=<?php echo $fcforumnamebgcolor; ?> width=200><?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?>Ignored By (# of users): 
										<?php echo $countofimid; ?></td></tr>
										<?php
								}
								}
							}else{
								//if the user is not an admin, it will display this message
								echo "<TR><TD bgColor=$fcforumnamebgcolor width=400><FONT face=\"$font\" size=1 color=$gcforumnametxtcolor>You are not authorized to view the Jerk List.</td></tr>";
							}
							?>
								</tbody></table><br>
	<?php
}else{

//if the user selected to hide or show the option bar, this is what does the magic
if ($tfunction == "toggleoptions") {
	$query = "select options from ibb_members where name='$sessionuser'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$oldoptionsetting = $row[0];
	if ($oldoptionsetting == "off") {
		$sql = "UPDATE ibb_members SET options='on' WHERE name='$sessionuser'";
		if (mysql_query($sql)) {
			?>
 <TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
      bgColor=<?php echo $fcbgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Option bar is now on. Redirecting to previous location.</center>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="1;URL=<?php echo $url; ?>"></td></tr></tbody></table><br>
			<?php
		}
	}else{
		$sql = "UPDATE ibb_members SET options='off' WHERE name='$sessionuser'";
		if (mysql_query($sql)) {
			?>
 <TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
      bgColor=<?php echo $fcbgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Option bar is now off. Redirecting to previous location.</center>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="1;URL=<?php echo $url; ?>"></td></tr></tbody></table><br>
			<?php
		}
	}
}else{

//if the user selected to register a username, this is what shows up
if ($function == "register") {
	?>
		<TABLE cellSpacing=0 cellPadding=2 width=100 background="" border=0>
  <TBODY>
  <TR>
    <TD background="" bgColor=<?php echo $fcbgcolor; ?>>
      <TABLE cellSpacing=0 cellPadding=3 width=300 background="" 
      border=0>
        <TBODY>
        <TR>
          <TD colSpan=2 bgcolor=<?php echo $fctopbarbgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2>» 
            Register for <?php echo $boardname; ?></FONT></FONT><br><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=1>* Signifies A Required Field</STRONG></TD></TR>
        <TR>
		<TR>
          <TD bgColor=<?php echo $fcbgcolor; ?> colSpan=2></TD></TR>
        <TR><form action="index.php" method=POST>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Username*:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=reguser></TD></TR>
        <TR>
		<TR>
          <TD bgcolor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Password*:</FONT></STRONG></TD>
          <TD bgcolor=<?php echo $fcforumnamebgcolor; ?>><INPUT type=password name=regpassword></TD></TR>
        <TR>  
	    <TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Verify*:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT type=password name=regverify></TD></TR>
        <TR>  
	    <TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Email Address*:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=regemail></TD></TR>
		<TR>
        <TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Avatar URL:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=regavatar></TD></TR>
        <TR>
        <TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>MSN IM:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=regmsn></TD></TR>
        <TR>
        <TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>AOL IM:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=regaim></TD></TR>
        <TR>
        <TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Yahoo IM:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=regyahoo></TD></TR>
        <TR>
        <TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>ICQ IM:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=regicq></TD></TR>
		<TR>
		<TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Interests<br>(250 chars max):</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name=reginterests></TD></TR>
        <TR>
		<TR>
          <TD background="" bgColor=<?php echo $fcforumlpbgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumlptxtcolor; ?> size=1>[ <A href="index.php"><font color=<?php echo $fclinkcolor; ?>>RETURN</FONT></A> ]</FONT></FONT></STRONG></TD>
          <TD background="" bgColor=<?php echo $fcforumlpbgcolor; ?>><INPUT type=submit value="Register" name="submitmember"></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>

<?php
}else{

if ("Register" == $submitmember) {
//gets the names of current members to make sure the user isn't taken
$mia = mysql_query("SELECT name FROM ibb_members WHERE name='$reguser'") or die(mysql_error());
while ($row = mysql_fetch_array($mia) ) {
	$dbusername = $row["name"];
}

//if the user clicked submit, this goes through the process of checking to see if the username is already taken
//or if the passwords match, if both clear, then it adds that person to the database
	if ($dbusername == false) {
		if ($reguser == "admin" || $reguser == "Admin" || $reguser == "Moderator" || $reguser == "moderator" || $reguser == "webmaster" || $reguser == "Webmaster" || $reguser == "owner" || $reguser == "Owner") {
				?>
					<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
						bgColor=<?php echo $fcbgcolor; ?> border=0>
							<TBODY>
							<TR>
								 <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>That username is a reserved username. Please click the back button.</center>
							</td></tr></tbody></table><br>
				<?php
			}else{
			if (($reguser != "") || ($regpassword != "") || ($regverify != "") || ($regemail != "")) {
				if ($regpassword == $regverify) {
					if(!strstr($reguser, "\"")) {
						if(!strstr($reguser, "'")) {
							if(strstr($regemail, "@")) {
								if(strstr($regemail, ".")) {
									if (($reguser == "") || ($regverify == "") || ($regpassword == "")){
										echo ("<FONT face=$font color=red size=2><b>Username, Password, or Verify Password spot was left 		blank.</b></font>");
									}else{
										$regtime = date("m/d/Y");
										$regpassword = md5($regpassword);
										$sql = "INSERT INTO ibb_members SET " .
										"name='$reguser'," .
										"mid='$mid'," .
										"time='$regtime'," .
										"aviator='$regavatar'," .
										"password='$regpassword'," .
										"status='Member'," .
										"title='Basic Member'," .
										"msn='$regmsn'," .
										"yahoo='$regyahoo'," .
										"aim='$regaim'," .
										"icq='$regicq'," .
										"groupname='Members'," .
										"interests='$reginterests'," .
										"email='$regemail'";
										if (mysql_query($sql)) {
											?>
											 <TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
											  bgColor=<?php echo $fcbgcolor; ?> border=0>
												<TBODY>
												<TR>
												  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>You are now registered. Redirecting to login page.</center>
													<META HTTP-EQUIV="Refresh" 
													CONTENT="1;URL=index.php?function=login"></td></tr></tbody></table><br>
											<?php
										} else {
											?>
											<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
											  bgColor=<?php echo $fcbgcolor; ?> border=0>
												<TBODY>
												<TR>
												  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Error registering: <?php echo mysql_error(); ?></center></td></tr></tbody></table><br>
											<?php
										}
									}
								}else{
									?>
									<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
											  bgColor=<?php echo $fcbgcolor; ?> border=0>
												<TBODY>
												<TR>
												  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Improper Email Format. You were missing a period before a domain. Please click the back button.</center>
												</td></tr></tbody></table><br>
									<?php
								}
							}else{
								?>
									<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
										  bgColor=<?php echo $fcbgcolor; ?> border=0>
											<TBODY>
											<TR>
											  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Improper Email Format. You were missing the "@" symbol. Please click the back button.</center>
											</td></tr></tbody></table><br>
								<?php
							}
						}else{
							?>
								<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
									  bgColor=<?php echo $fcbgcolor; ?> border=0>
										<TBODY>
										<TR>
										  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Invalid character in username. The character ' is not allowed. Please click the back button.</center>
										</td></tr></tbody></table><br>
							<?php
						}
						}else{
							?>
								<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
									  bgColor=<?php echo $fcbgcolor; ?> border=0>
										<TBODY>
										<TR>
										  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Invalid character in username. The character " is not allowed. Please click the back button.</center>
										</td></tr></tbody></table><br>
							<?php
						}
					}else{
					?>
						<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
							  bgColor=<?php echo $fcbgcolor; ?> border=0>
								<TBODY>
								<TR>
								  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Your passwords don't match. Please click the back button.</center>
								</td></tr></tbody></table><br>
					<?php
				}
			}else{
				?>
					<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
						  bgColor=<?php echo $fcbgcolor; ?> border=0>
							<TBODY>
							<TR>
							  <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>One of the required fields were not filled in. Please click the back button.</center>
							</td></tr></tbody></table><br>
				<?php
			}
		}
	}else{
		?>
			<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
				bgColor=<?php echo $fcbgcolor; ?> border=0>
					<TBODY>
					<TR>
						 <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>That username is already taken. Please click the back button.</center>
					</td></tr></tbody></table><br>
		<?php
	}
}else{

//if the user selects to log into icredibb, this is what shows up
if ($function == "login") {
	$sql = "DELETE FROM ibb_onlineusers WHERE IP='$IP'";
	if (mysql_query($sql)) { 
	} else { 
		echo(mysql_error()); 
	} 
?>
		<TABLE cellSpacing=0 cellPadding=2 width=100 background="" border=0>
  <TBODY>
  <TR>
    <TD background="" bgColor=<?php echo $fcbgcolor; ?>>
      <TABLE cellSpacing=0 cellPadding=3 width=300 border=0>
        <TBODY>
        <TR>
          <TD colSpan=2 bgcolor=<?php echo $fctopbarbgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2>» 
            Login to <?php echo $boardname; ?></FONT></FONT></STRONG></TD></TR>
        <TR>
          <TD background="" bgColor=<?php echo $fcbgcolor; ?> colSpan=2></TD></TR>
        <TR>
		<TR>
          <TD background="" bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG>
		  <form action="index.php" method=POST><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Username:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT name='loginuser'></TD></TR>
        <TR>
		<TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Password:</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT type=password name='password'></TD></TR>
		<TR>
		<TR>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumnametxtcolor; ?> size=1>Cookie Length (days):</FONT></STRONG></TD>
          <TD bgColor=<?php echo $fcforumnamebgcolor; ?>><INPUT type=text name='cookies'></TD></TR>
        <TR>
		<TR>
          <TD background="" bgColor=<?php echo $fcforumlpbgcolor; ?>><STRONG><FONT face="<?php echo $font; ?>" color=<?php echo $fcforumlptxtcolor; ?> size=1>[ <A href="index.php?function=register"><FONT face=<?php echo $fclinkcolor; ?> 
             size=1>REGISTER</FONT></A> 
            ]</FONT></FONT></STRONG></TD>
          <TD background="" bgColor=<?php echo $fcforumlpbgcolor; ?>>
		  <INPUT type=submit value="Log In" name="submitlogin">
		  </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><br>
<?php
}else{

//if the user submitted their login, this does it's stuff
if ($submitlogin == "Log In") {
	$miaone = mysql_query("SELECT mid, name, password, email, status FROM ibb_members WHERE name='$loginuser'") or 	die(mysql_error());
	while ( $row = mysql_fetch_array($miaone) ) { 
		$dbpassword = $row["password"];
		$dbusername = $row["name"];
		$dbstatus = $row["status"];
	}
	if ($loginuser == $dbusername) {
		$password = md5($password);
		if ($password == $dbpassword) {
			if (($loginuser == "") || ($password == "")) {
				?>
			<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
				bgColor=<?php echo $fcbgcolor; ?> border=0>
					<TBODY>
					<TR>
						 <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>You must enter both a username and password to login. Please click the back button.</center>
					</td></tr></tbody></table><br>
			<?php
			}
			session_destroy();
			$sessionuser = $loginuser;
			$sessionstatus = $dbstatus;
			session_start();
			session_register('sessionuser');
			session_register('sessionstatus');
			$sessionuser = $loginuser;
			$sessionstatus = $dbstatus;
			$sql = "DELETE FROM ibb_onlineusers WHERE IP='$IP'";
			if (mysql_query($sql)) { 
			} else { 
				echo(mysql_error()); 
			} 

			$cookies = $cookies * "86400";

			//sets cookies with the login information (not the password though)
			setcookie("userstuffid", $PHPSESSID, time()+$cookies);
			setcookie("sessionuser", $sessionuser, time()+$cookies);
			setcookie("sessionstatus", $sessionstatus, time()+$cookies);
			setcookie("date", $ttime, time()+$cookies);

			?>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="1;URL=index.php">
			<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
				bgColor=<?php echo $fcbgcolor; ?> border=0>
					<TBODY>
					<TR>
						 <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>You are logged in. You are being redirected.</center>
					</td></tr></tbody></table><br>
			<?php
		}else{
			?>
			<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
				bgColor=<?php echo $fcbgcolor; ?> border=0>
					<TBODY>
					<TR>
						 <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Your password is incorrect. Please click the back button.</center>
					</td></tr></tbody></table><br>
			<?php
		}
	}else{
		?>
			<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center 
				bgColor=<?php echo $fcbgcolor; ?> border=0>
					<TBODY>
					<TR>
						 <TD bgColor=<?php echo $fctopbarbgcolor; ?>><FONT face="<?php echo $font; ?>" color=<?php echo $fctopbartxtcolor; ?> size=2><center>Username doesn't exist. Please click the back button.</center>
					</td></tr></tbody></table><br>
		<?php
	}
}else{
?>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=1 cellPadding=4 width="100%" border=0 bgcolor=<?php echo $fcbgcolor; ?>>
              <TBODY>
              <TR>
                <TD width=10 bgColor="<?php echo $fctopbarbgcolor; ?>"></TD>
                <TD align=left width="50%" bgColor="<?php echo $fctopbarbgcolor; ?>"><FONT face=Verdana 
                   size=1 color="<?php echo $fctopbartxtcolor; ?>"><STRONG>Forums</STRONG></FONT></TD>
                <TD bgColor="<?php echo $fctopbarbgcolor; ?>"><FONT face=Verdana  size=1 color="<?php echo $fctopbartxtcolor; ?>">
                  <CENTER><STRONG>Posts</STRONG></CENTER></FONT></TD>
                <TD bgColor="<?php echo $fctopbarbgcolor; ?>"><FONT face=Verdana  size=1 color="<?php echo $fctopbartxtcolor; ?>">
                  <CENTER><STRONG>Threads</STRONG></CENTER></FONT></TD>
                <TD width="20%" bgColor="<?php echo $fctopbarbgcolor; ?>"><FONT face=Verdana size=1 color="<?php echo $fctopbartxtcolor; ?>">
                  <CENTER><STRONG>Lastest Post</STRONG></CENTER></FONT></TD>
                <TD bgColor="<?php echo $fctopbarbgcolor; ?>"><FONT face=Verdana size=1 color="<?php echo $fctopbartxtcolor; ?>">
                  <CENTER><STRONG>Moderators</STRONG></CENTER></FONT></TD>

<?php

//gets an array of the aid's in the table ibb_announcements
$result = mysql_query("SELECT * FROM ibb_announcements") or die(mysql_error());
while ( $row = mysql_fetch_array($result)) {
	$aidarray[] = $row['aid'];
}

//if there is anything int he db, this will show them
if (isset($aidarray)) {
	?>
              <TR>
                <TD colSpan=6 <?php echo $bgimage; ?>>
                  <P align=left><STRONG><FONT face=<?php echo $font; ?> 
                  size=<?php echo $fccattxtsize; ?> color="<?php echo $fccattxtcolor; ?>">» Announcements</FONT></STRONG></P></TD></TR>
<?php

//for each announcement, it does this
foreach($aidarray as $aid) {

	//gets everything from the announcements table where the row aid equals the variable $aid
	$result = mysql_query("SELECT * FROM ibb_announcements WHERE aid=$aid ORDER BY aid DESC") or die(mysql_error());
	while ( $row = mysql_fetch_array($result) ) {
	$aname = $row["name"];
	$andescription = $row["description"];
	$allowreplies = $row["allowreplies"];
	
	//gets the id of the announcement
	$query = "select tid from ibb_threads where fid='a$aid'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$atid = $row[0];

	//gets the count of replies for this announcement
	$query = "select count(*) from ibb_replies where fid='a$aid'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$forumreplies = $row[0];

	//gets the count of threads for this announcement
	$query = "select count(*) from ibb_threads where fid='a$aid'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$forumtopics = $row[0];

	//finds the last poster and when he/she posted
	$query = "SELECT timeline FROM `ibb_threads` WHERE fid='a$aid' ORDER BY timeline DESC LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$lastpostert = $row[0];

	//gets the time from the replies table of the last poster
	$query = "SELECT timeline FROM `ibb_replies` WHERE fid='a$aid' ORDER BY timeline DESC LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$lastposterr = $row[0];
	
	//gets last poster info
	if ($lastpostert > $lastposterr) {
		$lastpostertime = $lastpostert;

		$query = "SELECT name FROM ibb_threads WHERE timeline='$lastpostertime'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$lastposter = $row[0];

		$query = "SELECT time FROM ibb_threads WHERE timeline='$lastpostertime'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$lastposterd = $row[0];
	}else{
		$lastpostertime = $lastposterr;

		$query = "SELECT name FROM ibb_replies WHERE timeline='$lastpostertime'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$lastposter = $row[0];

		$query = "SELECT time FROM ibb_replies WHERE timeline='$lastpostertime'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$lastposterd = $row[0];
	}

	//gets the member ID from the database
	$query = "select mid from ibb_members where name='$lastposter'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$lastpostermid = $row[0];

	//gets rid of the beginning part of the date
	$lastposterd = eregi_replace("Posted On: ", "", $lastposterd);
	$lastposterd = eregi_replace("Editted On: ", "", $lastposterd);
	$lastposterd = eregi_replace("Replied On: ", "", $lastposterd);

	$servertime2 = $lastposterd;

	$servertimemonth = substr($servertime2, 0,2);
	$servertimeday = substr($servertime2, 3,2);
	$servertimeyear = substr($servertime2, 6,4);
	$servertimehour = substr($servertime2, 11,2);
	$servertimemin = substr($servertime2, 14,2);
	$servertimesec = substr($servertime2, 17,2);
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

	//if the forum is locked, this will change the image
	if ($allowreplies == "yes") {
		$fimg = "<img src='images/on.gif'>";
	}else{
		$fimg = "<img src='images/lock.gif'>";
	}

	$posts2 = $forumtopics + $forumreplies;
?>
		<TR align=middle>
                <TD bgColor="<?php echo $fcforumiconbgcolor; ?>"><center><?php echo $fimg; ?></center></TD>
                <TD align=left bgColor=<?php echo $fcforumnamebgcolor; ?>><FONT face="<?php echo $font; ?>" color="<?php echo $fcforumnametxtcolor; ?>" size=<?php echo $fcforumnametxtsize; ?>></FONT><STRONG><U><FONT 
                  size=<?php echo $fcforumnametxtsize; ?>><a href="topic.php?t=a&TID=<?php echo $atid; ?>&FID=a<?php echo $aid; ?>"><FONT face="<?php echo $font; ?>" color="<?php echo $fclinkcolor; ?>"><?php echo "$aname"; ?></a></FONT></U></STRONG><BR><FONT face="<?php echo $font; ?>" color="<?php echo $fcforumnametxtcolor; ?>" size=1><?php echo $andescription; ?></FONT></FONT></TD>
                <TD bgColor="<?php echo $fcforumpostsbgcolor; ?>"><FONT face="<?php echo $font; ?>" color="<?php echo $fcforumpoststxtcolor; ?>" size=1><?php echo $posts2; ?></FONT></TD>
                <TD bgColor="<?php echo $fcforumtopicsbgcolor; ?>"><FONT face="<?php echo $font; ?>" color="<?php echo $fcforumtopicstxtcolor; ?>" size=1><?php echo $forumtopics; ?></FONT></TD>
                <TD background="" bgColor="<?php echo $fcforumlpbgcolor; ?>">
                  <P align=right><FONT size=1><FONT face=Verdana>
				
<?php 
//checks to see if the forum has any posts, if not shows "No Posts Yet", if it does, it shows the name and date of the last one
if ($lastposter == "") {
	echo "No Posts Yet"; 
}else{
	if ($lastposter == "Guest") {
		echo ("$lastposterdst $lastposterdend<BR>by <B>$lastposter");
	}else{
		if ($lastposter == "Administrator") {
			echo ("$lastposterdst $lastposterdend<BR>by <B>$lastposter");
		}else{
		echo ("$lastposterdst $lastposterdend<BR>by <A href='member.php?MID=$lastpostermid'><B>$lastposter"); 
		}
	}
}
?>
	
</FONT></P></TD>
                <FORM>
                <TD vAlign=center noWrap bgColor="<?php echo $fcforummodsbgcolor; ?>"><FONT 
                  face=Verdana size=1>No Moderators</FONT></TD>
	<?php
}
}
}

//this gets the category info
$result = mysql_query("SELECT * FROM ibb_categories") or die(mysql_error());
while ( $row = mysql_fetch_array($result)) {
	$cid[] = $row['cid'];
}

foreach($cid as $thecid) {
	$result = mysql_query("SELECT * FROM ibb_categories WHERE cid=$thecid") or die(mysql_error());
	while ( $row = mysql_fetch_array($result) ) {
	$categoryname = $row["categories"];
	?>
              <TR>
                <TD colSpan=6 <?php echo $bgimage; ?>>
                  <P align=left><STRONG><FONT face=<?php echo $font; ?> 
                  size=<?php echo $fccattxtsize; ?> color="<?php echo $fccattxtcolor; ?>">» <?php echo $categoryname; ?></FONT></STRONG></P></TD></TR>

<?php

//this gets the forum info
$bob = mysql_query("SELECT * FROM ibb_forums WHERE cid='$thecid' ORDER BY fid") or die(mysql_error());
while ( $row = mysql_fetch_array($bob) ) { 
	$forumcid = $row["cid"];
	$forumid = $row["fid"];
	$theforumname = $row["name"];
	$date = $row["date"];
	$subject = $row["description"];
	$viewableto = $row["viewableto"];
	$lock = $row["locked"];

//gets the count of replies for this forum
$query = "select count(*) from ibb_replies where fid='$forumid'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$forumreplies = $row[0];

//gets the count of threads for this forum
$query = "select count(*) from ibb_threads where fid='$forumid'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$forumtopics = $row[0];

//finds the last poster and when he/she posted
$query = "SELECT timeline FROM `ibb_threads` WHERE fid='$forumid' ORDER BY timeline DESC LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$lastpostert = $row[0];

$query = "SELECT timeline FROM `ibb_replies` WHERE fid='$forumid' ORDER BY timeline DESC LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$lastposterr = $row[0];

if ($lastpostert > $lastposterr) {
	$lastpostertime = $lastpostert;

	$query = "SELECT name FROM ibb_threads WHERE timeline='$lastpostertime'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$lastposter = $row[0];

	$query = "SELECT time FROM ibb_threads WHERE timeline='$lastpostertime'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$lastposterd = $row[0];
}else{
	$lastpostertime = $lastposterr;

	$query = "SELECT name FROM ibb_replies WHERE timeline='$lastpostertime'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$lastposter = $row[0];

	$query = "SELECT time FROM ibb_replies WHERE timeline='$lastpostertime'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$lastposterd = $row[0];
}

//gets the member ID from the database
$query = "select mid from ibb_members where name='$lastposter'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$lastpostermid = $row[0];

//gets rid of the beginning part of the date
$lastposterd = eregi_replace("Posted On: ", "", $lastposterd);
$lastposterd = eregi_replace("Editted On: ", "", $lastposterd);
$lastposterd = eregi_replace("Replied On: ", "", $lastposterd);

$servertime2 = $lastposterd;

	$servertimemonth = substr($servertime2, 0,2);
	$servertimeday = substr($servertime2, 3,2);
	$servertimeyear = substr($servertime2, 6,4);
	$servertimehour = substr($servertime2, 11,2);
	$servertimemin = substr($servertime2, 14,2);
	$servertimesec = substr($servertime2, 17,2);
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

//if the forum is locked, this will change the image
if ($lock == "yes") {
	$fimg = "<img src='images/lock.gif'>";
}else{
	$fimg = "<img src='images/off.gif'>";
}

$posts2 = $forumtopics + $forumreplies;

if((strstr($viewableto, $sessionstatus)) || ($viewableto == "all")) {
?>
              <TR align=middle>
                <TD bgColor="<?php echo $fcforumiconbgcolor; ?>"><?php echo $fimg; ?></TD>
                <TD align=left bgColor="<?php echo $fcforumnamebgcolor; ?>">
				<FONT face="<?php echo $font; ?>" color="<?php echo $fcforumnametxtcolor; ?>" size=<?php echo $fcforumnametxtsize; ?>><STRONG><U>
				<a href="viewforum.php?FID=<?php echo $forumid; ?>"><FONT face="<?php echo $font; ?>" color="<?php echo $fclinkcolor; ?>"><?php echo "$theforumname"; ?></a></FONT></U></STRONG><BR>
				<FONT face="<?php echo $font; ?>" color="<?php echo $fcforumnametxtcolor; ?>" size=1><?php echo $subject; ?></FONT></FONT></TD>
                <TD bgColor="<?php echo $fcforumpostsbgcolor; ?>">
				<FONT face="<?php echo $font; ?>" color="<?php echo $fcforumpoststxtcolor; ?>" size=1><?php echo $posts2; ?></FONT></TD>
                <TD bgColor="<?php echo $fcforumtopicsbgcolor; ?>">
				<FONT face="<?php echo $font; ?>" color="<?php echo $fcforumtopicstxtcolor; ?>" size=1><?php echo $forumtopics; ?></FONT></TD>
                <TD background="" bgColor="<?php echo $fcforumlpbgcolor; ?>">
                  <P align=right><FONT face="<?php echo $font; ?>" color="<?php echo $fcforumlptxtcolor; ?>" size=1>
				
<?php 
//checks to see if the forum has any posts, if not shows "No Posts Yet", if it does, it shows the name and date of the last one
if ($lastposter == "") {
	echo "No Posts Yet"; 
}else{
	if ($lastposter == "Guest") {
		echo ("$lastposterdst $lastposterdend<BR>by <B>$lastposter");
	}else{
		echo ("$lastposterdst $lastposterdend<BR>by <A href='member.php?MID=$lastpostermid'><B>$lastposter"); 
	}
}
?>
	
</FONT></P></TD>
                <FORM>
                <TD vAlign=center noWrap align=right bgColor="<?php echo $fcforummodsbgcolor; ?>"><FONT 
                  face=Verdana><IMG alt="" hspace=0 
                  src="images/team.gif" 
                  align=absMiddle border=0> </FONT><SELECT 
                  style="FONT-SIZE: 7pt; FONT-FAMILY: Arial, Tahoma; BACKGROUND-COLOR: #dfdfdf" 
                  onchange="window.location=('member.php?MID='+this.options[this.selectedIndex].value)" name=newLoc 
                    maxlength="20"> 
					<OPTION value=# selected>Moderators</OPTION> 
                    <OPTION value=#><-------------------></OPTION> 
<?php
//gets the moderators
$result = mysql_query("SELECT * FROM ibb_mods WHERE fid='$forumid'") or die (mysql_error());
while ($row = mysql_fetch_array($result)) {
	$modsnames = $row ["name"];
	$modsmid = $row ["mid"];
	echo ("<OPTION value=$modsmid>$modsnames</OPTION>");
}
?>	

</SELECT></TD></FORM>

<?php
}
}
}
}

if ($sessionuser != "Guest") {
$query = "select mid from ibb_members where name ='$sessionuser'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$pmmid = $row[0];
$query = "select count(*) from ibb_priv_msgs where mid ='$pmmid' && status = 'yes'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$pmold = $row[0];
$query = "select count(*) from ibb_priv_msgs where mid ='$pmmid' && status = 'no'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$pmnew = $row[0];
?>

              <TR id=cat>
                <TD <?php echo $bgimage; ?> colSpan=6><B><FONT face=Verdana 
                  size=<?php echo $fccattxtsize; ?> color="<?php echo $fccattxtcolor; ?>">» Private Messages</FONT></B></TD></TR>
              <TR>
                <TD vAlign=top align=middle bgColor="<?php echo $fcforumiconbgcolor; ?>"></TD>
                <TD bgColor="<?php echo $fcforumnamebgcolor; ?>" colSpan=5><FONT face=<?php echo $font; ?> size=1 color="<?php echo $fcforumnametxtcolor; ?>">New Messeges: <b><?php echo $pmnew; ?></b> Old Messeges: <b><?php echo $pmold; ?></b><br>Go To [ <b><a href="pm.php?function=inbox">Inbox</a></b> ]</FONT></TD></TR><?php } ?>
              <TR>
                <TD <?php echo $bgimage; ?> colSpan=6><STRONG><FONT 
                  face=Verdana size=<?php echo $fccattxtsize; ?> color="<?php echo $fccattxtcolor; ?>">» Currently 
                  Online</FONT></STRONG></TD></TR>
              <TR>

<?php 

//gets the count of the guests and just registered users
$query = "select count(*) from ibb_onlineusers where username ='Guest' && username != ''";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$membersonline = $row[0];

$query = "select distinct count(IP) from ibb_onlineusers where username !='Guest'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$membersonline2 = $row[0];
?> 

                <TD bgColor="<?php echo $fcforumnamebgcolor; ?>" colSpan=6>
                  <P><FONT><FONT face=Verdana color="<?php echo $indexmcattxtcolor; ?>"><FONT size=1>There are 
                  <STRONG><?php echo $membersonline2; ?></STRONG> members and <STRONG><?php echo $membersonline; ?></STRONG> 
                  guests browsing our 
                  forums.<BR></FONT></FONT></FONT></FONT><FONT 
                 ><FONT><FONT face=Verdana 
                  size=1>
	
<?php 

//shows the actual user's names
$result = mysql_query("SELECT DISTINCT username FROM ibb_onlineusers WHERE username != 'Guest' && username != '' ORDER BY time desc") or die(mysql_error());
while ( $row = mysql_fetch_array($result)) {
	$array[] = $row['username'];
}
foreach($array as $thememberonline) {
	$result = mysql_query("SELECT DISTINCT IP FROM ibb_onlineusers WHERE username = '$thememberonline'") or die(mysql_error());
	while ($row=mysql_fetch_array($result)) {
	$blaIP = $row["IP"];
	}

	$memberonline = "<u>$thememberonline</u>";

	$query = "select mid from ibb_members where name = '$thememberonline'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$membersonlinemid = $row[0];

	$query = "select status from ibb_members where name = '$thememberonline'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$memberonlinestatus = $row[0];

	if ($memberonlinestatus == "admin") {
		echo("<font size=1 color=$indexmcattxtcolor>-></font><a href='member.php?MID=$membersonlinemid'><font color=$admincolor>$memberonline</font></a> ");
	}elseif ($memberonlinestatus == "Moderator"){
		echo("<font size=1 color=$indexmcattxtcolor>-></font><a href='member.php?MID=$membersonlinemid'><font color=$modcolor>$memberonline</font></a> ");
	}else{
		echo("<font size=1 color=$indexmcattxtcolor>-></font><a href='member.php?MID=$membersonlinemid'><font color=$usercolor>$memberonline</a>");
	}
} 

//gets the name of members whos status is admin
$result = mysql_query("select name from ibb_members where status='admin'");
while ($row = mysql_fetch_array($result)) {
	$blaname[] = $row["name"];
}

$result = mysql_query("select pagename from ibb_onlineusers where username='$blaname'");
?>
	
<BR></FONT></P></FONT></FONT></TD></TR>
              <TR>
                <TD background="" bgColor="<?php echo $fcforumnamebgcolor; ?>" colSpan=6><FONT face=Verdana size=1><FONT color=<?php echo $usercolor; ?>><STRONG>· </STRONG>Members 
                  Browsing:</FONT>&nbsp;<U><a href="onlineusers.php?view=Member">View Members</a></U>&nbsp;
<FONT color=<?php echo $admincolor; ?>><STRONG>· </STRONG>Admins</FONT><FONT color=<?php echo $admincolor; ?>> Browsing:</FONT>
	<a href="onlineusers.php?view=admin">View Admins</a></U>&nbsp;<FONT color=<?php echo $modcolor; ?>><STRONG>· </STRONG>Moderators</FONT><FONT color=<?php echo $modcolor; ?>>&nbsp;Browsing:</FONT><FONT face=Verdana> 
                  <U><a href="onlineusers.php?view=Moderator">View Moderators</a></U></FONT></FONT></FONT></FONT></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR><!-- timezone/login-->
<?php
}
}
}
}
}
}
}
include "footer.php";
echo $images;
echo $copyrights; 


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>