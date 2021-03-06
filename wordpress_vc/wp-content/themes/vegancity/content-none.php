<?php
/**
 * The template for displaying a "No posts found" message for VeganCity
 *
 */
?>

<header class="page-header">
	<h1 class="page-title"><?php _e( 'Nothing Found', 'twentythirteen' ); ?></h1>
</header>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentythirteen' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

	<p><?php _e( 'Well, it seems we can&rsquo;t find what you&rsquo;re looking for.', 'twentythirteen' ); ?></p>
	

	<?php else : ?>

	<p><?php _e( 'Well, it seems we have no content about.', 'twentythirteen' ); ?></p>
	

	<?php endif; ?>
</div><!-- .page-content -->