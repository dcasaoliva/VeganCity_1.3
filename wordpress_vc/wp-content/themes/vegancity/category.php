<?php
 /* Category Places for VeganCity */
 
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header-nodisplay">
				<h1 class="archive-title">Places added</h1>
			</header><!-- .archive-header -->
<?php 
$args = array( 'post_type' =>   'post',  
				'post_status' => 'publish',                      
               'category_name' =>  'Places',                    
               'posts_per_page' =>  9, 
               'paged' =>  $paged   );
query_posts( $args );
?>
			<?php /* The loop */ ?>
			
			<?php 
			
			while ( have_posts() ) : the_post();
			?>
			<span class="format-llista">
				<?php 
				get_template_part( 'content', get_post_format() ); 
				
				?>
				
				</span>
			<?php endwhile; ?>
			
<div class="nav-pagination">

			<?php $big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );  ?>
</div>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
