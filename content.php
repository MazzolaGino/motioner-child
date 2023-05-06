<?php $format = get_post_format(); ?>

<?php
$note = get_post_meta(get_the_ID(), 'review_rating', true);
$note = (floatval($note) > 0) ? $note : '';
$testClass = (floatval($note) > 0) ? 'test-type' : '';

$category_detail = get_the_category(get_the_ID());

foreach ($category_detail as $cd) {

    if (strtoupper($cd->cat_name) === "EDITO") {
        $testClass = 'edito-type';
    }

    if (strtoupper($cd->cat_name) === "JDX") {
        $testClass = 'jdx-type';
    }
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="article-type-list group <?php echo $testClass ?>">
        <?php if (has_post_thumbnail()) : ?>
            <div class="type-list-left">
                <a class="type-list-thumbnail" href="<?php the_permalink(); ?>">
                    <div class="image-container">
                        <?php the_post_thumbnail('motioner-small'); ?>
                        <?php if (has_post_format('video') && !is_sticky()) echo '<span class="thumb-icon"><i class="fas fa-play"></i></span>'; ?>
                        <?php if (has_post_format('audio') && !is_sticky()) echo '<span class="thumb-icon"><i class="fas fa-volume-up"></i></span>'; ?>
                        <?php if (is_sticky()) echo '<span class="thumb-icon"><i class="fas fa-star"></i></span>'; ?>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <div class="type-list-center <?php if (!has_post_thumbnail()) : ?>no-thumb<?php endif; ?>">
            <div class="type-list-content">
                <h2 class="type-list-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <?php $note = get_post_meta(get_the_ID(), 'review_rating', true);
                if ($note) :
                ?>
                    <p class="rev-note"><?php echo $note ?></p>
                <?php endif; ?>
                <?php if (get_theme_mod('excerpt-length', '26') != '0') : ?>
                    <div class="type-list-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="type-list-right">
            <div class="type-list-date"><a href="<?= get_author_posts_url(get_the_author_ID()) ?>"><i class="fa fa-user"></i> <?php the_author(); ?></a></div>
            <div class="type-list-date"><i class="far fa-calendar-alt"></i> <?php the_time(get_option('date_format')); ?></div>
            <div class="type-list-category"><?php echo motioner_category_class(' / '); ?></div>
            <?php if (comments_open() && (get_theme_mod('comment-count', 'on') == 'on')) : ?>
                <a class="post-comments" href="<?php comments_link(); ?>"><span><?php comments_number('0', '1', '%'); ?></span></a>
            <?php endif; ?>
            <a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('More', 'motioner'); ?></a>
        </div>

    </div>

</article><!--/.post-->