<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!function_exists('th_set_theme_config')){
    function th_set_theme_config(){
        global $th_dir,$th_config,$redux_option;
        /**************************************** BEGIN ****************************************/
        $th_dir = get_template_directory_uri();
        $redux_option = true;
        $th_config = array();
        $th_config['dir'] = $th_dir;
        $th_config['css_url'] = $th_dir . '/assets/css/';
        $th_config['js_url'] = $th_dir . '/assets/js/';
        $th_config['bootstrap_ver'] = '3';
        $th_config['nav_menu'] = array(
            'primary' => esc_html__( 'Primary Navigation', 'decofurniture' ),
        );
        $th_config['mega_menu'] = '1';
        $th_config['sidebars']=array(
            array(
                'name'              => esc_html__( 'Blog Sidebar', 'decofurniture' ),
                'id'                => 'blog-sidebar',
                'description'       => esc_html__( 'Widgets in this area will be shown on all blog page.', 'decofurniture'),
                'before_title'      => '<h3 class="widget-title">',
                'after_title'       => '</h3>',
                'before_widget'     => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                'after_widget'      => '</div>',
            )
        );
        if(class_exists("woocommerce")){
            $th_config['sidebars'][] = array(
                'name'              => esc_html__( 'WooCommerce Sidebar', 'decofurniture' ),
                'id'                => 'woocommerce-sidebar',
                'description'       => esc_html__( 'Widgets in this area will be shown on all woocommerce page.', 'decofurniture'),
                'before_title'      => '<h3 class="widget-title">',
                'after_title'       => '</h3>',
                'before_widget'     => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                'after_widget'      => '</div>',
            );
        }
        $th_config['import_config'] = array(
                'demo_url'                  => 'decofurniture.ththeme.net',
                'homepage_default'          => 'Home 1',
                'blogpage_default'          => 'Blog',
                'menu_replace'              => 'Main Menu',
                'menu_locations'            => array("Main Menu" => "primary"),
                'set_woocommerce_page'      => 1
            );
        $th_config['import_theme_option'] = '{"last_tab":"1","th_header_page":"187","th_footer_page":"308","th_404_page":"","th_404_page_style":"","th_show_breadrumb":"","th_bg_breadcrumb":{"background-color":"","background-repeat":"","background-size":"","background-attachment":"","background-position":"","background-image":"","media":{"id":"","height":"","width":"","thumbnail":""}},"breadcrumb_text":{"font-family":"","font-options":"","google":"1","font-weight":"","font-style":"","subsets":"","text-align":"","font-size":"","line-height":"","color":""},"breadcrumb_text_hover":{"font-family":"","font-options":"","google":"1","font-weight":"","font-style":"","subsets":"","text-align":"","font-size":"","line-height":"","color":""},"show_preload":"1","preload_bg":{"color":"","alpha":"1","rgba":""},"preload_style":"style3","show_scroll_top":"","show_wishlist_notification":"","show_too_panel":"","remove_style_content":"","tool_panel_page":"","body_bg":{"color":"","alpha":"1","rgba":""},"main_color":{"color":"","alpha":"","rgba":""},"main_color2":{"color":"","alpha":"","rgba":""},"th_page_style":"","container_width":"","before_append_post":"193","after_append_post":"","th_sidebar_position_blog":"right","th_sidebar_blog":"blog-sidebar","blog_default_style":"list","blog_style":"","blog_title":"1","blog_number_filter":"1","blog_number_filter_list":[{"title":" ","number":" "}],"blog_type_filter":"1","post_list_size":"","post_list_item_style":"style2","post_grid_column":"3","post_grid_size":"","post_grid_excerpt":"80","post_grid_item_style":"","post_grid_type":"","th_sidebar_position_post":"right","th_sidebar_post":"blog-sidebar","post_single_thumbnail":"1","post_single_size":"","post_single_meta":"1","post_single_author":"1","post_single_navigation":"1","post_single_related":"1","post_single_related_title":"","post_single_related_number":"","post_single_related_item":"","post_single_related_item_style":"","th_sidebar_position_page":"no","th_sidebar_page":"","th_sidebar_position_page_archive":"right","th_sidebar_page_archive":"blog-sidebar","th_sidebar_position_page_search":"","th_sidebar_page_search":"","th_add_sidebar":[{"title":" ","widget_title_heading":"h3"}],"th_custom_typography":[{"typo_area":"body","typo_heading":"","typography_style":{"font-family":"","font-options":"","google":"1","font-weight":"","font-style":"","subsets":"","text-align":"","font-size":"","line-height":"","color":""}}],"th_sidebar_position_woo":"right","th_sidebar_woo":"woocommerce-sidebar","shop_default_style":"grid","shop_gap_product":"","woo_shop_number":"12","sv_set_time_woo":"","shop_style":"","shop_ajax":"","shop_thumb_animation":"","shop_number_filter":"1","shop_number_filter_list":[{"number":" "}],"shop_type_filter":"1","shop_list_size":"","shop_list_item_style":"","shop_grid_column":"3","shop_grid_size":"","shop_grid_item_style":"style5","shop_grid_type":"","cart_page_style":"style2","checkout_page_style":"style2","th_header_page_woo":"","th_footer_page_woo":"","before_append_woo":"185","after_append_woo":"","product_single_style":"","sv_sidebar_position_woo_single":"no","sv_sidebar_woo_single":"","product_image_zoom":"","product_tab_detail":"","show_excerpt":"1","show_latest":"0","show_upsell":"0","show_related":"1","show_single_number":"6","show_single_size":"","show_single_itemres":"","show_single_item_style":"style5","before_append_woo_single":"185","before_append_tab":"","after_append_tab":"","after_append_woo_single":"","customize-selected-changeset-status-control-input-71":"publish","screenoptionnonce":"3e16d61e6d","background-position":"left top","_customize-radio-show_on_front":"page","_customize-dropdown-pages-page_on_front":"3136","_customize-dropdown-pages-page_for_posts":"18","woocommerce_thumbnail_cropping":"1:1","_customize-radio-store_layout":"left","redux-backup":1}';
        $th_config['import_widget'] = '{"sidebar-store":{"woocommerce_product_categories-2":{"title":"Product categories","orderby":"name","dropdown":0,"count":0,"hierarchical":1,"show_children_only":0,"hide_empty":0,"max_depth":""},"woocommerce_products-3":{"title":"Products","number":5,"show":"","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"woocommerce_product_tag_cloud-3":{"title":"Product tags"}},"blog-sidebar":{"search-3":{"title":""},"block-1":{"content":"<!-- wp:heading {\"level\":3,\"className\":\"block-widget-title\"} -->\n<h3 class=\"block-widget-title\">Categories<\/h3>\n<!-- \/wp:heading -->"},"block-2":{"content":"<!-- wp:categories \/-->"},"woocommerce_products-4":{"title":"New Products","number":5,"show":"","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"block-3":{"content":"<!-- wp:heading {\"level\":3,\"className\":\"block-widget-title\"} -->\n<h3 class=\"block-widget-title\">Tag Clouds<\/h3>\n<!-- \/wp:heading -->"},"block-4":{"content":"<!-- wp:tag-cloud \/-->"}},"woocommerce-sidebar":{"woocommerce_product_search-2":{"title":""},"woocommerce_product_categories-3":{"title":"Categories","orderby":"name","dropdown":0,"count":0,"hierarchical":1,"show_children_only":0,"hide_empty":1,"max_depth":""},"woocommerce_products-5":{"title":"Product Featured","number":5,"show":"featured","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"woocommerce_product_tag_cloud-4":{"title":"Product tags"}}}';
        $th_config['elementor_settings'] = '{"template":"default","system_colors":[{"_id":"primary","title":"Primary","color":"#333333"},{"_id":"secondary","title":"Secondary","color":"#DC9814"},{"_id":"text","title":"Text","color":"#555555"},{"_id":"accent","title":"Accent"}],"custom_colors":[{"_id":"0070b03","title":"Color 2","color":"#DC9814"},{"_id":"86b4d1b","title":"White","color":"#FFFFFF"},{"_id":"01bc2ae","title":"Black","color":"#000000"},{"_id":"99d4f0f","title":"Border","color":"#E5E5E5"},{"_id":"dc78774","title":"Color 3","color":"#F57107"}],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_line_height":{"unit":"em","size":1.3,"sizes":[]}},{"_id":"secondary","title":"Secondary","typography_typography":"custom"},{"_id":"text","title":"Text","typography_typography":"custom","typography_line_height":{"unit":"em","size":1.5,"sizes":[]}},{"_id":"accent","title":"Accent","typography_typography":"custom"}],"custom_typography":[{"typography_typography":"custom","typography_font_size":{"unit":"px","size":60,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":48,"sizes":[]},"typography_font_weight":"bold","typography_text_transform":"uppercase","typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"_id":"9144d0e","title":"Title 60","typography_font_size_mobile":{"unit":"px","size":36,"sizes":[]}},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":30,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":30,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":24,"sizes":[]},"typography_font_weight":"bold","typography_text_transform":"uppercase","typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"ac5608f","title":"Title home","typography_letter_spacing":{"unit":"px","size":3,"sizes":[]}},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":24,"sizes":[]},"typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"_id":"1aa392a","title":"Title 2"},{"typography_typography":"custom","typography_font_size":{"unit":"px","size":36,"sizes":[]},"typography_font_size_tablet_extra":{"unit":"px","size":30,"sizes":[]},"typography_font_size_mobile":{"unit":"px","size":24,"sizes":[]},"typography_font_weight":"bold","typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"12b682c","title":"Title home - normal"},{"typography_typography":"custom","typography_font_family":"Oswald","typography_font_size":{"unit":"px","size":24,"sizes":[]},"typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_word_spacing":{"unit":"em","size":"","sizes":[]},"_id":"a4dd5f0","title":"Title 2 - font"},{"_id":"c66b30f","title":"Footer title","typography_typography":"custom","typography_font_size":{"unit":"px","size":20,"sizes":[]},"typography_line_height":{"unit":"em","size":1.3,"sizes":[]},"typography_letter_spacing":{"unit":"px","size":3,"sizes":[]},"typography_text_transform":"uppercase"}],"default_generic_fonts":"Sans-serif","button_typography_typography":"custom","button_text_color":"#FFFFFF","page_title_selector":"h1.entry-title","activeItemIndex":1,"viewport_md":768,"viewport_lg":1025,"button_hover_text_color":"#FFFFFF","body_typography_typography":"custom","active_breakpoints":["viewport_mobile","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"body_background_background":"classic","container_width":{"unit":"px","size":1620,"sizes":[]},"button_typography_font_size":{"unit":"px","size":16,"sizes":[]},"button_border_width":{"unit":"px","top":"1","right":"1","bottom":"1","left":"1","isLinked":true},"button_border_color":"#FFC200","__globals__":{"button_background_color":"globals\/colors?id=secondary","button_hover_background_color":"globals\/colors?id=01bc2ae"},"button_border_radius":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}}';
        $th_config['import_category'] = '';

        /**************************************** PLUGINS ****************************************/
        $th_config['require-plugin'] = array(
            array(
                'name'      => esc_html__( 'Core THTheme', 'decofurniture'),
                'slug'      => 'core-ththeme',
                'required'  => true,
                'source'    => get_template_directory().'/plugins/core-ththeme.zip',
                'version'   => '1.3'
            ),
            array(
                'name'      => esc_html__( 'Slider Revolution', 'decofurniture'),
                'slug'      => 'revslider',
                'required'  => true,
                'source'    => get_template_directory().'/plugins/revslider.zip',
            ),        
            array(
                'name'      => esc_html__( 'Elementor', 'decofurniture'),
                'slug'      => 'elementor',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__( 'Redux Framework', 'decofurniture'),
                'slug'      => 'redux-framework',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__( 'WooCommerce', 'decofurniture'),
                'slug'      => 'woocommerce',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__( 'Contact Form 7', 'decofurniture'),
                'slug'      => 'contact-form-7',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('MailChimp for WordPress Lite','decofurniture'),
                'slug'      => 'mailchimp-for-wp',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('Yith WooCommerce Compare','decofurniture'),
                'slug'      => 'yith-woocommerce-compare',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('Yith WooCommerce Wishlist','decofurniture'),
                'slug'      => 'yith-woocommerce-wishlist',
                'required'  => false,
            ),
            array(
                'name'      => esc_html__('Dokan – Best WooCommerce Multivendor Marketplace Solution','decofurniture'),
                'slug'      => 'dokan-lite',
                'required'  => false,
            ),
        );

    /**************************************** PLUGINS ****************************************/
        
        
    }
}
th_set_theme_config();