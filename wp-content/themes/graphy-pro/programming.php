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
    
    $request = wp_remote_get( 'http://admin.freeformportland.org/api/v1/shows?startWeek=' . strtolower(date('l')));

    if( is_wp_error( $request ) ) {
    	return false;
    }
    
    $body = wp_remote_retrieve_body( $request );

    $data = json_decode( $body, true );
    
    #var_dump($data);
    
    $loop_day = '';
    $loop_hour = '';
    
    
    if( ! empty( $data ) ) : foreach( $data as $show ) {

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

          <a href="/program/<?php echo $show['slug'] ?>">
          <?= convert_to_twelve($hour) ?> -
          <?php echo $show['showName'] . ' w/ ' . show_all_djs($show['users']); ?>
          </a>
        <?php if ($hour !== $loop_hour) { ?>
        <li class="hour-<?= $hour ?>">
        </li>
        <?php } else { echo("<br />"); }
        } ?>
    <?php
    }; endif;
    ?>
    </ul>
    </section>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
