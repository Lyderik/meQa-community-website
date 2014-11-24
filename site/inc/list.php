<?php
if(isset($_GET['eventid'])){
ob_start();
session_start();
require '../inc/config.php';
require ROOT . 'inc/model.user.php';
require ROOT . 'inc/model.event.php';

	$param = eventGetUsers(1);
	$players = usersGetBySteamID($param);
	if(!empty($players)){

		$count = count($players);

	function sorter($key) {
	    return function ($a, $b) use ($key) {
	        if($a[$key] == $b[$key]){
	        	return 0; 
	        }
	        return ($a[$key] == 'offline' && $b[$key] == 'in-game' || $a[$key] == 'offline' && $b[$key] == 'online' || $a[$key] == 'online' && $b[$key] == 'in-game') ? 1 : -1;
	    };
	}
    usort($players, sorter('onlinestate'));

		echo "<b>" . $count . "</b> already signed up!";
		echo "<div>";


		if($count >= 30){
			for ($i = 0; $i <= 29; $i++) {
				echo "<a href='" . $players[$i]['profileurl'] . "' data-tooltip class='tip-top' target='_blank' title='" . $players[$i]['personaname'] . "'><img src='" . $players[$i]['avatar'] . "' class='" . $players[$i]['onlinestate'] . "'></a>";
			}
		}else{
			for ($i = 0; $i <= $count-1; $i++) {
        echo "<a href='" . $players[$i]['profileurl'] . "' data-tooltip class='tip-top' target='_blank' title='" . $players[$i]['personaname'] . "'><img src='" . $players[$i]['avatar'] . "' class='" . $players[$i]['onlinestate'] . "'></a>";
			}
		}
			echo "</div>";
  	}
}
?>