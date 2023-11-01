<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Th_Box_Info extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'th-box-info';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Box Info', 'decofurniture' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'th-category' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'hello-world' ];
	}

	public function get_all_pages($post_type = 'wpcf7_contact_form') {
		global $post;
        $post_temp = $post;
        $page_list = array(''=>esc_html__("--Select one--","decofurniture"));
        if(is_admin()){
            $pages = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
            if(is_array($pages)){
                foreach ($pages as $page) {
                    $page_list[$page->ID] = $page->post_title;
                }
            }
        }
        $post = $post_temp;
        return $page_list;
	}

	public function get_text_styles($key='text', $class="text-class") {
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $key.'_typography',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->start_controls_tabs( $key.'_effects' );

		$this->start_controls_tab( $key.'_normal',
			[
				'label' => esc_html__( 'Normal', 'decofurniture' ),
			]
		);

		$this->add_control(
			$key.'_color',
			[
				'label' => esc_html__( 'Color', 'decofurniture' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( $key.'_hover',
			[
				'label' => esc_html__( 'Hover', 'decofurniture' ),
			]
		);

		$this->add_control(
			$key.'_color_hover',
			[
				'label' => esc_html__( 'Color', 'decofurniture' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $key.'_shadow_hover',
				'selector' => '{{WRAPPER}} .'.$class.':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	public function get_box_settings($key='box-key',$class="box-class") {
		$this->add_responsive_control(
			$key.'_padding',
			[
				'label' => esc_html__( 'Padding', 'decofurniture' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			$key.'_margin',
			[
				'label' => esc_html__( 'Margin', 'decofurniture' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background',
				'label' => esc_html__( 'Background', 'decofurniture' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .'.$class,
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => $key.'_border',
                'label' => esc_html__( 'Border', 'decofurniture' ),
                'separator' => 'before',
				'selector' => '{{WRAPPER}} .'.$class,
			]
        );

        $this->add_responsive_control(
			$key.'_radius',
			[
				'label' => esc_html__( 'Border Radius', 'decofurniture' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);
	}

	public function get_button_styles($key='button', $class="btn-class") {

		$this->add_responsive_control(
			$key.'_align',
			[
				'label' => esc_html__( 'Alignment', 'decofurniture' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'decofurniture' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'decofurniture' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'decofurniture' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.'-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $key.'_typography',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->add_control(
			$key.'_icon',
			[
				'label' => esc_html__( 'Icon', 'decofurniture' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_responsive_control(
			$key.'_size_icon',
			[
				'label' => esc_html__( 'Size icon', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			$key.'_icon_pos',
			[
				'label' => esc_html__( 'Icon position', 'decofurniture' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after-icon',
				'options' => [
					'after-text'   => esc_html__( 'After text', 'decofurniture' ),
					'before-text'  => esc_html__( 'Before text', 'decofurniture' ),
				],
				'condition' => [
					$key.'_text!' => '',
					$key.'_icon[value]!' => '',
				]
			]
		);

		$this->add_responsive_control(
			$key.'_spacing',
			[
				'label' => esc_html__( 'Space', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.'-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			$key.'_icon_spacing_left',
			[
				'label' => esc_html__( 'Icon Space left', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' i' => 'margin-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			$key.'_icon_spacing_right',
			[
				'label' => esc_html__( 'Icon Space right', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class.' i' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( $key.'_effects' );

		$this->start_controls_tab( $key.'_normal',
			[
				'label' => esc_html__( 'Normal', 'decofurniture' ),
			]
		);

		$this->add_control(
			$key.'_color',
			[
				'label' => esc_html__( 'Color', 'decofurniture' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background',
				'label' => esc_html__( 'Background', 'decofurniture' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->add_responsive_control(
			$key.'_padding',
			[
				'label' => esc_html__( 'Padding', 'decofurniture' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow',
				'selector' => '{{WRAPPER}} .'.$class,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( $key.'_hover',
			[
				'label' => esc_html__( 'Hover', 'decofurniture' ),
			]
		);

		$this->add_control(
			$key.'_color_hover',
			[
				'label' => esc_html__( 'Color', 'decofurniture' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => $key.'_background_hover',
				'label' => esc_html__( 'Background', 'decofurniture' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .'.$class.':hover',
			]
		);

		$this->add_responsive_control(
			$key.'_padding_hover',
			[
				'label' => esc_html__( 'Padding', 'decofurniture' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .'.$class.':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => $key.'_shadow_hover',
				'selector' => '{{WRAPPER}} .'.$class.':hover',
			]
		);

		$this->add_control(
			$key.'_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .'.$class => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Style', 'decofurniture' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' 	=> esc_html__( 'Style', 'decofurniture' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''		=> esc_html__( 'Default', 'decofurniture' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_header',
			[
				'label' => esc_html__( 'Header', 'decofurniture' ),
			]
		);

		$this->add_control(
			'header_title', 
			[
				'label' => esc_html__( 'Title', 'decofurniture' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Header', 'decofurniture' ),
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'header_align',
			[
				'label' => esc_html__( 'Alignment', 'decofurniture' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'decofurniture' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'decofurniture' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'decofurniture' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .header-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_info',
			[
				'label' => esc_html__( 'Info', 'decofurniture' ),
			]
		);

		$this->add_control(
			'info_title', 
			[
				'label' => esc_html__( 'Title', 'decofurniture' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'decofurniture' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'info_des', 
			[
				'label' => esc_html__( 'Description', 'decofurniture' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Description', 'decofurniture' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'form',
			[
				'label' 	=> esc_html__( 'Add form', 'decofurniture' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $this->get_all_pages(),
			]
		);

		$repeater_icons = new Repeater();
		$repeater_icons->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'decofurniture' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'las la-user',
					'library' => 'solid',
				],
			]
		);

		$repeater_icons->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'decofurniture' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .info-icon-list {{CURRENT_ITEM}} i,{{WRAPPER}} {{CURRENT_ITEM}} .item-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater_icons->add_control(
			'size_icon',
			[
				'label' => esc_html__( 'Icon Size', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-icon-list {{CURRENT_ITEM}} i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$repeater_icons->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Icon Space', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-icon-list {{CURRENT_ITEM}} .adv-thumb-link' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);	

		$repeater_icons->add_control(
			'title', 
			[
				'label' => esc_html__( 'Title/name', 'decofurniture' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'separator' => 'before',
			]
		);
		$repeater_icons->add_control(
			'title_color', 
			[
				'label' => esc_html__( 'Color', 'decofurniture' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .item-title a' => 'color: {{VALUE}};',
				],
			]
		);
		$repeater_icons->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '.info-icon-list {{CURRENT_ITEM}} .item-title a',
			]
		);
		$repeater_icons->add_responsive_control(
			'title_space',
			[
				'label' => esc_html__( 'Title Space', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-icon-list {{CURRENT_ITEM}} .item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater_icons->add_control(
			'description', 
			[
				'label' => esc_html__( 'Description/position', 'decofurniture' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'separator' => 'before',
			]
		);
		$repeater_icons->add_control(
			'description_color', 
			[
				'label' => esc_html__( 'Color', 'decofurniture' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .item-des' => 'color: {{VALUE}};',
				],
			]
		);
		$repeater_icons->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '.info-icon-list {{CURRENT_ITEM}} .item-des',
			]
		);
		$repeater_icons->add_responsive_control(
			'description_space',
			[
				'label' => esc_html__( 'Description Space', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-icon-list {{CURRENT_ITEM}} .item-des' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater_icons->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'decofurniture' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'decofurniture' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'separator' => 'before',
			]
		);

		$repeater_icons->add_responsive_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'decofurniture' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'decofurniture' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'decofurniture' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'decofurniture' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-icon-list {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_icons',
			[
				'label' => esc_html__( 'Add icons', 'decofurniture' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_icons->get_controls(),
				'title_field' => '{{{ title }}}',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'icon_style',
			[
				'label' 	=> esc_html__( 'Style icon', 'decofurniture' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'style1',
				'options'   => [
					'style1'		=> esc_html__( 'Default', 'decofurniture' ),
				],
			]
		);

		$repeater_images = new Repeater();
		$repeater_images->add_control(
			'title', 
			[
				'label' => esc_html__( 'Title', 'decofurniture' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater_images->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'decofurniture' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater_images->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'include' => [],
				'default' => 'large',
			]
		);
		$repeater_images->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'decofurniture' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'decofurniture' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'list_images',
			[
				'label' => esc_html__( 'Add images', 'decofurniture' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_images->get_controls(),
				'title_field' => '{{{ title }}}',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'image_style',
			[
				'label' 	=> esc_html__( 'Style image', 'decofurniture' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'style1',
				'options'   => [
					'style1'		=> esc_html__( 'Default', 'decofurniture' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label' => esc_html__( 'Button', 'decofurniture' ),
			]
		);	

		$this->add_control(
			'check_button',
			[
				'label' => esc_html__( 'Show button', 'decofurniture' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'decofurniture' ),
				'label_off' => esc_html__( 'Off', 'decofurniture' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);	

		$this->add_control(
			'button_style',
			[
				'label' 	=> esc_html__( 'Style', 'decofurniture' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''		=> esc_html__( 'Default', 'decofurniture' ),
					'style2'		=> esc_html__( 'Style 2', 'decofurniture' ),
				],
			]
		);

		$this->add_control(
			'button_text', 
			[
				'label' => esc_html__( 'Button Text', 'decofurniture' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read more' , 'decofurniture' ),
				'label_block' => true,
				'condition' => [
					'check_button' => 'yes',
				]
			]
		);

		$this->add_control(
			'check_submit',
			[
				'label' => esc_html__( 'Click submit form', 'decofurniture' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'decofurniture' ),
				'label_off' => esc_html__( 'Off', 'decofurniture' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'check_button' => 'yes',
				]
			]
		);

		$this->add_control(
            'button_url',
            [
                'label' 	=> esc_html__( 'URL', 'decofurniture' ),
                'type' 		=> Controls_Manager::URL,
                'placeholder' => esc_url('http://your-link.com'),
                'condition' => [
					'check_button' => 'yes',
					'check_submit!' => 'yes',
				],
                'default' 	=> [
                    'url' 			=> '#',
                    'is_external' 	=> false,
					'nofollow' 		=> true,
                ],
                'dynamic' 	=> [
                    'active' 	=> true,
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_wrap',
			[
				'label' => esc_html__( 'Wrap Box', 'decofurniture' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'wrap_width',
			[
				'label' => esc_html__( 'Width', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' , 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.01,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->get_box_settings('wrap','box-info-wrap');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Header', 'decofurniture' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_text_styles('header','header-text');

		$this->get_box_settings('header_box','header-wrap');

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_ovelay',
				'label' => esc_html__( 'Background overlay', 'decofurniture' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .box-info-wrap .header-wrap:before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'decofurniture' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_text_styles('title','info-wrap .info-inner > h3');

		$this->add_responsive_control(
			'title_space',
			[
				'label' => esc_html__( 'Title Space', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-wrap .info-inner > h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_des',
			[
				'label' => esc_html__( 'Description', 'decofurniture' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_text_styles('des','info-wrap .info-inner > p');

		$this->add_responsive_control(
			'des_space',
			[
				'label' => esc_html__( 'Description Space', 'decofurniture' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-wrap .info-inner > p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'decofurniture' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'check_button' => 'yes',
				]
			]
		);

		$this->get_button_styles('button','readmore');

		$this->get_box_settings('button_wrap','readmore-wrap');

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_info',
			[
				'label' => esc_html__( 'Info Box', 'decofurniture' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'inner_align',
			[
				'label' => esc_html__( 'Alignment', 'decofurniture' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'decofurniture' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'decofurniture' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'decofurniture' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info-inner' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->get_box_settings('info','info-inner');

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();
		$this->add_render_attribute( 'box-wrap', 'class', 'box-info-wrap box-info-'.$settings['style'].' submit-button-'.$settings['check_submit'] );
		$attr = array(
			'wdata'		=> $this,
			'settings'	=> $settings,
		);
		echo th_get_template_widget('box-info/box',$settings['style'],$attr);
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() {
		
	}
}