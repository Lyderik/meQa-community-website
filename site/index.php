<?php
ob_start();
session_start();
require 'inc/config.php';
require ROOT . 'inc/model.user.php';
require ROOT . 'inc/model.event.php';

////// Set page variabels    ///////

$pageTitle = "RAF | Rent a frag home";

////// En of page variables ///////

include ROOT . 'inc/header.php';
?>
<div id="suModal" class="reveal-modal" data-reveal>
  <h2>Terms and conditions</h2>
  <p><b>Cheat & disqualification</b><br>You agree not to use any cheats of any kind, and to play fair. We reserve the right to disqualify any participant, under the suspicion of cheating.</p>
  <a class="close-reveal-modal">&#215;</a>
</div>

<div class="row" style="margin-top: 20px;">
  <div class="medium-3 medium-uncentered small-6 small-centered columns"><img src="<?php echo DIR?>code/img/logo.png" width="100%"/></div>
  <div class="medium-9 columns panel">
    <h1>Arms race Tournament!</h1>
    <p>Welcome to our first Frag Attack - Arms Race Tournament.<br>Please press the sign up button below to have a chance to play and win an EPIC ITEM!</p>
    <?php 
    if(isset($_SESSION['user'])){ 
    	if(eventCheckIfUserSignedUp($_SESSION['user']['steamid'],1)){ ?>
    		<div class="button radius disabled" style="margin-bottom:.25rem;display:block;">You already signed up</div>
    	<?php }else{ ?>
  	<a href="<?php echo DIR?>signup/?eventid=1&des=<?php echo $_SERVER['REQUEST_URI'];?>" class="button radius" style="margin-bottom:.25rem;display:block;">Sign up now!</a>
  	<?php }}else{ ?>
  	<a href="<?php echo DIR?>login/?des=<?php echo $_SERVER['REQUEST_URI'];?>" class="button radius" style="margin-bottom:.25rem;margin-right:auto;display:block;">Log in through steam to sign up</a>
  	<?php } ?>
    <p style="font-size:60%;">By signing up, you accept the <a href="javascript: $('#suModal').foundation('reveal', 'open');">terms and conditions</a>.</p>
    <div id="loadin"><img src="<?php echo DIR?>code/img/loader.gif" style="display:block;margin:0 auto;"><p style="font-size:60%;text-align:center;">Loading participating users<p></div>
  </div>
</div>

<div class="row">
  <div class="medium-3 columns" style="margin-bottom:20px;">
    <img src="<?php echo DIR?>code/img/twitch.png" width="100%">
  </div>
	<div class="medium-9 columns" style="padding:0;"><figure style="margin:0"><object type="application/x-shockwave-flash" height="900" width="1600" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=rentafrag" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel=rentafrag&auto_play=true&start_volume=25" /></object></figure></div>
</div>
<script type="text/javascript">
$(function() {
  $('#loadin').load("<?php echo DIR?>inc/list.php?eventid=1");
    
    var $allVideos = $("iframe[src^='http://player.vimeo.com'], iframe[src^='http://www.youtube.com'], object, embed"),
    $fluidEl = $("figure");
        
  $allVideos.each(function() {
  
    $(this)
      // jQuery .data does not work on object/embed elements
      .attr('data-aspectRatio', this.height / this.width)
      .removeAttr('height')
      .removeAttr('width');
  
  });
  
  $(window).resize(function() {
  
    var newWidth = $fluidEl.width();
    $allVideos.each(function() {
    
      var $el = $(this);
      $el
          .width(newWidth)
          .height(newWidth * $el.attr('data-aspectRatio'));
    
    });
  
  }).resize();

});
</script>
<script src="<?php echo DIR?>code/js/foundation/foundation.reveal.js"></script>
<script src="<?php echo DIR?>code/js/foundation/foundation.tooltip.js"></script>
<?php include ROOT . 'inc/footer.php'; ?>