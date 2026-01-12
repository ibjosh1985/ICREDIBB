<?php
/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/


include "header.php";

//starts a session, then sets cookies with the info of them
session_start();
if (!isset($userstuffid)) {
session_register('sessionuser');
session_register('sessionstatus');
session_register('count');
} else if ((!$sessionuser) || (!$sessionstatus) || (!$count)) {
session_register('sessionuser');
session_register('sessionstatus');
session_register('count');
}

if (!$sessionuser) {
$sessionuser = "Guest";
} 

if (!$sessionstatus) {

$sessionstatus = "Guest";

}

if ($MID < "1") {
	?>
		 <TABLE cellSpacing=1 cellPadding=0 width="100%" align=center 
      bgColor=<?php echo $muabgcolor; ?> border=0>
        <TBODY>
        <TR>
          <TD bgColor=<?php echo $muatopbarbgcolor; ?>><FONT face=<?php echo $font; ?> size=2 color=<?php echo $muatopbartxtcolor; ?>><center>No user specified. Redirecting to main page.</center>
			<META HTTP-EQUIV="Refresh" 
			CONTENT="2;URL=index.php"></td></tr></tbody></table><br>
	<?php
}else{


$result = mysql_query("SELECT * FROM ibb_members WHERE mid=$MID");
while ( $row = mysql_fetch_array($result) ) {
$membername = $row["name"];
$memberemail = $row["email"];
$memberstatus = $row["status"];
$membersince = $row["time"];
$birthday = $row["birthday"];
$location = $row["location"];
$signature = $row["signature"];
$avatar = $row["aviator"];
$totalposts = $row["posts"];
$msn = $row["msn"];
$aim = $row["aim"];
$icq = $row["icq"];
$yahoo = $row["yahoo"];
$occupation = $row["occupation"];
$website2 = $row["website"];
$interests = $row["interests"];
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
}

if (!$occupation) {
	$occupation = "N/A";
}

if (!$location) {
	$location = "N/A";
}

if (!$membersince) {
	$membersince = "N/A";
}

if (!$signature) {
	$signature = "No Signature";
}

$ptitle = "$boardname - Member: $membername";
echo ("<title>$ptitle</title>");

$sql = "UPDATE ibb_onlineusers SET pagename='$ptitle' WHERE IP='$IP'";
if (mysql_query($sql)) {
}

$query = "select count(*) from ibb_threads where name='$membername'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$totalthreads = $row[0];

$query = "select count(*) from ibb_replies where name='$membername'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$totalreplies = $row[0];

$aliveposts = $totalthreads + $totalreplies;

if ($totalposts == "") {
$totalposts = "0";
}

$query = "SELECT name FROM ibb_members WHERE mid='$MID'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$membersname = $row[0];

$query = "SELECT pagename FROM ibb_onlineusers WHERE username='$membername'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$ibblocation = $row[0];
$query = "SELECT location FROM ibb_onlineusers WHERE username='$membername'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$ibblocationurl = $row[0];

if (!$ibblocation) {
	$ibblocation = "Not Online";
}
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border: 1 solid <?php echo $muabgcolor; ?>"><tr><td>
<table cellpadding="4" cellspacing="0" border="0" width="100%">
                <tr bgcolor="<?php echo $muatopbarbgcolor; ?>" border="0" style="border: 1 solid <?php echo $muabgcolor; ?>"> 
                  <td colspan="2" align="center"><FONT face=<?php echo $font; ?> size=2 color=<?php echo $muatopbartxtcolor; ?>><b>Viewing 
                    profile for user <?php echo "\"$membersname\""; ?></b></font></td><tr><td bgcolor="#000000" colspan="2"></td></tr>
</tr>
<tr>
                  <td bgcolor="<?php echo $muaboxbgcolor; ?>" valign="top"> 
                    <table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
                        <td align="center" bgcolor="<?php echo $muatopbarbgcolor; ?>" valign="top" style="border: 1 solid <?php echo $muabgcolor; ?>" width="20%"><font face="<?php echo $font; ?>" color="<?php echo $muatopbartxtcolor; ?>" size="2"><B>Avatar</B></font></td>
                      </tr>
<tr>
                        <td align="center" valign="top"><?php 
				  if ($sessionuser == "Guest") {
				  echo ("<img src='images/guestavatar.gif'>");
			}else{
				if (($avatar == "") || ($avatar == "You do not have an avatar yet.")) {
				  echo ("<img src='images/noavatar.gif'>");
				}else{
					echo ("<img src='$avatar'>");
				}
			}?></td>
                      </tr>
</table>
                  </td>
                  <td bgcolor="<?php echo $muaboxbgcolor; ?>" rowspan="2" valign="top">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
                        <td align="center" bgcolor="<?php echo $muatopbarbgcolor; ?>" valign="top" style="border: 1 solid <?php echo $muabgcolor; ?>"><font face="<?php echo $font; ?>" color="<?php echo $muatopbartxtcolor; ?>" size="2"><B>User 
                          Info</B></font></td>
                      </tr>
<tr><td valign="top">
                          <table width="100%" cellspacing="0" cellpadding="2" border="0">
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Registered: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><?php echo $membersince; ?></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Status: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><b> 
                                
                                </b><?php echo $memberstatus; ?></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Total Posts:
								 </B></font></td>
							  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><b> 

                               <?php echo $totalposts; ?></B></font></td>
                            </tr>              
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Active Posts:
								 </B></font></td>
							  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><b> 

                               <?php echo $aliveposts; ?></B></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>IcrediBB Location: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><?php if ($ibblocation == "Not Online") { echo "<i>"; }else{ ?><a href="<?php echo $ibblocationurl; ?>"><?php } ?><font color=<?php echo $mualinkcolor; ?>><?php echo $ibblocation; ?></a></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Website: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><a href="<?php echo $website2; ?>"><?php echo $website2; ?></a></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Birthday: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><?php echo $birthday; ?></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Occupation: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><?php echo $occupation; ?></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Location: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><?php echo $location; ?></font></td>
                            </tr>
                            <tr> 
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Interests: 
                                </B></font></td>
                              <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><?php echo $interests; ?></font></td>
                            </tr>
                            <font face="verdana,arial,helvetica" size="1" > 
                            <tr> 
                              <td valign="top" colspan="2" style="border: 1 solid #000000"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" >Signature:<BR><?php echo $signature; ?></font> </td>
                            </tr>
                            </font> 
                          </table>
                        </td></tr>
</table>
</td></tr>
</table></td></tr></table><p>
<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border: 1 solid <?php echo $muabgcolor; ?>"><tr><td>
<table cellpadding="4" cellspacing="0" border="0" width="100%">
                <tr bgcolor="<?php echo $muaboxbgcolor; ?>" border="0" style="border: 1 solid <?php echo $muabgcolor; ?>"> 
            <td align="center" bgcolor="<?php echo $muatopbarbgcolor; ?>" valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muatopbartxtcolor; ?>" size="2"><B>User 
              Contact</B></font></td><tr><td bgcolor="#000000" colspan="2"></td></tr>
          </tr>
<tr><td align="center" valign="top" bgcolor=<?php echo $muaboxbgcolor; ?>>
              <table width="100%" cellspacing="0" cellpadding="2" border="0">
                <tr bordercolor="#000000" style="border: 1 solid #000000"> 
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>E-Mail: 
                    </B></font></td>
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><a href="mailto:<?php echo $memberemail; ?>">Click 
                    here to email <?php echo $membersname; ?></a></font></td>
                </tr>
                <tr bordercolor="#000000"> 
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>Private 
                    Message: </B></font></td>
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" >
                    <a href="pm.php?function=sendpm&to=<?php echo $membersname; ?>">Send 
                    <?php echo $membersname; ?> a Private Message!</a></font></td>
                </tr>
                <tr bordercolor="#000000"> 
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>ICQ: 
                    </B></font></td>
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=<?php echo $icq; ?>&action=message"><?php echo $icq; ?></a></font></td>
                </tr>
                <tr bordercolor="#000000"> 
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>AIM: 
                    </B></font></td>
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><a href="aim:goim?screenname=<?php echo $aim; ?>"><?php echo $aim; ?></a></font></td>
                </tr>
                <tr bordercolor="#000000"> 
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>MSN: 
                    </B></font></td>
                  <td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><?php echo $msn; ?></font></td>
                </tr>
<tr><td valign="top"><font face="<?php echo $font; ?>" color="<?php echo $muaboxtxtcolor; ?>" size="1" ><B>YAHOO: </B></font></td>
                  <td valign="top"><font face="verdana,arial,helvetica" size="1" ><?php echo $yahoo; ?></font></td>
                </tr>
</table>
</td></tr>
</table>
      </td>
    </tr>
</table></center><p>
<?php
}
include "footer.php";
echo $copyrights;


/***************************************************\
**                    IcrediBB Bulletin Board System                    **
**         Copyright © 2001-2002 IcrediBB Design Team         **
\***************************************************/
?>