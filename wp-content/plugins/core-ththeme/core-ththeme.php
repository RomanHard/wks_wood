<?php
/*
Plugin Name: Core THTheme
Plugin URI: https://ththeme.net/about/
Description: Required with themes of ththeme. Contains all helper functions.
Author: ththeme
Text Domain: core-ththeme
Version: 1.3
Author URI: https://ththeme.net/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if(!defined('TH_TEXTDOMAIN')){
    define('TH_TEXTDOMAIN','th-core');
}

defined( 'CORETH_PLUGIN_URL' ) or define('CORETH_PLUGIN_URL', plugins_url( '/', __FILE__ )) ;

defined( 'CORETH_OPTIONS_BY_ELEMENTS' ) or define('CORETH_OPTIONS_BY_ELEMENTS', '_th_options_by_elements') ;

defined( 'CORETH_CUSTOM_ELEMENTS' ) or define('CORETH_CUSTOM_ELEMENTS', '_th_custom_elements') ;

defined( 'CORETH_MENU_TAB_POSITION' ) or define('CORETH_MENU_TAB_POSITION', '_th_menu_tab_position') ;

defined( 'CORETH_PARAM_PREFIX' ) or define('CORETH_PARAM_PREFIX', 'th_');
defined( 'CORETH_DEVICES' ) or define('CORETH_DEVICES', '_th_devices');
defined( 'CORETH_SHOWHIDE' ) or define('CORETH_SHOWHIDE', '_th_showhide');

if(!class_exists('PluginCore'))
{
    class PluginCore
    {
        static protected $_dir='';
        static protected $_uri='';
        static $plugins_data;

        static function init()
        {

            add_action( 'plugins_loaded', array(__CLASS__,'_load_text_domain') );

            self::$_dir=plugin_dir_path(__FILE__);
            self::$_uri=plugin_dir_url(__FILE__);

            global $this_file;
            $this_file=__FILE__;

            self::load_core_class();

            self::load_required_class();


            require_once self::dir('libs/menu.exporter.php');
            require_once self::dir('libs/importer/importer.php');
            // require_once self::dir('libs/reduxframe/reduxframe.php');
            // require_once self::dir('libs/reduxframe/metaboxes-config.php');
            require_once self::dir('libs/elementor.php');

            add_filter( 'user_contactmethods', array(__CLASS__,'_add_author_profile'), 10, 1);
            add_action( 'woocommerce_edit_account_form', array(__CLASS__,'add_favorite_color_to_edit_account_form' ));
            add_action( 'woocommerce_save_account_details', array(__CLASS__,'save_redirect_account_details'), 1001, 1 );
            add_action( 'woocommerce_save_account_details_errors',array(__CLASS__,'action_woocommerce_save_account_details_errors'), 10, 1 );
            add_action( 'woocommerce_save_account_details', array(__CLASS__,'action_woocommerce_save_account_details'), 10, 1 );
            add_filter( 'get_avatar' , array(__CLASS__,'my_custom_avatar') , 1 , 5 );
            add_action('woocommerce_edit_account_form_tag', array(__CLASS__,'custom_woocommerce_edit_account_form_tag'));
            add_action( 'admin_init', array(__CLASS__,'th_disable_vc_update'), 9 );
            add_filter( 'style_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
            add_filter( 'script_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
        }
        static function  _load_auto_update()
        {
            self::$plugins_data=get_plugin_data(__FILE__);
            self::$plugins_data['plugin_basename']=plugin_basename(__FILE__);

            require_once self::dir('libs/class.autoupdater.php');

        }
        static function _load_text_domain()
        {
            load_plugin_textdomain( 'th-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        static function load_core_class()
        {
            $array=glob(self::dir().'core/*');

            if(!is_array($array)) return false;

            $dirs = array_filter($array, 'is_file');

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    require_once $value;

                }
            }
        }


        static function load_required_class()
        {
            // Fix array_filter argument should be an array
            $class=glob(self::dir().'class/*');
            if(!is_array($class)) return false;

            $dirs = array_filter($class, 'is_file');

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    require_once $value;

                }
            }
        }



        // Helper functions
        static function dir($file=false)
        {
            return self::$_dir.$file;
        }


        static function uri($file=false)
        {
            return self::$_uri.$file;
        }

        static function _add_author_profile( $contactmethods ){       
            $contactmethods['position']     = esc_html__('Position','7up-core');
            $contactmethods['googleplus']   = esc_html__('Google Profile URL','7up-core');
            $contactmethods['twitter']      = esc_html__('Twitter Profile URL','7up-core');
            $contactmethods['facebook']     = esc_html__('Facebook Profile URL','7up-core');
            $contactmethods['linkedin']     = esc_html__('Linkedin Profile URL','7up-core');
            $contactmethods['pinterest']    = esc_html__('Pinterest Profile URL','7up-core');
            $contactmethods['github']       = esc_html__('Github Profile URL','7up-core');
            $contactmethods['instagram']    = esc_html__('Instagram Profile URL','7up-core');
            $contactmethods['vimeo']        = esc_html__('Vimeo Profile URL','7up-core');       
            $contactmethods['youtube']      = esc_html__('Youtube Profile URL','7up-core');       
            return $contactmethods;
        }        

        static function th_disable_vc_update() {
            if (function_exists('vc_license') && function_exists('vc_updater') && ! vc_license()->isActivated()) {

                remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10);
                remove_filter( 'pre_set_site_transient_update_plugins', array(
                    vc_updater()->updateManager(),
                    'check_update'
                ) );

            }
        }

        static function _remove_enqueue_ver($src)    {
            if (strpos($src, '?ver=') && !is_admin())
                $src = remove_query_arg('ver', $src);
            return $src;
        }

        static function add_favorite_color_to_edit_account_form() {
            $user = wp_get_current_user();
            ?>
            
            <div class="avatar-user">
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="image"><?php _e( 'Avatar', 'woocommerce' ); ?></label>
                <p class="avatar user-avatar">
                    <?php
                    if(isset($user->image) && $user->image) echo wp_get_attachment_image($user->image);
                    else echo '<img src="'.esc_url(get_avatar_url($user->ID)).'">';
                    ?>
                </p>
                <input type="file" accept="image/png, image/jpeg" class="woocommerce-Input" name="image" id="image" value="<?php echo esc_attr( $user->image ); ?>" />
            </div>
            <div class="popup-notifi">
                <div class="popup-content">
                    <h2>Notification</h2>
                    <p>File is too big! </p>
                    <p>Please upload file < 2mb.</p>
                    <i class="eicon-close"></i>
                </div>
            </div>
            
            <?php
        }

        static function save_redirect_account_details( $user_id ) {
            wp_safe_redirect( wc_get_endpoint_url( 'edit-account', '', wc_get_page_permalink( 'myaccount' ) ) );
            exit;
        }

        static function action_woocommerce_save_account_details_errors( $args ){
            if ( isset($_POST['image']) && empty($_POST['image']) ) {
                $args->add( 'image_error', __( 'Please provide a valid image', 'woocommerce' ) );
            }
        }

        static function action_woocommerce_save_account_details( $user_id ) { 
            if ( isset( $_FILES['image'] ) && count($_FILES['image']) > 0) {
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
                require_once( ABSPATH . 'wp-admin/includes/media.php' );

                $attachment_id = media_handle_upload( 'image', 0 );
                if ( is_wp_error( $attachment_id ) ) {
                    update_user_meta( $user_id, 'image', '' );
                } else {
                    update_user_meta( $user_id, 'image', $attachment_id );
                }
            }
        }

        static function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
            $user = false; 
            if ( is_numeric( $id_or_email ) ) { 
                $id = (int) $id_or_email;
                $user = get_user_by( 'id' , $id ); 
            } elseif ( is_object( $id_or_email ) ) { 
                if ( ! empty( $id_or_email->user_id ) ) {
                    $id = (int) $id_or_email->user_id;
                    $user = get_user_by( 'id' , $id );
                } 
            } else {
                $user = get_user_by( 'email', $id_or_email );   
            }
            if(!empty($user->image)){
                $avatar =  wp_get_attachment_image($user->image, $size, 0 , array('class'=>'avatar'));
            }
            return $avatar;
        }

        static function custom_woocommerce_edit_account_form_tag(){ 
            echo 'enctype="multipart/form-data"';
        } 

    }
    PluginCore::init();
}
if(class_exists('Elementor\Core\Admin\Admin')){
    function get_section_slider_settings($element) {
       $element->start_controls_section(
          'section_slider_check',
          [
             'label' => esc_html__( 'Section Slider', 'thframe' ),
             'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
          ]
       );

       $element->add_control(
          'slider_enable',
          [
             'label' => esc_html__( 'Enable Slider', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'On', 'thframe' ),
             'label_off' => esc_html__( 'Off', 'thframe' ),
             'return_value' => 'yes',
             'default' => '',
             'description'  => esc_html__( 'When this option is enabled, the section will display as a slider and each column will be a slider item', 'thframe' ),
          ]
       );
       $element->end_controls_section();

       $element->start_controls_section(
          'section_slider',
          [
             'label' => esc_html__( 'Slider Settings', 'thframe' ),
             'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
             'condition' => [
                'slider_enable' => 'yes',
             ]
          ]
       );

       

       $element->add_responsive_control(
          'slider_items',
          [
             'label' => esc_html__( 'Items', 'thframe' ),
             'type' => \Elementor\Controls_Manager::NUMBER,
             'min' => 1,
             'max' => 10,
             'step' => 1,
             'default' => 1,
             'condition' => [
                'slider_auto' => '',
             ]
          ]
       );

       $element->add_responsive_control(
          'slider_space',
          [
             'label' => esc_html__( 'Space(px)', 'thframe' ),
             'description'  => esc_html__( 'For example: 20', 'thframe' ),
             'type' => \Elementor\Controls_Manager::NUMBER,
             'min' => 0,
             'max' => 200,
             'step' => 1,
             'default' => 0,
          ]
       );

       $element->add_control(
          'slider_column',
          [
             'label' => esc_html__( 'Columns', 'thframe' ),
             'type' => \Elementor\Controls_Manager::NUMBER,
             'min' => 1,
             'max' => 10,
             'step' => 1,
             'default' => 1,
          ]
       );

       $element->add_control(
          'slider_speed',
          [
             'label' => esc_html__( 'Speed(ms)', 'thframe' ),
             'description'  => esc_html__( 'For example: 3000 or 5000', 'thframe' ),
             'type' => \Elementor\Controls_Manager::NUMBER,
             'min' => 3000,
             'max' => 10000,
             'step' => 100,
          ]
       );    

       $element->add_control(
          'slider_auto',
          [
             'label' => esc_html__( 'Auto width', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'On', 'thframe' ),
             'label_off' => esc_html__( 'Off', 'thframe' ),
             'return_value' => 'yes',
             'default' => '',
          ]
       );

       $element->add_control(
          'slider_center',
          [
             'label' => esc_html__( 'Center', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'On', 'thframe' ),
             'label_off' => esc_html__( 'Off', 'thframe' ),
             'return_value' => 'yes',
             'default' => '',
          ]
       );

       $element->add_control(
          'slider_middle',
          [
             'label' => esc_html__( 'Middle', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'On', 'thframe' ),
             'label_off' => esc_html__( 'Off', 'thframe' ),
             'return_value' => 'yes',
             'default' => '',
          ]
       );

       $element->add_control(
          'slider_loop',
          [
             'label' => esc_html__( 'Loop', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'On', 'thframe' ),
             'label_off' => esc_html__( 'Off', 'thframe' ),
             'return_value' => 'yes',
             'default' => '',
          ]
       );

       $element->add_control(
          'slider_mousewheel',
          [
             'label' => esc_html__( 'Mousewheel', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'On', 'thframe' ),
             'label_off' => esc_html__( 'Off', 'thframe' ),
             'return_value' => 'yes',
             'default' => '',
          ]
       );

       $element->add_control(
          'slider_navigation',
          [
             'label' => esc_html__( 'Navigation', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'Show', 'thframe' ),
             'label_off' => esc_html__( 'Hide', 'thframe' ),
             'return_value' => 'yes',
             'default' => 'yes',
          ]
       );

       $element->add_control(
          'slider_pagination',
          [
             'label' => esc_html__( 'Pagination', 'thframe' ),
             'type' => \Elementor\Controls_Manager::SWITCHER,
             'label_on' => esc_html__( 'Show', 'thframe' ),
             'label_off' => esc_html__( 'Hide', 'thframe' ),
             'return_value' => 'yes',
             'default' => 'yes',
          ]
       );

       $element->add_control(
          'slider_effects',
          [
             'label'  => esc_html__( 'Effects', 'thframe' ),
             'type'      => \Elementor\Controls_Manager::SELECT,
             'default'   => '',
             'options'   => [
                ''    => esc_html__( 'Default', 'thframe' ),
                'fade'         => esc_html__( 'Fade', 'thframe' ),
                'coverflow'    => esc_html__( 'Coverflow', 'thframe' ),
                'flip'         => esc_html__( 'Flip', 'thframe' ),
                'cube'         => esc_html__( 'cube', 'thframe' ),
             ],
          ]
       );

       $element->end_controls_section();
    }
    add_action( 'elementor/element/before_section_start', function( $element, $section_id, $args ) {
       /** @var \Elementor\Element_Base $element */
       if ( 'section' === $element->get_name() && 'section_background' === $section_id ) {

        get_section_slider_settings($element);
          $element->start_controls_section(
             'section_style_slider_nav',
             [
                'label' => esc_html__( 'Slider Navigation', 'thframe' ),
                'tab'    => \Elementor\Controls_Manager::TAB_STYLE,            
                'condition' => [
                   'slider_navigation' => 'yes',
                   'slider_enable' => 'yes',
                ]
             ]
          );

          $element->add_control(
             'slider_nav_style',
             [
                'label' => esc_html__( 'Style', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                   ''  => esc_html__( 'Default', 'thframe' ),
                   'slider-nav-style2'  => esc_html__( 'Style 2', 'thframe' ),
                   'slider-nav-style3'  => esc_html__( 'Style 3', 'thframe' ),
                ],
             ]
          );

          $element->add_responsive_control(
             'width_slider_nav',
             [
                'label' => esc_html__( 'Width', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                   'px' => [
                      'min' => 0,
                      'max' => 1000,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav' => 'width: {{SIZE}}{{UNIT}};',
                ],
             ]
          );

          $element->add_responsive_control(
             'height_slider_nav',
             [
                'label' => esc_html__( 'Height', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                   'px' => [
                      'min' => 0,
                      'max' => 500,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav' => 'height: {{SIZE}}{{UNIT}};',
                   '{{WRAPPER}} .swiper-button-nav i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
             ]
          );

          $element->add_responsive_control(
             'padding_slider_nav',
             [
                'label' => esc_html__( 'Padding', 'thframe' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
             ]
          );

          $element->add_responsive_control(
             'margin_slider_nav',
             [
                'label' => esc_html__( 'Margin', 'thframe' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
             ]
          );

          $element->start_controls_tabs( 'slider_nav_effects' );

          $element->start_controls_tab( 'slider_nav_normal',
             [
                'label' => esc_html__( 'Normal', 'thframe' ),
             ]
          );

          $element->add_control(
             'nav_color',
             [
                'label' => esc_html__( 'Color', 'thframe' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav i' => 'color: {{VALUE}};',
                ],
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Background::get_type(),
             [
                'name' => 'background_slider_nav',
                'label' => esc_html__( 'Background', 'thframe' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .swiper-button-nav',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Box_Shadow::get_type(),
             [
                'name' => 'shadow_slider_nav',
                'selector' => '{{WRAPPER}} .swiper-button-nav',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Border::get_type(),
             [
                'name' => 'border_slider_nav',
                'selector' => '{{WRAPPER}} .swiper-button-nav',
                'separator' => 'before',
             ]
          );

          $element->add_responsive_control(
             'border_radius_slider_nav',
             [
                'label' => esc_html__( 'Border Radius', 'thframe' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
             ]
          );

          $element->end_controls_tab();

          $element->start_controls_tab( 'slider_nav_hover',
             [
                'label' => esc_html__( 'Hover', 'thframe' ),
             ]
          );

          $element->add_control(
             'nav_color_hover',
             [
                'label' => esc_html__( 'Color', 'thframe' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav:hover i' => 'color: {{VALUE}};',
                ],
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Background::get_type(),
             [
                'name' => 'background_slider_nav_hover',
                'label' => esc_html__( 'Background', 'thframe' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .swiper-button-nav:hover',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Box_Shadow::get_type(),
             [
                'name' => 'shadow_slider_nav_hover',
                'selector' => '{{WRAPPER}} .swiper-button-nav:hover',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Border::get_type(),
             [
                'name' => 'border_slider_nav_hover',
                'selector' => '{{WRAPPER}} .swiper-button-nav:hover',
                'separator' => 'before',
             ]
          );

          $element->add_responsive_control(
             'border_radius_slider_nav_hover',
             [
                'label' => esc_html__( 'Border Radius', 'thframe' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
             ]
          );

          $element->end_controls_tab();

          $element->end_controls_tabs();   

          $element->add_control(
             'separator_slider_nav',
             [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
             ]
          );

          $element->add_control(
             'slider_icon_next',
             [
                'label' => esc_html__( 'Icon next', 'thframe' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                   'value' => 'las la-angle-right',
                   'library' => 'solid',
                ],
             ]
          );

          $element->add_control(
             'slider_icon_prev',
             [
                'label' => esc_html__( 'Icon prev', 'thframe' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                   'value' => 'las la-angle-left',
                   'library' => 'solid',
                ],
             ]
          );

          $element->add_responsive_control(
             'slider_icon_size',
             [
                'label' => esc_html__( 'Size icon', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-nav i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
             ]
          );

          $element->add_responsive_control(
             'slider_nav_space',
             [
                'label' => esc_html__( 'Space', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                   'px' => [
                      'min' => -500,
                      'max' => 500,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
                   '{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
             ]
          );

          $element->end_controls_section();

          $element->start_controls_section(
             'section_style_slider_pag',
             [
                'label' => esc_html__( 'Slider Pagination', 'thframe' ),
                'tab'    => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                   'slider_pagination' => 'yes',
                   'slider_enable' => 'yes',
                ]
             ]
          );

          $element->add_control(
             'slider_pag_style',
             [
                'label' => esc_html__( 'Style', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                   ''  => esc_html__( 'Default', 'thframe' ),
                   'slider-pag-style2'  => esc_html__( 'Style 2', 'thframe' ),
                   'slider-pag-style3'  => esc_html__( 'Style 3', 'thframe' ),
                   'slider-pag-style4'  => esc_html__( 'Style 4', 'thframe' ),
                ],
             ]
          );

          $element->add_responsive_control(
             'width_slider_pag',
             [
                'label' => esc_html__( 'Width', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                   'px' => [
                      'min' => 0,
                      'max' => 1000,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}};',
                ], 
             ]
          );

          $element->add_responsive_control(
             'height_slider_pag',
             [
                'label' => esc_html__( 'Height', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                   'px' => [
                      'min' => 0,
                      'max' => 500,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-pagination span' => 'height: {{SIZE}}{{UNIT}};',
                ],
             ]
          );

          $element->add_control(
             'separator_bg_normal',
             [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
             ]
          );

          $element->add_control(
             'background_pag_heading',
             [
                'label' => esc_html__( 'Normal', 'thframe' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Background::get_type(),
             [
                'name' => 'background_slider_pag',
                'label' => esc_html__( 'Background', 'thframe' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .swiper-pagination span',
             ]
          );

          $element->add_control(
             'opacity_pag',
             [
                'label' => esc_html__( 'Opacity', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                   'px' => [
                      'max' => 1,
                      'min' => 0.10,
                      'step' => 0.01,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-pagination span' => 'opacity: {{SIZE}};',
                ],
             ]
          );

          $element->add_control(
             'separator_bg_active',
             [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
             ]
          );

          $element->add_control(
             'background_pag_heading_active',
             [
                'label' => esc_html__( 'Active', 'thframe' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Background::get_type(),
             [
                'name' => 'background_slider_pag_active',
                'label' => esc_html__( 'Background', 'thframe' ),
                'description'  => esc_html__( 'Active status', 'thframe' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .swiper-pagination span.swiper-pagination-bullet-active',
             ]
          );

          $element->add_control(
             'opacity_pag_active',
             [
                'label' => esc_html__( 'Opacity', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                   'px' => [
                      'max' => 1,
                      'min' => 0.10,
                      'step' => 0.01,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-pagination span.swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
                ],
             ]
          );

          $element->add_control(
             'separator_shadow',
             [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Box_Shadow::get_type(),
             [
                'name' => 'shadow_slider_pag',
                'selector' => '{{WRAPPER}} .swiper-pagination span',
             ]
          );

          $element->add_group_control(
             \Elementor\Group_Control_Border::get_type(),
             [
                'name' => 'border_slider_pag',
                'selector' => '{{WRAPPER}} .swiper-pagination span',
                'separator' => 'before',
             ]
          );

          $element->add_responsive_control(
             'border_radius_slider_pag',
             [
                'label' => esc_html__( 'Border Radius', 'thframe' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
             ]
          );

          $element->add_responsive_control(
             'slider_pag_space',
             [
                'label' => esc_html__( 'Space', 'thframe' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                   'px' => [
                      'min' => -500,
                      'max' => 500,
                   ],
                ],
                'selectors' => [
                   '{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
             ]
          );

          $element->end_controls_section();
       }
    }, 10, 3 );
    add_action( 'elementor/frontend/section/before_render', 'th_section_before_render', 99 );
    function th_section_before_render(\Elementor\Element_Base $element){
       if ( 'section' === $element->get_name()) {
          $settings = $element->get_settings_for_display();
          extract($settings);
          if($slider_enable == 'yes'){
             echo '<div class="th-slider-wrap">';
             $element->add_render_attribute( '_wrapper', 'class', 'elth-swiper-slider swiper-container slider-wrap');
             if($slider_nav_style) $element->add_render_attribute( '_wrapper', 'class', $slider_nav_style );
             if($slider_pag_style) $this->add_render_attribute( '_wrapper', 'class', $slider_pag_style );
             if($slider_middle == 'yes') $element->add_render_attribute( '_wrapper', 'class', 'slider-middle-item' );
             $element->add_render_attribute( '_wrapper', 'data-items', $slider_items );
             $element->add_render_attribute( '_wrapper', 'data-items-tablet', $slider_items_tablet);
             $element->add_render_attribute( '_wrapper', 'data-items-mobile', $slider_items_mobile );
             $element->add_render_attribute( '_wrapper', 'data-items-laptop', $slider_items_laptop );
             $element->add_render_attribute( '_wrapper', 'data-items-extra_tablet', $slider_items_tablet_extra);
             $element->add_render_attribute( '_wrapper', 'data-space', $slider_space );
             $element->add_render_attribute( '_wrapper', 'data-space-tablet', $slider_space_tablet );
             $element->add_render_attribute( '_wrapper', 'data-space-mobile', $slider_space_mobile );
             $element->add_render_attribute( '_wrapper', 'data-space-laptop', $slider_space_laptop );
             $element->add_render_attribute( '_wrapper', 'data-space-extra_tablet', $slider_space_tablet_extra);
             $element->add_render_attribute( '_wrapper', 'data-column', $slider_column );
             $element->add_render_attribute( '_wrapper', 'data-auto', $slider_auto );
             $element->add_render_attribute( '_wrapper', 'data-center', $slider_center );
             $element->add_render_attribute( '_wrapper', 'data-loop', $slider_loop );
             $element->add_render_attribute( '_wrapper', 'data-speed', $slider_speed );
             $element->add_render_attribute( '_wrapper', 'data-mousewheel', $slider_mousewheel );
             $element->add_render_attribute( '_wrapper', 'data-navigation', $slider_navigation );
             $element->add_render_attribute( '_wrapper', 'data-pagination', $slider_pagination );
             $element->add_render_attribute( '_wrapper', 'data-effect', $slider_effects );
          }
       }
    }
    add_action( 'elementor/frontend/section/after_render', 'th_section_after_render' );
    function th_section_after_render(\Elementor\Element_Base $element){
       if ( 'section' === $element->get_name()) {
          $settings = $element->get_settings_for_display();
          extract($settings);
          if($slider_enable == 'yes'){
             ?>
             <div class="section-slider-nav">
                <?php if ( $slider_navigation == 'yes' ):?>
                    <div class="swiper-button-nav swiper-button-next"><?php \Elementor\Icons_Manager::render_icon( $slider_icon_next, [ 'aria-hidden' => 'true' ] );?></div>
                    <div class="swiper-button-nav swiper-button-prev"><?php \Elementor\Icons_Manager::render_icon( $slider_icon_prev, [ 'aria-hidden' => 'true' ] );?></div>
                <?php endif?>
                <?php if ( $slider_pagination == 'yes' ):?>
                    <div class="swiper-pagination"></div>
                <?php endif?>
                </div>
             </div>
             <?php
          }
       }
    }
}