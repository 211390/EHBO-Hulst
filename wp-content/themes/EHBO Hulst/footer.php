<?php
/**
 * The template for displaying the footer.
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?>

<!--FOOTER-->
<footer class="footer" role="contentinfo">

    <div class="inner-footer grid-x grid-margin-x grid-padding-x">

        <!--NAVIGATION-->
        <div class="small-12 medium-12 large-12 cell">
            <nav role="navigation">
                <?php joints_footer_links(); ?>
            </nav>
        </div>

        <!--WIDGETS-->
        <div class="small-12 medium-12 large-12 cell">
            <div id="footer-sidebar" class="grid-x secondary">
                <div class="cell footer-widget large-3" id="footer-sidebar1">
                    <?php
                    if (is_active_sidebar('footer-sidebar-1')) {
                        dynamic_sidebar('footer-sidebar-1');
                    }
                    ?>
                </div>
                <div class="cell footer-widget large-3" id="footer-sidebar2">
                    <?php
                    if (is_active_sidebar('footer-sidebar-2')) {
                        dynamic_sidebar('footer-sidebar-2');
                    }
                    ?>
                </div>
                <div class="cell footer-widget large-3" id="footer-sidebar3">
                    <?php
                    if (is_active_sidebar('footer-sidebar-3')) {
                        dynamic_sidebar('footer-sidebar-3');
                    }
                    ?>
                </div>
                <div class="cell footer-widget large-3" id="footer-sidebar4">
                    <?php
                    if (is_active_sidebar('footer-sidebar-4')) {
                        dynamic_sidebar('footer-sidebar-4');
                    }
                    ?>
                </div>
            </div>
        </div> <!--end #widgets-->

        <!--COPYRIGHT-->
        <p class="source-org copyright text-white text-center" style="margin: 2%;">
            <small><!--&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>--> &copy; Realisatie door:
                Stichting Innovision Solutions
            </small>
        </p>

    </div> <!-- end #inner-footer -->

</footer> <!-- end .footer -->

<?php wp_footer(); ?>

</body>

</html> <!-- end page -->

