<?php 
/*
 * This file contains the HTML generated for full calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.
 *
 * Note that leaving the class names for the previous/next links will keep the AJAX navigation working.
 *
 * There are two variables made available to you: 
 */
/* @var array $calendar - contains an array of information regarding the calendar and is used to generate the content */
/* @var array $args - the arguments passed to EM_Calendar::output() */
global $tw_events_calendar_weekly_today_found, $tw_events_calendar_more;

$cal_count = count($calendar['cells']); //to prevent an extra tr
$col_count = $tot_count = 1; //this counts collumns in the $calendar_array['cells'] array
$col_max = count($calendar['row_headers']); //each time this collumn number is reached, we create a new collumn, the number of cells should divide evenly by the number of row_headers
$EM_DateTime = new EM_DateTime($calendar['month_start'], 'UTC'); 

$tableOpened = false;

foreach( $calendar['cells'] as $date => $cell_data ) {
    if ( ! $tableOpened ) {
        $tableOpened = true;
        ob_start();
        echo '<li><div class="em-calendar-wrapper"><table class="em-calendar fullcalendar"><tbody><tr class="days-names"><td>';
            echo implode( '</td><td>', $calendar['row_headers'] );
        echo '</td></tr><tr>';
    }
    $class = ( !empty( $cell_data['events'] ) && count( $cell_data['events'] ) > 0 ) ? 'eventful' : 'eventless';
    $today_label = '';
    if ( ! empty( $cell_data['type'] ) ) {
        $class .= "-" . $cell_data['type'];
        if ( $cell_data['type'] === 'today' ) {
            $today_label = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'TODAY':'ӨНӨӨДӨР' );
            $tw_events_calendar_weekly_today_found = true;
        }
    }
    //In some cases (particularly when long events are set to show here) long events and all day events are not shown in the right order. In these cases, 
    //if you want to sort events cronologically on each day, including all day events at top and long events within the right times, add define('EM_CALENDAR_SORTTIME', true); to your wp-config.php file 
    if ( defined( 'EM_CALENDAR_SORTTIME' ) && EM_CALENDAR_SORTTIME ) {
        ksort( $cell_data['events'] ); //indexes are timestamps
    } ?>
    <td class="<?php echo esc_attr($class); ?>"><?php
        if ( ! empty( $today_label ) ) {
            echo '<div class="tw-today-label">' . esc_html( $today_label ) . '</div>';
        }
        if( !empty( $cell_data['events'] ) && count( $cell_data['events'] ) > 0 ){ ?>
            <span><?php
                echo esc_html(date('d',$cell_data['date'])); ?>
            </span>
            <div class="tw-events-list-container">
                <a href="<?php echo empty($tw_events_calendar_more) ? '#': esc_url($tw_events_calendar_more); ?>">
                    <div class="tw-events-list-inner"><?php
                        for ( $i = 0; $i<count( $cell_data['events'] ); $i++ ) { ?>
                            <svg width="49" height="48" viewBox="0 0 49 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#filter0_d_550_3579)"><rect x="4" width="40.0016" height="40" rx="20" fill="#F1F4F9" shape-rendering="crispEdges"/><path d="M12.8627 13.7226C14.0778 11.6977 15.698 10.0776 17.7232 8.86266C20.1534 7.64768 22.5836 7.24269 22.5836 10.8876V12.1026V15.7476C22.5836 17.7726 21.7735 18.5825 19.7484 18.5825H16.103H14.8879C11.2426 18.5825 11.6476 15.7476 12.8627 13.7226Z" fill="#DF6837"/><path d="M35.1389 13.7226C33.9238 11.6977 32.3036 10.0776 30.2784 8.86266C28.2532 7.64768 25.418 7.24269 25.418 10.8876V12.1026V15.7476C25.418 17.7726 26.2281 18.5825 28.2533 18.5825H31.8986H33.1137C36.759 18.5825 36.354 15.7476 35.1389 13.7226Z" fill="#B5C450"/><path d="M35.1389 26.2773C33.9238 28.3023 32.3036 29.9223 30.2784 31.1373C28.2532 32.3523 25.418 32.7573 25.418 29.1123V27.8974V24.2524C25.418 22.2274 26.2281 21.4175 28.2533 21.4175H31.8986H33.1137C36.759 21.4175 36.354 24.2524 35.1389 26.2773Z" fill="#FAD547"/><path d="M12.8627 26.2773C14.0778 28.3023 15.698 29.9223 17.7232 31.1373C20.1534 32.3523 22.5836 32.7573 22.5836 29.1123V27.8974V24.2524C22.5836 22.2274 21.7735 21.4175 19.7484 21.4175H16.103H14.8879C11.2426 21.4175 11.6476 24.2524 12.8627 26.2773Z" fill="#C14B93"/></g><defs><filter id="filter0_d_550_3579" x="0" y="0" width="48.002" height="48" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4"/><feGaussianBlur stdDeviation="2"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0.101961 0 0 0 0 0.168627 0 0 0 0 0.419608 0 0 0 0.12 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_550_3579"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_550_3579" result="shape"/></filter></defs></svg><?php
                        } ?>
                    </div>
                </a>
            </div><?php
        } else {
            echo esc_html( date( 'd', $cell_data['date'] ) );
        } ?>
    </td>
    <?php
    //create a new row once we reach the end of a table collumn
    $col_count= ($col_count == $col_max ) ? 1 : $col_count + 1;

    if ( ( $col_count == 1 && $tot_count < $cal_count ) ) {
        $tableOpened = false;
        echo '</tr></tbody></table></div></li>';
        $output = ob_get_clean();
        if ( ! empty( $tw_events_calendar_weekly_today_found ) ) {
            echo $output;
        }
    }
    $tot_count ++; 
}
if ( $tableOpened ) {
    echo '</tr></tbody></table></div></li>';
    $output = ob_get_clean();
    if ( ! empty( $tw_events_calendar_weekly_today_found ) ) {
        echo $output;
    }
}