<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Button extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-button';
    }
    
    public function check_rtl() {
        return is_rtl();
    }
    
    public function getTemplateInstance() {
		return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
	}
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }

    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Button', 'pixerex-elements') );
	}

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'pixerex-elements'];
    }

    // Adding the controls fields for the button widegt
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /*Start Button Content Section */
        $this->start_controls_section('pixerex_button_general_section',
                [
                    'label'         => __('Button', 'pixerex-elements'),
                    ]
                );
        
        $this->add_control('pixerex_button_text',
                [
                    'label'         => __('Text', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('Click Me','pixerex-elements'),
                    'label_block'   => true,
                ]
                );
        
        $this->add_control('pixerex_button_link_selection', 
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
        
        $this->add_control('pixerex_button_link',
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
                        'pixerex_button_link_selection' => 'url'
                    ]
                ]
                );
        
        $this->add_control('pixerex_button_existing_link',
                [
                    'label'         => __('Existing Page', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT2,
                    'options'       => $this->getTemplateInstance()->get_all_post(),
                    'condition'     => [
                        'pixerex_button_link_selection'     => 'link',
                    ],
                    'multiple'      => false,
                    'separator'     => 'after',
                    'label_block'   => true,
                ]
                );

        $this->add_control('pixerex_button_hover_effect', 
                [
                    'label'         => __('Hover Effect', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'none',
                    'options'       => [
                        'none'          => __('None', 'pixerex-elements'),
                        'style1'        => __('Slide', 'pixerex-elements'),
                        'style2'        => __('Shutter', 'pixerex-elements'),
                        'style3'        => __('Icon Fade', 'pixerex-elements'),
                        'style4'        => __('Icon Slide', 'pixerex-elements'),
                        'style5'        => __('In & Out', 'pixerex-elements'),
                    ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_button_style1_dir', 
            [
                'label'         => __('Slide Direction', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'bottom',
                'options'       => [
                    'bottom'       => __('Top to Bottom', 'pixerex-elements'),
                    'top'          => __('Bottom to Top', 'pixerex-elements'),
                    'left'         => __('Right to Left', 'pixerex-elements'),
                    'right'        => __('Left to Right', 'pixerex-elements'),
                ],
                'condition'     => [
                    'pixerex_button_hover_effect' => 'style1',
                ],
                'label_block'   => true,
                ]
            );
        
        $this->add_control('pixerex_button_style2_dir', 
                [
                    'label'         => __('Shutter Direction', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'shutouthor',
                    'options'       => [
                        'shutinhor'     => __('Shutter in Horizontal', 'pixerex-elements'),
                        'shutinver'     => __('Shutter in Vertical', 'pixerex-elements'),
                        'shutoutver'    => __('Shutter out Horizontal', 'pixerex-elements'),
                        'shutouthor'    => __('Shutter out Vertical', 'pixerex-elements'),
                        'scshutoutver'  => __('Scaled Shutter Vertical', 'pixerex-elements'),
                        'scshutouthor'  => __('Scaled Shutter Horizontal', 'pixerex-elements'),
                        'dshutinver'   => __('Tilted Left'),
                        'dshutinhor'   => __('Tilted Right'),
                    ],
                    'condition'     => [
                        'pixerex_button_hover_effect' => 'style2',
                    ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_button_style4_dir', 
                [
                    'label'         => __('Slide Direction', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'bottom',
                    'options'       => [
                        'top'          => __('Top', 'pixerex-elements'),
                        'bottom'       => __('Bottom', 'pixerex-elements'),
                        'left'         => __('Left', 'pixerex-elements'),
                        'right'        => __('Right', 'pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_button_hover_effect' => 'style4',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_button_style5_dir', 
                [
                    'label'         => __('Style', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'radialin',
                    'options'       => [
                        'radialin'          => __('Radial In', 'pixerex-elements'),
                        'radialout'         => __('Radial Out', 'pixerex-elements'),
                        'rectin'            => __('Rectangle In', 'pixerex-elements'),
                        'rectout'           => __('Rectangle Out', 'pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_button_hover_effect' => 'style5',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_button_icon_switcher',
                [
                    'label'         => __('Icon', 'pixerex-elements'),
                    'type'          => Controls_Manager::SWITCHER,
                    'condition'     => [
                        'pixerex_button_hover_effect!'  => 'style4'
                    ],
                    'description'   => __('Enable or disable button icon','pixerex-elements'),
                ]
                );

        $this->add_control('pixerex_button_icon_selection_updated',
            [
                'label'             => __('Icon', 'pixerex-elements'),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_button_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'condition'         => [
                    'pixerex_button_icon_switcher'  => 'yes',
                    'pixerex_button_hover_effect!'  => 'style4'
                ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_button_style4_icon_selection_updated',
            [
                'label'         => __('Icon', 'pixerex-elements'),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_button_style4_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'pixerex_button_hover_effect'  => 'style4'
                ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_button_icon_position', 
                [
                    'label'         => __('Icon Position', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'before',
                    'options'       => [
                        'before'        => __('Before', 'pixerex-elements'),
                        'after'         => __('After', 'pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_hover_effect!' => 'style4',
                    ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_responsive_control('pixerex_button_icon_before_size',
                [
                    'label'         => __('Icon Size', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_hover_effect!'  => 'style4'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-text-icon-wrapper i' => 'font-size: {{SIZE}}px',
                        '{{WRAPPER}} .pixerex-button-text-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                    ]
                ]
                );
        
        $this->add_responsive_control('pixerex_button_icon_style4_size',
                [
                    'label'         => __('Icon Size', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_hover_effect'  => 'style4'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-style4-icon-wrapper i' => 'font-size: {{SIZE}}px',
                        '{{WRAPPER}} .pixerex-button-style4-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px'
                    ]
                ]
                );
        
        if( ! $this->check_rtl() ) {
            $this->add_responsive_control('pixerex_button_icon_before_spacing',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_icon_position' => 'before',
                        'pixerex_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-text-icon-wrapper i' => 'margin-right: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        
        $this->add_responsive_control('pixerex_button_icon_after_spacing',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_icon_position' => 'after',
                        'pixerex_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-text-icon-wrapper i' => 'margin-left: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        if( $this->check_rtl() ) {
            $this->add_responsive_control('pixerex_button_icon_rtl_before_spacing',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_icon_position' => 'before',
                        'pixerex_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-text-icon-wrapper i' => 'margin-left: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        
        $this->add_responsive_control('pixerex_button_icon_rtl_after_spacing',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_icon_position' => 'after',
                        'pixerex_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-text-icon-wrapper i' => 'margin-right: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        $this->add_responsive_control('pixerex_button_icon_style3_before_transition',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_icon_position' => 'before',
                        'pixerex_button_hover_effect'  => 'style3'
                    ],
                    'range'         => [
                        'px'    => [
                            'min'   => -50,
                            'max'   => 50,
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-style3-before:hover i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
                    ],
                ]
                );
        
        $this->add_responsive_control('pixerex_button_icon_style3_after_transition',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_button_icon_switcher' => 'yes',
                        'pixerex_button_icon_position!'=> 'before',
                        'pixerex_button_hover_effect'  => 'style3'
                    ],
                    'range'         => [
                        'px'    => [
                            'min'   => -50,
                            'max'   => 50,
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button-style3-after:hover i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
                    ],
                ]
                );

        $this->add_control('pixerex_button_size', 
                [
                    'label'         => __('Size', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'lg',
                    'options'       => [
                            'sm'          => __('Small', 'pixerex-elements'),
                            'md'            => __('Medium', 'pixerex-elements'),
                            'lg'            => __('Large', 'pixerex-elements'),
                            'block'         => __('Block', 'pixerex-elements'),
                        ],
                    'label_block'   => true,
                    'separator'     => 'before',
                    ]
                );
        
        $this->add_responsive_control('pixerex_button_align',
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
                    '{{WRAPPER}} .pixerex-button-container' => 'text-align: {{VALUE}}',
                ],
				'default' => 'center',
			]
		);
        
        $this->add_control('pixerex_button_event_switcher', 
                [
                    'label'         => __('onclick Event', 'pixerex-elements'),
                    'type'          => Controls_Manager::SWITCHER,
                    'separator'     => 'before',
                    ]
                );

        $this->add_control('pixerex_button_event_function', 
                [
                    'label'         => __('Example: myFunction();', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXTAREA,
                    'dynamic'       => [ 'active' => true ],
                    'condition'     => [
                        'pixerex_button_event_switcher' => 'yes',
                        ],
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_button_style_section',
            [
                'label'             => __('Button', 'pixerex-elements'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'pixerex_button_typo',
                'scheme'            => Scheme_Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .pixerex-button',
            ]
            );
        
        $this->start_controls_tabs('pixerex_button_style_tabs');
        
        $this->start_controls_tab('pixerex_button_style_normal',
            [
                'label'             => __('Normal', 'pixerex-elements'),
            ]
            );
        
        $this->add_control('pixerex_button_text_color_normal',
            [
                'label'             => __('Text Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-button .pixerex-button-text-icon-wrapper span'   => 'color: {{VALUE}};',
                ]
            ]);
        
        $this->add_control('pixerex_button_icon_color_normal',
            [
                'label'             => __('Icon Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_button_icon_switcher'  => 'yes',
                    'pixerex_button_hover_effect!'  => ['style3','style4']
                ]
            ]);
        
        $this->add_control('pixerex_button_background_normal',
                [
                    'label'             => __('Background Color', 'pixerex-elements'),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'      => [
                        '{{WRAPPER}} .pixerex-button, {{WRAPPER}} .pixerex-button.pixerex-button-style2-shutinhor:before , {{WRAPPER}} .pixerex-button.pixerex-button-style2-shutinver:before , {{WRAPPER}} .pixerex-button-style5-radialin:before , {{WRAPPER}} .pixerex-button-style5-rectin:before'  => 'background-color: {{VALUE}};',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_button_border_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-button',
                ]
                );
        
        $this->add_control('pixerex_button_border_radius_normal',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Icon Shadow','pixerex-elements'),
                    'name'          => 'pixerex_button_icon_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-button-text-icon-wrapper i',
                    'condition'         => [
                            'pixerex_button_icon_switcher'  => 'yes',
                            'pixerex_button_hover_effect!'  => ['style3', 'style4']
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Text Shadow','pixerex-elements'),
                    'name'          => 'pixerex_button_text_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-button-text-icon-wrapper span',
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Button Shadow','pixerex-elements'),
                    'name'          => 'pixerex_button_box_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-button',
                ]
                );
        
        $this->add_responsive_control('pixerex_button_margin_normal',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('pixerex_button_padding_normal',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_button_style_hover',
            [
                'label'             => __('Hover', 'pixerex-elements'),
            ]
            );
        
        $this->add_control('pixerex_button_text_color_hover',
            [
                'label'             => __('Text Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-button:hover .pixerex-button-text-icon-wrapper span'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_button_hover_effect!'   => 'style4'
                ]
            ]);
        
        $this->add_control('pixerex_button_icon_color_hover',
            [
                'label'             => __('Icon Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-button:hover .pixerex-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_button_icon_switcher'  => 'yes',
                    'pixerex_button_hover_effect!'  => 'style4',
                ]
            ]);
        
        $this->add_control('pixerex_button_style4_icon_color',
            [
                'label'             => __('Icon Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-button:hover .pixerex-button-style4-icon-wrapper'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_button_hover_effect'  => 'style4'
                ]
            ]);
        
        $this->add_control('pixerex_button_background_hover',
                [
                    'label'             => __('Background Color', 'pixerex-elements'),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_3
                    ],
                    'selectors'          => [
                        ''
                    . '{{WRAPPER}} .pixerex-button-none:hover ,{{WRAPPER}} .pixerex-button-style1-bottom:before, {{WRAPPER}} .pixerex-button-style1-top:before, {{WRAPPER}} .pixerex-button-style1-right:before, {{WRAPPER}} .pixerex-button-style1-left:before, {{WRAPPER}} .pixerex-button-style2-shutouthor:before, {{WRAPPER}} .pixerex-button-style2-shutoutver:before, {{WRAPPER}} .pixerex-button-style2-shutinhor, {{WRAPPER}} .pixerex-button-style2-shutinver , {{WRAPPER}} .pixerex-button-style2-dshutinhor:before , {{WRAPPER}} .pixerex-button-style2-dshutinver:before , {{WRAPPER}} .pixerex-button-style2-scshutouthor:before , {{WRAPPER}} .pixerex-button-style2-scshutoutver:before, {{WRAPPER}} .pixerex-button-style3-after:hover , {{WRAPPER}} .pixerex-button-style3-before:hover,{{WRAPPER}} .pixerex-button-style4-icon-wrapper , {{WRAPPER}} .pixerex-button-style5-radialin , {{WRAPPER}} .pixerex-button-style5-radialout:before, {{WRAPPER}} .pixerex-button-style5-rectin , {{WRAPPER}} .pixerex-button-style5-rectout:before' => 'background-color: {{VALUE}};',
                    ],
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_button_border_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-button:hover',
                ]
                );
        
        $this->add_control('pixerex_button_border_radius_hover',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Icon Shadow','pixerex-elements'),
                    'name'          => 'pixerex_button_icon_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-button:hover .pixerex-button-text-icon-wrapper i',
                    'condition'         => [
                            'pixerex_button_icon_switcher'  => 'yes',
                            'pixerex_button_hover_effect!'   => 'style4',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Icon Shadow','pixerex-elements'),
                    'name'          => 'pixerex_button_style4_icon_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-button:hover .pixerex-button-style4-icon-wrapper',
                    'condition'         => [
                        'pixerex_button_hover_effect'   => 'style4',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Text Shadow','pixerex-elements'),
                    'name'          => 'pixerex_button_text_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-button:hover .pixerex-button-text-icon-wrapper span',
                    'condition'         => [
                       'pixerex_button_hover_effect!'   => 'style4'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Button Shadow','pixerex-elements'),
                    'name'          => 'pixerex_button_box_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-button:hover',
                ]
                );
        
        $this->add_responsive_control('pixerex_button_margin_hover',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('pixerex_button_padding_hover',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
   
    /**
	 * Render Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes( 'pixerex_button_text');
        
        $button_text = $settings['pixerex_button_text'];
        
        if( $settings['pixerex_button_link_selection'] == 'url' ){
            $button_url = $settings['pixerex_button_link']['url'];
        } else {
            $button_url = get_permalink( $settings['pixerex_button_existing_link'] );
        }
        
        $button_size = 'pixerex-button-' . $settings['pixerex_button_size'];
        
        $button_event = $settings['pixerex_button_event_function'];
        
        if ( ! empty ( $settings['pixerex_button_icon_selection'] ) ) {
            $this->add_render_attribute( 'icon', 'class', $settings['pixerex_button_icon_selection'] );
            $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
        }
        
        $migrated = isset( $settings['__fa4_migrated']['pixerex_button_icon_selection_updated'] );
        $is_new = empty( $settings['pixerex_button_icon_selection'] ) && Icons_Manager::is_migration_allowed();
        
        if ( $settings['pixerex_button_hover_effect'] == 'none' ) {
            $style_dir = 'pixerex-button-none';
        } elseif( $settings['pixerex_button_hover_effect'] == 'style1' ) {
            $style_dir = 'pixerex-button-style1-' . $settings['pixerex_button_style1_dir'];
        } elseif ( $settings['pixerex_button_hover_effect'] == 'style2' ) {
            $style_dir = 'pixerex-button-style2-' . $settings['pixerex_button_style2_dir'];
        } elseif ( $settings['pixerex_button_hover_effect'] == 'style3' ) {
            $style_dir = 'pixerex-button-style3-' . $settings['pixerex_button_icon_position'];
        } elseif ( $settings['pixerex_button_hover_effect'] == 'style4' ) {
            $style_dir = 'pixerex-button-style4-' . $settings['pixerex_button_style4_dir'];
            
            if ( ! empty ( $settings['pixerex_button_style4_icon_selection'] ) ) {
                $this->add_render_attribute( 'slide_icon', 'class', $settings['pixerex_button_style4_icon_selection'] );
                $this->add_render_attribute( 'slide_icon', 'aria-hidden', 'true' );
            }
            
            $slide_migrated = isset( $settings['__fa4_migrated']['pixerex_button_style4_icon_selection_updated'] );
            $slide_is_new = empty( $settings['pixerex_button_style4_icon_selection'] ) && Icons_Manager::is_migration_allowed();
            
        } elseif ( $settings['pixerex_button_hover_effect'] == 'style5' ) {
            $style_dir = 'pixerex-button-style5-' . $settings['pixerex_button_style5_dir'];
        }
        
        $this->add_render_attribute( 'button', 'class', array(
            'pixerex-button',
            $button_size,
            $style_dir
        ));
        
        if( ! empty( $button_url ) ) {
        
            $this->add_render_attribute( 'button', 'href', $button_url );
            
            if( ! empty( $settings['pixerex_button_link']['is_external'] ) )
                $this->add_render_attribute( 'button', 'target', '_blank' );
            
            if( ! empty( $settings['pixerex_button_link']['nofollow'] ) )
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );
        }
        
        if( 'yes' === $settings['pixerex_button_event_switcher'] && ! empty( $button_event ) ) {
            $this->add_render_attribute( 'button', 'onclick', $button_event );
        }
        
    ?>

    <div class="pixerex-button-container">
        <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
            <div class="pixerex-button-text-icon-wrapper">
                <?php if( 'yes' === $settings['pixerex_button_icon_switcher'] && $settings['pixerex_button_icon_position'] === 'before' && $settings['pixerex_button_hover_effect'] !== 'style4' ) :
                    if ( $is_new || $migrated ) :
                        Icons_Manager::render_icon( $settings['pixerex_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                    else: ?>
                        <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                    <?php endif;
                endif; ?>
                <span <?php echo $this->get_render_attribute_string( 'pixerex_button_text' ); ?>><?php echo $button_text; ?></span>
                <?php if( 'yes' === $settings['pixerex_button_icon_switcher'] && $settings['pixerex_button_icon_position'] === 'after' && $settings['pixerex_button_hover_effect'] !== 'style4' ) :
                    if ( $is_new || $migrated ) :
                        Icons_Manager::render_icon( $settings['pixerex_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                    else: ?>
                        <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                    <?php endif;
                endif; ?>
            </div>
            <?php if( $settings['pixerex_button_hover_effect'] === 'style4' ) : ?>
                <div class="pixerex-button-style4-icon-wrapper <?php echo esc_attr( $settings['pixerex_button_style4_dir'] ); ?>">
                    <?php if ( $slide_is_new || $slide_migrated ) :
                        Icons_Manager::render_icon( $settings['pixerex_button_style4_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                    else: ?>
                        <i <?php echo $this->get_render_attribute_string( 'slide_icon' ); ?>></i>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </a>
    </div>

    <?php
    }
    
    protected function _content_template() {
        ?>
        <#
        
        view.addInlineEditingAttributes( 'pixerex_button_text' );
        
        var buttonText = settings.pixerex_button_text,
            buttonUrl,
            styleDir,
            slideIcon,
            buttonSize = 'pixerex-button-' + settings.pixerex_button_size,
            buttonEvent = settings.pixerex_button_event_function,
            buttonIcon = settings.pixerex_button_icon_selection;
        
        if( 'url' == settings.pixerex_button_link_selection ) {
            buttonUrl = settings.pixerex_button_link.url;
        } else {
            buttonUrl = settings.pixerex_button_existing_link;
        }
        
        if ( 'none' == settings.pixerex_button_hover_effect ) {
            styleDir = 'pixerex-button-none';
        } else if( 'style1' == settings.pixerex_button_hover_effect ) {
            styleDir = 'pixerex-button-style1-' + settings.pixerex_button_style1_dir;
        } else if ( 'style2' == settings.pixerex_button_hover_effect ){
            styleDir = 'pixerex-button-style2-' + settings.pixerex_button_style2_dir;
        } else if ( 'style3' == settings.pixerex_button_hover_effect ) {
            styleDir = 'pixerex-button-style3-' + settings.pixerex_button_icon_position;
        } else if ( 'style4' == settings.pixerex_button_hover_effect ) {
            styleDir = 'pixerex-button-style4-' + settings.pixerex_button_style4_dir;
            slideIcon = settings.pixerex_button_style4_icon_selection;
            
            var slideIconHTML = elementor.helpers.renderIcon( view, settings.pixerex_button_style4_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                slideMigrated = elementor.helpers.isIconMigrated( settings, 'pixerex_button_style4_icon_selection_updated' );
            
        } else if ( 'style5' == settings.pixerex_button_hover_effect ){
            styleDir = 'pixerex-button-style5-' + settings.pixerex_button_style5_dir;
        }
        
        var iconHTML = elementor.helpers.renderIcon( view, settings.pixerex_button_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
            migrated = elementor.helpers.isIconMigrated( settings, 'pixerex_button_icon_selection_updated' );
        
        #>
        
        <div class="pixerex-button-container">
            <a class="pixerex-button {{ buttonSize }} {{ styleDir }}" href="{{ buttonUrl }}" onclick="{{ buttonEvent }}">
                <div class="pixerex-button-text-icon-wrapper">
                    <# if( 'yes' === settings.pixerex_button_icon_switcher && 'before' == settings.pixerex_button_icon_position &&  'style4' != settings.pixerex_button_hover_effect ) {
                        if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
                            {{{ iconHTML.value }}}
                        <# } else { #>
                            <i class="{{ buttonIcon }}" aria-hidden="true"></i>
                        <# }
                    } #>
                    <span {{{ view.getRenderAttributeString('pixerex_button_text') }}}>{{{ buttonText }}}</span>
                    <# if( 'yes' === settings.pixerex_button_icon_switcher && 'after' == settings.pixerex_button_icon_position && 'style4' != settings.pixerex_button_hover_effect ) {
                        if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
                            {{{ iconHTML.value }}}
                        <# } else { #>
                            <i class="{{ buttonIcon }}" aria-hidden="true"></i>
                        <# }
                    } #>
                </div>
                <# if( 'style4' == settings.pixerex_button_hover_effect ) { #>
                    <div class="pixerex-button-style4-icon-wrapper {{ settings.pixerex_button_style4_dir }}">
                        <# if ( slideIconHTML && slideIconHTML.rendered && ( ! slideIcon || slideMigrated ) ) { #>
                            {{{ slideIconHTML.value }}}
                        <# } else { #>
                            <i class="{{ slideIcon }}" aria-hidden="true"></i>
                        <# } #>
                    </div>
                <# } #>
            </a>
        </div>
        
        <?php
    }
}