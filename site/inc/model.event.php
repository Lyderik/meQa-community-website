<?php
/* 
Add the user to an envent in the users-event table.

@param		string 		The steam ID
@param		int			The event ID
@return		boolean		True if user added to event, false if not

*/
function eventAddUser($steamid, $eventid){
	require ROOT . 'inc/db.php';
	try{
	    $query = $db->prepare("INSERT INTO `frag`.`user-event`(`steam_id`, `event_id`) VALUES (?, ?)");
	    $query->bindParam(1, $steamid, PDO::PARAM_STR);
	    $query->bindParam(2, $eventid, PDO::PARAM_INT);
	    $query->execute(); 
	}catch(Exception $e){
	    return false;
	}
	return true;
}

/* 
Add the user to an envent in the users-event table.

@param		string 		The steam ID
@param		int			The event ID
@return		boolean		True if user added to event, false if not

*/
function eventRemoveUser($steamid, $eventid){
	require ROOT . 'inc/db.php';
	try{
	    $query = $db->prepare("DELETE FROM `frag`.`user-event` WHERE `steam_id`= ? AND `event_id`= ?");
	    $query->bindParam(1, $steamid, PDO::PARAM_STR);
	    $query->bindParam(2, $eventid, PDO::PARAM_INT);
	    $query->execute(); 
	}catch(Exception $e){
	    return false;
	}
	return true;
}

/* 
Chech if the user already signed up for the event in the event-uset table.

@param		string 		The steam ID
@param		int			The event ID
@return		boolean		True if already added to event, false if not

*/
function eventCheckIfUserSignedUp($steamid, $eventid){
	require ROOT . 'inc/db.php';
	try{
	    $query = $db->prepare("SELECT * FROM `frag`.`user-event` WHERE `steam_id`= ? AND `event_id`= ?");
	    $query->bindParam(1, $steamid, PDO::PARAM_STR);
	    $query->bindParam(2, $eventid, PDO::PARAM_INT);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database in eventCheckIfUserSignedUp()";
	    print_r($e);
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
Get the steam ID's from the users who signed up for a specifig event

@param		int			The event ID
@return		array		Rerurns an array with the steam ID's

*/
function eventGetUsers($eventid){
	require ROOT . 'inc/db.php';
	try{
	    $query = $db->prepare("SELECT `steam_id` FROM `frag`.`user-event` WHERE `event_id`= ?");
	    $query->bindParam(1, $eventid, PDO::PARAM_INT);
	    $query->execute(); 
	}catch(Exception $e){
	    echo "Could not retrieve data from database in eventGetUsers()";
	    return false;
	}
	$return = array();

	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$return[] = $row['steam_id'];
	}
	return $return;
}