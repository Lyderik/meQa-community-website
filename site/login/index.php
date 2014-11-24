<?php
ob_start();
session_start();
require '../inc/config.php';
require ROOT . 'inc/model.user.php';
require ROOT . 'inc/lightopenid/openid.php';
try 
{
    $openid = new LightOpenID('localhost'.DIR.'login/');
    if(!$openid->mode) 
    {
        $openid->identity = 'http://steamcommunity.com/openid/?l=english';    // This is forcing english because it has a weird habit of selecting a random language otherwise
        header('Location: ' . $openid->authUrl());
    } 
    elseif($openid->mode == 'cancel') 
    {
        echo 'User has canceled authentication!';
    } 
    else 
    {
        if($openid->validate()) 
        {
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);

                $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . STEAMAPI . "&steamids=$matches[1]";
                $json_object= file_get_contents($url);
                $json_decoded = json_decode($json_object);

                foreach ($json_decoded->response->players as $player)
                { 
                    if(!userCheckIfExist($player->steamid)){
                        $insert = userCreate($player->steamid);
                         if(!$insert){
                            echo "Failed to create user";
                        }
                    }
                    
                    $_SESSION['user'] = array('steamid' => $player->steamid, 'personaname' => $player->personaname, 'profileurl' => $player->profileurl,'avatar' => $player->avatar,'avatarfull' => $player->avatarfull); 
                    if(isset($_GET['des'])){
                        header("Location: ". $_GET['des']);
                    }else{
                        header("Location: /");
                    }
                }
        } 
        else 
        {
            header('Location: ' . $openid->authUrl());  
        }
    }
} 
catch(ErrorException $e) 
{
    echo $e->getMessage();
}
?>