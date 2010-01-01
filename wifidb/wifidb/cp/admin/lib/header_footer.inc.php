<?php
function admin_pageheader($page = '')
{
	global $login_check;
	
	$ver 		=	$GLOBALS['ver']['wifidb'];
	$root		= 	$GLOBALS['root'];
	$hosturl	= 	$GLOBALS['hosturl'];
	$conn		=	$GLOBALS['conn'];
	$db			=	$GLOBALS['db'];
	$head		= 	$GLOBALS['header'];
	$half_path	=	$GLOBALS['half_path'];
	$mode = $GLOBALS['mode'];
	$func = $GLOBALS['func'];
	
	$token = session_starter();
	
	include_once($half_path.'/lib/database.inc.php');
	include_once($half_path.'/lib/security.inc.php');
	include_once($half_path.'/lib/config.inc.php');	
	
	$sec = new security();
	
	?>
	<html>
		<head>
			<title>Wireless DataBase <?php echo $ver;?> --> Administrator Control Panel --> <?php echo $page;?></title>
			<?php echo $head;?>
		</head>
	<?php

	#check_install_folder();
	# START YOUR HTML EDITS HERE #
	$filtered = $_SERVER['QUERY_STRING'];
	$SELF = $_SERVER['PHP_SELF'];
	if($SELF == '/wifidb/login.php')
	{
		$SELF = "/$root/";
		$filtered = '';
	}
	if($filtered != '')
	{$SELF = $SELF.'?'.$filtered;}
	?>
	<script type="text/javascript">
	
	function confirmation()
	{
		if (!confirm("Are you sure you want to leave the Administrative page?"))
		{
			document.location = "<?php echo $SELF; ?>";
		}else
		{
			document.location = "<?php echo '/'.$root.'/cp/';?>";
		}
	}
	
	function confirmation1() {
		var answer = confirm("Leave the Admin area?")
		if (answer){
			alert("Bye bye!")
			window.location = "<?php echo '/'.$root.'/cp/';?>";
		}else
		{
			alert("All righty then!")
		}
	}
	</script>
	<link rel="stylesheet" href="<?php if($root != ''){echo $hosturl.$root;}?>/themes/wifidb/styles.css">
	<body topmargin="10" leftmargin="0" rightmargin="0" bottommargin="10" marginwidth="10" marginheight="10">
	<div align="center">
	<table border="0" width="85%" cellspacing="5" cellpadding="2">
		<tr style="background-color: #315573;"><td colspan="2">
		<table width="100%">
			<tr>
				<td style="width: 215px">
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.randomintervals.com"><img border="0" src="<?php echo $hosturl.$root; ?>/img/logo.png"></a>
				</td>
				<td>
					<p align="center"><b>
					<font style="size: 5;font-family: Arial;color: #FFFFFF;">
					Wireless DataBase <?php echo $ver;?> <br /><br /></font>
					<font style="font-size: medium;text-decoration: underline;color: #FFFFFF;">
					<strong><em>Administrator Control Panel Page</em></strong></b></p>
				</td>
			</tr>
		</table>
		</td></tr>
		<tr>
			<td style="background-color: #304D80;width: 15%;vertical-align: top;">
			<img alt="" src="/wifidb/themes/wifidb/img/1x1_transparent.gif" width="185" height="1" /><br>
			<?php
			switch($func)
			{
				case "overview":
					?>
					<span class="content_head"><strong><em>[Overview]</em></strong></span><br>
					<a class="links<?php if($mode == 'aps'){echo '_s';}?>" href="?func=overview&mode=APs">Access Points</a><br>
					<a class="links<?php if($mode == 'geo'){echo '_s';}?>" href="?func=overview&mode=geo">Geocaches</a><br>
					<a class="links<?php if($mode == 'users'){echo '_s';}?>" href="?func=overview&mode=users">Users</a><br>
					<a class="links<?php if($mode == 'daemon'){echo '_s';}?>" href="?func=overview&mode=daemon">Daemon Stats</a>
					<?php
				break;
				
				case "uandp":
					?>
					<span class="content_head"><strong><em>[Users and Permissions]</em></strong></span><br>
					<a class="links<?php if($mode == 'man_users'){echo '_s';}?>" href="?func=uandp&mode=man_users">Manage Users</a><br>
					<a class="links<?php if($mode == 'man_groups'){echo '_s';}?>" href="?func=uandp&mode=man_groups">Manage Groups</a><br>
					<a class="links<?php if($mode == 'man_titles'){echo '_s';}?>" href="?func=uandp&mode=man_titles">Manage Titles</a>
					<?php
				break;
				
				case "maint":
					?>
					<span class="content_head"><strong><em>[Maintenance]</em></strong></span><br>
					<a class="links<?php if($mode == 'clean_tmp'){echo '_s';}?>" href="?func=maint&mode=clean_tmp">Clean-up temp folders</a><br>
					<a class="links<?php if($mode == 'clean_upload'){echo '_s';}?>" href="?func=maint&mode=clean_upload">Clean-up upload files</a><br>
					<a class="links<?php if($mode == 'clean_signal'){echo '_s';}?>" href="?func=maint&mode=clean_signal">Clean-up Signal Graphs</a><br>
					<a class="links<?php if($mode == 'check_dates'){echo '_s';}?>" href="?func=maint&mode=check_dates">Check for bad dates</a><br>
					<a class="links<?php if($mode == 'check_cords'){echo '_s';}?>" href="?func=maint&mode=check_cords">Check for geo-cords</a><br>
					<?php
				break;
				
				case "system":
					?>
					<span class="content_head"><strong><em>[System]</em></strong></span><br>
					<a class="links<?php if($mode == 'daemon'){echo '_s';}?>" href="?func=system&mode=daemon">Daemon</a><br>
					<a class="links<?php if($mode == 'daemon_config'){echo '_s';}?>" href="?func=system&mode=daemon_config">Edit Daemon Config File</a><br>
					<a class="links<?php if($mode == 'db_config'){echo '_s';}?>" href="?func=system&mode=db_config">Edit Config File</a><br><br>
					<a class="links<?php if($mode == 'updates'){echo '_s';}?>" href="?func=system&mode=updates">Check for updates</a>
					<?php
				break;
				
				default:
					?>
					<span class="content_head"><strong><em>[Overview]</em></strong></span><br>
					<a class="links<?php if($mode == 'aps'){echo '_s';}?>" href="?func=overview&mode=APs">Access Points</a><br>
					<a class="links<?php if($mode == 'geo'){echo '_s';}?>" href="?func=overview&mode=geo">Geocaches</a><br>
					<a class="links<?php if($mode == 'users'){echo '_s';}?>" href="?func=overview&mode=users">Users</a><br>
					<a class="links<?php if($mode == 'daemon'){echo '_s';}?>" href="?func=overview&mode=daemon">Daemon Stats</a>
					<?php
				break;
			}
			?>
		</td>
		<td style="background-color: #A9C6FA;width: 80%;vertical-align: top;" align="center">
		<table width="100%">
			<tr>
				<?php
				$user_logins_table = $GLOBALS['user_logins_table'];
				list($cookie_pass_seed, $username) = explode(':', $_COOKIE['WiFiDB_login_yes']);
				$sql0 = "SELECT * FROM `$db`.`$user_logins_table` WHERE `username` = '$username' LIMIT 1";
				$result = mysql_query($sql0, $conn);
				$newArray = mysql_fetch_array($result);
				$last_login = $newArray['last_login'];
				
				?>
				<td>Welcome, <a class="links" href="javascript:confirmation()"><?php echo $username;?></a><font size="1"> (Last Login: <?php echo $last_login;?>)</font></td>
				<td align="right"><a class="links" href="<?php echo $hosturl.$root; ?>/login.php?func=logout_proc">Logout</a></td>
			</tr>
		</table>
		<table width="100%" align="center" border='1'>
			<tr class="sub_header">
				<td align="center" width="25%">&nbsp;&nbsp;<a class="links<?php if($func == 'overview' or $func == ''){echo '_s';}?>" href="?func=overview">Overview</a>&nbsp;&nbsp;</td>
				<td align="center" width="25%">&nbsp;&nbsp;<a class="links<?php if($func == 'uandp'){echo '_s';}?>" href="?func=uandp">Users and Permissions</a>&nbsp;&nbsp;</td>
				<td align="center" width="25%">&nbsp;&nbsp;<a class="links<?php if($func == 'maint'){echo '_s';}?>" href="?func=maint">Maintenance</a>&nbsp;&nbsp;</td>
				<td align="center" width="25%">&nbsp;&nbsp;<a class="links<?php if($func == 'system'){echo '_s';}?>" href="?func=system">System</a>&nbsp;&nbsp;</td>
			</tr>
		</table>
		<p align="center">
		<br>
	<!-- KEEP BELOW HERE -->
	<?php
}


#========================================================================================================================#
#									Footer (writes the footer for all pages)								#
#========================================================================================================================#

function admin_footer($filename = '', $output = "detailed")
{
	$half_path	=	$GLOBALS['half_path'];
	include_once($half_path.'/lib/database.inc.php');
	include_once($half_path.'/lib/config.inc.php');
	$root = $GLOBALS['root'];
	$tracker = $GLOBALS['tracker'];
	$ads = $GLOBALS['ads'];
	$file_ex = explode("/", $filename);
	$count = count($file_ex);
	$filename_1 = $file_ex[($count)-1];
	if($output == "detailed")
	{
		?>
		</p>
		<br>
		</td>
		</tr>
		<tr>
		<td bgcolor="#315573" height="23"></td>
		<td bgcolor="#315573" width="0" align="center">
		<?php
		if (file_exists($filename_1)) 
		{
		?>
			<h6><i><u><?php echo $filename_1;?></u></i> was last modified:  <?php echo date ("Y F d @ H:i:s", getlastmod());?></h6>
		<?php
		}
		?>
		</td>
		</tr>
		<tr>
		<td></td>
		<!--  ADS AND TRACKER" -->
		<td align="center">
		<?php
		echo $tracker;
		echo $ads;
		?>
		</td>
		<!-- END ADS AND TRACKER" -->
		</tr>
		</table>
		</body>
		</html>
		<?php
	}
}

?>