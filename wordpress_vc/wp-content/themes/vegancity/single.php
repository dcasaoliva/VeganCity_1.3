<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage VeganCity
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<div id="content" class="site-content" role="main">

		
			<?php /* The loop */ ?>
			<?php 
			
			$id = get_the_ID();
			$post_object = get_post( $id );

			 if (!empty($single_background)){?>
	  <?php } ?>
	  
	<section id="intro" class="intro-section">
	
		<div class='place-info'>
		<?php the_post_thumbnail(); ?>
				<div id="place_title_stars">
				<?php the_title('<h1 class="entry-title">', '</h1>');				
				echo show_stars($id); ?>
				</div>
				
					<div id='place_content'>
					<?php echo apply_filters('the_content', $post->post_content);?>
					
					</div>
				</div>
				
				<div id="rate-this-place">
				 <?php 
				if (is_user_logged_in()){
					$user_id = get_current_user_id();
					$already_voted =user_already_voted($id, $user_id);
				}
				if (is_user_logged_in()&& $already_voted==false)	
				{
					echo do_shortcode( '[contact-form-7 id="22" title="Rate Place"]' );
			
					} else if (is_user_logged_in ()&& $already_voted==true)
				
					{
						echo 'You already voted this one!';
					
					} else if (!is_user_logged_in ())
					
					{
					 echo 'Please <a id="pop_login" href="">Login</a> or <a id="pop_signup" href="">Signup</a> to rate this place'; }		 ?>
	
					 </div>
					 </section>
				<section id="rates-section">	 
				<?php
  // set up or arguments for our custom query
 // $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $query_args = array(
    'post_type' => 'rates',
	'post_parent' => $id,
	'post_status' => 'publish',
    //'posts_per_page' => 9,
	 'paged' =>  $paged  
  );
  // create a new instance of WP_Query
  $the_query = new WP_Query( $query_args );
?>


<?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); // run the loop ?>
 <span class="rate-comments format-llista">
  <article>
	<span>
   
      <?php the_content(); ?>
    </span>
  </article>
  </span>
  
<?php 

endwhile; ?>

<div class="nav-pagination">
  <?php
  // check if the max number of pages is greater than 1  
 $big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $the_query->max_num_pages
) ); 
 ?>
  
  
  
  
<?php  ?>





<?php 


?>
   





		<?php 
		/*if ( have_posts() ) :
$args = array( 'post_type' =>   'rates',                                            
               'posts_per_page' =>  9, 
               'paged' =>  $paged   );
query_posts( $args );
			 
			
			 
			
			while ( have_posts() ) : the_post();
		
				the_content(); 
				
				
				
				
		 endwhile;*/ ?>



			<?php /*$big = 999999999; // need an unlikely integer

echo $html='<div class="nav-votes">' .  paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => $paged,
	'current' => max( 1, get_query_var($paged) ),
	'total' => $wp_query->max_num_pages
) ).'</div>'; */ ?>
	</div>
		</section>
		<?php endif; ?>

			

		</div><!-- #content -->
	</div><!-- #primary -->
<script type="text/javascript">


</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
