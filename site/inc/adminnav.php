<?php 
if(!isset($active)){
	$active = 'admin';
}
?>

<dl class="sub-nav">
	<dd <?php if($active == 'admin'){echo 'class="active"';}?> ><a href="/admin">Admin</a></dd>
	<dd <?php if($active == 'event'){echo 'class="active"';}?> ><a href="/admin/event">Tournament</a></dd>
</dl>