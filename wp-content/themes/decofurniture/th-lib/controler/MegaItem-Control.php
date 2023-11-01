<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('Th_MegaItemController'))
{
    class Th_MegaItemController{

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
                'name'               => esc_html__('Mega Page','decofurniture'),
                'singular_name'      => esc_html__('Mega Page','decofurniture'),
                'menu_name'          => esc_html__('Mega Page','decofurniture'),
                'name_admin_bar'     => esc_html__('Mega Page','decofurniture'),
                'add_new'            => esc_html__('Add New','decofurniture'),
                'add_new_item'       => esc_html__( 'Add New Mega Page','decofurniture' ),
                'new_item'           => esc_html__( 'New Mega Page', 'decofurniture' ),
                'edit_item'          => esc_html__( 'Edit Mega Page', 'decofurniture' ),
                'view_item'          => esc_html__( 'View Mega Page', 'decofurniture' ),
                'all_items'          => esc_html__( 'All Mega Page', 'decofurniture' ),
                'search_items'       => esc_html__( 'Search Mega Page', 'decofurniture' ),
                'parent_item_colon'  => esc_html__( 'Parent Mega Page:', 'decofurniture' ),
                'not_found'          => esc_html__( 'No Mega Page found.', 'decofurniture' ),
                'not_found_in_trash' => esc_html__( 'No Mega Page found in Trash.', 'decofurniture' )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'th_mega_item' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => get_template_directory_uri() . "/assets/admin/image/megamenu-icon.png",
                'supports'           => array( 'title', 'editor', 'revisions' )
            );

            stp_reg_post_type('th_mega_item',$args);
        }
    }

    Th_MegaItemController::_init();

}