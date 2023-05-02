<?php
/**
 * template name: Game Page
 *   
 */
get_header();

$gameImporter = new Game_Importer($_GET);

/* @var $gameItem Game_Item */
$gameItem = $gameImporter->getGameInfo();

//$output =  apply_filters( 'the_content', $post->post_content );
?>
<div class="content">
    <div class="content-inner group">
        <article>	
            <div class="post-wrapper group">
                <header class="entry-header group">
                    <h1 class="entry-title"><?php echo $gameItem->get('nom') ?></h1>
                    <img src="<?php echo $gameItem->get('image') ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image">
                </header>
                <div class="entry-content">
                    <div class="entry themeform">
                        <ul class="game-item-list">
                            <li><strong>ÉDITEUR / DÉVELOPPEUR</strong> : <?php echo implode(', ', explode('|', $gameItem->get('editeur'))) ?></li>
                            <li><strong>GENRE(S)</strong> : <?php echo implode(', ', explode('|', $gameItem->get('genre'))) ?></li>
                            <li><strong>DESCRIPTION</strong> : <?php echo $gameItem->get('description') ?></li>
                        </ul>
                        <hr />
                        <h2>Dernières News</h2>

                        <div class="clear"></div>
                    </div><!--/.entry-->
                </div>
            </div>

        </article>

    </div>
</div>

<div id="move-sidebar-content"></div>
<?php
get_footer();
