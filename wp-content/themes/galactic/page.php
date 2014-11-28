<?php get_header();
?>

<div class="row">
    <div class="col-md-9">
        <?php
        if(have_posts()) :
            while(have_posts()) :
                the_post();
                ?>
                <div class="post">
                    <div class="post-title row">
                        <h1><?php the_title(); ?></h1>
                    </div>
                    <div class="post-thumbnail row">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    
                    <div class="post-content row">
                        <p><?php the_content(); ?></p>
                    </div>
                </div>
            <?php
            endwhile;
            else :
                echo '<h2>Sorry. The page your looking for doesn\'t exist!</h2>';
        endif;
        ?>
    </div>
        
    <div class="col-md-3">
        <?php get_sidebar('sidebar-primary'); ?>
    </div>
</div>

<?php get_footer();