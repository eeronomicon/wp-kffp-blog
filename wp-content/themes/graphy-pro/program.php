<?php
/**
 * Template Name: Program
 * @package Graphy
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<?php
		
      if(isset($wp_query->query_vars['show_name'])) {
        $showName = urldecode($wp_query->query_vars['show_name']);
      }

      $request = wp_remote_get( 'http://admin.freeformportland.org/api/v1/playlists/' . $showName);

      if( is_wp_error( $request ) ) {
      	return false;
      }
      
      $body = wp_remote_retrieve_body( $request );
  
      $data = json_decode( $body, true );
      
		?>
		
	  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
        <h1 class="entry-title"><?php echo $data['show']['showName']; ?></h1>
    
        <?php graphy_entry_meta(); ?>
        <?php if ( has_post_thumbnail() ): ?>
        <div class="post-thumbnail"><?php the_post_thumbnail(); ?></div>
        <?php endif; ?>
      </header><!-- .entry-header -->
    
      <div class="entry-content">
        
        <h3 class="dj-name"><?php echo implode(" & ", $data['show']['users']); ?></h3>
    
        <h3 class="timeslot"><?php echo $data['show']['dayOfWeek'] . ' ' .  convert_to_twelve($data['show']['startTime']) . '-' . convert_to_twelve($data['show']['endTime']); ?></h3>
    
        <?php echo $data['show']['description']; ?>
      </div><!-- .entry-content -->
      <?php graphy_footer_meta(); ?>
    </article><!-- #post-## -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
$playlists = $data['playlists'];
?>


<ul class="playlist-list">

  <?php   foreach($playlists as $playlist){
    $playlistDate = date_create($playlist['playlistDate']);
    echo '<li><h3>' . date_format($playlistDate, "F d, Y") . '</h3>';
    echo '<ul class="playlist-songs">';
    foreach($playlist['songs'] as $song) {
      echo '<li>';
      echo '<span class="song-artist">' . ($song['artist'] ? $song['artist'] : '' ) . '</span>';
      echo '<span class="song-title">' . ($song['title'] ? ' "' . $song['title'] . '"' : '') . '</span>';
      echo '<span class="song-album">' . ($song['album'] ? ' (' . $song['album'] . ')' : '') . '</span>';
      #echo '<span class="song-label">' .  ($song['label'] ? ' [' . $song['label'] . ']' : '') . '</span>';
      echo '</li>';
    }
    echo '</ul>';
    echo '</li>';

  } ?>

</ul>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
