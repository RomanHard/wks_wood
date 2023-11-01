<?php

if ( ! defined( 'ABSPATH' ) ) exit;
class Plugin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		//add_action( 'wp_enqueue_scripts',[ $this , 'th_add_scripts' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );

		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'wp_enqueue_custom_scripts' ] );
	}

	public function wp_enqueue_custom_scripts() {
			wp_register_script( 'hello-world', plugins_url( '/assets/js/custom-elementor.js', __FILE__ ), [ 'jquery' ], false, true );
		}

	public function th_add_scripts() {
		wp_register_style( 'owl2-carousel', plugins_url( '/assets/css/owl.carousel.min.css', __FILE__ ));
		wp_register_style( 'owl2-carousel-theme', plugins_url( '/assets/css/owl.theme.default.css', __FILE__ ));
		wp_register_script( 'owl2-carousel-script', plugins_url( '/assets/js/owl.carousel.min.js', __FILE__ ), [ 'jquery' ], false, true );
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {	

		$files=glob(__DIR__."/widgets/*.php");
		$template_path = get_template_directory();
        $stylesheet_path = get_stylesheet_directory();
		$files2=glob($template_path."/th-lib/th-elementor/*.php");
		$files = array_merge($files,$files2);
		$names = [];
        // Auto load all file
        if(!empty($files)){
            foreach ($files as $filename)
            {
            	$dirname = pathinfo($filename);
            	$name =  $dirname['filename'];
            	if(!in_array($name, $names));{
            		$names[] = $name;
	            	$child_path = $stylesheet_path.'/th-lib/7up-elementor/'.$name.'.php';
	            	$theme_path = $template_path.'/th-lib/7up-elementor/'.$name.'.php';
	            	if( $template_path != $stylesheet_path && is_file($child_path) ) require $child_path;
	            	elseif(is_file($theme_path)) require $theme_path;
	                else require $filename;
			        $class_name	 = str_replace('-', '_', $name);
			        $class_name = 'Elementor\\'.$class_name;
	                if(class_exists($class_name)) \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
            		}
            }
        }
	}
}

new Plugin();
