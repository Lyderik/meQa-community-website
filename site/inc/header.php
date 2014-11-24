<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php if(isset($pageTitle)){echo $pageTitle;}else{echo "RAF - Rent a frag";}?></title>
<link rel="stylesheet" href="<?php echo DIR?>code/css/foundation.css" />
<link rel="stylesheet" href="<?php echo DIR?>code/css/main.css" />
<script src="<?php echo DIR?>code/js/vendor/modernizr.js"></script>
<script src="<?php echo DIR?>code/js/vendor/jquery.js"></script>
<script src="<?php echo DIR?>code/js/foundation.min.js"></script>
</head>

<body>
<!-- Navigation -->
      <nav class="top-bar fixed sticky" data-topbar>
        <ul class="title-area">
          <!-- Title Area -->
          <li class="name">
            <h1>
              <a href="<?php echo DIR?>">
                RAF Frag'em
              </a>
            </h1>
          </li>
          <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
        </ul>
     
        <section class="top-bar-section">
          <!-- Right Nav Section -->
          <ul class="right">
            <li class="divider"></li>
            <li><a href="<?php echo DIR?>forum/">Forum</a></li>
            <li class="divider"></li>
            <li><a href="#">Members</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo DIR?>rules/">Rules</a></li>
            <li class="divider"></li>
            <li>
            <?php if(isset($_SESSION['user'])){ ?>
            
              <li class="has-dropdown">
                <a href="#"><img src="<?php echo $_SESSION['user']['avatar'];?>" style="display:inline-block;margin-right:15px;"><?php echo $_SESSION['user']['personaname'];?></a>
                <ul class="dropdown">
                  <li><a href="<?php echo DIR?>logout/">Logout</a></li>
                </ul>
              </li>
            <?php }else{ ?>
            <li class="has-form">
              <a href="<?php echo DIR?>login/?des=<?php echo $_SERVER['REQUEST_URI'];?>"  class="button">
                Log in through steam!
              </a>
            </li>
            <?php } ?>
            
          </ul>
        </section>
      </nav>
      <!-- End Top Bar -->
<!-- End Navigation -->