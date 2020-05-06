<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Dual_Header extends Widget_Base {
    protected $templateInstance;

    public function getTemplateInstance(){
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }
    
    public function get_name() {
        return 'pixerex-dual-header';
    }

    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Dual Heading', 'pixerex-elements') );
	}

    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }
    
    public function get_icon() {
        return 'eicon-heading';
    }

    public function get_categories() {
        return [ 'pixerex-elements'];
    }

    // Adding the controls fields for the dual header
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /*Start General Section*/
        $this->start_controls_section('pixerex_dual_header_general_settings',
            [
                'label'         => __('Dual Heading', 'pixerex-elements')
            ]
        );
        
        /*First Header*/
        $this->add_control('pixerex_dual_header_first_header_text',
            [
                'label'         => __('First Heading', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Pixerex', 'pixerex-elements'),
                'label_block'   => true,
            ]
        );

        /*Second Header*/
        $this->add_control('pixerex_dual_header_second_header_text',
            [
                'label'         => __('Second Heading', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Addons', 'pixerex-elements'),
                'label_block'   => true,
            ]
        );
        
         /*Title Tag*/
        $this->add_control('pixerex_dual_header_first_header_tag',
            [
                'label'         => __('HTML Tag', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h2',
                'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'p'     => 'p',
                    'span'  => 'span',
                ],
                'label_block'   =>  true,
            ]
        );
        
        /*Text Align*/
        $this->add_control('pixerex_dual_header_position',
            [
                'label'         => __( 'Display', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'inline'=> __('Inline', 'pixerex-elements'),
                    'block' => __('Block', 'pixerex-elements'),
                ],
                'default'       => 'inline',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-container span, {{WRAPPER}} .pixerex-dual-header-second-container' => 'display: {{VALUE}};',
                ],
                'label_block'   => true
            ]
        );
        
        $this->add_control('pixerex_dual_header_link_switcher',
            [
                'label'         => __('Link', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Enable or disable link','pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_dual_heading_link_selection', 
            [
                'label'         => __('Link Type', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'pixerex-elements'),
                    'link'  => __('Existing Page', 'pixerex-elements'),
                ],
                'default'       => 'url',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_dual_header_link_switcher'     => 'yes',
                ]
            ]
        );
        
        $this->add_control('pixerex_dual_heading_link',
            [
                'label'         => __('Link', 'pixerex-elements'),
                'type'          => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'   => '#',
                ],
                'placeholder'   => 'https://www.google.com/',
                'label_block'   => true,
                'separator'     => 'after',
                'condition'     => [
                    'pixerex_dual_header_link_switcher'     => 'yes',
                    'pixerex_dual_heading_link_selection'   => 'url'
                ]
            ]
        );
        
        $this->add_control('pixerex_dual_heading_existing_link',
            [
                'label'         => __('Existing Page', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'condition'     => [
                    'pixerex_dual_header_link_switcher'         => 'yes',
                    'pixerex_dual_heading_link_selection'       => 'link',
                ],
                'multiple'      => false,
                'separator'     => 'after',
                'label_block'   => true,
            ]
        );
        
        /*Text Align*/
        $this->add_responsive_control('pixerex_dual_header_text_align',
            [
                'label'         => __( 'Alignment', 'pixerex-elements' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-right'
                    ]
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-container' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control('rotate',
            [
                'label'         => __('Degrees', 'pixerex-elements'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => -180,
                'max'           => 180,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-container' => 'transform: rotate({{VALUE}}deg);'
                ],
            ]
        );

        $this->add_responsive_control('transform_origin_x',
            [
                'label' => __( 'X Anchor Point', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'pixerex-elements' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'pixerex-elements' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'pixerex-elements' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'label_block' => false,
                'toggle' => false,
                'render_type' => 'ui',
                'condition' => [
                    'rotate!'    => ''
                ]
            ]
        );

        $this->add_responsive_control('transform_origin_y',
            [
                'label' => __( 'Y Anchor Point', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'top' => [
                        'title' => __( 'Top', 'pixerex-elements' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'pixerex-elements' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => __( 'Bottom', 'pixerex-elements' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-dual-header-container' => 'transform-origin: {{transform_origin_x.VALUE}} {{VALUE}}',
                ],
                'label_block' => false,
                'toggle' => false,
                'condition' => [
                    'rotate!'    => ''
                ]
            ]
		);

        /*End General Settings Section*/
        $this->end_controls_section();
        
        /*Start First Header Styling Section*/
        $this->start_controls_section('pixerex_dual_header_first_style',
            [
                'label'         => __('First Heading', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );
        
        /*First Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'first_header_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-dual-header-first-span'
            ]
        );
        
        $this->add_control('pixerex_dual_header_first_animated',
            [
                'label'         => __('Animated Background', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );

        /*First Coloring Style*/
        $this->add_control('pixerex_dual_header_first_back_clip',
            [
                'label'         => __('Background Style', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'color',
                'description'   => __('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.','pixerex-elements'),
                'options'       => [
                    'color'         => __('Normal', 'pixerex-elements'),
                    'clipped'       => __('Clipped', 'pixerex-elements'),
                ],
                'label_block'   =>  true
            ]
        );

        /*First Color*/
        $this->add_control('pixerex_dual_header_first_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1
                ],
                'condition'     => [
                    'pixerex_dual_header_first_back_clip' => 'color'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-span'   => 'color: {{VALUE}};'
                ]
            ]
        );
        
        /*First Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_dual_header_first_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'pixerex_dual_header_first_back_clip'  => 'color'
                ],
                'selector'          => '{{WRAPPER}} .pixerex-dual-header-first-span'
            ]
        );
        
        $this->add_control('pixerex_dual_header_first_stroke',
            [
                'label'         => __('Stroke', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'         => [
                    'pixerex_dual_header_first_back_clip'  => 'clipped'
                ],
            ]
        );
        
        $this->add_control('pixerex_dual_header_first_stroke_text_color',
            [
                'label'         => __('Stroke Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'condition'     => [
                    'pixerex_dual_header_first_back_clip'   => 'clipped',
                    'pixerex_dual_header_first_stroke'      => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-clip.stroke .pixerex-dual-header-first-span'   => '-webkit-text-stroke-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('pixerex_dual_header_first_stroke_color',
            [
                'label'         => __('Stroke Fill Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'condition'     => [
                    'pixerex_dual_header_first_back_clip'   => 'clipped',
                    'pixerex_dual_header_first_stroke'      => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-clip.stroke .pixerex-dual-header-first-span'   => '-webkit-text-fill-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('pixerex_dual_header_first_stroke_width',
            [
                'label'         => __('Stroke Fill Width', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'pixerex_dual_header_first_back_clip'   => 'clipped',
                    'pixerex_dual_header_first_stroke'      => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-clip.stroke .pixerex-dual-header-first-span'   => '-webkit-text-stroke-width: {{SIZE}}px;'
                ]
            ]
        );
        
        /*First Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_dual_header_first_clipped_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'pixerex_dual_header_first_back_clip'  => 'clipped',
                    'pixerex_dual_header_first_stroke!'      => 'yes'
                ],
                'selector'          => '{{WRAPPER}} .pixerex-dual-header-first-span'
            ]
        );
        
        /*First Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'              => 'first_header_border',
                'selector'          => '{{WRAPPER}} .pixerex-dual-header-first-span',
                'separator'         => 'before'
            ]
        );
        
        /*First Border Radius*/
        $this->add_control('pixerex_dual_header_first_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-span' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        /*First Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-elements'),
                'name'          => 'pixerex_dual_header_first_text_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-dual-header-first-span'
            ]
        );
        
        /*First Margin*/
        $this->add_responsive_control('pixerex_dual_header_first_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'separator'     => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        /*First Padding*/
        $this->add_responsive_control('pixerex_dual_header_first_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-first-span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        /*End First Header Styling Section*/
        $this->end_controls_section();
        
        /*Start First Header Styling Section*/
        $this->start_controls_section('pixerex_dual_header_second_style',
            [
                'label'         => __('Second Heading', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );
        
        /*Second Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'second_header_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-dual-header-second-header'
            ]
        );
        
        $this->add_control('pixerex_dual_header_second_animated',
            [
                'label'         => __('Animated Background', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );
        
        /*Second Coloring Style*/
        $this->add_control('pixerex_dual_header_second_back_clip',
            [
                'label'         => __('Background Style', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'color',
                'description'   => __('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.','pixerex-elements'),
                'options'       => [
                    'color'         => __('Normal', 'pixerex-elements'),
                    'clipped'       => __('Clipped', 'pixerex-elements')
                ],
                'label_block'   =>  true
            ]
        );
        
        /*Second Color*/
        $this->add_control('pixerex_dual_header_second_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2
                ],
                'condition'     => [
                    'pixerex_dual_header_second_back_clip' => 'color'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-second-header'   => 'color: {{VALUE}};'
                ]
            ]
        );
        
        /*Second Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_dual_header_second_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'pixerex_dual_header_second_back_clip'  => 'color'
                ],
                'selector'          => '{{WRAPPER}} .pixerex-dual-header-second-header'
            ]
        );
        
        $this->add_control('pixerex_dual_header_second_stroke',
            [
                'label'         => __('Stroke', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'         => [
                    'pixerex_dual_header_second_back_clip'  => 'clipped'
                ],
            ]
        );
        
        $this->add_control('pixerex_dual_header_second_stroke_text_color',
            [
                'label'         => __('Stroke Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'condition'     => [
                    'pixerex_dual_header_second_back_clip'   => 'clipped',
                    'pixerex_dual_header_second_stroke'      => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-second-clip.stroke'   => '-webkit-text-stroke-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('pixerex_dual_header_second_stroke_color',
            [
                'label'         => __('Stroke Fill Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'condition'     => [
                    'pixerex_dual_header_second_back_clip'   => 'clipped',
                    'pixerex_dual_header_second_stroke'      => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-second-clip.stroke'   => '-webkit-text-fill-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('pixerex_dual_header_second_stroke_width',
            [
                'label'         => __('Stroke Fill Width', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'pixerex_dual_header_second_back_clip'   => 'clipped',
                    'pixerex_dual_header_second_stroke'      => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-second-clip.stroke'   => '-webkit-text-stroke-width: {{SIZE}}px;'
                ]
            ]
        );
        
        /*Second Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_dual_header_second_clipped_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'pixerex_dual_header_second_back_clip'  => 'clipped',
                    'pixerex_dual_header_second_stroke!'      => 'yes'
                ],
                'selector'          => '{{WRAPPER}} .pixerex-dual-header-second-header'
            ]
        );
        
        /*Second Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'              => 'second_header_border',
                'selector'          => '{{WRAPPER}} .pixerex-dual-header-second-header',
                'separator'         => 'before'
            ]
        );
        
        /*Second Border Radius*/
        $this->add_control('pixerex_dual_header_second_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-second-header' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        /*Second Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-elements'),
                'name'          => 'pixerex_dual_header_second_text_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-dual-header-second-header'
            ]
        );
        
        /*Second Margin*/
        $this->add_responsive_control('pixerex_dual_header_second_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'separator'     => 'before',
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-second-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        /*Second Padding*/
        $this->add_responsive_control('pixerex_dual_header_second_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-dual-header-second-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );
        
        /*End Second Header Styling Section*/
        $this->end_controls_section();
       
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('pixerex_dual_header_first_header_text');

        $this->add_inline_editing_attributes('pixerex_dual_header_second_header_text');

        $first_title_tag = $settings['pixerex_dual_header_first_header_tag'];

        $first_title_text = $settings['pixerex_dual_header_first_header_text'] . ' ';

        $second_title_text = $settings['pixerex_dual_header_second_header_text'];

        $first_clip = '';

        $second_clip = '';
        
        $first_stroke = '';

        $second_stroke = '';

        if( 'clipped' === $settings['pixerex_dual_header_first_back_clip'] ) : $first_clip = "pixerex-dual-header-first-clip"; endif; 

        if( 'clipped' === $settings['pixerex_dual_header_second_back_clip'] ) : $second_clip = "pixerex-dual-header-second-clip"; endif; 
        
        if( ! empty( $first_clip ) && 'yes' === $settings['pixerex_dual_header_first_stroke'] ) : $first_stroke = " stroke"; endif; 

        if( ! empty( $second_clip ) && 'yes' === $settings['pixerex_dual_header_second_stroke'] ) : $second_stroke = " stroke"; endif; 
        
        $first_grad = $settings['pixerex_dual_header_first_animated'] === 'yes' ? ' gradient' : '';
        
        $second_grad = $settings['pixerex_dual_header_second_animated'] === 'yes' ? ' gradient' : '';
        
        $full_title = '<' . $first_title_tag . ' class="pixerex-dual-header-first-header ' . $first_clip . $first_stroke . $first_grad . '"><span class="pixerex-dual-header-first-span">'. $first_title_text . '</span><span class="pixerex-dual-header-second-header ' . $second_clip . $second_stroke . $second_grad . '">'. $second_title_text . '</span></' . $settings['pixerex_dual_header_first_header_tag'] . '> ';
        
        $link = '';
        if( $settings['pixerex_dual_header_link_switcher'] == 'yes' && $settings['pixerex_dual_heading_link_selection'] == 'link' ) {
            $link = get_permalink( $settings['pixerex_dual_heading_existing_link'] );
        } elseif( $settings['pixerex_dual_header_link_switcher'] == 'yes' && $settings['pixerex_dual_heading_link_selection'] == 'url' ) {
            $link = $settings['pixerex_dual_heading_link']['url'];
        }
        
    ?>
    
    <div class="pixerex-dual-header-container">
        <?php if( ! empty ( $link ) ) : ?>
            <a href="<?php echo esc_attr( $link ); ?>" <?php if( ! empty( $settings['pixerex_dual_heading_link']['is_external'] ) ) : ?> target="_blank" <?php endif; ?><?php if( ! empty( $settings['pixerex_dual_heading_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>>
            <?php endif; ?>
            <div class="pixerex-dual-header-first-container">
                <?php echo $full_title; ?>
            </div>
        <?php if( ! empty ( $link ) ) : ?>
            </a>
        <?php endif; ?>
    </div>

    <?php
    }
    
    protected function _content_template()
    {
        ?>
        <#
        
            view.addInlineEditingAttributes('pixerex_dual_header_first_header_text');

            view.addInlineEditingAttributes('pixerex_dual_header_second_header_text');

            var firstTag = settings.pixerex_dual_header_first_header_tag,

            firstText = settings.pixerex_dual_header_first_header_text + ' ',

            secondText = settings.pixerex_dual_header_second_header_text,

            firstClip = '',

            secondClip = '',
            
            firstStroke = '',
            
            secondStroke = '';

            if( 'clipped' === settings.pixerex_dual_header_first_back_clip )
                firstClip = "pixerex-dual-header-first-clip"; 

            if( 'clipped' === settings.pixerex_dual_header_second_back_clip )
                secondClip = "pixerex-dual-header-second-clip";
                
            if( 'yes' === settings.pixerex_dual_header_first_stroke )
                firstStroke = "stroke"; 

            if( 'yes' === settings.pixerex_dual_header_second_stroke )
                secondStroke = "stroke";

            var firstGrad = 'yes' === settings.pixerex_dual_header_first_animated  ? ' gradient' : '',

                secondGrad = 'yes' === settings.pixerex_dual_header_second_animated ? ' gradient' : '';
            
                view.addRenderAttribute('first_title', 'class', ['pixerex-dual-header-first-header', firstClip, firstGrad, firstStroke ] );
                view.addRenderAttribute('second_title', 'class', ['pixerex-dual-header-second-header', secondClip, secondGrad, secondStroke ] );
        
            if( 'yes' == settings.pixerex_dual_header_link_switcher && 'link' == settings.pixerex_dual_heading_link_selection ) {
                var link = settings.pixerex_dual_heading_existing_link;
            } else if( 'yes' == settings.pixerex_dual_header_link_switcher && 'url' == settings.pixerex_dual_heading_link_selection ){
                var link = settings.pixerex_dual_heading_link.url;
            }
        
        #>
        
        <div class="pixerex-dual-header-container">
            <# if( 'yes' == settings.pixerex_dual_header_link_switcher && ( '' != settings.pixerex_dual_heading_link.url || '' != settings.pixerex_dual_heading_existing_link ) ) { #>
                <a href="{{ link }}">
            <# } #>
            <div class="pixerex-dual-header-first-container">
                <{{{firstTag}}} {{{ view.getRenderAttributeString('first_title') }}}>
                    <span class="pixerex-dual-header-first-span">{{{ firstText }}}</span><span {{{ view.getRenderAttributeString('second_title') }}}>{{{ secondText }}}</span>
                </{{{firstTag}}}>
                
            </div>
            <# if( 'yes' == settings.pixerex_dual_header_link_switcher && ( '' != settings.pixerex_dual_heading_link.url || '' != settings.pixerex_dual_heading_existing_link ) ) { #>
                </a>
            <# } #>
        </div>
        
        <?php
    }
}