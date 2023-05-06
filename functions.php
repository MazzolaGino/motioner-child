<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')) :
	function chld_thm_cfg_locale_css($uri)
	{
		if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
			$uri = get_template_directory_uri() . '/rtl.css';
		return $uri;
	}
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('chld_thm_cfg_parent_css')) :
	function chld_thm_cfg_parent_css()
	{
		wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . 'style.css', array());
	}
endif;
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10);

// END ENQUEUE PARENT ACTION


function shortcode_spoiler($atts, $content)
{

	return '<details><summary>SPOILER !</summary>' . $content . '</details>';
}

add_shortcode('spoiler', 'shortcode_spoiler');

function test_form_post_search()
{
	global $wpdb;

	$results = [];

	if (key_exists('letter', $_GET)) {

		// rechercher les test dont les noms de jeu débutent par la lettre donnée

		$sql = "SELECT wp_posts.ID, wp_posts.post_title from wp_posts
				left join wp_postmeta on wp_postmeta.post_id = wp_posts.ID
				where meta_key like 'wp_review_heading' and LOWER(meta_value) like '" . $_GET['letter'] . "%'
				and wp_posts.post_status = 'publish'
				and wp_posts.post_type = 'post'";

		$results = $wpdb->get_results($sql);
	}

?>

	<div class="letter-list">
		<a href="https://jrpgfr.net/test/?letter=A">A</a>
		<a href="https://jrpgfr.net/test/?letter=B">B</a>
		<a href="https://jrpgfr.net/test/?letter=C">C</a>
		<a href="https://jrpgfr.net/test/?letter=D">D</a>
		<a href="https://jrpgfr.net/test/?letter=E">E</a>
		<a href="https://jrpgfr.net/test/?letter=F">F</a>
		<a href="https://jrpgfr.net/test/?letter=G">G</a>
		<a href="https://jrpgfr.net/test/?letter=H">H</a>
		<a href="https://jrpgfr.net/test/?letter=I">I</a>
		<a href="https://jrpgfr.net/test/?letter=J">J</a>
		<a href="https://jrpgfr.net/test/?letter=K">K</a>
		<a href="https://jrpgfr.net/test/?letter=L">L</a>
		<a href="https://jrpgfr.net/test/?letter=M">M</a>
		<a href="https://jrpgfr.net/test/?letter=N">N</a>
		<a href="https://jrpgfr.net/test/?letter=O">O</a>
		<a href="https://jrpgfr.net/test/?letter=P">P</a>
		<a href="https://jrpgfr.net/test/?letter=Q">Q</a>
		<a href="https://jrpgfr.net/test/?letter=R">R</a>
		<a href="https://jrpgfr.net/test/?letter=S">S</a>
		<a href="https://jrpgfr.net/test/?letter=T">T</a>
		<a href="https://jrpgfr.net/test/?letter=U">U</a>
		<a href="https://jrpgfr.net/test/?letter=V">V</a>
		<a href="https://jrpgfr.net/test/?letter=W">W</a>
		<a href="https://jrpgfr.net/test/?letter=X">X</a>
		<a href="https://jrpgfr.net/test/?letter=Y">Y</a>
		<a href="https://jrpgfr.net/test/?letter=Z">Z</a>
		<?php
		if (!empty($results)) :

			$link = 'https://jrpgfr.net/test/?letter=' . $_GET['letter'];
			$linkNote = $link . '&order=asc&orderby=note';
			$linkTitle = $link . '&order=asc&orderby=title';

			$tests = array();
			$noteColumn = array();
			$titleColumn = array();
			foreach ($results as $test) {
				$tests[] = array(
					'permalink' => get_permalink($test->ID),
					'title' => $test->post_title,
					'note' => (float) get_post_meta($test->ID, 'wp_review_total', true),
				);
				$noteColumn[] = $tests[count($tests) - 1]['note'];
				$titleColumn[] = $tests[count($tests) - 1]['title'];
			}

			if (isset($_GET['order'], $_GET['orderby'])) {
				switch ($_GET['order']) {
					case 'asc':
						switch ($_GET['orderby']) {
							case 'note':
								$linkNote = $link . '&order=desc&orderby=note';
								array_multisort($noteColumn, SORT_ASC, SORT_NUMERIC, $titleColumn, SORT_ASC, SORT_STRING, $tests);
								break;
							case 'title':
								$linkTitle = $link . '&order=desc&orderby=title';
								array_multisort($titleColumn, SORT_ASC, SORT_STRING, $noteColumn, SORT_ASC, SORT_NUMERIC, $tests);
								break;
						}
						break;
					case 'desc':
						switch ($_GET['orderby']) {
							case 'note':
								$linkNote = $link . '&order=asc&orderby=note';
								array_multisort($noteColumn, SORT_DESC, SORT_NUMERIC, $titleColumn, SORT_ASC, SORT_STRING, $tests);
								break;
							case 'title':
								$linkTitle = $link . '&order=asc&orderby=title';
								array_multisort($titleColumn, SORT_DESC, SORT_STRING, $noteColumn, SORT_ASC, SORT_NUMERIC, $tests);
								break;
						}
						break;
				}
			}

		?>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th scope="col"><a href="<?= $linkTitle ?>">Titre</a></th>
				<th scope="col"><a href="<?= $linkNote ?>">Note</a></th>
			</tr>
		</thead>
		<tbody>
		<?php



			foreach ($tests as $test) {

				echo '<tr><td><a href="' . $test['permalink'] . '">' . $test['title'] . '</a></td><td><span class="note-in-list">' . $test['note'] . ' </span></td></tr>';
			}


		endif;

		?>

		</tbody>
	</table>

<?php
}

add_shortcode('letter_search', 'test_form_post_search');



function shortcode_game_note($atts, $content)
{

	$note = "";
	$content = intval($content);

	for ($i = 0; $i < 5; $i++) {

		if ($content > 0) {
			$note .= '<span class="fa fa-star checked"></span>';
		} else {
			$note .= '<span class="fa fa-star"></span>';
		}

		$content--;
	}

	return $note;
}
add_shortcode('note', 'shortcode_game_note');


function shortcode_game_note_blockquote($atts, $content)
{

	$blockquote = "";

	if (isset($atts["note"]) && $content !== "") {
		$blockquote = '<blockquote class="blocknote">
	  <p><span class="blocknote-note">' . intval($atts["note"]) . '</span><span class=="blocknote-text">' . $content . '</span></p>
  </blockquote>';
	} else {
		$blockquote = '<blockquote>
	  <p>' . $content . '</p>
  </blockquote>';
	}

	return $blockquote;
}

add_shortcode('blocknote', 'shortcode_game_note_blockquote');


function shortcode_multimedia_shop_blockquote($atts, $content)
{


	$blockquote = '<blockquote class="blocknote">
	 Pour commander ce jeu ou des milliers d\'autres articles J-RPG, vous pouvez visiter <a target="_blank" href="' . $atts["url"] . '">notre boutique partenaire</a> !
  </blockquote>';


	return $blockquote;
}

add_shortcode('multimedia_shop', 'shortcode_multimedia_shop_blockquote');

function the_reverse_post_navigation($args = array())
{
	$args = wp_parse_args($args, array(
		'prev_text'          => '%title',
		'next_text'          => '%title',
		'in_same_term'       => false,
		'excluded_terms'     => '',
		'taxonomy'           => 'category',
		'screen_reader_text' => __('Post navigation'),
	));

	$navigation = '';

	$previous = get_next_post_link(
		'<div class="nav-previous">%link</div>',
		$args['prev_text'],
		$args['in_same_term'],
		$args['excluded_terms'],
		$args['taxonomy']
	);

	$next = get_previous_post_link(
		'<div class="nav-next">%link</div>',
		$args['next_text'],
		$args['in_same_term'],
		$args['excluded_terms'],
		$args['taxonomy']
	);

	// Only add markup if there's somewhere to navigate to.
	if ($previous || $next) {
		$navigation = _navigation_markup($previous . $next, 'post-navigation', $args['screen_reader_text']);
	}

	echo $navigation;
}

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar()
{
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

add_action('admin_init', 'rm34_jetpack_deactivate_modules');
function rm34_jetpack_deactivate_modules()
{
	if (class_exists('Jetpack') && Jetpack::is_module_active('notes')) {
		Jetpack::deactivate_module('notes');
	}
}

function shortcode_glitch($atts, $content)
{

	return '<a id="glitchModalButton" onclick="displayModal(' . $atts['id'] . ')" href="javascript:void(0);" class="glitch">' . $content  . '</a>';
}

add_shortcode('glitch', 'shortcode_glitch');


function glitch_get_content()
{
	$id = $_GET['glitch'];

	$result =  do_shortcode('[content_block id=' . $id . ']');
	wp_send_json($result);
	die();
}

add_action('wp_ajax_nopriv_glitch_get_content', 'glitch_get_content');
add_action('wp_ajax_glitch_get_content', 'glitch_get_content');

function shortcode_quiz($atts, $content)
{

	$quizList = require 'Quiz.php';



	$content = json_decode($quizList);

	var_dump($quizList);
	die();
?>


	<div class="custom-quiz"></div>

	<script type="text/javascript">
		var quiz = <?php echo json_decode($content, JSON_PRETTY_PRINT) ?>;
	</script>

<?php



}

add_shortcode('quiz', 'shortcode_quiz');

function motioner_category_class($param)
{


	$categories = get_the_category();


	$output = '';
	$before_categories = '';

	foreach ($categories as $category) {

		if (in_array($category->slug, [
			'xbox-one', 'xbox-series', 'pc', 'switch', 'ps4', 'ps5', 'ios', 'android'
		])) {
			$before_categories .= '<a class="category tag cat-' . $category->slug . '" href="' . esc_url(get_category_link($category->term_id)) . '">' . $category->name . '</a>';
		} else {
			$output .= '<a class="category tag cat-' . $category->slug . '" href="' . esc_url(get_category_link($category->term_id)) . '">' . $category->name . '</a>';
		}
	}

	return $before_categories . $output;
}

function example_admin_bar_remove_logo()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'example_admin_bar_remove_logo', 0);

function wpm_admin_footer()
{
	echo "Faisons du JRPG un genre phare des pays francophones";
}
add_filter('admin_footer_text', 'wpm_admin_footer');




function custom_motioner_related_posts()
{
	wp_reset_postdata();
	global $post;

	// Define shared post arguments
	$args = array(
		'no_found_rows'				=> true,
		'update_post_meta_cache'	=> false,
		'update_post_term_cache'	=> false,
		'ignore_sticky_posts'		=> 1,
		'orderby'					=> 'rand',
		'post__not_in'				=> array($post->ID),
		'posts_per_page'			=> 3
	);
	// Related by categories
	if (get_theme_mod('related-posts') == 'categories') {

		$cats = get_post_meta($post->ID, 'related-cat', true);

		if (!$cats) {
			$cats = wp_get_post_categories($post->ID, array('fields' => 'ids'));
			$args['category__in'] = $cats;
		} else {
			$args['cat'] = $cats;
		}
	}
	// Related by tags
	if (get_theme_mod('related-posts') == 'tags') {

		$tags = get_post_meta($post->ID, 'related-tag', true);

		if (!$tags) {
			$tags = wp_get_post_tags($post->ID, array('fields' => 'ids'));
			$args['tag__in'] = $tags;
		} else {
			$args['tag_slug__in'] = explode(',', $tags);
		}
		if (!$tags) {
			$break = true;
		}
	}

	$query = !isset($break) ? new WP_Query($args) : new WP_Query;
	return $query;
}

function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}

add_action("init","add_cors_http_header");
