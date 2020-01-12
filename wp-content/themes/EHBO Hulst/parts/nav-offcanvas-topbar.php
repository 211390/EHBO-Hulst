<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */
?>

<div class="top-bar" id="top-bar-menu">
    <div class="top-bar-left float-left">
        <img id="siteLogo" src="http://localhost/ehbo-hulst/wp-content/uploads/2019/11/EHBO-Logo.jpg" alt="EHBO Logo">
        <ul class="menu">
            <li id="headerTitle">
                <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
            </li>
        </ul>
    </div>
    <div class="top-bar-right show-for-large">
        <?php joints_top_nav(); ?>
    </div>
    <div class="top-bar-right float-right show-for-small-only">
        <ul class="hamburger-menu menu">
            <!-- <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li> -->
            <li>
                <a data-toggle="off-canvas">
                    <img id="hamburgerMenuSmall" src="http://localhost/ehbo-hulst/wp-content/uploads/2019/12/Hamburger-icon.png"
                         alt="Menu">
                </a>
            </li>
        </ul>
    </div>
    <div class="top-bar-right float-right show-for-medium-only">
        <ul class="hamburger-menu menu">
            <!-- <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li> -->
            <li>
                <a data-toggle="off-canvas">
                    <img id="hamburgerMenuMedium" src="http://localhost/ehbo-hulst/wp-content/uploads/2019/12/Hamburger-icon.png"
                         alt="Menu">
                </a>
            </li>
        </ul>
    </div>
</div>