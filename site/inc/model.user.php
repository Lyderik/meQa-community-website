<?php
/* 
Create user in the database in the users table.

@param		string 		The steam ID
@return		boolean		True if created, false if not

*/
function userCreate($steamid){
	require ROOT . 'inc/db.php';
	try{
	    $query = $db->prepare("INSERT INTO `frag`.`users`(`steam_id`) VALUES (?)");
	    $query->bindParam(1, $steamid, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}
	return true;
}

/* 
Checks if the user alredt exist in the database.

@param		string 		The steam ID
@return		boolean		True if created, false if not

*/
function userCheckIfExist($steamid){
	require ROOT . 'inc/db.php';
	try{
	    $query = $db->prepare("SELECT * FROM `frag`.`users` WHERE `steam_id`= ?");
	    $query->bindParam(1, $steamid, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}

	$result = $query->fetch(PDO::FETCH_ASSOC);

	if ($result) {
		return true;
	}else{
		return false;
	}
}

/*
Gets userinformations from the user in by the steam web api from the steam ID.

@param		string		The steam ID
@return		array		An array with user informatin, but false if the user does not exist
*/

function userGetBySteamID($steamid){

	$url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=". STEAMAPI ."&steamids=$steamid";
	$response = json_decode(file_get_contents($url));

	$player = $response->response->players[0];

	$result = array('steamid'=>$player->steamid,'personaname'=>$player->personaname,'profileurl'=>$player->profileurl,'avatar'=>$player->avatar,'avatarfull'=>$player->avatarfull,'onlinestate' => userGetStatus($player->steamid));

	return $result;
}

/*
Gets userinformations from the users in by the steam web api from the steam ID.

@param		array		The steam ID's
@return		array		An array with user informatin, but false if the user does not exist
*/

function usersGetBySteamID($steamids){

	$url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=". STEAMAPI ."&steamids=";

	foreach ($steamids as $steamid) {
		$url .= $steamid . ',';
	}

	$response = json_decode(file_get_contents($url));

	$players = $response->response->players;

	$result = array();

	foreach ($players as $player) {

		$result[] = array(
			'steamid' => $player->steamid, 
			'personaname' => $player->personaname, 
			'profileurl' => $player->profileurl, 
			'avatar' => $player->avatar, 
			'avatarfull' => $player->avatarfull,
			'onlinestate' => userGetStatus($player->steamid)
		);
	}

	
	return $result;
}

/* 
Checks the user online status from the steam api, because it cant be retrived from the newest steam api

@param		string 		The steam ID
@return		boolean		True if user is an admin, false if not
*/

function userGetStatus($steamid, $timeout = 5) {
    $context = stream_context_create(array('http' => array('timeout' => $timeout)));
    $file = @file_get_contents('http://steamcommunity.com/profiles/' . $steamid . '/?xml=1', false, $context);
    $xml = @simplexml_load_string($file);
    if (isset($xml->onlineState)) {
      $onlineState = (string)$xml->onlineState;
    } else {
      $onlineState = 'offline';
    }
    return $onlineState;
  }

/* 
Checks if the user has admin rights.

@param		string 		The steam ID
@return		boolean		True if user is an admin, false if not
*/

function userisAdmin($steamid){
	require ROOT . 'inc/db.php';
	try{
	    $query = $db->prepare("SELECT * FROM `frag`.`admins` WHERE `steam_id`= ?");
	    $query->bindParam(1, $steamid, PDO::PARAM_STR);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database.";
	    return false;
	}

	$result = $query->fetch(PDO::FETCH_ASSOC);

	if ($result) {
		return true;
	}else{
		return false;
	}
}

/*
Checks if the user is logged in

@return		boolean		True if logged in, false if not


*/
function userIsLoggedIn(){
	if(isset($_SESSION['user'])){
		return true;
	}
	else{
		return false;
	}
}

/*
Logs the user en by setting the global variable $_SESSION

@param		string 		The steam ID
@param		string 		The steam users display name
@param		string 		The steam users profie url
@param		string 		The steam users avatar url
@param		string 		The steam users avatarfull url		
@return		boolean		true if succes, false if fails
*/
function userLogIn($steamid,$personaname,$profileurl,$avatar,$avatarfull){

	$_SESSION['user'] = array('steamid' => $steamid, 'personaname' => $personaname, 'profileurl' => $profileurl,'avatar' => $avatar,'avatarfull' => $avatarfull);

	if(isset($_SESSION['user'])){
		return true;
	}else{
		return false;
	}
}

function userLogOut(){

}

?>