<?php
/*
Template Name: Archives
 */

get_header();
?>

<div class="row">
    <div class="col-md-9 page-archives">
        <h2>Archives by month</h2>
        <ul>
            <?php wp_get_archives('type=monthly'); ?>
        </ul>
        <h2>Archives by subject</h2>
        <ul>
            <?php wp_list_categories('hierarchical=0&title_li='); ?>
        </ul>
    </div>
        
    <div class="col-md-3">
        <?php get_sidebar('sidebar-primary'); ?>
    </div>
</div>

<?php get_footer();