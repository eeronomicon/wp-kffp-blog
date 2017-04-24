<?php
/**
	Template Name: DUMP SHOWS

*/
?>
<html>
<head>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<title><?php wp_title( '|', true, 'right' ); bloginfo('url'); ?></title>
<?php wp_head(); ?>
</head>

<body>

<?php
$type = 'show';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1,
  'meta_key'     => 'id',
	'meta_compare' => 'EXISTS'
);

$allShows = array();

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post();
  
    // make show object && add it to $allShows
    $showData = array(
      "timeSlot" => get_timeslot($post->ID, $fancy = false),
      "showName" => get_the_title(),
      "showID" => get_post_meta($post->ID, 'id', true),
      "email" => get_post_meta($post->ID, 'dj_email', true),
      "firstName" => "",
      "lastName" => "",
      "djName" => get_post_meta($post->ID, 'dj_name', true),
      "showDescription" => wp_strip_all_tags(get_the_content()),
    );

    $allShows[] = $showData;


  endwhile;
}

wp_reset_query();  // Restore global post data stomped by the_post().
?>

<pre><?php echo json_encode($allShows); ?></pre>


</body>
</html>
