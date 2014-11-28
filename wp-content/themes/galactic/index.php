<?php get_header(); ?>

<div class="row">
    <div class="col-md-8">
        <?php
        if(have_posts()) :
            while(have_posts()) :
                the_post();
                ?>
                <div class="post">
                    <div class="post-title">
                        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                    </div>
                    <div class="post-meta">
                        <h4>Published by <?php the_author_posts_link(); ?> on <?php the_date(); ?></h4>
                    </div>
                    <?php if(has_post_thumbnail()) {
                        $thumbnailID = get_post_thumbnail_id();
                        $url = wp_get_attachment_url($thumbnailID);
                    ?>
                    <div class="post-thumbnail-home" style="background-image: url('<?php echo $url; ?>');">
                        <div class="overlay"></div>
                    </div>
                    <?php }
                    if(!is_single()) {
                        ?>
                        <div class="post-excerpt">
                            <p><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>">Read more</a>
                        </div>
                    <?php
                    } else {
                    ?>
                    <div class="post-content">
                        <p><?php the_content(); ?></p>
                    </div>
                    <?php } ?>
                </div>
            <?php
            endwhile;
            else :
                echo '<h2>No Posts were found!</h2>';
        endif;
        ?>
        <nav>
            <ul class="pager">
                <li class="previous"><?php previous_posts_link('<span class="glyphicon glyphicon-chevron-left"></span> Previous'); ?></li>
                <li class="next"><?php next_posts_link('Next <span class="glyphicon glyphicon-chevron-right"></span>'); ?></li>
            </ul>
        </nav>
    </div>

    <div class="col-md-4">
        <h1>Some sidebar content</h1>
        <?php get_sidebar('sidebar-primary'); ?>
    </div>
</div>

<?php get_footer();