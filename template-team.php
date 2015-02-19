<?php
/*
Template Name: Team Member Page
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>
				
				
				<?php 
					$teams = get_post_meta(get_the_ID(),"_cmb_teamid",true);
					if(!empty($teams)){ 
				?>
					
				<div class="row">
					<?php foreach($teams AS $key => $mid):?>

					<div class="col-md-4">
						<?php 
							$member = get_post($mid); 
							$name = $member->post_title;
							$biography = $member->post_content;							
							if(has_post_thumbnail($mid) ) {
								echo get_the_post_thumbnail($mid, 'thumbnails');
							}
						?>

							<p><?php echo $name; ?></p>
							
							<p><?php echo $biography; ?></p>	
						

					</div>

					<?php endforeach; ?>
				</div>

				<?php } ?>

				



			<?php endwhile; // end of the loop. ?>
			

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

