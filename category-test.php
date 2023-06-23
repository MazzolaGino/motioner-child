<?php get_header(); ?>

<?php

$query_args = array(
    'post_type' => 'post',
    'category_name' => 'test',
    'posts_per_page' => -1,
);

if (isset($_POST['s_genre']) || isset($_POST['s_console']) || isset($_POST['s_name'])) {

    $s_name = isset($_POST['s_name']) ? sanitize_text_field($_POST['s_name']) : '';
    $s_genre = $_POST['s_genre'];
    $s_console = $_POST['s_console'];
    $s_note = $_POST['s_note'];

    $tax_query = array();
    $meta_query = array();

    if ($s_genre !== '-1') {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $s_genre,
        );
    }

    if ($s_console !== '-1') {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $s_console,
        );
    }

    if (!empty($s_name)) {
        $meta_query[] = array(
            'key' => 'review_game_title',
            'value' => $s_name,
            'compare' => 'LIKE',
        );
    }

    if ($s_note !== '-1') {
        $meta_query[] = array(
            'key' => 'review_rating',
            'value' => floatval($s_note),
            'compare' => '>=',
        );
    }

    if (!empty($tax_query)) {
        $query_args['tax_query'] = $tax_query;
        $query_args['tax_query']['relation'] = 'AND';
    }



    if (!empty($meta_query)) {
        $query_args['meta_query'] = $meta_query;
    }
}

$query = new WP_Query($query_args);


?>

<?php if (get_theme_mod('heading-enable', 'off') == 'on') : ?>
    <?php get_template_part('inc/page-title'); ?>
<?php endif; ?>
<style>
    .content .search-test {
        display: flex;
        flex-wrap: wrap;
    }

    .content .search-test .select-console,
    .content .search-test .select-genre,
    .content .search-test .name,
    .content .search-test .select-note {
        flex-basis: 100%;
        margin-bottom: 10px;
    }
</style>
<div class="content">
    <div class="content-inner group">
        <?php get_template_part('inc/front-widgets-top'); ?>
        <div class="content">
            <div class="content-inner group">
                <article>
                    <div class="post-wrapper group">
                        <header class="entry-header group">
                            <h1 class="entry-title">Recherche de Test</h1>
                        </header>
                        <div class="entry-content">
                            <div class="entry themeform">
                                <form class="search-test" action="/category/test" method="post">
                                    <input class="name" width="100%" type="text" name="s_name" placeholder="Nom du jeu" />
                                    <select class="select-console" name="s_console">
                                        <option value="-1">Choisir une console</option>
                                        <option value="ps5">PS5</option>
                                        <option value="ps4">PS4</option>
                                        <option value="one">One</option>
                                        <option value="series">Series</option>
                                        <option value="pc">PC</option>
                                        <option value="switch">Switch</option>
                                    </select>

                                    <select class="select-genre" name="s_genre">
                                        <option value="-1">Choisir un genre</option>
                                        <option value="tour-par-tour">Tour par tour</option>
                                        <option value="action">Action</option>
                                        <option value="visual-novel">Visual novel</option>
                                        <option value="simulation">Simulation</option>
                                        <option value="tactique">Tactique</option>
                                    </select>

                                    <select class="select-note" name="s_note">
                                        <option value="-1">Choisir une note</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>

                                    <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="Rechercher">

                                </form>
                                <div class="clear"></div>
                            </div><!--/.entry-->
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="content">
            <div class="content-inner group">
                <article>
                    <div class="post-wrapper group">
                        <header class="entry-header group">
                            <h1 class="entry-title">Résultats</h1>
                        </header>
                        <div class="entry-content">
                            <div class="entry themeform">
                                <?php if ($query->have_posts()) : ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Titre</th>
                                                <th scope="col">Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                                <tr>
                                                    <td><a href="<?= get_permalink(get_the_ID()) ?>"><?= get_the_title() ?></a></td>
                                                    <td><?= get_post_meta(get_the_ID(), 'review_rating', true) ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <h2>Aucun test ne correspond à votre recherche !</h2>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div><!--/.content-->

<div id="move-sidebar-content"></div>

<?php get_footer(); ?>