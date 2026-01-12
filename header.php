<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


//DO NOT TOUCH ANY OF THE PHP CODE
//
//IF YOU DO AND IT SCREWS UP THE BOARD, IT IS NOT ICREDIBB'S RESPONSIBILITY
//
//EDIT IT AT YOUR OWN RISK!

//this gets various functions used across IcrediBB
include "functions.php";

//if ($sessionstatus != "admin") {
//	die("Forum is restricted for the development team only.");
//}

//THE HTML HERE ON IS EDITTABLE
?>
<HTML><HEAD>
<STYLE type=text/css>
BODY {
	scrollbar-base-color: <?php echo $scrollbasecolor; ?>;
	scrollbar-track-color: <?php echo $scrolltrackcolor; ?>;
	scrollbar-face-color: <?php echo $scrollfacecolor; ?>;
	scrollbar-highlight-color: <?php echo $scrollhighcolor; ?>;
	scrollbar-3dlight-color: <?php echo $scroll3dlight; ?>;
	scrollbar-darkshadow-color: <?php echo $scrolldscolor; ?>;
	scrollbar-shadow-color: <?php echo $scrollshadow; ?>;
	scrollbar-arrow-color: <?php echo $scrollarrowcolor; ?>;
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
<BODY id=all text="<?php echo $txtcolor; ?>" vLink=#000020 aLink="<?php echo $activelinkcolor; ?>" link="<?php echo $linkcolor; ?>"
bgColor="<?php echo $bgcolor; ?>" topMargin=10 marginheight="10" marginwidth="10">
<CENTER>
<a href="index.php"><img src='<?php echo $boardlogo; ?>' border=0></a>
<TABLE cellSpacing=0 cellPadding=10 width="760" bgColor=<?php echo $bgcolor; ?> border=0>
  <TBODY>
  <TR>
    <TD>

			  <?php
			  //EDIT AT YOUR OWN RISK
              if ($optionstatus == "off") {
				?> 
				<center><FONT face=<?php echo $font; ?> color="<?php echo $txtcolor; ?>" size=1>User Status:</U></STRONG> 
                  <?php echo $sessionstatus; ?> <form action="index.php?tfunction=toggleoptions" method=post>[ <input type=hidden name=url value=<?php echo $thelocation; ?>><input type=submit name=submitthis2 value="Show Header Bar" style="font-family: <?php echo $font; ?>; background-color: <?php echo $bgcolor; ?>; border-right: 0; border-left: 0; border-top: 0; border-bottom: 0; height: 15px; width: 98px; cursor: hand; font-size: 10px; text-decoration: underline;"> ]</FONT></center></form>
				<?php
			  }else{
		      //HTML HERE ON OUT IS EDITABLE
			  ?>

      <TABLE cellSpacing=0 cellPadding=1 width="100%" background="" border=0>
        <TBODY>
        <TR>
          <TD background="" bgColor="<?php echo $hbgcolor; ?>">
            <TABLE cellSpacing=0 cellPadding=4 width="100%" background="" 
            border=0>
              <TBODY>
              <TR>
                <TD width="50%" bgColor="<?php echo $htopbarbgcolor; ?>"><STRONG><FONT face=Verdana size=1 color="<?php echo $htopbartxtcolor; ?>">»&nbsp;Welcome 
                  to <?php echo $boardname; ?>, <?php echo $sessionuser; ?></FONT></STRONG></TD>
                <TD background="" bgColor=<?php echo $htopbarbgcolor; ?> colSpan=6><FONT face=Verdana size=1 color="<?php echo $htopbartxtcolor; ?>"><B>»&nbsp;<?php echo $boardname; ?>
              Stats</B></FONT></TD></TR>
              <TR>
                <TD width="50%" background="" bgColor=#000000><STRONG><FONT 
                  face=Verdana color=#eeeeff size=2></FONT></STRONG></TD>
                <TD background="" bgColor=#000000 colSpan=6><FONT 
                  face=Verdana></FONT></TD></TR>
              <TR>
                <TD width="50%" bgColor="<?php echo $hboxbgcolor; ?>"><FONT size=1>
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD width="10%">
					  
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
			
			</TD>
                      <TD width="1%"><FONT face=Verdana>&nbsp;</FONT></TD>
                      <TD vAlign=top width="89%">
					  <FONT face=Verdana size=1 color="<?php echo $hboxtxtcolor; ?>">
					  <?php
					  if ($sessionstatus == "Guest") {
						  echo ("Please <a href=\"index.php?function=register\">Register</a> or ");
						  echo ("<a href=\"index.php?function=login\">Login</a>");
			          }else{
						  ?>
                        Enter the </FONT>
					  <FONT size=1>
					  <FONT face=Verdana color="<?php echo $hboxtxtcolor; ?>"><u><a href="pm.php?function=inbox">Inbox</a></u>, <U><a href="usercp.php">User 
                        CP</a></U><?php if ($sessionstatus == "admin") {?>, <u><a target="_blank" href="admincp.php">Admin CP</a></u><?php } ?>
							
						<?php 
						//EDIT AT YOUR OWN RISK
						if($sessionstatus == "admin") { 
						?>
						<BR>Change Color Theme </FONT>
						<FONT face=Verdana color="<?php echo $hboxtxtcolor; ?>"><U><STRONG><a href="admincp.php?function=thchange">»</a>
						<?php } ?>
							
						<BR></STRONG></U>Change Time 
                        Zone <STRONG><U><a href="usercp.php?function=changetpref">»</a></U> 
                        </STRONG><BR><BR><U><STRONG><a href="usercp.php?function=avataroptions&thing=addnew">Change 
                        Avatar</a></STRONG></U></FONT></FONT>

						<?php 
						//DO NOT EDIT THIS
						} 
						$totalposts = $topicnumber + $replynumber;
						//HTML HERE ON OUT IS EDITABLE
						?>

						</TD></TR></TBODY></TABLE></FONT></TD>
                <TD vAlign=top background="" bgColor=<?php echo $hboxbgcolor; ?> colSpan=6>
				<FONT size=1>
				<FONT face=Verdana color="<?php echo $hboxtxtcolor; ?>">
				<STRONG>Total Posts:</STRONG> 
                  <?php echo $totalposts; ?> - 
				  <STRONG>Total Threads:</STRONG> 
				  <?php echo $topicnumber; ?><BR>Total 
                  Registered Members: <B>
				  <?php echo $totalmembers; ?><BR>
				  </B>Welcome to our newest 
                  member, </FONT>
				  <FONT face=Verdana size=1 color="<?php echo $hboxtxtcolor; ?>">
				  <?php echo ("<a href=\"member.php?MID=$newmemberid\">$newestmember</a>"); ?><br><br><STRONG><u>User Group:</u></strong> <?php echo $usergroup; ?>
				  <STRONG><U><BR>User Status:</U></STRONG> 
                  <?php echo $sessionstatus; ?></FONT>
				  </FONT></TD></TR>
				  <TR> <TD vAlign=top background="" bgColor=<?php echo $hboxbgcolor; ?> colSpan=7><center><FONT face=Verdana size=1 color="<?php echo $hboxtxtcolor; ?>">
					 <?php if ($sessionstatus == "Guest") { }else{ ?> <form action="index.php?tfunction=toggleoptions" method=post>[ <input type=hidden name=url value=<?php echo $thelocation; ?>><input type=submit name=submitthis2 value="Hide Header Bar" style="font-family: <?php echo $font; ?>; background-color: <?php echo $hboxbgcolor; ?>; border-right: 0; border-left: 0; border-top: 0; border-bottom: 0; height: 15px; width: 95px; cursor: hand; font-size: 10px; text-decoration: underline;"> ]<?php 						} ?></TD></TR></form></TBODY></TABLE></TD></TR></TBODY></TABLE></FONT><BR></P><?php } ?>
				  <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
				  <script language="JavaScript" src="overlib.js"><!-- overLIB (c) Erik Bosrup --></script> 
				  <a href="index.php"><img src='themes/<?php echo $theme1; ?>/images/home.gif' border=0></a> 
				  <?php if ($sessionstatus == "Guest") { ?>
				  <a href="index.php?function=register"><img src='themes/<?php echo $theme1; ?>/images/register.gif' border=0></a> 
				  <a href="index.php?function=login"><img src='themes/<?php echo $theme1; ?>/images/login.gif' border=0></a><?php }else{ ?>
				  <a href="usercp.php"><img src='themes/<?php echo $theme1; ?>/images/usercp.gif' border=0></a> 
				  <a href="index.php?function=logout"><img src='themes/<?php echo $theme1; ?>/images/logout.gif' border=0></a><?php } ?> 

<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>																		