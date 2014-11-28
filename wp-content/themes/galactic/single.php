<?php get_header(); 
$nextPost = get_next_post();
$prevPost = get_previous_post();
?>

<div class="row">
    <?php if(isset($nextPost->ID)) { ?>
        <div class="post-pagination prev-post col-md-1"><a class="left" href="<?php echo get_the_permalink($nextPost->ID); ?>"></a></div>
    <?php } ?>
        <div class="col-md-7">
        <?php
        if(have_posts()) :
            while(have_posts()) :
                the_post();
                ?>
                <div class="post">
                    <div class="post-title row">
                        <h1><?php the_title(); ?></h1>
                    </div>
                    <div class="post-meta row">
                        <h4>Published by <?php the_author_posts_link(); ?> on <?php the_date(); ?></h4>
                    </div>
                    <div class="post-cats row">
                        <h5>Posted in <?php the_category(); ?></h5>
                    </div>
                    <div class="post-thumbnail row">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    
                    <div class="post-content row">
                        <p><?php the_content(); ?></p>
                    </div>
                    
                    <div class="post-tags row">
                        <h5>Tags: <?php the_tags('', '', ''); ?></h5>
                    </div>
                </div>
            <?php
            endwhile;
            else :
                echo '<h2>Sorry. The post your looking for doesn\'t exist!</h2>';
        endif;
        ?>
    </div>
    <?php if(isset($prevPost->ID)) { ?>
        <div class="post-pagination prev-next col-md-1"><a class="right" href="<?php echo get_the_permalink($prevPost->ID); ?>"></a></div>
    <?php } ?>
        
    <div class="col-md-3">
        <?php get_sidebar('sidebar-primary'); ?>
    </div>
</div>

<?php get_footer();