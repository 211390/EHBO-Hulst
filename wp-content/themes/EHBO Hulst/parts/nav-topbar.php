<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/responsive-navigation/
 */
?>

<div class="top-bar" id="main-menu">
	<div class="top-bar-left">
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