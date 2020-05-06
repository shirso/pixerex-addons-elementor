<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Pricing_Table extends Widget_Base {
    protected $templateInstance;

    public function getTemplateInstance() {
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }

    public function get_name() {
        return 'pixerex-addon-pricing-table';
    }

    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Pricing Table', 'pixerex-elements') );
    }

    public function get_icon() {
        return 'pa-pricing-table';
    }
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }

    public function get_categories() {
        return [ 'pixerex-elements'];
    }

    // Adding the controls fields for the pricing table widget
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        
        $this->start_controls_section('pixerex_pricing_table_icon_section',
                [
                    'label'         => __('Icon', 'pixerex-elements'),
                    'condition'     => [
                        'pixerex_pricing_table_icon_switcher'  => 'yes',
                        ]
                    ]
                );
        
        $this->add_control('pixerex_pricing_table_icon_selection_updated', 
            [
                'label'         => __('Select an Icon', 'pixerex-elements'),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_pricing_table_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        /*Title Content Section*/
        $this->start_controls_section('pixerex_pricing_table_title_section',
            [
                'label'         => __('Title', 'pixerex-elements'),
                'condition'     => [
                    'pixerex_pricing_table_title_switcher'  => 'yes',
                ]
            ]
        );
        
        $this->add_control('pixerex_pricing_table_title_text',
            [
                'label'         => __('Text', 'pixerex-elements'),
                'default'       => __('Pricing Table', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_pricing_table_title_size',
            [
                'label'         => __('HTML Tag', 'pixerex-elements'),
                'description'   => __( 'Select HTML tag for the title', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h3',
                'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'div'   => 'div',
                    'span'  => 'span',
                    'p'     => 'p',
                ],
                'label_block'   => true,
            ]
        );
        
        $this->end_controls_section();
        
        
        /*Price Content Section*/
        $this->start_controls_section('pixerex_pricing_table_price_section',
                [
                    'label'         => __('Price', 'pixerex-elements'),
                    'condition'     => [
                        'pixerex_pricing_table_price_switcher'  => 'yes',
                        ]
                    ]
                );

        /*Price Value*/ 
        $this->add_control('pixerex_pricing_table_slashed_price_value',
                [
                    'label'         => __('Slashed Price', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'label_block'   => true,
                ]
            );
        
        /*Price Currency*/ 
        $this->add_control('pixerex_pricing_table_price_currency',
                [
                    'label'         => __('Currency', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => '$',
                    'label_block'   => true,
                ]
                );
        
        /*Price Value*/ 
        $this->add_control('pixerex_pricing_table_price_value',
                [
                    'label'         => __('Price', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => '25',
                    'label_block'   => true,
                ]
                );
        
        /*Price Separator*/ 
        $this->add_control('pixerex_pricing_table_price_separator',
                [
                    'label'         => __('Divider', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => '/',
                    'label_block'   => true,
                ]
                );
       
        /*Price Duration*/ 
        $this->add_control('pixerex_pricing_table_price_duration',
                [
                    'label'         => __('Duration', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => 'm',
                    'label_block'   => true,
                ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_table_list_section',
            [
                'label'         => __('Feature List', 'pixerex-elements'),
                'condition'     => [
                    'pixerex_pricing_table_list_switcher'  => 'yes',
                ]
            ]
        );
        
        $repeater = new REPEATER();
        
        $repeater->add_control('pixerex_pricing_list_item_text',
            [
                'label'       => __( 'Text', 'pixerex-elements' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Feature Title', 'pixerex-elements'),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );
        
        $repeater->add_control('pixerex_pricing_list_item_icon_updated',
            [
                'label'             => __( 'Icon', 'pixerex-elements' ),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_pricing_list_item_icon',
                'default'           => [
					'value'     => 'fas fa-check',
					'library'   => 'fa-solid',
				],
            ]
        );

        $repeater->add_control('pixerex_pricing_table_item_tooltip',
            [
                'label'         => __('Tooltip', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control('pixerex_pricing_table_item_tooltip_text',
            [
                'label'         => __('Tooltip Text', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXTAREA,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                'condition'     => [
                    'pixerex_pricing_table_item_tooltip'    => 'yes'
                ]
            ]
        );
        
         $this->add_control('pixerex_fancy_text_list_items',
            [
                'label'         => __( 'Features', 'pixerex-elements' ),
                'type'          => Controls_Manager::REPEATER,
                'default'       => [
                [
                    'pixerex_pricing_list_item_icon_updated'    => [
                        'value'     => 'fas fa-check',
                        'library'   => 'fa-solid',
                    ],
                    'pixerex_pricing_list_item_text'    => __( 'List Item #1', 'pixerex-elements' ),
                ],
                [
                    'pixerex_pricing_list_item_icon_updated'    => [
                        'value'     => 'fas fa-check',
                        'library'   => 'fa-solid',
                    ],
                    'pixerex_pricing_list_item_text'    => __( 'List Item #2', 'pixerex-elements' ),
                ],
                [
                    'pixerex_pricing_list_item_icon_updated'    => [
                        'value'     => 'fas fa-check',
                        'library'   => 'fa-solid',
                    ],
                    'pixerex_pricing_list_item_text'    => __( 'List Item #3', 'pixerex-elements' ),
                ],
                ],
                'fields'        => array_values( $repeater->get_controls() ),
                'title_field'   => '{{{ elementor.helpers.renderIcon( this, pixerex_pricing_list_item_icon_updated, {}, "i", "panel" ) || \'<i class="{{ pixerex_pricing_list_item_icon }}" aria-hidden="true"></i>\' }}} {{{ pixerex_pricing_list_item_text }}}'
            ]
        );

         $this->add_responsive_control('pixerex_pricing_table_list_align',
            [
                'label'             => __( 'Alignment', 'pixerex-elements' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'left'    => [
                        'title' => __( 'Left', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors_dictionary'  => [
                    'left'      => 'flex-start',
                    'center'    => 'center',
                    'right'     => 'flex-end',
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-list li' => 'justify-content: {{VALUE}}',
                ],
                'default' => 'center',
            ]
        );
        
        $this->end_controls_section();
        
        /*Description Content Section*/
        $this->start_controls_section('pixerex_pricing_table_description_section',
                [
                    'label'         => __('Description', 'pixerex-elements'),
                    'condition'     => [
                        'pixerex_pricing_table_description_switcher'  => 'yes',
                        ]
                    ]
                );
        
        $this->add_control('pixerex_pricing_table_description_text',
            [
                'label'         => __('Description', 'pixerex-elements'),
                'type'          => Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit'
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_table_button_section',
            [
                'label'         => __('Button', 'pixerex-elements'),
                'condition'     => [
                    'pixerex_pricing_table_button_switcher'  => 'yes',
                ]
            ]
        );
        
        $this->add_control('pixerex_pricing_table_button_text',
            [
                'label'         => __('Text', 'pixerex-elements'),
                'default'       => __('Get Started' , 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
            ]
        );

        $this->add_control('pixerex_pricing_table_button_url_type', 
            [
                'label'         => __('Link Type', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'pixerex-elements'),
                    'link'  => __('Existing Page', 'pixerex-elements'),
                ],
                'default'       => 'url',
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_pricing_table_button_link',
            [
                'label'         => __('Link', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'condition'     => [
                    'pixerex_pricing_table_button_url_type'     => 'url',
                ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_pricing_table_button_link_existing_content',
            [
                'label'         => __('Existing Page', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'condition'     => [
                    'pixerex_pricing_table_button_url_type'     => 'link',
                ],
                'multiple'      => false,
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_pricing_table_button_link_target',
            [
                'label'         => __('Link Target', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'description'   => __( ' Where would you like the link be opened?', 'pixerex-elements' ),
                'options'       => [
                    'blank'  => 'Blank',
                    'parent' => 'Parent',
                    'self'   => 'Self',
                    'top'    => 'Top',
                    ],
                'default'       => 'blank' ,
                'label_block'   => true,
                ]
            );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_table_ribbon_section',
            [
                'label'         => __('Ribbon', 'pixerex-elements'),
                'condition'     => [
                    'pixerex_pricing_table_badge_switcher'  => 'yes',
                ]
            ]
        );
        
        $this->add_control('ribbon_type',
            [
                'label'         => __('Type', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'triangle'      => __('Triangle', 'pixerex-elements'),
                    'circle'        => __('Circle', 'pixerex-elements'),
                    'stripe'        => __('Stripe', 'pixerex-elements'),
                    'flag'          => __('Flag', 'pixerex-elements'),
                ],
                'default'       => 'triangle'
            ]
        );
        
        $this->add_control('pixerex_pricing_table_badge_text',
            [
                'label'         => __('Text', 'pixerex-elements'),
                'default'       => __('NEW', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_table_badge_left_size', 
            [
                'label'     => __('Size', 'pixerex-elements'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-badge-triangle.pixerex-badge-left .corner' => 'border-top-width: {{SIZE}}px; border-bottom-width: {{SIZE}}px; border-right-width: {{SIZE}}px;'
                ],
                'condition' => [
                    'ribbon_type'                           => 'triangle',
                    'pixerex_pricing_table_badge_position'  => 'left'
                ]
            ]
        );
                
        $this->add_responsive_control('pixerex_pricing_table_badge_right_size', 
            [
                'label'     => __('Size', 'pixerex-elements'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-badge-triangle.pixerex-badge-right .corner' => 'border-right-width: {{SIZE}}px; border-bottom-width: {{SIZE}}px; border-left-width: {{SIZE}}px;'
                ],
                'condition' => [
                    'ribbon_type'                           => 'triangle',
                    'pixerex_pricing_table_badge_position'  => 'right'
                ]
            ]
        );
        
        $this->add_responsive_control('circle_ribbon_size', 
            [
                'label'     => __('Size', 'pixerex-elements'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-badge-circle' => 'min-width: {{SIZE}}em; min-height: {{SIZE}}em; line-height: {{SIZE}}'
                ],
                'condition' => [
                    'ribbon_type'   => 'circle'
                ]
            ]
        );
       
        $this->add_control('pixerex_pricing_table_badge_position',
			[
				'label'       => __( 'Position', 'pixerex-elements' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'options'     => [
					'left'  => [
						'title' => __( 'Left', 'pixerex-elements' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'pixerex-elements' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => 'right',
                'condition'     => [
                    'ribbon_type!'  => 'flag'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_pricing_table_badge_right_right', 
            [
                'label'     => __('Horizontal Offset', 'pixerex-elements'),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em', '%' ],
                'range'     => [
                    'px'=> [
                        'min'   => 1,
                        'max'   => 170,
                    ],
                    'em'=> [
                        'min'   => 1,
                        'max'   => 30,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-badge-right .corner span' => 'right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pixerex-badge-circle' => 'right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'ribbon_type!'                          => [ 'stripe', 'flag' ],
                    'pixerex_pricing_table_badge_position'  => 'right'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_table_badge_right_left', 
            [
                'label'     => __('Horizontal Offset', 'pixerex-elements'),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em', '%' ],
                'range'     => [
                    'px'=> [
                        'min'   => 1,
                        'max'   => 170,
                    ],
                    'em'=> [
                        'min'   => 1,
                        'max'   => 30,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-badge-left .corner span' => 'left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pixerex-badge-circle' => 'left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'ribbon_type!'                          => [ 'stripe', 'flag' ],
                    'pixerex_pricing_table_badge_position'  => 'left'
                ]
            ]
        ); 
        
        $this->add_responsive_control('pixerex_pricing_table_badge_right_top', 
            [
                'label'     => __('Vertical Offset', 'pixerex-elements'),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em', '%'],
                'range'     => [
                    'px'=> [
                        'min'   => 1,
                        'max'   => 200,
                    ],
                    'em'=> [
                        'min'   => 1,
                        'max'   => 20,
                    ]
                ],
                'condition' => [
                    'ribbon_type!'  => 'stripe'
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-pricing-badge-container .corner span' => 'top: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pixerex-badge-circle , .pixerex-badge-flag .corner' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_table_title',
            [
                'label'         => __('Display Options', 'pixerex-elements'),
            ]
        );
    
        $this->add_control('pixerex_pricing_table_icon_switcher',
            [
                'label'         => __('Icon', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('pixerex_pricing_table_title_switcher',
            [
                'label'         => __('Title', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_pricing_table_price_switcher',
            [
                'label'         => __('Price', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_pricing_table_list_switcher',
            [
                'label'         => __('Features', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_pricing_table_description_switcher',
            [
                'label'         => __('Description', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('pixerex_pricing_table_button_switcher',
            [
                'label'         => __('Button', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_pricing_table_badge_switcher',
            [
                'label'         => __('Ribbon', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_icon_style_settings',
            [
                'label'         => __('Icon', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_pricing_table_icon_switcher'  => 'yes',
                ]
            ]
        );
        
        $this->add_control('pixerex_pricing_icon_color',
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-icon-container i'  => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control('pixerex_pricing_icon_size',
            [
                'label'         => __('Size', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 25,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-icon-container i' => 'font-size: {{SIZE}}px',
                    '{{WRAPPER}} .pixerex-pricing-icon-container svg' => 'width: {{SIZE}}px; height: {{SIZE}}px'
                ]
            ]
        );
        
        $this->add_control('pixerex_pricing_icon_back_color',
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-icon-container i'  => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_icon_inner_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px','em'],
                'default'       => [
                    'size'  => 10,
                    'unit'  => 'px'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-icon-container i' => 'padding: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_pricing_icon_inner_border',
                'selector'      => '{{WRAPPER}} .pixerex-pricing-icon-container i',
            ]
        );
        
        $this->add_control('pixerex_pricing_icon_inner_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' , 'em'],
                'default'       => [
                    'size'  => 100,
                    'unit'  => 'px'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-icon-container i' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator'     => 'after'
            ]
        );
        
        $this->add_control('pixerex_pricing_icon_container_heading',
            [
                'label'         => __('Container', 'pixerex-elements'),
                'type'          => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_pricing_table_icon_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .pixerex-pricing-icon-container',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_pricing_icon_border',
                'selector'      => '{{WRAPPER}} .pixerex-pricing-icon-container',
            ]
        );
        
        $this->add_control('pixerex_pricing_icon_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-icon-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_icon_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'default'       => [
                    'top'   => 50,
                    'right' => 0,
                    'bottom'=> 20,
                    'left'  => 0,
                    'unit'  => 'px',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-icon-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
        
        /*Icon Padding*/
        $this->add_responsive_control('pixerex_pricing_icon_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 0,
                        'right' => 0,
                        'bottom'=> 0,
                        'left'  => 0,
                        'unit'  => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-icon-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
          
        /*End Icon Style Settings */
        $this->end_controls_section();
        
        /*Start Title Style Settings */
        $this->start_controls_section('pixerex_pricing_title_style_settings',
                [
                    'label'         => __('Title', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pixerex_pricing_table_title_switcher'  => 'yes',
                        ]
                ]
                );
        
        /*Title Color*/
        $this->add_control('pixerex_pricing_title_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-table-title'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        /*Title Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'title_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-table-title',
                ]
                );
        
        /*Title Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_pricing_table_title_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-pricing-table-title',
                    ]
                );
        
        /*Title Margin*/
        $this->add_responsive_control('pixerex_pricing_title_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 0,
                        'right' => 0,
                        'bottom'=> 0,
                        'left'  => 0,
                        'unit'  => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-table-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
        
        /*Title Padding*/
        $this->add_responsive_control('pixerex_pricing_title_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 0,
                        'right' => 0,
                        'bottom'=> 20,
                        'left'  => 0,
                        'unit'  => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-table-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
          
        /*End Title Style Settings */
        $this->end_controls_section();
        
        /*Start Price Style Settings */
        $this->start_controls_section('pixerex_pricing_price_style_settings',
                [
                    'label'         => __('Price', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pixerex_pricing_table_price_switcher'  => 'yes',
                        ]
                ]
                );

        $this->add_control('pixerex_pricing_slashed_price_heading',
                [
                    'label'         => __('Slashed Price', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Slashed Price Color*/
        $this->add_control('pixerex_pricing_slashed_price_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-slashed-price-value'  => 'color: {{VALUE}};'
                        ],
                    ]
                );
        
        /*Slashed Price Typo*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'slashed_price_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-slashed-price-value',
                    ]
                );
        
        /*Slashed Price Margin*/
        $this->add_responsive_control('pixerex_pricing_slashed_price_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing--slashed-price-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('pixerex_pricing_currency_heading',
                [
                    'label'         => __('Currency', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
       
        /*Currency Color*/
        $this->add_control('pixerex_pricing_currency_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-currency'  => 'color: {{VALUE}};'
                        ],
                    ]
                );
        
        /*Currency Typo*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [   
                    'label'         => __('Typography', 'pixerex-elements'),
                    'name'          => 'currency_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-currency',
                    ]
                );
        
        $this->add_responsive_control('pixerex_pricing_currency_align',
                [
                    'label'         => __( 'Vertical Align', 'pixerex-elements' ),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'top'      => [
                            'title'=> __( 'Top', 'pixerex-elements' ),
                            'icon' => 'fa fa-long-arrow-up',
                            ],
                        'unset'    => [
                            'title'=> __( 'Unset', 'pixerex-elements' ),
                            'icon' => 'fa fa-align-justify',
                            ],
                        'bottom'     => [
                            'title'=> __( 'Bottom', 'pixerex-elements' ),
                            'icon' => 'fa fa-long-arrow-down',
                            ],
                        ],
                    'default'       => 'unset',
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-currency' => 'vertical-align: {{VALUE}};',
                        ],
                    'label_block'   => false
                    ]
                );
        
        $this->add_responsive_control('pixerex_pricing_currency_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-price-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'separator'     => 'after'
                ]
            ]      
        );
        
        
        $this->add_control('pixerex_pricing_price_heading',
                [
                    'label'         => __('Price', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Price Color*/
        $this->add_control('pixerex_pricing_price_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-value'  => 'color: {{VALUE}};'
                        ],
                    'separator'     => 'before'
                    ]
                );
        
        /*Price Typo*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'label'         => __('Typography', 'pixerex-elements'),
                    'name'          => 'price_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-value',
                    ]
                );
        
        $this->add_responsive_control('pixerex_pricing_price_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-price-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('pixerex_pricing_sep_heading',
                [
                    'label'         => __('Divider', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Separator Color*/
        $this->add_control('pixerex_pricing_sep_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-separator'  => 'color: {{VALUE}};'
                        ],
                    'separator'     => 'before'
                    ]
                );
        
        /*Separator Typo*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'label'         => __('Typography', 'pixerex-elements'),
                    'name'          => 'separator_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-separator',
                ]
            );
        
        $this->add_responsive_control('pixerex_pricing_sep_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 0,
                        'right' => 0,
                        'bottom'=> 20,
                        'left'  => -15,
                        'unit'  => 'px',
                    ],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-price-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('pixerex_pricing_dur_heading',
                [
                    'label'         => __('Duration', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Duration Color*/
        $this->add_control('pixerex_pricing_dur_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-duration'  => 'color: {{VALUE}};'
                        ],
                    'separator'     => 'before'
                    ]
                );
        
        /*Duration Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'label'         => __('Typography', 'pixerex-elements'),
                    'name'          => 'duration_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-duration',
                ]
            );
        
        $this->add_responsive_control('pixerex_pricing_dur_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-price-duration' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'separator'     => 'after'
                ]
            ]      
        );
        
        $this->add_control('pixerex_pricing_price_container_heading',
                [
                    'label'         => __('Container', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Price Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_pricing_table_price_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-pricing-price-container',
                    ]
                );
        
        /*Price Margin*/
        $this->add_responsive_control('pixerex_pricing_price_container_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'default'           => [
                        'top'       => 16,
                        'right'     => 0,
                        'bottom'    => 16,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-price-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        /*Price Padding*/
        $this->add_responsive_control('pixerex_pricing_price_padding',
                [
                    'label'             => __('Padding', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-price-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_list_style_settings',
                [
                    'label'         => __('Features', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pixerex_pricing_table_list_switcher'  => 'yes',
                        ]
                ]
                );
        
        $this->add_control('pixerex_pricing_features_text_heading',
                [
                    'label'         => __('Text', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        $this->add_control('pixerex_pricing_list_text_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list .pixerex-pricing-list-span'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'list_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-list .pixerex-pricing-list-span',
                ]
                );
        
        $this->add_control('pixerex_pricing_features_icon_heading',
                [
                    'label'         => __('Icon', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Button Color*/
        $this->add_control('pixerex_pricing_list_icon_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list i'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_responsive_control('pixerex_pricing_list_icon_size',
                [
                    'label'         => __('Size', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list i' => 'font-size: {{SIZE}}px',
                        '{{WRAPPER}} .pixerex-pricing-list svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                    ]
                ]
                );
        
        $this->add_responsive_control('pixerex_pricing_list_icon_spacing',
                [
                    'label'         => __('Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'default'       => [
                        'size'  => 5
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list i' => 'margin-right: {{SIZE}}px',
                    ],
                ]
                );
        
        $this->add_responsive_control('pixerex_pricing_list_item_margin',
                [
                    'label'         => __('Vertical Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list li' => 'margin-bottom: {{SIZE}}px;'
                    ],
                    'separator'     => 'after'
                ]);
        
        $this->add_control('pixerex_pricing_features_container_heading',
                [
                    'label'         => __('Container', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_pricing_list_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-pricing-list-container',
                    ]
                );
        
        /*List Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_pricing_list_border',
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-list-container',
                ]
                );
        
        /*List Border Radius*/
        $this->add_control('pixerex_pricing_list_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*List Margin*/
        $this->add_responsive_control('pixerex_pricing_list_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'           => [
                        'top'       => 30,
                        'right'     => 0,
                        'bottom'    => 30,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*List Padding*/
        $this->add_responsive_control('pixerex_pricing_list_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-list-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_section();

        $this->start_controls_section('tooltips_style',
            [
                'label'         => __('Tooltips', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_pricing_table_list_switcher'  => 'yes',
                ]
            ]
        );

        $this->add_responsive_control('tooltips_align',
            [
                'label'             => __( 'Alignment', 'pixerex-elements' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'left'    => [
                        'title' => __( 'Left', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-list-tooltip' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control('tooltips_width',
            [
                'label'         => __('Width', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 1,
                        'min'   => 400,
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-list-tooltip' => 'min-width: {{SIZE}}px;'
                ]
            ]
        );

        $this->add_control('tooltips_color',
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-list-tooltip'  => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'tooltips_typo',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-pricing-list-tooltip',
            ]
        );

        $this->add_control('tooltips_background_color',
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-list-tooltip'  => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control('tooltips_border_color',
            [
                'label'         => __('Border Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .list-item-tooltip'  => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
        
        /*Start Description Style Settings */
        $this->start_controls_section('pixerex_pricing_description_style_settings',
                [
                    'label'         => __('Description', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pixerex_pricing_table_description_switcher'  => 'yes',
                        ]
                ]
                );
        
        $this->add_control('pixerex_pricing_desc_text_heading',
                [
                    'label'         => __('Text', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Description Color*/
        $this->add_control('pixerex_pricing_desc_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-description-container'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        /*Description Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'description_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-description-container',
                ]
            );
        
        $this->add_control('pixerex_pricing_desc_container_heading',
                [
                    'label'         => __('Container', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Description Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_pricing_table_desc_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-pricing-description-container',
                    ]
                );
        
        /*Description Margin*/
        $this->add_responsive_control('pixerex_pricing_desc_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'default'           => [
                        'top'       => 16,
                        'right'     => 0,
                        'bottom'    => 16,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-description-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        /*Description Padding*/
        $this->add_responsive_control('pixerex_pricing_desc_padding',
                [
                    'label'             => __('Padding', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pixerex-pricing-description-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        /*End Description Style Settings */
        $this->end_controls_section();
        
        /*Start Button Style Settings */
        $this->start_controls_section('pixerex_pricing_button_style_settings',
                [
                    'label'         => __('Button', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pixerex_pricing_table_button_switcher'  => 'yes',
                        ]
                ]
                );
        
        /*Button Color*/
        $this->add_control('pixerex_pricing_button_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-button'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_control('pixerex_pricing_button_hover_color',
                [
                    'label'         => __('Hover Text Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-button:hover'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        /*Button Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'button_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-button',
                ]
                );
        
        $this->start_controls_tabs('pixerex_pricing_table_button_style_tabs');
        
        $this->start_controls_tab('pixerex_pricing_table_button_style_normal',
                [
                    'label'         => __('Normal', 'pixerex-elements'),
                ]
                );
        
        /*Button Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_pricing_table_button_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-pricing-price-button',
                    ]
                );
        
        /*Button Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_pricing_table_button_border',
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-button',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pixerex_pricing_table_box_button_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-button' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Shadow','pixerex-elements'),
                    'name'          => 'pixerex_pricing_table_button_box_shadow',
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-button',
                ]
                );
        
        /*Button Margin*/
        $this->add_responsive_control('pixerex_pricing_button_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Button Padding*/
        $this->add_responsive_control('pixerex_pricing_button_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'           => [
                        'top'       => 20,
                        'right'     => 0,
                        'bottom'    => 20,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();

        $this->start_controls_tab('pixerex_pricing_table_button_style_hover',
        [
            'label'         => __('Hover', 'pixerex-elements'),
        ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_pricing_table_button_background_hover',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-pricing-price-button:hover',
                    ]
                );
        
        
        /*Button Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_pricing_table_button_border_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-pricing-price-button:hover',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pixerex_pricing_table_button_border_radius_hover',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em' , '%' ],                    
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-price-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-elements'),
                'name'          => 'pixerex_pricing_table_button_shadow_hover',
                'selector'      => '{{WRAPPER}} .pixerex-pricing-price-button:hover',
            ]
        );
        
        /*Button Margin*/
        $this->add_responsive_control('pixerex_pricing_button_margin_hover',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-price-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_button_padding_hover',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'default'           => [
                        'top'       => 20,
                        'right'     => 0,
                        'bottom'    => 20,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-pricing-price-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_table_badge_style',
            [
                'label'         => __('Ribbon', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_pricing_table_badge_switcher'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_pricing_badge_text_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-badge-container .corner span'  => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'badge_text_typo',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-pricing-badge-container .corner span',
            ]
        );
        
        $this->add_control('pixerex_pricing_badge_left_color',
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-badge-triangle.pixerex-badge-left .corner'  => 'border-top-color: {{VALUE}}',
                    '{{WRAPPER}} .pixerex-badge-triangle.pixerex-badge-right .corner'  => 'border-right-color: {{VALUE}}'
                ],
                'condition'     => [
                    'ribbon_type'   => 'triangle'
                ]
            ]
        );
        
        $this->add_control('ribbon_background',
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-badge-circle, .pixerex-badge-stripe .corner, .pixerex-badge-flag .corner'  => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .pixerex-badge-flag .corner::before'  => 'border-left: 8px solid {{VALUE}}'
                ],
                'condition'     => [
                    'ribbon_type!'   => 'triangle'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'ribbon_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-badge-circle, {{WRAPPER}} .pixerex-badge-stripe .corner, {{WRAPPER}} .pixerex-badge-flag .corner',
                'condition'     => [
                    'ribbon_type!'   => 'triangle'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_pricing_box_style_settings',
            [
                'label'         => __('Box Settings', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs('pixerex_pricing_table_box_style_tabs');
        
        $this->start_controls_tab('pixerex_pricing_table_box_style_normal',
            [
                'label'         => __('Normal', 'pixerex-elements'),
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_pricing_table_box_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .pixerex-pricing-table-container',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_pricing_table_box_border',
                'selector'      => '{{WRAPPER}} .pixerex-pricing-table-container',
            ]
        );
        
        $this->add_control('pixerex_pricing_table_box_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-table-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-elements'),
                'name'          => 'pixerex_pricing_table_box_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-pricing-table-container',
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_box_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-table-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_box_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'default'       => [
                    'top'   => 40,
                    'right' => 0,
                    'bottom'=> 0,
                    'left'  => 0,
                    'unit'  => 'px',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-table-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab('pixerex_pricing_table_box_style_hover',
            [
                'label'         => __('Hover', 'pixerex-elements'),
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_pricing_table_box_background_hover',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .pixerex-pricing-table-container:hover',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_pricing_table_box_border_hover',
                'selector'      => '{{WRAPPER}} .pixerex-pricing-table-container:hover',
            ]
        );
        
        $this->add_control('pixerex_pricing_table_box_border_radius_hover',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em' , '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-table-container:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-elements'),
                'name'          => 'pixerex_pricing_table_box_shadow_hover',
                'selector'      => '{{WRAPPER}} .pixerex-pricing-table-container:hover',
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_box_margin_hover',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-table-container:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_pricing_box_padding_hover',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'default'       => [
                    'top'   => 40,
                    'right' => 0,
                    'bottom'=> 0,
                    'left'  => 0,
                    'unit'  => 'px',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-pricing-table-container:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
        
        
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes('title_text');
        
        $this->add_inline_editing_attributes('description_text', 'advanced');
        
        $this->add_inline_editing_attributes('button_text');
        
        $title_tag = $settings['pixerex_pricing_table_title_size'];
        
        $link_type = $settings['pixerex_pricing_table_button_url_type'];
        
        if( 'yes' === $settings['pixerex_pricing_table_badge_switcher'] ) {
            $badge_position = 'pixerex-badge-' .  $settings['pixerex_pricing_table_badge_position'];
        
            $badge_style = 'pixerex-badge-' .  $settings['ribbon_type'];
            
            $this->add_inline_editing_attributes('pixerex_pricing_table_badge_text');
            
            if( 'pixerex-badge-flag' === $badge_style )
                $badge_position   = '';
        }
        
        if( $link_type == 'link' ) {
            $link_url = get_permalink($settings['pixerex_pricing_table_button_link_existing_content']);
        } elseif ( $link_type == 'url' ) {
            $link_url = $settings['pixerex_pricing_table_button_link'];
        }
        
        if( 'yes' === $settings['pixerex_pricing_table_icon_switcher'] ) {
            if ( ! empty ( $settings['pixerex_pricing_table_icon_selection'] ) ) {
                $this->add_render_attribute( 'icon', 'class', $settings['pixerex_pricing_table_icon_selection'] );
                $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
            }
        
            $migrated = isset( $settings['__fa4_migrated']['pixerex_pricing_table_icon_selection_updated'] );
            $is_new = empty( $settings['pixerex_pricing_table_icon_selection'] ) && Icons_Manager::is_migration_allowed();
        }
        
    ?>
    
    <div class="pixerex-pricing-table-container">
        <?php if( 'yes' === $settings['pixerex_pricing_table_badge_switcher'] ) : ?>
            <div class="pixerex-pricing-badge-container <?php echo esc_attr( $badge_position . ' ' . $badge_style ); ?>">
                <div class="corner"><span <?php echo $this->get_render_attribute_string('pixerex_pricing_table_badge_text'); ?>><?php echo $settings['pixerex_pricing_table_badge_text']; ?></span></div>
            </div>
        <?php endif;
        if( $settings['pixerex_pricing_table_icon_switcher'] === 'yes' ) : ?>
            <div class="pixerex-pricing-icon-container">
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $settings['pixerex_pricing_table_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                else: ?>
                    <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                <?php endif; ?>
            </div>
        <?php endif;
            if( $settings['pixerex_pricing_table_title_switcher'] === 'yes') : ?>
        <<?php echo $title_tag; ?> class="pixerex-pricing-table-title">
            <span <?php echo $this->get_render_attribute_string('title_text'); ?>><?php echo $settings['pixerex_pricing_table_title_text'];?></span>
            </<?php echo $title_tag;?>>
        <?php endif; ?>
        <?php if($settings['pixerex_pricing_table_price_switcher'] === 'yes') : ?>
        <div class="pixerex-pricing-price-container">
            <strike class="pixerex-pricing-slashed-price-value">
                <?php echo $settings['pixerex_pricing_table_slashed_price_value']; ?>
            </strike>
            <span class="pixerex-pricing-price-currency">
                <?php echo $settings['pixerex_pricing_table_price_currency']; ?>
            </span>
            <span class="pixerex-pricing-price-value">
                <?php echo $settings['pixerex_pricing_table_price_value']; ?>
            </span>    
            <span class="pixerex-pricing-price-separator">
                <?php echo $settings['pixerex_pricing_table_price_separator']; ?>    
            </span>
            <span class="pixerex-pricing-price-duration">
                <?php echo $settings['pixerex_pricing_table_price_duration']; ?>
            </span>
        </div>
        <?php endif;
        if( 'yes' === $settings['pixerex_pricing_table_list_switcher'] ) : ?>
            <div class="pixerex-pricing-list-container">
                <ul class="pixerex-pricing-list">
                    <?php foreach( $settings['pixerex_fancy_text_list_items'] as $item ):
                        $icon_migrated = isset( $item['__fa4_migrated']['pixerex_pricing_list_item_icon_updated'] );
                        $icon_new = empty( $item['pixerex_pricing_list_item_icon'] ) && Icons_Manager::is_migration_allowed();
                    ?>
                        <li>
                            <?php if ( $icon_new || $icon_migrated ) :
                                Icons_Manager::render_icon( $item['pixerex_pricing_list_item_icon_updated'], [ 'aria-hidden' => 'true' ] );
                            else: ?>
                                <i class="<?php echo $item['pixerex_pricing_list_item_icon']; ?>"></i>
                            <?php endif;
                            if ( ! empty( $item['pixerex_pricing_list_item_text'] ) ) :
                                $item_class = 'yes' === $item['pixerex_pricing_table_item_tooltip'] ? 'list-item-tooltip' : '';
                            ?>
                                <span class="pixerex-pricing-list-span <?php echo $item_class; ?>"><?php echo esc_html( $item['pixerex_pricing_list_item_text'] );
                                if ( 'yes' === $item['pixerex_pricing_table_item_tooltip'] && ! empty( $item['pixerex_pricing_table_item_tooltip_text'] ) ) : ?>
                                        <span class="pixerex-pricing-list-tooltip"><?php echo esc_html( $item['pixerex_pricing_table_item_tooltip_text'] ); ?></span>
                                    <?php endif; ?>    
                                </span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if($settings['pixerex_pricing_table_description_switcher'] == 'yes') : ?>
        <div class="pixerex-pricing-description-container">
            <div <?php echo $this->get_render_attribute_string('description_text'); ?>>
            <?php echo $settings['pixerex_pricing_table_description_text']; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if($settings['pixerex_pricing_table_button_switcher'] == 'yes') : ?>
        <div class="pixerex-pricing-button-container">
            <a class="pixerex-pricing-price-button" target="_<?php echo esc_attr( $settings['pixerex_pricing_table_button_link_target'] ); ?>" href="<?php echo esc_url( $link_url ); ?>">
                <span <?php echo $this->get_render_attribute_string('button_text'); ?>><?php echo $settings['pixerex_pricing_table_button_text']; ?></span>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <?php
    }
    
    protected function _content_template() {
        ?>
        <#
            
        view.addInlineEditingAttributes('title_text');
        
        view.addInlineEditingAttributes('description_text', 'advanced');
        
        view.addInlineEditingAttributes('button_text');
        
        var titleTag = settings.pixerex_pricing_table_title_size,
            linkType = settings.pixerex_pricing_table_button_url_type,
            linkURL = 'link' === linkType ? settings.pixerex_pricing_table_button_link_existing_content : settings.pixerex_pricing_table_button_link;

        if( 'yes' === settings.pixerex_pricing_table_icon_switcher ) {
            var iconHTML = elementor.helpers.renderIcon( view, settings.pixerex_pricing_table_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                migrated = elementor.helpers.isIconMigrated( settings, 'pixerex_pricing_table_icon_selection_updated' );
        }
        
        if( 'yes' === settings.pixerex_pricing_table_badge_switcher ) {
            var badgePosition   = 'pixerex-badge-'  + settings.pixerex_pricing_table_badge_position,
                badgeStyle      = 'pixerex-badge-'  + settings.ribbon_type;
                
            view.addInlineEditingAttributes('pixerex_pricing_table_badge_text');
            
            if( 'pixerex-badge-flag' === badgeStyle )
                badgePosition   = '';
            
        }
        
        #>
        
        <div class="pixerex-pricing-table-container">
            <# if('yes' === settings.pixerex_pricing_table_badge_switcher ) { #>
                <div class="pixerex-pricing-badge-container {{ badgePosition }} {{ badgeStyle }}">
                    <div class="corner"><span {{{ view.getRenderAttributeString('pixerex_pricing_table_badge_text') }}}>{{{ settings.pixerex_pricing_table_badge_text }}}</span></div>
                </div>
            <# } #>
            <# if( 'yes' === settings.pixerex_pricing_table_icon_switcher ) { #>
                <div class="pixerex-pricing-icon-container">
                    <# if ( iconHTML && iconHTML.rendered && ( ! settings.pixerex_pricing_table_icon_selection || migrated ) ) { #>
                        {{{ iconHTML.value }}}
                    <# } else { #>
                        <i class="{{ settings.pixerex_pricing_table_icon_selection }}" aria-hidden="true"></i>
                    <# } #>
                </div>
            <# } #>
            <# if('yes' === settings.pixerex_pricing_table_title_switcher ) { #>
                <{{{titleTag}}} class="pixerex-pricing-table-title"><span {{{ view.getRenderAttributeString('title_text') }}}>{{{ settings.pixerex_pricing_table_title_text }}}</span></{{{titleTag}}}>
            <# } #>
            
            <# if('yes' === settings.pixerex_pricing_table_price_switcher ) { #>
                <div class="pixerex-pricing-price-container">
                        <strike class="pixerex-pricing-slashed-price-value">{{{ settings.pixerex_pricing_table_slashed_price_value }}}</strike>
                        <span class="pixerex-pricing-price-currency">{{{ settings.pixerex_pricing_table_price_currency }}}</span>
                        <span class="pixerex-pricing-price-value">{{{ settings.pixerex_pricing_table_price_value }}}</span>
                        <span class="pixerex-pricing-price-separator">{{{ settings.pixerex_pricing_table_price_separator }}}</span>
                        <span class="pixerex-pricing-price-duration">{{{ settings.pixerex_pricing_table_price_duration }}}</span>
                </div>
            <# } #>
            <# if('yes' === settings.pixerex_pricing_table_list_switcher ) { #>
                <div class="pixerex-pricing-list-container">
                    <ul class="pixerex-pricing-list">
                    <# _.each( settings.pixerex_fancy_text_list_items, function( item ) {
                    
                        var listIconHTML = elementor.helpers.renderIcon( view, item.pixerex_pricing_list_item_icon_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                        listIconMigrated = elementor.helpers.isIconMigrated( item, 'pixerex_pricing_list_item_icon_updated' );
                    
                    #>
                        <li>
                            <# if ( listIconHTML && listIconHTML.rendered && ( ! item.pixerex_pricing_list_item_icon || listIconMigrated ) ) { #>
                                {{{ listIconHTML.value }}}
                            <# } else { #>
                                <i class="{{ item.pixerex_pricing_list_item_icon }}" aria-hidden="true"></i>
                            <# }
                            if ( '' !== item.pixerex_pricing_list_item_text ) { 
                                var itemClass = 'yes' === item.pixerex_pricing_table_item_tooltip ? 'list-item-tooltip' : '';
                            #>
                                <span class="pixerex-pricing-list-span {{itemClass}}">{{{ item.pixerex_pricing_list_item_text }}}
                                <# if ( 'yes' === item.pixerex_pricing_table_item_tooltip && '' !== item.pixerex_pricing_table_item_tooltip_text ) { #>
                                    <span class="pixerex-pricing-list-tooltip">{{{ item.pixerex_pricing_table_item_tooltip_text }}}</span>
                                <# } #>
                                </span>
                            <# } #>
                        </li>
                    <# } ); #>
                    </ul>
                </div>
            <# } #>
            <# if('yes' === settings.pixerex_pricing_table_description_switcher ) { #>
                <div class="pixerex-pricing-description-container">
                    <div {{{ view.getRenderAttributeString('description_text') }}}>
                        {{{ settings.pixerex_pricing_table_description_text }}}
                    </div>
                </div>
            <# } #>
            <# if('yes' === settings.pixerex_pricing_table_button_switcher ) { #>
                <div class="pixerex-pricing-button-container">
                    <a class="pixerex-pricing-price-button" target="_{{ settings.pixerex_pricing_table_button_link_target }}" href="{{ linkURL }}">
                        <span {{{ view.getRenderAttributeString('button_text') }}}>{{{ settings.pixerex_pricing_table_button_text }}}</span>
                    </a>
                </div>
            <# } #>
        </div>
        <?php
    }
}