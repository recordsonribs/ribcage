<?php
require_once("../../../../wp-config.php");
require_once (ABSPATH . WPINC . '/rss.php');

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));

switch ( $_GET['jax'] ) {

case 'ribcagelog' :
$rss = @fetch_rss(apply_filters( 'ribcage_log_feed', 'http://tools.assembla.com/ribcage/timeline?milestone=on&ticket=on&changeset=on&wiki=on&max=50&daysback=90&format=rss' ));
if ( isset($rss->items) && 0 != count($rss->items) ) {
?>
	<h3><?php echo apply_filters( 'ribcage_primary_title', __('Ribcage Development Log') ); ?></h3>
	<?php
	$rss->items = array_slice($rss->items, 0, 5);
	foreach ($rss->items as $item ) {
		?>
		<h4><a href='<?php echo wp_filter_kses($item['link']); ?>'><?php echo wp_specialchars($item['title']); ?></a> &#8212; <?php printf(__('%s ago'), human_time_diff(strtotime($item['pubdate'], time() ) ) ); ?></h4>
		<p><?php echo $item['description']; ?></p>
		<?php
	} // end foreach
} // end if

break;
} // end switch

?>