<?php

namespace Baobab\Helper;

/**
 * Class Posts
 * @package Baobab\Helper
 *
 *          Provides various functions that help making cleaner template files in the theme
 */
class Posts
{

    /**
     * You can use this to output a proper title for your page. This handles special cases such as archive page titles,
     * taxonomy archives, etc.
     *
     * @return string A nice page title
     */
    public static function mainPageTitle()
    {
        if (is_home())
        {
            if (get_option('page_for_posts', true))
            {
                return get_the_title(get_option('page_for_posts', true));
            }
            else
            {
                return __('Latest Posts', 'baobab');
            }
        }
        elseif (is_archive())
        {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            if ($term)
            {
                return apply_filters('single_term_title', $term->name);
            }
            elseif (is_post_type_archive())
            {
                return apply_filters('the_title', get_queried_object()->labels->name);
            }
            elseif (is_day())
            {
                return sprintf(__('Daily Archives: %s', 'baobab'), get_the_date());
            }
            elseif (is_month())
            {
                return sprintf(__('Monthly Archives: %s', 'baobab'), get_the_date('F Y'));
            }
            elseif (is_year())
            {
                return sprintf(__('Yearly Archives: %s', 'baobab'), get_the_date('Y'));
            }
            elseif (is_author())
            {
                $author = get_queried_object();

                return sprintf(__('Author Archives: %s', 'baobab'),
                    apply_filters('the_author', is_object($author) ? $author->display_name : null));
            }
            else
            {
                return single_cat_title('', false);
            }
        }
        elseif (is_search())
        {
            return sprintf(__('Search Results for %s', 'baobab'), get_search_query());
        }
        elseif (is_404())
        {
            return __('Not Found', 'baobab');
        }
        else
        {
            return get_the_title();
        }
    }

}