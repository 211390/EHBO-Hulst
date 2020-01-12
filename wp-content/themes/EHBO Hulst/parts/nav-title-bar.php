<?php
// Adjust the breakpoint of the title-bar by adjusting this variable
$breakpoint = "medium"; ?>

<div class="title-bar" data-responsive-toggle="top-bar-menu" data-hide-for="<?php echo $breakpoint ?>">
  <button class="menu-icon" type="button" data-toggle></button>
  <div class="title-bar-title"><?php _e( 'Menu', 'jointswp' ); ?></div>
</div>

<div class="top-bar" id="top-bar-menu">
	<div class="top-bar-left show-for-<?php echo $breakpoint ?>">
        <img id="siteLogo" src="http://localhost/ehbo-hulst/wp-content/uploads/2019/11/EHBO-Logo.jpg" alt="EHBO Logo">
		<ul class="menu">
			<li id="headerTitle">
                <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
            </li>
        </ul>
	</div>
	<div class="top-bar-right">
		<?php joints_top_nav(); ?>
	</div>
</div>