<aside class="sidebar">
    <?php
    if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar')) {
    ?>
        <h4>Some text displayed when sidebar is not defined</h4>
        <h4>Search:</h4>
        <?php get_search_form(); ?>
    <?php
    }
    ?>
</aside>

