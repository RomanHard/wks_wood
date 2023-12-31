<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('Th_FooterController'))
{
    class Th_FooterController{

        static function _init()
        {
            if(function_exists('stp_reg_post_type'))
            {
                add_action('init',array(__CLASS__,'_add_post_type'));
            }
        }

        static function _add_post_type()
        {
            $labels = array(
                'name'               => esc_html__('Footer Page','decofurniture'),
                'singular_name'      => esc_html__('Footer Page','decofurniture'),
                'menu_name'          => esc_html__('Footer Page','decofurniture'),
                'name_admin_bar'     => esc_html__('Footer Page','decofurniture'),
                'add_new'            => esc_html__('Add New','decofurniture'),
                'add_new_item'       => esc_html__( 'Add New Footer','decofurniture' ),
                'new_item'           => esc_html__( 'New Footer', 'decofurniture' ),
                'edit_item'          => esc_html__( 'Edit Footer', 'decofurniture' ),
                'view_item'          => esc_html__( 'View Footer', 'decofurniture' ),
                'all_items'          => esc_html__( 'All Footer', 'decofurniture' ),
                'search_items'       => esc_html__( 'Search Footer', 'decofurniture' ),
                'parent_item_colon'  => esc_html__( 'Parent Footer:', 'decofurniture' ),
                'not_found'          => esc_html__( 'No Footer found.', 'decofurniture' ),
                'not_found_in_trash' => esc_html__( 'No Footer found in Trash.', 'decofurniture' )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'th_footer' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,                
                'menu_icon'          => get_template_directory_uri() . "/assets/admin/image/footer-icon.png",
                'supports'           => array( 'title', 'editor', 'revisions' )
            );

            stp_reg_post_type('th_footer',$args);
        }
    }

    Th_FooterController::_init();

}