<?php
/**
 * @package Graphy
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		
		<?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            	<header class="entry-header">
            		<h1 class="entry-title"><?php the_title(); ?></h1>
            
            
            		<?php graphy_entry_meta(); ?>
            		<?php if ( has_post_thumbnail() ): ?>
            		<div class="post-thumbnail"><?php the_post_thumbnail(); ?></div>
            		<?php endif; ?>
            	</header><!-- .entry-header -->
            
            	<div class="entry-content">
            	  <?php
            	  $id = get_the_ID();
            	  $custom_fields = get_post_custom();
            	  ?>
            	  <h2 class="dj-name"><?= $custom_fields['dj_name'][0] ?></h2>
            
            	  <h3 class="timeslot"><?= get_timeslot($id, true) ?></h3>
            
            		<?php the_content(); ?>
            		<?php wp_link_pages( array(	'before' => '<div class="page-links">' . __( 'Pages:', 'graphy-pro' ), 'after'  => '</div>', ) ); ?>
            	</div><!-- .entry-content -->
            	<?php graphy_footer_meta(); ?>
            </article><!-- #post-## -->

		<?php endwhile; // End of the loop. ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
$showID = $custom_fields['id'][0];

$request = wp_remote_get( 'http://kffp.rocks/api/setlistsByShowID/' . $showID );

if( is_wp_error( $request ) ) {
	return false;
}

$body = wp_remote_retrieve_body( $request );

$data = json_decode( $body, true );

?>

<? // if dj is logged in, show the show id and a link to create a playlist ?>
<?php if (is_user_logged_in ()) {
?>
<div class="dj-login-wrapper">
<div class="dj-login">
<p class="show-id">KFFP ID: <?= $showID ?></p>
<a href='http://kffp.rocks/api/newSetlist/<?= $showID ?>' target='_blank'>Make New Playlist</a>
</div>
</div>

<?php } ?>

<?php
  echo '<ul class="playlist-list">';
  if ( count($data) > 0 ) {
    foreach ( array_reverse($data) as $episode ) {
      if ( count( $episode['songs'] ) > 0) {
        $playlistDate = date_create($episode['createdAt'])->setTimezone(new DateTimeZone('America/Los_Angeles'));
        echo '<li><h3>' . date_format($playlistDate, "F d, Y") . '</h3>';
        echo '<ul class="playlist-songs">';
        foreach($episode['songs'] as $song) {
          if ( $song['inputs'][1]['value'] != 'freeformportland.org') {
            echo '<li>';
            echo '<span class="song-timestamp" style="display: none;">' . $song['playedAt'] . '</span>';
            echo '<span class="song-artist">' . ($song['inputs'][1]['value'] ? $song['inputs'][1]['value'] : '' ) . '</span>';
            echo ' - ';
            echo '<span class="song-title">' . ($song['inputs'][0]['value'] ? $song['inputs'][0]['value'] : '' ) . '</span>';
            echo '<span class="song-album" style="display: none;">' . ($song['inputs'][2]['value'] ? $song['inputs'][2]['value'] : '' ) . '</span>';
            echo '<span class="song-label" style="display: none;">' . ($song['inputs'][3]['value'] ? $song['inputs'][3]['value'] : '' ) . '</span>';
            echo '</li>';
          }
        }
        echo '</ul>';
        echo '</li>';
      }
    }
  } else {
    echo '<h3>No playlists found</h3>';
  }
  echo '</ul>';
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>