<?php
#error_reporting(1);
#@ini_set('display_errors', 1);
/*
Copyright (C) 2015 Andrew Calcutt

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; Version 2 of the License.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; If not, see <http://www.gnu.org/licenses/gpl-2.0.html>.
*/
define("SWITCH_SCREEN", "HTML");
define("SWITCH_EXTRAS", "api");

include('../lib/init.inc.php');

if((int)@$_REQUEST['all'] === 1){$all = 1;}else{$all = 0;}#Show both old and new access points. by default only new APs are shown.
if((int)@$_REQUEST['new_icons'] === 1){$new_icons = 1;}else{$new_icons = 0;}#use new AP icons instead of old AP icons in kml file. by default old icons are shown.
if((int)@$_REQUEST['labeled'] === 1){$labeled = 1;}else{$labeled = 0;}#Show AP labels in kml file. by default labels are not shown.
if((int)@$_REQUEST['json'] === 1){$json = 1;}else{$json = 0;}#output json instead of creating a download
if((int)@$_REQUEST['debug'] === 1){$debug = 1;}else{$debug = 0;}#output extra debug stuff
$func=$_REQUEST['func'];
switch($func)
{
	case "exp_ap":
		$id = (int)($_REQUEST['id'] ? $_REQUEST['id']: 0);
		$Import_Map_Data = "";
		$sql = "SELECT `mac`,`ssid`,`chan`,`radio`,`NT`,`sectype`,`auth`,`encry`,`BTx`,`OTx`,`FA`,`LA`,`lat`,`long`,`alt`,`username` FROM `wifi_pointers` WHERE `id` = ?";
		$prep = $dbcore->sql->conn->prepare($sql);
		$prep->bindParam(1, $id, PDO::PARAM_INT);
		$prep->execute();
		$appointer = $prep->fetchAll();
		foreach($appointer as $ap)
		{
			#Get AP GeoJSON
			$ap_info = array(
			"id" => $id,
			"new_ap" => $new_icons,
			"named" => $named,
			"mac" => $ap['mac'],
			"ssid" => $ap['ssid'],
			"chan" => $ap['chan'],
			"radio" => $ap['radio'],
			"NT" => $ap['NT'],
			"sectype" => $ap['sectype'],
			"auth" => $ap['auth'],
			"encry" => $ap['encry'],
			"BTx" => $ap['BTx'],
			"OTx" => $ap['OTx'],
			"FA" => $ap['FA'],
			"LA" => $ap['LA'],
			"lat" => $dbcore->convert->dm2dd($ap['lat']),
			"long" => $dbcore->convert->dm2dd($ap['long']),
			"alt" => $ap['alt'],
			"manuf"=>$dbcore->findManuf($ap['mac']),
			"username" => $ap['username']
			);
			if($Import_Map_Data !== ''){$Import_Map_Data .=',';};
			$Import_Map_Data .=$dbcore->createGeoJSON->CreateApFeature($ap_info);
		}
		$results = $dbcore->createGeoJSON->createGeoJSONstructure($Import_Map_Data, $labeled);
	break;
	
	case "exp_list":
		$row = (int)($_REQUEST['row'] ? $_REQUEST['row']: 0);
		$sql = "SELECT * FROM `user_imports` WHERE `id` = ?";
		$prep = $dbcore->sql->conn->prepare($sql);
		$prep->bindParam(1, $row, PDO::PARAM_INT);
		$prep->execute();
		$dbcore->sql->checkError(__LINE__, __FILE__);
		$fetch = $prep->fetch();
		$title = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $fetch['title']);
		
		$ListGeoJSON = $dbcore->export->UserListGeoJSON($fetch['points'], $new_icons);
		$Center_LatLon = $dbcore->convert->GetCenterFromDegrees($ListGeoJSON['latlongarray']);
		$results = $dbcore->createGeoJSON->createGeoJSONstructure($ListGeoJSON['data'], $labeled);
		$file_name = $row."-".$title.".geojson";
		
		break;
		
	case "exp_user_list":
		$user = ($_REQUEST['user'] ? $_REQUEST['user'] : die("User value is empty"));
		$Import_Map_Data="";
		for ($i = 0; TRUE; $i++) {
			error_log("Processing pass $i");
			$row_count = 10000;	
			$offset = $i*$row_count ;

			$sql = "SELECT `mac`,`ssid`,`chan`,`radio`,`NT`,`sectype`,`auth`,`encry`,`BTx`,`OTx`,`FA`,`LA`,`lat`,`long`,`alt`,`username` FROM `wifi_pointers` WHERE `long` != '0.0000' AND `username` LIKE ? LIMIT $offset,$row_count";
			$prep = $dbcore->sql->conn->prepare($sql);
			$prep->bindParam(1, $user, PDO::PARAM_STR);
			$prep->execute();
			$appointer = $prep->fetchAll();
			foreach($appointer as $ap)
			{
				#Get AP GeoJSON
				$ap_info = array(
				"id" => $id,
				"new_ap" => $new_icons,
				"named" => $named,
				"mac" => $ap['mac'],
				"ssid" => $ap['ssid'],
				"chan" => $ap['chan'],
				"radio" => $ap['radio'],
				"NT" => $ap['NT'],
				"sectype" => $ap['sectype'],
				"auth" => $ap['auth'],
				"encry" => $ap['encry'],
				"BTx" => $ap['BTx'],
				"OTx" => $ap['OTx'],
				"FA" => $ap['FA'],
				"LA" => $ap['LA'],
				"lat" => $dbcore->convert->dm2dd($ap['lat']),
				"long" => $dbcore->convert->dm2dd($ap['long']),
				"alt" => $ap['alt'],
				"manuf"=>$dbcore->findManuf($ap['mac']),
				"username" => $ap['username']
				);
				if($Import_Map_Data !== ''){$Import_Map_Data .=',';};
				$Import_Map_Data .=$dbcore->createGeoJSON->CreateApFeature($ap_info);
			}
			
			$number_of_rows = $prep->rowCount();
			if ($number_of_rows !== $row_count) {break;}
		}
		$results = $dbcore->createGeoJSON->createGeoJSONstructure($Import_Map_Data, $labeled);
		break;
		
	case "exp_date":
		if(!empty($_REQUEST['date']))
		{
			$date = $_REQUEST['date'];
		}
		else
		{	
			#Get the date of the newest import
			$sql = "SELECT `date` FROM `user_imports` ORDER BY `date` DESC LIMIT 1";
			$date_query = $dbcore->sql->conn->query($sql);
			$date_fetch = $date_query->fetch(2);
			$datestamp = $date_fetch['date'];
			$datestamp_split = explode(" ", $datestamp);
			$date = $datestamp_split[0];
		}
		$date = (empty($date)) ? date($dbcore->export->date_format) : $date;
		
		#Get lists from the date specified
		$date_search = $date."%";
		$sql = "SELECT `id` , `points`, `username`, `title`, `date` FROM `user_imports` WHERE `date` LIKE '$date_search' AND `points` != ''";
		$prep = $dbcore->sql->conn->prepare($sql);
		$prep->execute();
		$fetch_imports = $prep->fetchAll();
		$AllListGeoJSON = "";
		foreach($fetch_imports as $import)
		{
			if($AllListGeoJSON !== ''){$AllListGeoJSON .=',';};
			$ListGeoJSON = $dbcore->export->UserListGeoJSON($import['points'], $new_icons);
			$AllListGeoJSON .= $ListGeoJSON['data'];
		}
		
		$results = $dbcore->createGeoJSON->createGeoJSONstructure($AllListGeoJSON, $labeled);
		$file_name = "Daily_Exports.geojson";
		break;
		
	case "exp_daily":
		#Get lists from the last day and a half
		$sql = "SELECT `id` , `points`, `username`, `title`, `date` FROM `user_imports` WHERE `date` >= DATE_SUB(NOW(),INTERVAL 1.5 DAY) AND `points` != ''";
		$prep = $dbcore->sql->conn->prepare($sql);
		$prep->execute();
		$fetch_imports = $prep->fetchAll();
		$AllListGeoJSON = "";
		foreach($fetch_imports as $import)
		{
			if($AllListGeoJSON !== ''){$AllListGeoJSON .=',';};
			$ListGeoJSON = $dbcore->export->UserListGeoJSON($import['points'], $new_icons);
			$AllListGeoJSON .= $ListGeoJSON['data'];
		}
		
		$results = $dbcore->createGeoJSON->createGeoJSONstructure($AllListGeoJSON, $labeled);
		$file_name = "Daily_Exports.geojson";
		break;
}	
if($json)
{
	header('Content-type: application/json');
}
else
{
	$download = (empty($_REQUEST['download'])) ? $file_name : $_REQUEST['download'];#Override export filename if set
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$download.'"');
}
echo $results;

