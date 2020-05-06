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
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Image_Button extends Widget_Base {
    public function get_name() {
        return 'pixerex-image-button';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Image Button', 'pixerex-elements') );
	}
    
    public function getTemplateInstance() {
		return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
	}
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }

    public function get_icon() {
        return 'pa-image-button';
    }

    public function get_categories() {
        return [ 'pixerex-elements'];
    }

    // Adding the controls fields for the image button widget
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        $this->start_controls_section('pixerex_image_button_general_section',
                [
                    'label'         => __('Button', 'pixerex-elements'),
                    ]
                );
        
        $this->add_control('pixerex_image_button_text',
                [
                    'label'         => __('Text', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('Click Me','pixerex-elements'),
                    'label_block'   => true,
                ]
                );
        
        $this->add_control('pixerex_image_button_link_selection', 
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
        
        $this->add_control('pixerex_image_button_link',
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
                        'pixerex_image_button_link_selection' => 'url'
                    ]
                ]
                );
        
        $this->add_control('pixerex_image_button_existing_link',
                [
                    'label'         => __('Existing Page', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT2,
                    'options'       => $this->getTemplateInstance()->get_all_post(),
                    'condition'     => [
                        'pixerex_image_button_link_selection'     => 'link',
                    ],
                    'multiple'      => false,
                    'separator'     => 'after',
                    'label_block'   => true,
                ]
                );
        
        $this->add_control('pixerex_image_button_hover_effect', 
                [
                    'label'         => __('Hover Effect', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'none',
                    'options'       => [
                        'none'          => __('None','pixerex-elements'),
                        'style1'        => __('Background Slide','pixerex-elements'),
                        'style3'        => __('Diagonal Slide','pixerex-elements'),
                        'style4'        => __('Icon Slide','pixerex-elements'),
                        'style5'        => __('Overlap','pixerex-elements'),
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_image_button_style1_dir', 
                [
                    'label'         => __('Slide Direction', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'bottom',
                    'options'       => [
                        'bottom'       => __('Top to Bottom','pixerex-elements'),
                        'top'          => __('Bottom to Top','pixerex-elements'),
                        'left'         => __('Right to Left','pixerex-elements'),
                        'right'        => __('Left to Right','pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_image_button_hover_effect' => 'style1',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_image_button_style3_dir', 
                [
                    'label'         => __('Slide Direction', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'bottom',
                    'options'       => [
                        'top'          => __('Bottom Left to Top Right','pixerex-elements'),
                        'bottom'       => __('Top Right to Bottom Left','pixerex-elements'),
                        'left'         => __('Top Left to Bottom Right','pixerex-elements'),
                        'right'        => __('Bottom Right to Top Left','pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_image_button_hover_effect' => 'style3',
                        ],
                    'label_block'   => true,
                    ]
                );

        $this->add_control('pixerex_image_button_style4_dir', 
                [
                    'label'         => __('Slide Direction', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'bottom',
                    'options'       => [
                        'top'          => __('Bottom to Top','pixerex-elements'),
                        'bottom'       => __('Top to Bottom','pixerex-elements'),
                        'left'         => __('Left to Right','pixerex-elements'),
                        'right'        => __('Right to Left','pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_image_button_hover_effect' => 'style4',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_image_button_style5_dir', 
                [
                    'label'         => __('Overlap Direction', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'horizontal',
                    'options'       => [
                        'horizontal'          => __('Horizontal','pixerex-elements'),
                        'vertical'       => __('Vertical','pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_image_button_hover_effect' => 'style5',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pixerex_image_button_icon_switcher',
                [
                    'label'         => __('Icon', 'pixerex-elements'),
                    'type'          => Controls_Manager::SWITCHER,
                    'condition'     => [
                        'pixerex_image_button_hover_effect!'  => 'style4'
                    ],
                    'description'   => __('Enable or disable button icon','pixerex-elements'),
                ]
                );

        $this->add_control('pixerex_image_button_icon_selection_updated',
            [
                'label'         => __('Icon', 'pixerex-elements'),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_image_button_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'pixerex_image_button_icon_switcher' => 'yes',
                    'pixerex_image_button_hover_effect!'  =>  'style4'
                ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_image_button_style4_icon_selection_updated',
            [
                'label'         => __('Icon', 'pixerex-elements'),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_image_button_style4_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'pixerex_image_button_hover_effect'  => 'style4'
                ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_image_button_icon_position', 
                [
                    'label'         => __('Icon Position', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'before',
                    'options'       => [
                        'before'        => __('Before','pixerex-elements'),
                        'after'         => __('After','pixerex-elements'),
                        ],
                    'condition'     => [
                        'pixerex_image_button_icon_switcher' => 'yes',
                        'pixerex_image_button_hover_effect!'  =>  'style4'
                    ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_responsive_control('pixerex_image_button_icon_before_size',
                [
                    'label'         => __('Icon Size', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_image_button_icon_switcher' => 'yes',
                        'pixerex_image_button_hover_effect!'  => 'style4'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button-text-icon-wrapper i' => 'font-size: {{SIZE}}px',
                        '{{WRAPPER}} .pixerex-image-button-text-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                    ]
                ]
                );
        
        $this->add_responsive_control('pixerex_image_button_icon_style4_size',
                [
                    'label'         => __('Icon Size', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_image_button_hover_effect'  => 'style4'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button-style4-icon-wrapper i' => 'font-size: {{SIZE}}px',
                        '{{WRAPPER}} .pixerex-image-button-style4-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                    ]
                ]
                );
        
        $this->add_responsive_control('pixerex_image_button_icon_before_spacing',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_image_button_icon_switcher' => 'yes',
                        'pixerex_image_button_icon_position' => 'before',
                        'pixerex_image_button_hover_effect!' => 'style4'
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button-text-icon-wrapper i' => 'margin-right: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
                );
        
        $this->add_responsive_control('pixerex_image_button_icon_after_spacing',
                [
                    'label'         => __('Icon Spacing', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pixerex_image_button_icon_switcher' => 'yes',
                        'pixerex_image_button_icon_position' => 'after',
                        'pixerex_image_button_hover_effect!' => 'style4'
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button-text-icon-wrapper i' => 'margin-left: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
                );
        
        $this->add_control('pixerex_image_button_size', 
                [
                    'label'         => __('Size', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'lg',
                    'options'       => [
                            'sm'            => __('Small','pixerex-elements'),
                            'md'            => __('Medium','pixerex-elements'),
                            'lg'            => __('Large','pixerex-elements'),
                            'block'         => __('Block','pixerex-elements'),
                        ],
                    'label_block'   => true,
                    'separator'     => 'before',
                    ]
                );
        
        $this->add_responsive_control('pixerex_image_button_align',
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
                    '{{WRAPPER}} .pixerex-image-button-container' => 'text-align: {{VALUE}}',
                ],
				'default' => 'center',
			]
		);
        
        $this->add_control('pixerex_image_button_event_switcher', 
                [
                    'label'         => __('onclick Event', 'pixerex-elements'),
                    'type'          => Controls_Manager::SWITCHER,
                    'separator'     => 'before',
                    ]
                );
        
        $this->add_control('pixerex_image_button_event_function', 
                [
                    'label'         => __('Example: myFunction();', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXTAREA,
                    'dynamic'       => [ 'active' => true ],
                    'condition'     => [
                        'pixerex_image_button_event_switcher' => 'yes',
                        ],
                    ]
                );
        
        $this->end_controls_section();

        $this->start_controls_section('pixerex_image_button_style_section',
            [
                'label'             => __('Button', 'pixerex-elements'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'pixerex_image_button_typo',
                'scheme'            => Scheme_Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .pixerex-image-button',
            ]
            );
        
        $this->start_controls_tabs('pixerex_image_button_style_tabs');
        
        $this->start_controls_tab('pixerex_image_button_style_normal',
            [
                'label'             => __('Normal', 'pixerex-elements'),
            ]
            );

        $this->add_control('pixerex_image_button_text_color_normal',
            [
                'label'             => __('Text Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-image-button .pixerex-image-button-text-icon-wrapper'   => 'color: {{VALUE}};',
                ]
            ]);
        
        $this->add_control('pixerex_image_button_icon_color_normal',
            [
                'label'             => __('Icon Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-image-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_image_button_icon_switcher'  => 'yes',
                    'pixerex_image_button_hover_effect!'   => 'style4'
                ]
            ]);
        
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_image_button_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-image-button',
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_image_button_border_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button',
                ]
                );
        
        $this->add_control('pixerex_image_button_border_radius_normal',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Icon Shadow','pixerex-elements'),
                    'name'          => 'pixerex_image_button_icon_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button-text-icon-wrapper i',
                    'condition'         => [
                        'pixerex_image_button_icon_switcher'  => 'yes',
                        'pixerex_image_button_hover_effect!'  => 'style4'
                    
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Text Shadow','pixerex-elements'),
                    'name'          => 'pixerex_image_button_text_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button-text-icon-wrapper span',
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Button Shadow','pixerex-elements'),
                    'name'          => 'pixerex_image_button_box_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button',
                ]
                );
        
        $this->add_responsive_control('pixerex_image_button_margin_normal',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('pixerex_image_button_padding_normal',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button, {{WRAPPER}} .pixerex-image-button-effect-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_image_button_style_hover',
            [
                'label'             => __('Hover', 'pixerex-elements'),
            ]
            );

        $this->add_control('pixerex_image_button_text_color_hover',
            [
                'label'             => __('Text Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-image-button:hover .pixerex-image-button-text-icon-wrapper'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_image_button_hover_effect!'   => 'style4'
                ]
            ]);
        
        $this->add_control('pixerex_image_button_icon_color_hover',
            [
                'label'             => __('Icon Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-image-button:hover .pixerex-image-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_image_button_icon_switcher'  => 'yes',
                    'pixerex_image_button_hover_effect!'  => 'style4'
                ]
            ]);

            $this->add_control('pixerex_image_button_style4_icon_color',
            [
                'label'             => __('Icon Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-image-button:hover .pixerex-image-button-style4-icon-wrapper'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_image_button_hover_effect'  => 'style4'
                ]
            ]);

            $this->add_control('pixerex_image_button_diagonal_overlay_color',
            [
                'label'             => __('Overlay Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-image-button-diagonal-effect-top:before, {{WRAPPER}} .pixerex-image-button-diagonal-effect-bottom:before, {{WRAPPER}} .pixerex-image-button-diagonal-effect-left:before, {{WRAPPER}} .pixerex-image-button-diagonal-effect-right:before'   => 'background-color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_image_button_hover_effect'  => 'style3'
                ]
            ]);


            $this->add_control('pixerex_image_button_overlap_overlay_color',
            [
                'label'             => __('Overlay Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-image-button-overlap-effect-horizontal:before, {{WRAPPER}} .pixerex-image-button-overlap-effect-vertical:before'   => 'background-color: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_image_button_hover_effect'  => 'style5'
                ]
            ]);
            
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_image_button_background_hover',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-image-button-none:hover, {{WRAPPER}} .pixerex-image-button-style4-icon-wrapper,{{WRAPPER}} .pixerex-image-button-style1-top:before,{{WRAPPER}} .pixerex-image-button-style1-bottom:before,{{WRAPPER}} .pixerex-image-button-style1-left:before,{{WRAPPER}} .pixerex-image-button-style1-right:before,{{WRAPPER}} .pixerex-image-button-diagonal-effect-right:hover, {{WRAPPER}} .pixerex-image-button-diagonal-effect-top:hover, {{WRAPPER}} .pixerex-image-button-diagonal-effect-left:hover, {{WRAPPER}} .pixerex-image-button-diagonal-effect-bottom:hover,{{WRAPPER}} .pixerex-image-button-overlap-effect-horizontal:hover, {{WRAPPER}} .pixerex-image-button-overlap-effect-vertical:hover',
                    ]
                );
        
        $this->add_control('pixerex_image_button_overlay_color',
                [
                    'label'         => __('Overlay Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'condition'     => [
                        'pixerex_image_button_overlay_switcher' => 'yes'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button-squares-effect:before, {{WRAPPER}} .pixerex-image-button-squares-effect:after,{{WRAPPER}} .pixerex-image-button-squares-square-container:before, {{WRAPPER}} .pixerex-image-button-squares-square-container:after' => 'background-color: {{VALUE}};',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_image_button_border_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button:hover',
                ]
                );
        
        $this->add_control('pixerex_image_button_border_radius_hover',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Icon Shadow','pixerex-elements'),
                    'name'          => 'pixerex_image_button_icon_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button:hover .pixerex-image-button-text-icon-wrapper i',
                    'condition'         => [
                        'pixerex_image_button_icon_switcher'  => 'yes',
                        'pixerex_image_button_hover_effect!'     => 'style4'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Icon Shadow','pixerex-elements'),
                    'name'          => 'pixerex_image_button_style4_icon_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button:hover .pixerex-image-button-style4-icon-wrapper i',
                    'condition'         => [
                        'pixerex_image_button_hover_effect'     => 'style4'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Text Shadow','pixerex-elements'),
                    'name'          => 'pixerex_image_button_text_shadow_hover',
                    'selector'      => '{{WRAPPER}}  .pixerex-image-button:hover .pixerex-image-button-text-icon-wrapper span',
                    'condition'         => [
                       'pixerex_image_button_hover_effect!'   => 'style4'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Button Shadow','pixerex-elements'),
                    'name'          => 'pixerex_image_button_box_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pixerex-image-button:hover',
                ]
                );
        
        $this->add_responsive_control('pixerex_image_button_margin_hover',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('pixerex_image_button_padding_hover',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-image-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes( 'pixerex_image_button_text' );
        
        if($settings['pixerex_image_button_link_selection'] == 'url'){
            $image_link = $settings['pixerex_image_button_link']['url'];
        } else {
            $image_link = get_permalink($settings['pixerex_image_button_existing_link']);
        }
        
        $button_text = $settings['pixerex_image_button_text'];
        
        $button_size = 'pixerex-image-button-' . $settings['pixerex_image_button_size'];
        
        $image_event = $settings['pixerex_image_button_event_function'];
        
        if ( ! empty ( $settings['pixerex_image_button_icon_selection'] ) ) {
            $this->add_render_attribute( 'icon', 'class', $settings['pixerex_image_button_icon_selection'] );
            $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
        }
        
        $migrated = isset( $settings['__fa4_migrated']['pixerex_image_button_icon_selection_updated'] );
        $is_new = empty( $settings['pixerex_image_button_icon_selection'] ) && Icons_Manager::is_migration_allowed();
        
        if ($settings['pixerex_image_button_hover_effect'] == 'none'){
            $style_dir = 'pixerex-image-button-none';
        }    elseif($settings['pixerex_image_button_hover_effect'] == 'style1'){
            $style_dir = 'pixerex-image-button-style1-' . $settings['pixerex_image_button_style1_dir'];
        }   elseif($settings['pixerex_image_button_hover_effect'] == 'style3'){
            $style_dir = 'pixerex-image-button-diagonal-effect-' . $settings['pixerex_image_button_style3_dir'];
        }   elseif($settings['pixerex_image_button_hover_effect'] == 'style4'){
            $style_dir = 'pixerex-image-button-style4-' . $settings['pixerex_image_button_style4_dir'];
            
            if ( ! empty ( $settings['pixerex_image_button_style4_icon_selection'] ) ) {
                $this->add_render_attribute( 'slide_icon', 'class', $settings['pixerex_image_button_style4_icon_selection'] );
                $this->add_render_attribute( 'slide_icon', 'aria-hidden', 'true' );
            }
            
            $slide_migrated = isset( $settings['__fa4_migrated']['pixerex_image_button_style4_icon_selection_updated'] );
            $slide_is_new = empty( $settings['pixerex_image_button_style4_icon_selection'] ) && Icons_Manager::is_migration_allowed();
            
        }   elseif($settings['pixerex_image_button_hover_effect'] == 'style5'){
            $style_dir = 'pixerex-image-button-overlap-effect-' . $settings['pixerex_image_button_style5_dir'];
        }
        
        $this->add_render_attribute( 'button', 'class', array(
            'pixerex-image-button',
            $button_size,
            $style_dir
        ));
        
        if( ! empty( $image_link ) ) {
        
            $this->add_render_attribute( 'button', 'href', $image_link );
            
            if( ! empty( $settings['pixerex_image_button_link']['is_external'] ) )
                $this->add_render_attribute( 'button', 'target', '_blank' );
            
            if( ! empty( $settings['pixerex_image_button_link']['nofollow'] ) )
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );
        }
        
        if( 'yes' === $settings['pixerex_image_button_event_switcher'] && ! empty( $image_event ) ) {
            $this->add_render_attribute( 'button', 'onclick', $image_event );
        }

    ?>
    <div class="pixerex-image-button-container">
        <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
            <div class="pixerex-image-button-text-icon-wrapper">
            <?php if( 'yes' === $settings['pixerex_image_button_icon_switcher'] && $settings['pixerex_image_button_hover_effect'] !== 'style4' && $settings['pixerex_image_button_icon_position'] === 'before' ) :
                if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $settings['pixerex_image_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                else: ?>
                    <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                <?php endif;
            endif; ?>
                <span <?php echo $this->get_render_attribute_string( 'pixerex_image_button_text' ); ?>>
                    <?php echo $button_text; ?>
                </span>
            <?php if( 'yes' === $settings['pixerex_image_button_icon_switcher'] && $settings['pixerex_image_button_hover_effect'] != 'style4' &&  $settings['pixerex_image_button_icon_position'] == 'after' ) :
                if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $settings['pixerex_image_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                else: ?>
                    <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                <?php endif;
            endif; ?>
        </div>
        <?php if( $settings['pixerex_image_button_hover_effect'] == 'style4') : ?>
            <div class="pixerex-image-button-style4-icon-wrapper <?php echo esc_attr( $settings['pixerex_image_button_style4_dir'] ); ?>">
                <?php if ( $slide_is_new || $slide_migrated ) :
                    Icons_Manager::render_icon( $settings['pixerex_image_button_style4_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
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
        
        view.addInlineEditingAttributes( 'pixerex_image_button_text' );
        
        var buttonText = settings.pixerex_image_button_text,
            buttonUrl,
            styleDir,
            slideIcon,
            buttonSize = 'pixerex-image-button-' + settings.pixerex_image_button_size,
            buttonEvent = settings.pixerex_image_button_event_function,
            buttonIcon = settings.pixerex_image_button_icon_selection;
        
        if( 'url' == settings.pixerex_image_button_link_selection ) {
            buttonUrl = settings.pixerex_image_button_link.url;
        } else {
            buttonUrl = settings.pixerex_image_button_existing_link;
        }
        
        if ( 'none' == settings.pixerex_image_button_hover_effect ) {
            styleDir = 'pixerex-button-none';
        } else if( 'style1' == settings.pixerex_image_button_hover_effect ) {
            styleDir = 'pixerex-image-button-style1-' + settings.pixerex_image_button_style1_dir;
        } else if ( 'style3' == settings.pixerex_image_button_hover_effect ) {
            styleDir = 'pixerex-image-button-diagonal-effect-' + settings.pixerex_image_button_style3_dir;
        } else if ( 'style4' == settings.pixerex_image_button_hover_effect ) {
            styleDir = 'pixerex-image-button-style4-' + settings.pixerex_image_button_style4_dir;
            slideIcon = settings.pixerex_image_button_style4_icon_selection;
            
            var slideIconHTML = elementor.helpers.renderIcon( view, settings.pixerex_image_button_style4_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                slideMigrated = elementor.helpers.isIconMigrated( settings, 'pixerex_image_button_style4_icon_selection_updated' );
        } else if ( 'style5' == settings.pixerex_image_button_hover_effect ){
            styleDir = 'pixerex-image-button-overlap-effect-' + settings.pixerex_image_button_style5_dir;
        }
        
        var iconHTML = elementor.helpers.renderIcon( view, settings.pixerex_image_button_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
            migrated = elementor.helpers.isIconMigrated( settings, 'pixerex_image_button_icon_selection_updated' );
        
        #>
        
        <div class="pixerex-image-button-container">
            <a class="pixerex-image-button  {{ buttonSize }} {{ styleDir }}" href="{{ buttonUrl }}" onclick="{{ buttonEvent }}">
                <div class="pixerex-image-button-text-icon-wrapper">
                    <# if( 'yes' === settings.pixerex_image_button_icon_switcher && 'before' === settings.pixerex_image_button_icon_position &&  'style4' !== settings.pixerex_image_button_hover_effect ) {
                        if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
                            {{{ iconHTML.value }}}
                        <# } else { #>
                            <i class="{{ buttonIcon }}" aria-hidden="true"></i>
                        <# }
                    } #>
                    <span {{{ view.getRenderAttributeString('pixerex_image_button_text') }}}>{{{ buttonText }}}</span>
                    <# if( 'yes' === settings.pixerex_image_button_icon_switcher && 'after' === settings.pixerex_image_button_icon_position && 'style4' !== settings.pixerex_image_button_hover_effect ) {
                        if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
                            {{{ iconHTML.value }}}
                        <# } else { #>
                            <i class="{{ buttonIcon }}" aria-hidden="true"></i>
                        <# }
                    } #>
                </div>
                <# if( 'style4' == settings.pixerex_image_button_hover_effect ) { #>
                    <div class="pixerex-image-button-style4-icon-wrapper {{ settings.pixerex_image_button_style4_dir }}">
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