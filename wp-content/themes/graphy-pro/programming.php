<?php
/**
 *  * Template Name: Program Schedule
 * @package Graphy
 */

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <header class="entry-header">
      <h1 class="entry-title">
      KFFP Program Schedule
      </h1>
    </header>

    <?php
    
    $today = new DateTime();
    $today_pacific = $today->setTimezone(new DateTimeZone('America/Los_Angeles'))->format('l');
    
    $request = wp_remote_get( 'http://admin.freeformportland.org/api/v1/shows?isActive=true&startWeek=' . strtolower($today_pacific) );

    if( is_wp_error( $request ) ) {
      echo '<h1>Whoops, something is not working correctly! Hold on, we are looking into it!</h1>';
    } else {
    
    $body = wp_remote_retrieve_body( $request );

    $data = json_decode( $body, true );
    
    $loop_day = '';
    $loop_hour = '';
    
    if( ! empty( $data ) && empty($data['statusCode']) ) {
      foreach( $data as $show ) {
  
        $day = $show['dayOfWeek'];
  
        if ($day !== $loop_day ) {
          if ($loop_day !== '') {
            echo '</ul></section>';
          }
  
          $loop_day = $day;
  
          if ($day < 7) {
          ?>
          <section class="schedule-block">
            <div class="day">
            <?= $day; ?>
            </div>
  
            <ul class="schedule">
          <?php
          }
        }
  
        $hour = $show['startTime'];
  
        if ($day < 7 && $hour !== '') {
          if ($hour !== $loop_hour) {
            $loop_hour = $hour;
          ?>
          <li class="hour-<?= $hour ?>">
            <?php } ?>
            <a href="/program/?show_name=<?php echo $show['slug'] ?>">
            <?= convert_to_twelve($hour) ?> -
            <?php echo $show['showName'] . ' w/ ' . show_all_djs($show['users']); ?>
            </a>
          <?php if ($hour !== $loop_hour) { ?>
          <li class="hour-<?= $hour ?>">
          </li>
          <?php } else { echo("<br />"); }
          }
        };
      } else {
        echo '<h1>Whoops, something is not working correctly! Hold on, we are looking into it!</h1>';
      };
    }; ?>
    
    </ul>
    </section>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
