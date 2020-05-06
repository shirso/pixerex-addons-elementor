<?php

namespace PixerexElements\Widgets;

use PixerexElements\Admin\Settings\Maps;
use PixerexElements\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Maps extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-maps';
    }
    
    public function is_reload_preview_required() {
        return true;
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Google Maps', 'pixerex-elements') );
	}
    
    public function get_icon() {
        return 'eicon-google-maps';
    }

    public function get_categories() {
        return [ 'pixerex-elements'];
    }
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }
    
    public function get_script_depends() {
        return [
            'google-maps-cluster',
            'pixerex-maps-api-js',
            'pixerex-maps-js'
        ];
    }
    
    public function get_keywords() {
		return [ 'google', 'marker', 'pin' ];
	
    }

    // Adding the controls fields for the maps widget
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /* Start Map Settings Section */
        $this->start_controls_section('pixerex_maps_map_settings',
                [
                    'label'         => __('Center Location', 'pixerex-elements'),
                    ]
                );
        
        $settings = Maps::get_enabled_keys();
        
        if( empty( $settings['pixerex-map-api'] ) ) {
            $this->add_control('pixerex_maps_api_url',
                [
                    'label'         => '<span style="line-height: 1.4em;">Pixerex Maps requires an API key. Get your API key from <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a> and add it to Pixerex Addons admin page. Go to Dashboard -> Pixerex Addons for Elementor -> Google Maps API</span>',
                    'type'          => Controls_Manager::RAW_HTML,
                ]
            );
        }
        
        $this->add_control('pixerex_map_ip_location',
            [
                'label'         => __( 'Get User Location', 'pixerex-elements' ),
                'description'   => __('Get center location from visitor\'s location','pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true'
            ]
        );
        
        $this->add_control('pixerex_map_location_finder',
            [
                'label'         => __( 'Latitude & Longitude Finder', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_map_ip_location!'  => 'true'
                ]
            ]
        );
        
        $this->add_control('pixerex_map_notice',
		    [
			    'label' => __( 'Find Latitude & Longitude', 'elementor' ),
			    'type'  => Controls_Manager::RAW_HTML,
			    'raw'   => '<form onsubmit="getAddress(this);" action="javascript:void(0);"><input type="text" id="pixerex-map-get-address" class="pixerex-map-get-address" style="margin-top:10px; margin-bottom:10px;"><input type="submit" value="Search" class="elementor-button elementor-button-default" onclick="getAddress(this)"></form><div class="pixerex-address-result" style="margin-top:10px; line-height: 1.3; font-size: 12px;"></div>',
			    'label_block' => true,
                'condition'     => [
                    'pixerex_map_location_finder'   => 'yes',
                    'pixerex_map_ip_location!'  => 'true'
                ]
		    ]
	    );
        
        
        $this->add_control('pixerex_maps_center_lat',
                [
                    'label'         => __('Center Latitude', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'description'   => __('Center latitude and longitude are required to identify your location', 'pixerex-elements'),
                    'default'       => '18.591212',
                    'label_block'   => true,
                    'condition'     => [
                        'pixerex_map_ip_location!'  => 'true'
                        ]
                    ]
                );

        $this->add_control('pixerex_maps_center_long',
                [
                    'label'         => __('Center Longitude', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'description'   => __('Center latitude and longitude are required to identify your location', 'pixerex-elements'),
                    'default'       => '73.741261',
                    'label_block'   => true,
                    'condition'     => [
                        'pixerex_map_ip_location!'  => 'true'
                        ]
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_maps_map_pins_settings',
            [
                'label'         => __('Markers', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_maps_markers_width',
                [
                    'label'         => __('Max Width', 'pixerex-elements'),
                    'type'          => Controls_Manager::NUMBER,
                    'title'         => __('Set the Maximum width for markers description box','pixerex-elements'),
                    ]
                );
         
        $repeater = new REPEATER();
        
        $repeater->add_control('pixerex_map_pin_location_finder',
            [
                'label'         => __( 'Latitude & Longitude Finder', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $repeater->add_control('pixerex_map_pin_notice',
		    [
			    'label' => __( 'Find Latitude & Longitude', 'elementor' ),
			    'type'  => Controls_Manager::RAW_HTML,
			    'raw'   => '<form onsubmit="getPinAddress(this);" action="javascript:void(0);"><input type="text" id="pixerex-map-get-address" class="pixerex-map-get-address" style="margin-top:10px; margin-bottom:10px;"><input type="submit" value="Search" class="elementor-button elementor-button-default" onclick="getPinAddress(this)"></form><div class="pixerex-address-result" style="margin-top:10px; line-height: 1.3; font-size: 12px;"></div>',
			    'label_block' => true,
                'condition' => [
                    'pixerex_map_pin_location_finder'   => 'yes'
                ]
		    ]
	    );
        
        $repeater->add_control('map_latitude',
            [
                'label'         => __('Latitude', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'description'   => 'Click <a href="https://www.latlong.net/" target="_blank">here</a> to get your location coordinates',
                'label_block'   => true,
            ]
        );
        
        $repeater->add_control('map_longitude',
            [
                'name'          => 'map_longitude',
                'label'         => __('Longitude', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'description'   => 'Click <a href="https://www.latlong.net/" target="_blank">here</a> to get your location coordinates',
                'label_block'   => true,
            ]
        );
        
        $repeater->add_control('pin_title',
            [
                'label'         => __('Title', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
            ]
        );
        
        $repeater->add_control('pin_desc',
            [
                'label'         => __('Description', 'pixerex-elements'),
                'type'          => Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
            ]
        );
        
        $repeater->add_control('pin_icon',
            [
                'label'         => __('Custom Icon', 'pixerex-elements'),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
            ]
        );

        $this->add_control('pixerex_maps_map_pins',
            [
                'label'         => __('Map Pins', 'pixerex-elements'),
                'type'          => Controls_Manager::REPEATER,
                'default'       => [
                    'map_latitude'      => '18.591212',
                    'map_longitude'     => '73.741261',
                    'pin_title'         => __('Pixerex Google Maps', 'pixerex-elements'),
                    'pin_desc'          => __('Add an optional description to your map pin', 'pixerex-elements'),
                ],
                'fields'       => array_values( $repeater->get_controls() ),
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_maps_controls_section',
                [
                    'label'         => __('Controls', 'pixerex-elements'),
                    ]
                );
        
        $this->add_control('pixerex_maps_map_type',
                [
                    'label'         => __( 'Map Type', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => [
                        'roadmap'       => __( 'Road Map', 'pixerex-elements' ),
                        'satellite'     => __( 'Satellite', 'pixerex-elements' ),
                        'terrain'       => __( 'Terrain', 'pixerex-elements' ),
                        'hybrid'        => __( 'Hybrid', 'pixerex-elements' ),
                        ],
                    'default'       => 'roadmap',
                    ]
                );
        
        $this->add_responsive_control('pixerex_maps_map_height',
                [
                    'label'         => __( 'Height', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SLIDER,
                    'default'       => [
                            'size' => 500,
                    ],
                    'range'         => [
                            'px' => [
                                'min' => 80,
                                'max' => 1400,
                            ],
                    ],
                    'selectors'     => [
                            '{{WRAPPER}} .pixerex_maps_map_height' => 'height: {{SIZE}}px;',
                    ],
                ]
  		);
        
        $this->add_control('pixerex_maps_map_zoom',
                [
                    'label'         => __( 'Zoom', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SLIDER,
                    'default'       => [
                        'size' => 12,
                    ],
                    'range'         => [
                        'px' => [
                                'min' => 0,
                                'max' => 22,
                        ],
                    ],
                ]
                );
        
        $this->add_control('pixerex_maps_map_option_map_type_control',
                [
                    'label'         => __( 'Map Type Controls', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );

        $this->add_control('pixerex_maps_map_option_zoom_controls',
                [
                    'label'         => __( 'Zoom Controls', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );
		
        $this->add_control('pixerex_maps_map_option_streeview',
                [
                    'label'         => __( 'Street View Control', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );
		
        $this->add_control('pixerex_maps_map_option_fullscreen_control',
                [
                    'label'         => __( 'Fullscreen Control', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );
		
        $this->add_control('pixerex_maps_map_option_mapscroll',
                [
                    'label'         => __( 'Scroll Wheel Zoom', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );
        
        $this->add_control('pixerex_maps_marker_open',
                [
                    'label'         => __( 'Info Container Always Opened', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );
        
        $this->add_control('pixerex_maps_marker_hover_open',
                [
                    'label'         => __( 'Info Container Opened when Hovered', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );
        
        $this->add_control('pixerex_maps_marker_mouse_out',
                [
                    'label'         => __( 'Info Container Closed when Mouse Out', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'condition'     => [
                        'pixerex_maps_marker_hover_open'   => 'yes'
                        ]
                    ]
                );

        if( $settings['pixerex-map-cluster'] ) {
            $this->add_control('pixerex_maps_map_option_cluster',
                [
                    'label'         => __( 'Marker Clustering', 'pixerex-elements' ),
                    'type'          => Controls_Manager::SWITCHER,
                ]
            );
        }
        
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_maps_custom_styling_section',
            [
                'label'         => __('Map Style', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_maps_custom_styling',
            [
                'label'         => __('JSON Code', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXTAREA,
                'description'   => 'Get your custom styling from <a href="https://snazzymaps.com/" target="_blank">here</a>',
                'label_block'   => true,
            ]
        );
    
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_maps_pin_title_style',
            [
                'label'         => __('Title', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_maps_pin_title_color',
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-maps-info-title'   => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'pin_title_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-maps-info-title',
                ]
                );
        
        $this->add_responsive_control('pixerex_maps_pin_title_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-info-title'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ]
                    ]
                );
        
        /*Pin Title Padding*/
        $this->add_responsive_control('pixerex_maps_pin_title_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-info-title'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ]
                    ]
                );
        
        /*Pin Title ALign*/
        $this->add_responsive_control('pixerex_maps_pin_title_align',
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
                            'icon' => 'fa fa-align-right',
                            ],
                        ],
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-info-title' => 'text-align: {{VALUE}};',
                        ],
                    ]
                );
                
        /*End Title Style Section*/
        $this->end_controls_section();
        
        /*Start Pin Style Section*/
        $this->start_controls_section('pixerex_maps_pin_text_style',
                [
                    'label'         => __('Description', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        $this->add_control('pixerex_maps_pin_text_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-info-desc'   => 'color: {{VALUE}};',
                        ]
                    ]
                );
        
        $this->add_group_control(
        Group_Control_Typography::get_type(),
                [
                    'name'          => 'pin_text_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-maps-info-desc',
                ]
                );
        
        $this->add_responsive_control('pixerex_maps_pin_text_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-info-desc'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->add_responsive_control('pixerex_maps_pin_text_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-info-desc'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ]
                    ]
                );
        
        /*Pin Title ALign*/
        $this->add_responsive_control('pixerex_maps_pin_description_align',
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
                            'icon' => 'fa fa-align-right',
                            ],
                        ],
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-info-desc' => 'text-align: {{VALUE}};',
                        ],
                    ]
                );
        
        /*End Pin Style Section*/
        $this->end_controls_section();
        
        /*Start Map Style Section*/
        $this->start_controls_section('pixerex_maps_box_style',
                [
                    'label'         => __('Map', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );

        /*First Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'              => 'map_border',
                    'selector'          => '{{WRAPPER}} .pixerex-maps-container',
                    ]
                );
        
        /*First Border Radius*/
        $this->add_control('pixerex_maps_box_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-container,{{WRAPPER}} .pixerex_maps_map_height' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        /*Box Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Shadow','pixerex-elements'),
                    'name'          => 'pixerex_maps_box_shadow',
                    'selector'      => '{{WRAPPER}} .pixerex-maps-container',
                ]
                );

        /*First Margin*/
        $this->add_responsive_control('pixerex_maps_box_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        /*First Padding*/
        $this->add_responsive_control('pixerex_maps_box_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-maps-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        /*End Map Style Section*/
        $this->end_controls_section();
        
    }

    protected function render() {
        
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        
        $map_pins = $settings['pixerex_maps_map_pins'];

        $street_view = 'yes' == $settings['pixerex_maps_map_option_streeview'] ? 'true' : 'false';
        
        $scroll_wheel = 'yes' == $settings['pixerex_maps_map_option_mapscroll'] ? 'true' : 'false';
        
        $enable_full_screen = 'yes' == $settings['pixerex_maps_map_option_fullscreen_control'] ? 'true' : 'false';
        
        $enable_zoom_control = 'yes' == $settings['pixerex_maps_map_option_zoom_controls'] ? 'true' : 'false';
        
        $map_type_control = 'yes' == $settings['pixerex_maps_map_option_map_type_control'] ? 'true' : 'false';
        
        $automatic_open = 'yes' == $settings['pixerex_maps_marker_open'] ? 'true' : 'false';
        
        $hover_open = 'yes' == $settings['pixerex_maps_marker_hover_open'] ? 'true' : 'false';
        
        $hover_close = 'yes' == $settings['pixerex_maps_marker_mouse_out'] ? 'true' : 'false';
        
        $marker_cluster = false; 
        
        $is_cluster_enabled = Maps::get_enabled_keys()['pixerex-map-cluster'];
        
        if( $is_cluster_enabled ) {
            $marker_cluster = 'yes' == $settings['pixerex_maps_map_option_cluster'] ? 'true' : 'false';
        }
        
        $centerlat = !empty($settings['pixerex_maps_center_lat']) ? $settings['pixerex_maps_center_lat'] : 18.591212;
        
        $centerlong = !empty($settings['pixerex_maps_center_long']) ? $settings['pixerex_maps_center_long'] : 73.741261;
        
        $marker_width = !empty($settings['pixerex_maps_markers_width']) ? $settings['pixerex_maps_markers_width'] : 1000;
        
        $get_ip_location = $settings['pixerex_map_ip_location'];
        
        if( 'true' == $get_ip_location ) {
            
            if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
                $http_x_headers = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );

                $_SERVER['REMOTE_ADDR'] = $http_x_headers[0];
            }
            $ipAddress = $_SERVER['REMOTE_ADDR'];

            $env = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ipAddress"));

            $centerlat = isset( $env['geoplugin_latitude'] ) ? $env['geoplugin_latitude'] : $centerlat;
            
            $centerlong = isset( $env['geoplugin_longitude'] ) ? $env['geoplugin_longitude'] : $centerlong;
            
        }
        
        $map_settings = [
            'zoom'                  => $settings['pixerex_maps_map_zoom']['size'],
            'maptype'               => $settings['pixerex_maps_map_type'],
            'streetViewControl'     => $street_view,
            'centerlat'             => $centerlat,
            'centerlong'            => $centerlong, 
            'scrollwheel'           => $scroll_wheel,
            'fullScreen'            => $enable_full_screen,
            'zoomControl'           => $enable_zoom_control,
            'typeControl'           => $map_type_control,
            'automaticOpen'         => $automatic_open,
            'hoverOpen'             => $hover_open,
            'hoverClose'            => $hover_close,
            'cluster'               => $marker_cluster
        ];
        
        $this->add_render_attribute('style_wrapper', 'data-style', $settings['pixerex_maps_custom_styling']);
    ?>

    <div class="pixerex-maps-container" id="pixerex-maps-container">
        <?php if( count( $map_pins ) ) { ?>
	        <div class="pixerex_maps_map_height" data-settings='<?php echo wp_json_encode( $map_settings ); ?>' <?php echo $this->get_render_attribute_string('style_wrapper'); ?>>
			<?php
        	foreach( $map_pins as $pin ) {
				?>
		        <div class="pixerex-pin" data-lng="<?php echo $pin['map_longitude']; ?>" data-lat="<?php echo $pin['map_latitude']; ?>" data-icon="<?php echo $pin['pin_icon']['url']; ?>" data-max-width="<?php echo $marker_width; ?>">
                    <?php if( ! empty( $pin['pin_title'] )|| !empty( $pin['pin_desc'] ) ) : ?>
                        <div class='pixerex-maps-info-container'><p class='pixerex-maps-info-title'><?php echo $pin['pin_title']; ?></p><div class='pixerex-maps-info-desc'><?php echo $pin['pin_desc']; ?></div></div>
                    <?php endif; ?>
		        </div>
		        <?php
	        }
	        ?>
	        </div>
			<?php
        } ?>
    </div>
    <?php
    }
}