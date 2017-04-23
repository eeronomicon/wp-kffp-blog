<?php
/**
	Template Name: DUMP USERS

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
$args = array( 'role__not_in' => 'Contributor' );
$allUsers = array();

$my_query = null;
$my_query = new WP_User_Query($args);
if( ! empty( $my_query->results ) ) {
  foreach ( $my_query->results as $user ) {

    // make show object && add it to $allUsers
    $userData = array(
      "loginName" => $user->user_login,
      "userEmail" => $user->user_email,
      "displayName" => $user->display_name,
    );

    $allUsers[] = $userData;

  }
} else {
  $allUsers = "None found";
}

wp_reset_query();  // Restore global post data stomped by the_post().
?>

<pre><?php echo json_encode($allUsers); ?></pre>


</body>
</html>
