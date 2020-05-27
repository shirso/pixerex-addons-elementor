<?php
namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class Pixerex_Flipbox extends Base {
    protected $templateInstance;
    public function getTemplateInstance() {
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }
    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Flip Box', 'pixerex-elements') );
    }

    public function get_icon() {
        return 'px px-flip-card1';
    }
    public function get_style_depends() {
        return ['pixerex-flipbox-element'];
    }
    protected function _register_controls() {
        $this->start_controls_section(
            '_section_front',
            [
                'label' => __( 'Front Side', 'pixerex-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'front_icon_type',
            [
                'label' => __( 'Media Type', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'icon',
                'options' => [
                    'none' => [
                        'title' => __( 'None', 'pixerex-elements' ),
                        'icon' => 'eicon-close',
                    ],
                    'icon' => [
                        'title' => __( 'Icon', 'pixerex-elements' ),
                        'icon' => 'eicon-star',
                    ],
                    'image' => [
                        'title' => __( 'Image', 'pixerex-elements' ),
                        'icon' => 'eicon-image',
                    ],
                ],
                'toggle' => false,
                'style_transfer' => true,
            ]
        );

        if ( Helper_Functions::is_elementor_version( '<', '2.6.0' ) ) {
            $this->add_control(
                'front_icon',
                [
                    'label' => __( 'Icon', 'pixerex-elements' ),
                    'type' => Controls_Manager::ICON,
                    'options' => ha_get_happy_icons(),
                    'default' => 'fa fa-home',
                    'condition' => [
                        'front_icon_type' => 'icon'
                    ],
                ]
            );
        } else {
            $this->add_control(
                'front_selected_icon',
                [
                    'label' => __( 'Icon', 'pixerex-elements' ),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'front_icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'hm hm-home',
                        'library' => 'happy-icons',
                    ],
                    'condition' => [
                        'front_icon_type' => 'icon'
                    ],
                ]
            );
        }

        $this->add_control(
            'front_icon_image',
            [
                'label' => __( 'Image', 'pixerex-elements' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'front_icon_type' => 'image'
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'front_icon_thumbnail',
                'default' => 'thumbnail',
                'exclude' => [
                    'full',
                    'shop_catalog',
                    'shop_single',
                ],
                'condition' => [
                    'front_icon_type' => 'image'
                ]
            ]
        );

        $this->add_control(
            'front_title',
            [
                'label' => __( 'Title', 'pixerex-elements' ),
                'label_block' => true,
                'separator' => 'before',
                'type' => Controls_Manager::TEXT,
                'default' => 'Start Marketing',
                'placeholder' => __( 'Type Flip Box Title', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'front_description',
            [
                'label' => __( 'Description', 'pixerex-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'consectetur adipiscing elit, sed do<br>eiusmod Lorem ipsum dolor sit amet,<br> consectetur.',
                'placeholder' => __( 'Description', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'front_text_align',
            [
                'label' => __( 'Alignment', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha-flip-box-front-inner .icon-wrap' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .ha-flip-box-front-inner .ha-text' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_back',
            [
                'label' => __( 'Back Side', 'pixerex-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'back_icon_type',
            [
                'label' => __( 'Media Type', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'none',
                'options' => [
                    'none' => [
                        'title' => __( 'None', 'pixerex-elements' ),
                        'icon' => 'eicon-close',
                    ],
                    'icon' => [
                        'title' => __( 'Icon', 'pixerex-elements' ),
                        'icon' => 'eicon-star',
                    ],
                    'image' => [
                        'title' => __( 'Image', 'pixerex-elements' ),
                        'icon' => 'eicon-image',
                    ],
                ],
                'toggle' => false,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'back_icon_image',
            [
                'label' => __( 'Image', 'pixerex-elements' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'back_icon_type' => 'image'
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'back_icon_thumbnail',
                'default' => 'thumbnail',
                'exclude' => [
                    'full',
                    'shop_catalog',
                    'shop_single',
                ],
                'condition' => [
                    'back_icon_type' => 'image'
                ]
            ]
        );

        if ( Helper_Functions::is_elementor_version( '<', '2.6.0' ) ) {
            $this->add_control(
                'back_icon',
                [
                    'label' => __( 'Icon', 'pixerex-elements' ),
                    'type' => Controls_Manager::ICON,
                    'options' => ha_get_happy_icons(),
                    'default' => 'fa fa-home',
                    'condition' => [
                        'back_icon_type' => 'icon'
                    ],
                ]
            );
        } else {
            $this->add_control(
                'back_selected_icon',
                [
                    'label' => __( 'Icon', 'pixerex-elements' ),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'back_icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-smile-wink',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'back_icon_type' => 'icon'
                    ],
                ]
            );
        }

        $this->add_control(
            'back_title',
            [
                'label' => __( 'Title', 'pixerex-elements' ),
                'label_block' => true,
                'separator' => 'before',
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Start Marketing', 'pixerex-elements' ),
                'placeholder' => __( 'Type Flip Box Title', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'back_description',
            [
                'label' => __( 'Description', 'pixerex-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'consectetur adipiscing elit, sed do<br>eiusmod Lorem ipsum dolor sit amet.',
                'placeholder' => __( 'Description', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __( 'Show Button', 'pixerex-elements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'pixerex-elements' ),
                'label_off' => __( 'Hide', 'pixerex-elements' ),
                'return_value' => 'yes',
                'default' => 'no',
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Text', 'pixerex-elements' ),
                'label_block' => false,
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Click Here', 'pixerex-elements' ),
                'placeholder' => __( 'Type Button Text', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'pixerex-elements' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://example.com', 'pixerex-elements' ),
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'back_text_align',
            [
                'label' => __( 'Alignment', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha-flip-box-back-inner .icon-wrap' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .ha-flip-box-back-inner .ha-text' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .ha-flip-box-back-inner .ha-flip-btn-container' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_settings',
            [
                'label' => __( 'Settings', 'pixerex-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'animation_type',
            [
                'label' => __( 'Animation Type', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'classic',
                'label_block' => false,
                'options' => [
                    'classic' => [
                        'title' => __( 'Classic', 'pixerex-elements' ),
                        'icon' => 'fa fa-square',
                    ],
                    '3d' => [
                        'title' => __( '3D', 'pixerex-elements' ),
                        'icon' => 'fa fa-cube',
                    ],
                ],
                'toggle' => false,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'flip_position',
            [
                'label' => __( 'Flip Direction', 'pixerex-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left-right',
                'label_block' => false,
                'options' => [
                    'top-bottom' => [
                        'title' => __( 'Top To Bottom ', 'pixerex-elements' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'right-left' => [
                        'title' => __( 'Right to Left', 'pixerex-elements' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'bottom-top' => [
                        'title' => __( 'Bottom To Top', 'pixerex-elements' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'left-right' => [
                        'title' => __( 'Left To Right', 'pixerex-elements' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => false,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            '3d_duration',
            [
                'label' => __( 'Duration', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                    ],
                ],
                'condition' => [
                    'animation_type'	=> '3d',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha-flip-effect-3d .ha-flip-box-front' => 'transition-duration: {{SIZE}}ms;',
                    '{{WRAPPER}} .ha-flip-effect-3d .ha-flip-box-back' => 'transition-duration: {{SIZE}}ms;',
                ],
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'front_transform_offset_toggle',
            [
                'label' => __( 'Front Transform', 'pixerex-elements' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'pixerex-elements' ),
                'label_on' => __( 'Custom', 'pixerex-elements' ),
                'return_value' => 'yes',
                'condition' => [
                    'animation_type'	=> 'classic',
                ],
                'style_transfer' => true,
            ]
        );

        $this->start_popover();

        $this->add_control(
            'front_transform_x',
            [
                'label' => __( 'Transform Origin X', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'size' => '50'
                ],
                'condition' => [
                    'animation_type'	=> 'classic',
                    'front_transform_offset_toggle' => 'yes'
                ],
                'render_type' => 'ui',
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'front_transform_y',
            [
                'label' => __( 'Transform Origin Y', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'size' => '50'
                ],
                'condition' => [
                    'animation_type'	=> 'classic',
                    'front_transform_offset_toggle' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha-flip-effect-classic .ha-flip-box-front' => 'transform-origin: {{front_transform_x.SIZE || 0}}% {{front_transform_y.SIZE || 0}}%;',
                ],
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'front_duration',
            [
                'label' => __( 'Duration', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                    ],
                ],
                'condition' => [
                    'animation_type'	=> 'classic',
                    'front_transform_offset_toggle' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha-flip-effect-classic .ha-flip-box-front' => 'transition-duration: {{SIZE}}ms;',
                ],
            ]
        );

        $this->end_popover();

        $this->add_control(
            'back_transform_offset_toggle',
            [
                'label' => __( 'Back Transform', 'pixerex-elements' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'pixerex-elements' ),
                'label_on' => __( 'Custom', 'pixerex-elements' ),
                'return_value' => 'yes',
                'condition' => [
                    'animation_type'	=> 'classic',
                ],
                'style_transfer' => true,
            ]
        );

        $this->start_popover();

        $this->add_control(
            'back_transform_origin_x',
            [
                'label' => __( 'Transform Origin X', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'size' => '50'
                ],
                'condition' => [
                    'animation_type'	=> 'classic',
                    'back_transform_offset_toggle' => 'yes'
                ],
                'render_type' => 'ui',
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'back_transform_origin_y',
            [
                'label' => __( 'Transform Origin Y', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'size' => '50'
                ],
                'condition' => [
                    'animation_type'	=> 'classic',
                    'back_transform_offset_toggle' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha-flip-effect-classic .ha-flip-box-back' => 'transform-origin: {{back_transform_origin_x.SIZE || 0}}% {{back_transform_origin_y.SIZE || 0}}%;',
                ],
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'back_duration',
            [
                'label' => __( 'Duration', 'pixerex-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                    ],
                ],
                'condition' => [
                    'animation_type'	=> 'classic',
                    'back_transform_offset_toggle' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .ha-flip-effect-classic .ha-flip-box-back' => 'transition-duration: {{SIZE}}ms;',
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();

    }
    protected function render() {
        $settings = $this->get_settings_for_display();

        // icon/image
        if ( $settings['front_icon_image']['id'] && isset( $settings['front_icon_image']['url'] ) ) {
            $this->add_render_attribute( 'front_icon_image', 'src', $settings['front_icon_image']['url'] );
            $this->add_render_attribute( 'front_icon_image', 'alt', Control_Media::get_image_alt( $settings['front_icon_image'] ) );
            $this->add_render_attribute( 'front_icon_image', 'title', Control_Media::get_image_title( $settings['front_icon_image'] ) );
        }

        // title & description
        $this->add_render_attribute( 'front_title', 'class', 'ha-flip-box-heading' );
        $this->add_render_attribute( 'back_title', 'class', 'ha-flip-box-heading-back' );
        $this->add_render_attribute( 'front_description', 'class', 'ha-desc' );
        $this->add_render_attribute( 'back_description', 'class', 'ha-desc' );
        $this->add_inline_editing_attributes( 'back_description', 'intermediate' );

        // link
        $this->add_render_attribute('link', 'class', 'ha-flip-btn');
        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_link_attributes('link', $settings['link'] );
        }

        // display type
        if ( $settings['animation_type'] === 'classic' ) {
            $this->add_render_attribute('display', 'class', 'ha-flip-box-container ha-flip-effect-classic');
        } elseif ( $settings['animation_type'] === '3d' ) {
            $this->add_render_attribute('display', 'class', 'ha-flip-box-container ha-flip-effect-3d');
        }

        // flip position
        $this->add_render_attribute( 'flip-position', 'class', 'ha-flip-box-inner' );
        if ( $settings['flip_position'] === 'top-bottom' ) {
            $this->add_render_attribute( 'flip-position', 'class', 'ha-flip-down' );
        } elseif ( $settings['flip_position'] === 'right-left' ) {
            $this->add_render_attribute( 'flip-position', 'class', 'ha-flip-left' );
        } elseif ( $settings['flip_position'] === 'bottom-top' ) {
            $this->add_render_attribute( 'flip-position', 'class', 'ha-flip-up' );
        } elseif ( $settings['flip_position'] === 'left-right' ) {
            $this->add_render_attribute( 'flip-position', 'class', 'ha-flip-right' );
        }
        ?>

        <div <?php $this->print_render_attribute_string( 'display' ); ?>>

            <div <?php $this->print_render_attribute_string( 'flip-position' ); ?>>
                <div class="ha-flip-box-inner-wrapper">
                    <div class="ha-flip-box-front">
                        <div class="ha-flip-box-front-inner">
                            <div class="icon-wrap">
                                <?php if ( ! empty( $settings['front_icon'] ) || ! empty( $settings['front_selected_icon'] ) ) : ?>
                                    <span class="ha-flip-icon icon">
                                        <?php Helper_Functions::render_icon( $settings, 'front_icon', 'front_selected_icon' ); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ( $settings['front_icon_image'] ) : ?>
                                    <div class="ha-flip-icon">
                                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'front_icon_thumbnail', 'front_icon_image' ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="ha-text">
                                <?php if ( $settings['front_title'] ) : ?>
                                    <h2 <?php $this->print_render_attribute_string( 'front_title' ); ?>><?php echo Helper_Functions::ha_kses_basic( $settings['front_title'] ); ?></h2>
                                <?php endif; ?>

                                <?php if ( $settings['front_description'] ) : ?>
                                    <p <?php $this->print_render_attribute_string( 'front_description' ); ?>><?php echo Helper_Functions::ha_kses_basic( $settings['front_description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="ha-flip-box-back">
                        <div class="ha-flip-box-back-inner">
                            <div class="icon-wrap">
                                <?php if ( ! empty( $settings['back_icon'] ) || ! empty( $settings['back_selected_icon'] ) ) : ?>
                                    <span class="ha-flip-icon icon">
                                        <?php ha_render_icon( $settings, 'back_icon', 'back_selected_icon' ); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ( $settings['back_icon_image'] ) : ?>
                                    <div class="ha-flip-icon">
                                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'back_icon_thumbnail', 'back_icon_image' ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="ha-text">
                                <?php if ( $settings['back_title'] ) : ?>
                                    <h2 <?php $this->print_render_attribute_string( 'back_title' ); ?>><?php echo Helper_Functions::ha_kses_basic( $settings['back_title'] ); ?></h2>
                                <?php endif; ?>

                                <?php if ( $settings['back_description'] ) : ?>
                                    <p <?php $this->print_render_attribute_string( 'back_description' ) ?>><?php echo Helper_Functions::ha_kses_intermediate( $settings['back_description'] ); ?></p>
                                <?php endif; ?>
                            </div>

                            <?php if ( !empty( $settings['button_text'] ) ) : ?>
                                <div class="ha-flip-btn-container">
                                    <a <?php $this->print_render_attribute_string( 'link' ); ?>>
                                        <?php echo esc_html( $settings['button_text'] ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}