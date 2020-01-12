<?php 
/**
 * The template for displaying all single posts and attachments
 */

get_header(); ?>
			
<div id="postPageContent" class="content">

	<div class="inner-content grid-x grid-margin-x grid-padding-x">

        <!--GRID SPACER SECTION-->
        <div class="small-1 medium-1 large-1 cell"></div>

		<main class="main small-12 medium-8 large-8 cell" role="main">
		
		    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		    	<?php get_template_part( 'parts/loop', 'single' ); ?>
		    	
		    <?php endwhile; else : ?>
		
		   		<?php get_template_part( 'parts/content', 'missing' ); ?>

		    <?php endif; ?>

		</main> <!-- end #main -->

		<?php get_sidebar(); ?>

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>