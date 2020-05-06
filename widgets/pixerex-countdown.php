<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if( !defined( 'ABSPATH' ) ) exit; // No access of directly access

class Pixerex_Countdown extends Widget_Base {
    
	public function get_name() {
		return 'pixerex-countdown-timer';
	}

	public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Countdown', 'pixerex-elements') );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}
    
    public function is_reload_preview_required() {
        return true;
    }
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }
    
    public function get_script_depends() {
		return [
            'count-down-timer-js',
            'pixerex-elements-js'
        ];
	}

	public function get_categories() {
		return [ 'pixerex-elements'];
	}

    // Adding the controls fields for the countdown widget
    // This will controls the animation, colors and background, dimensions etc
	protected function _register_controls() {
		$this->start_controls_section(
			'pixerex_countdown_global_settings',
			[
				'label'		=> __( 'Countdown', 'pixerex-elements' )
			]
		);

		$this->add_control(
			'pixerex_countdown_style',
		  	[
		     	'label'			=> __( 'Style', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'options' 		=> [
		     		'd-u-s' => __( 'Inline', 'pixerex-elements' ),
		     		'd-u-u' => __( 'Block', 'pixerex-elements' ),
		     	],
		     	'default'		=> 'd-u-u'
		  	]
		);

		$this->add_control(
			'pixerex_countdown_date_time',
		  	[
		     	'label'			=> __( 'Due Date', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::DATE_TIME,
		     	'picker_options'	=> [
		     		'format' => 'Ym/d H:m:s'
		     	],
		     	'default' => date( "Y/m/d H:m:s", strtotime("+ 1 Day") ),
				'description' => __( 'Date format is (yyyy/mm/dd). Time format is (hh:mm:ss). Example: 2020-01-01 09:30.', 'pixerex-elements' )
		  	]
		);

		$this->add_control(
			'pixerex_countdown_s_u_time',
			[
				'label' 		=> __( 'Time Zone', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'wp-time'			=> __('WordPress Default', 'pixerex-elements' ),
					'user-time'			=> __('User Local Time', 'pixerex-elements' )
				],
				'default'		=> 'wp-time',
				'description'	=> __('This will set the current time of the option that you will choose.', 'pixerex-elements')
			]
		);

		$this->add_control(
			'pixerex_countdown_units',
		  	[
		     	'label'			=> __( 'Time Units', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SELECT2,
				'description' => __('Select the time units that you want to display in countdown timer.', 'pixerex-elements' ),
				'options'		=> [
					'Y'     => __( 'Years', 'pixerex-elements' ),
					'O'     => __( 'Month', 'pixerex-elements' ),
					'W'     => __( 'Week', 'pixerex-elements' ),
					'D'     => __( 'Day', 'pixerex-elements' ),
					'H'     => __( 'Hours', 'pixerex-elements' ),
					'M'     => __( 'Minutes', 'pixerex-elements' ),
					'S' 	=> __( 'Second', 'pixerex-elements' ),
				],
				'default' 		=> [ 'O', 'D', 'H', 'M', 'S' ],
				'multiple'		=> true,
				'separator'		=> 'after'
		  	]
		);
        
        $this->add_control('pixerex_countdown_separator',
            [
                'label'         => __('Digits Separator', 'pixerex-elements'),
                'description'   => __('Enable or disable digits separator','pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_countdown_style'   => 'd-u-u'
                ]
            ]
        );
        
        $this->add_control(
			'pixerex_countdown_separator_text',
			[
				'label'			=> __('Separator Text', 'pixerex-elements'),
				'type'			=> Controls_Manager::TEXT,
				'condition'		=> [
                    'pixerex_countdown_style'   => 'd-u-u',
					'pixerex_countdown_separator' => 'yes'
				],
				'default'		=> ':'
			]
		);
        
        $this->add_responsive_control(
            'pixerex_countdown_align',
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
                    'toggle'        => false,
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-countdown' => 'justify-content: {{VALUE}};',
                        ],
                    ]
                );

		$this->end_controls_section();

		$this->start_controls_section(
			'pixerex_countdown_on_expire_settings',
			[
				'label' => __( 'Expire' , 'pixerex-elements' )
			]
		);

		$this->add_control(
			'pixerex_countdown_expire_text_url',
			[
				'label'			=> __('Expire Type', 'pixerex-elements'),
				'label_block'	=> false,
				'type'			=> Controls_Manager::SELECT,
                'description'   => __('Choose whether if you want to set a message or a redirect link', 'pixerex-elements'),
				'options'		=> [
					'text'		=> __('Message', 'pixerex-elements'),
					'url'		=> __('Redirection Link', 'pixerex-elements')
				],
				'default'		=> 'text'
			]
		);

		$this->add_control(
			'pixerex_countdown_expiry_text_',
			[
				'label'			=> __('On expiry Text', 'pixerex-elements'),
				'type'			=> Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __('Countdown is finished!','prmeium_elementor'),
				'condition'		=> [
					'pixerex_countdown_expire_text_url' => 'text'
				]
			]
		);

		$this->add_control(
			'pixerex_countdown_expiry_redirection_',
			[
				'label'			=> __('Redirect To', 'pixerex-elements'),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
				'condition'		=> [
					'pixerex_countdown_expire_text_url' => 'url'
				],
				'default'		=> get_permalink( 1 )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pixerex_countdown_transaltion',
			[
				'label' => __( 'Strings Translation' , 'pixerex-elements' )
			]
		);

		$this->add_control(
			'pixerex_countdown_day_singular',
		  	[
		     	'label'			=> __( 'Day (Singular)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Day'
		  	]
		);

		$this->add_control(
			'pixerex_countdown_day_plural',
		  	[
		     	'label'			=> __( 'Day (Plural)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Days'
		  	]
		);

		$this->add_control(
			'pixerex_countdown_week_singular',
		  	[
		     	'label'			=> __( 'Week (Singular)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Week'
		  	]
		);

		$this->add_control(
			'pixerex_countdown_week_plural',
		  	[
		     	'label'			=> __( 'Weeks (Plural)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Weeks'
		  	]
		);


		$this->add_control(
			'pixerex_countdown_month_singular',
		  	[
		     	'label'			=> __( 'Month (Singular)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Month'
		  	]
		);


		$this->add_control(
			'pixerex_countdown_month_plural',
		  	[
		     	'label'			=> __( 'Months (Plural)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Months'
		  	]
		);


		$this->add_control(
			'pixerex_countdown_year_singular',
		  	[
		     	'label'			=> __( 'Year (Singular)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Year'
		  	]
		);


		$this->add_control(
			'pixerex_countdown_year_plural',
		  	[
		     	'label'			=> __( 'Years (Plural)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Years'
		  	]
		);


		$this->add_control(
			'pixerex_countdown_hour_singular',
		  	[
		     	'label'			=> __( 'Hour (Singular)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Hour'
		  	]
		);


		$this->add_control(
			'pixerex_countdown_hour_plural',
		  	[
		     	'label'			=> __( 'Hours (Plural)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Hours'
		  	]
		);


		$this->add_control(
			'pixerex_countdown_minute_singular',
		  	[
		     	'label'			=> __( 'Minute (Singular)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Minute'
		  	]
		);

		$this->add_control(
			'pixerex_countdown_minute_plural',
		  	[
		     	'label'			=> __( 'Minutes (Plural)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Minutes'
		  	]
		);

        $this->add_control(
			'pixerex_countdown_second_singular',
		  	[
		     	'label'			=> __( 'Second (Singular)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Second',
		  	]
		);
        
		$this->add_control(
			'pixerex_countdown_second_plural',
		  	[
		     	'label'			=> __( 'Seconds (Plural)', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Seconds'
		  	]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pixerex_countdown_typhography',
			[
				'label' => __( 'Digits' , 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'pixerex_countdown_digit_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pixerex_countdown_digit_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount',
				'separator'		=> 'after'
			]
		);
        
        
        $this->add_control(
			'pixerex_countdown_timer_digit_bg_color',
			[
				'label' 		=> __( 'Background Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_countdown_units_shadow',
                'selector'      => '{{WRAPPER}} .countdown .pre_countdown-section',
            ]
        );
        
        $this->add_responsive_control(
			'pixerex_countdown_digit_bg_size',
		  	[
		     	'label'			=> __( 'Background Size', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 30
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 400,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'padding: {{SIZE}}px;'
				]
		  	]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'          => 'pixerex_countdown_digits_border',
                    'selector'      => '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount',
                ]);

        $this->add_control('pixerex_countdown_digit_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_countdown_unit_style', 
            [
                'label'         => __('Units', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
            );

        $this->add_control(
			'pixerex_countdown_unit_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-period' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pixerex_countdown_unit_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-period',
			]
		);
        
        $this->add_control(
			'pixerex_countdown_unit_backcolor',
			[
				'label' 		=> __( 'Background Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-period' => 'background-color: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
			'pixerex_countdown_separator_width',
			[
				'label'			=> __( 'Spacing in Between', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::SLIDER,
				'default' 		=> [
					'size' => 40,
				],
				'range' 		=> [
					'px' 	=> [
						'min' => 0,
						'max' => 200,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section' => 'margin-right: calc( {{SIZE}}{{UNIT}} / 2 ); margin-left: calc( {{SIZE}}{{UNIT}} / 2 );'
				],
                'condition'		=> [
					'pixerex_countdown_separator!' => 'yes'
				],
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_countdown_separator_style', 
            [
                'label'         => __('Separator', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'		=> [
                    'pixerex_countdown_style'   => 'd-u-u',
					'pixerex_countdown_separator' => 'yes'
				],
            ]
            );
        
        $this->add_responsive_control(
			'pixerex_countdown_separator_size',
		  	[
		     	'label'			=> __( 'Size', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .pre-countdown_separator' => 'font-size: {{SIZE}}px;'
				]
		  	]
		);

        $this->add_control(
			'pixerex_countdown_separator_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .pre-countdown_separator' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_responsive_control('pixerex_countdown_separator_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pre-countdown_separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );
        
        $this->end_controls_section();
        
	}

	protected function render( ) {
		
      	$settings = $this->get_settings_for_display();

      	$target_date = str_replace('-', '/', $settings['pixerex_countdown_date_time'] );
        
      	$formats = $settings['pixerex_countdown_units'];
      	$format = implode('', $formats );
      	$time = str_replace('-', '/', current_time('mysql') );
      	
      	if( $settings['pixerex_countdown_s_u_time'] == 'wp-time' ) : 
			$sent_time = $time;
        else:
            $sent_time = '';
        endif;

		$redirect = !empty( $settings['pixerex_countdown_expiry_redirection_'] ) ? esc_url($settings['pixerex_countdown_expiry_redirection_']) : '';
        
      	// Singular labels set up
      	$y = !empty( $settings['pixerex_countdown_year_singular'] ) ? $settings['pixerex_countdown_year_singular'] : 'Year';
      	$m = !empty( $settings['pixerex_countdown_month_singular'] ) ? $settings['pixerex_countdown_month_singular'] : 'Month';
      	$w = !empty( $settings['pixerex_countdown_week_singular'] ) ? $settings['pixerex_countdown_week_singular'] : 'Week';
      	$d = !empty( $settings['pixerex_countdown_day_singular'] ) ? $settings['pixerex_countdown_day_singular'] : 'Day';
      	$h = !empty( $settings['pixerex_countdown_hour_singular'] ) ? $settings['pixerex_countdown_hour_singular'] : 'Hour';
      	$mi = !empty( $settings['pixerex_countdown_minute_singular'] ) ? $settings['pixerex_countdown_minute_singular'] : 'Minute';
      	$s = !empty( $settings['pixerex_countdown_second_singular'] ) ? $settings['pixerex_countdown_second_singular'] : 'Second';
      	$label = $y."," . $m ."," . $w ."," . $d ."," . $h ."," . $mi ."," . $s;

      	// Plural labels set up
      	$ys = !empty( $settings['pixerex_countdown_year_plural'] ) ? $settings['pixerex_countdown_year_plural'] : 'Years';
      	$ms = !empty( $settings['pixerex_countdown_month_plural'] ) ? $settings['pixerex_countdown_month_plural'] : 'Months';
      	$ws = !empty( $settings['pixerex_countdown_week_plural'] ) ? $settings['pixerex_countdown_week_plural'] : 'Weeks';
      	$ds = !empty( $settings['pixerex_countdown_day_plural'] ) ? $settings['pixerex_countdown_day_plural'] : 'Days';
      	$hs = !empty( $settings['pixerex_countdown_hour_plural'] ) ? $settings['pixerex_countdown_hour_plural'] : 'Hours';
      	$mis = !empty( $settings['pixerex_countdown_minute_plural'] ) ? $settings['pixerex_countdown_minute_plural'] : 'Minutes';
      	$ss = !empty( $settings['pixerex_countdown_second_plural'] ) ? $settings['pixerex_countdown_second_plural'] : 'Seconds';
      	$labels1 = $ys."," . $ms ."," . $ws ."," . $ds ."," . $hs ."," . $mis ."," . $ss;
      	
        $expire_text = $settings['pixerex_countdown_expiry_text_'];
        
      	$pcdt_style = $settings['pixerex_countdown_style'] == 'd-u-s' ? ' side' : ' down';
        
        if( $settings['pixerex_countdown_expire_text_url'] == 'text' ){
            $event = 'onExpiry';
            $text = $expire_text;
        }
        
        if( $settings['pixerex_countdown_expire_text_url'] == 'url' ){
            $event = 'expiryUrl';
            $text = $redirect;
        }
        
        $separator_text = ! empty ( $settings['pixerex_countdown_separator_text'] ) ? $settings['pixerex_countdown_separator_text'] : '';
        
        $countdown_settings = [
            'label1'    => $label,
            'label2'    => $labels1,
            'until'     => $target_date,
            'format'    => $format,
            'event'     => $event,
            'text'      => $text,
            'serverSync'=> $sent_time,
            'separator' => $separator_text
        ];
        
      	?>
        <div id="countDownContiner-<?php echo esc_attr($this->get_id()); ?>" class="pixerex-countdown pixerex-countdown-separator-<?php  echo $settings['pixerex_countdown_separator']; ?>" data-settings='<?php echo wp_json_encode( $countdown_settings ); ?>'>
            <div id="countdown-<?php echo esc_attr( $this->get_id() ); ?>" class="pixerex-countdown-init countdown<?php echo $pcdt_style; ?>"></div>
        </div>
      	<?php
    }
}