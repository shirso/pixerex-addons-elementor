<?php
namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Slider extends Base {
    protected $templateInstance;
    public function getTemplateInstance() {
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }
    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Slider', 'pixerex-elements') );
    }
    public function get_icon() {
        return 'px px-image-slider';
    }
    public function get_style_depends() {
        return ['pixerex-slick','pixerex-slick-theme','pixerex-slider-carousel-element'];
    }
    public function get_script_depends() {
        return ['pixerex-elements-js','pixerex-slick-js','pixerex-slider-js'];
    }
    protected function _register_controls() {
        $this->start_controls_section(
            '_section_slides',
            [
                'label' => __( 'Slides', 'pixerex-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => __( 'Image', 'pixerex-elements' ),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => __( 'Title & Subtitle', 'pixerex-elements' ),
                'placeholder' => __( 'Type title here', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'show_label' => false,
                'placeholder' => __( 'Type subtitle here', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'slides',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '<# print(title || "Carousel Item"); #>',
                'default' => [
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_settings',
            [
                'label' => __( 'Settings', 'pixerex-elements' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'label' => __( 'Animation Speed', 'pixerex-elements' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 10,
                'max' => 10000,
                'default' => 300,
                'description' => __( 'Slide speed in milliseconds', 'pixerex-elements' ),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __( 'Autoplay?', 'pixerex-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'pixerex-elements' ),
                'label_off' => __( 'No', 'pixerex-elements' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __( 'Autoplay Speed', 'pixerex-elements' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 100,
                'max' => 10000,
                'default' => 3000,
                'description' => __( 'Autoplay speed in milliseconds', 'pixerex-elements' ),
                'condition' => [
                    'autoplay' => 'yes'
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => __( 'Infinite Loop?', 'pixerex-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'pixerex-elements' ),
                'label_off' => __( 'No', 'pixerex-elements' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'vertical',
            [
                'label' => __( 'Vertical Mode?', 'pixerex-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'pixerex-elements' ),
                'label_off' => __( 'No', 'pixerex-elements' ),
                'return_value' => 'yes',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => __( 'Navigation', 'pixerex-elements' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => __( 'None', 'pixerex-elements' ),
                    'arrow' => __( 'Arrow', 'pixerex-elements' ),
                    'dots' => __( 'Dots', 'pixerex-elements' ),
                    'both' => __( 'Arrow & Dots', 'pixerex-elements' ),
                ],
                'default' => 'arrow',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'pixerex_section_item_style',
            [
                'label' => __( 'Slider Item', 'pixerex-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .ha-slick-item',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => __( 'Border Radius', 'pixerex-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ha-slick-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_content',
            [
                'label' => __( 'Slide Content', 'pixerex-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Content Padding', 'pixerex-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ha-slick-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'selector' => '{{WRAPPER}} .ha-slick-content',
                'exclude' => [
                    'image'
                ]
            ]
        );

        $this->add_control(
            '_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', 'pixerex-elements' ),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Bottom Spacing', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .ha-slick-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-slick-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .ha-slick-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_control(
            '_heading_subtitle',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Subtitle', 'pixerex-elements' ),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'subtitle_spacing',
            [
                'label' => __( 'Bottom Spacing', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .ha-slick-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => __( 'Text Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ha-slick-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle',
                'selector' => '{{WRAPPER}} .ha-slick-subtitle',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Navigation - Arrow', 'pixerex-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrow_position_toggle',
            [
                'label' => __( 'Position', 'pixerex-elements' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'pixerex-elements' ),
                'label_on' => __( 'Custom', 'pixerex-elements' ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'arrow_position_y',
            [
                'label' => __( 'Vertical', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'condition' => [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_position_x',
            [
                'label' => __( 'Horizontal', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'condition' => [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slick-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrow_border',
                'selector' => '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next',
            ]
        );

        $this->add_responsive_control(
            'arrow_border_radius',
            [
                'label' => __( 'Border Radius', 'pixerex-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs( '_tabs_arrow' );

        $this->start_controls_tab(
            '_tab_arrow_normal',
            [
                'label' => __( 'Normal', 'pixerex-elements' ),
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => __( 'Text Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color',
            [
                'label' => __( 'Background Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_arrow_hover',
            [
                'label' => __( 'Hover', 'pixerex-elements' ),
            ]
        );

        $this->add_control(
            'arrow_hover_color',
            [
                'label' => __( 'Text Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_bg_color',
            [
                'label' => __( 'Background Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'arrow_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_dots',
            [
                'label' => __( 'Navigation - Dots', 'pixerex-elements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'dots_nav_position_y',
            [
                'label' => __( 'Vertical Position', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nav_spacing',
            [
                'label' => __( 'Spacing', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nav_align',
            [
                'label' => __( 'Alignment', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->start_controls_tabs( '_tabs_dots' );
        $this->start_controls_tab(
            '_tab_dots_normal',
            [
                'label' => __( 'Normal', 'pixerex-elements' ),
            ]
        );

        $this->add_control(
            'dots_nav_color',
            [
                'label' => __( 'Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_dots_hover',
            [
                'label' => __( 'Hover', 'pixerex-elements' ),
            ]
        );

        $this->add_control(
            'dots_nav_hover_color',
            [
                'label' => __( 'Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:hover:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_dots_active',
            [
                'label' => __( 'Active', 'pixerex-elements' ),
            ]
        );

        $this->add_control(
            'dots_nav_active_color',
            [
                'label' => __( 'Color', 'pixerex-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots .slick-active button:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['slides'] ) ) {
            return;
        }
        ?>

        <div class="hajs-slick ha-slick ha-slick--slider">

            <?php foreach ( $settings['slides'] as $slide ) :
                $image = wp_get_attachment_image_url( $slide['image']['id'], $settings['thumbnail_size'] );
                if ( ! $image ) {
                    $image = $slide['image']['url'];
                }
                ?>

                <div class="ha-slick-slide">
                    <div class="ha-slick-item">
                        <?php if ( $image ) : ?>
                            <img class="ha-slick-img" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>">
                        <?php endif; ?>

                        <?php if ( $slide['title'] || $slide['subtitle'] ) : ?>
                            <div class="ha-slick-content">
                                <?php if ( $slide['title'] ) : ?>
                                    <h2 class="ha-slick-title"><?php echo ha_kses_basic( $slide['title'] ); ?></h2>
                                <?php endif; ?>
                                <?php if ( $slide['subtitle'] ) : ?>
                                    <p class="ha-slick-subtitle"><?php echo ha_kses_basic( $slide['subtitle'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <?php
    }

}