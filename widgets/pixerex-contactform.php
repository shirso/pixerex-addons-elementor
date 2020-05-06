<?php 

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Contactform extends Widget_Base {

	public function get_name() {
		return 'pixerex-contact-form';
	}

	public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Contact Form7', 'pixerex-elements') );
	}

	public function get_icon() {
		return 'pa-contact-form';
    }
    
    public function get_categories() {
		return array( 'pixerex-elements');
	}
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
	}
	
	public function get_script_depends() {
		return [
            'pixerex-elements-js'
        ];
	}

    // Adding the controls fields for the contact form widget
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

  		$this->start_controls_section('pixerex_section_wpcf7_form',
  			[
  				'label' => __( 'Contact Form', 'pixerex-elements' )
  			]
  		);

        
		$this->add_control('pixerex_wpcf7_form',
			[
				'label' => __( 'Select Your Contact Form', 'pixerex-elements' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_wpcf_forms(),
			]
		);

		
		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_wpcf7_fields', 
            [
                'label'     => __('Fields', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_wpcf7_fields_heading',
            [
                'label'     => __('Width', 'pixerex-elements'),
                'type'      => Controls_Manager::HEADING
            ]
        );
        
        $this->add_responsive_control('pixerex_elements_input_width',
  			[
  				'label' => __( 'Input Field', 'pixerex-elements' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
                'default'   => [
                    'size'  => 100,
                    'unit'  => '%'
                ],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-text, {{WRAPPER}} .pixerex-cf7-container .wpcf7-file' => 'width: {{SIZE}}{{UNIT}};',
				],
  			]
  		);
        
         $this->add_responsive_control('pixerex_elements_textarea_width',
  			[
  				'label' => __( 'Text Area', 'pixerex-elements' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
                'default'   => [
                    'size'  => 100,
                    'unit'  => '%'
                ],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container textarea.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}};',
				],
  			]
  		);  
         
         $this->add_control('pixerex_wpcf7_fields_height_heading',
            [
                'label'     => __('Height', 'pixerex-elements'),
                'type'      => Controls_Manager::HEADING
            ]
        );
         
         $this->add_responsive_control('pixerex_elements_input_height',
  			[
  				'label' => __( 'Input Field', 'pixerex-elements' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
					'em' => [
						'min' => 1,
						'max' => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-text' => 'height: {{SIZE}}{{UNIT}};',
				],
  			]
  		);
        
         $this->add_responsive_control('pixerex_elements_textarea_height',
  			[
  				'label' => __( 'Text Area', 'pixerex-elements' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container textarea.wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}};',
				],
  			]
  		); 
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_wpcf7_button', 
            [
                'label'     => __('Button', 'pixerex-elements'),
            ]
        );
        
        $this->add_responsive_control('pixerex_elements_button_width',
  			[
  				'label' => __( 'Width', 'pixerex-elements' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit' => 'width: {{SIZE}}{{UNIT}};',
				],
  			]
  		);  
        
        
        $this->add_responsive_control('pixerex_elements_button_height',
  			[
  				'label' => __( 'Height', 'pixerex-elements' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
					'em' => [
						'min' => 1,
						'max' => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit' => 'height: {{SIZE}}{{UNIT}};',
				],
  			]
  		);
        
        $this->end_controls_section();
                
        $this->start_controls_section('section_contact_form_styles',
			[
				'label' => __( 'Form', 'pixerex-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_control('pixerex_elements_input_background',
			[
				'label'         => __( 'Input Field Background', 'pixerex-elements' ),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .pixerex-cf7-container input, {{WRAPPER}} .pixerex-cf7-container textarea' => 'background: {{VALUE}}',
				]
			]
		);
                
        $this->add_responsive_control('pixerex_elements_input_padding',
			[
				'label'         => __( 'Padding', 'pixerex-elements' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', 'em', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .pixerex-cf7-container input, {{WRAPPER}} .pixerex-cf7-container textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);            
                
        $this->add_group_control(
            Group_Control_Border::get_type(),
			[
				'name'          => 'pixerex_elements_input_border',
				'selector'      => '{{WRAPPER}} .pixerex-cf7-container input, {{WRAPPER}} .pixerex-cf7-container textarea',
			]
		);
                
        $this->add_responsive_control('pixerex_elements_input_border_radius',
			[
				'label' => __( 'Border Radius', 'pixerex-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input, {{WRAPPER}} .pixerex-cf7-container textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control('pixerex_elements_input_margin',
			[
				'label' => __( 'Margin', 'pixerex-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input, {{WRAPPER}} .pixerex-cf7-container textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control('pixerex_elements_input_focus',
			[
				'label' => __( 'Focus Border Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-text:focus, {{WRAPPER}} .pixerex-cf7-container textarea.wpcf7-textarea:focus , {{WRAPPER}} .pixerex-cf7-container .wpcf7-file:focus' => 'border-color: {{VALUE}};',
				],
			]
		);
                
        $this->add_control('pixerex_elements_input_focus_border_animation',
			[
				'label'         => __( 'Focus Border Animation', 'pixerex-elements' ),
				'type'          => Controls_Manager::SWITCHER,
                'prefix_class'  => 'pixerex-contact-form-anim-'
			]
		);
                		
        $this->add_control('pixerex_elements_input_focus_border_color',
			[
				'label'         => __( 'Focus Line Color', 'pixerex-elements' ),
				'type'          => Controls_Manager::COLOR,
                'condition'		=> [
					'pixerex_elements_input_focus_border_animation' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}}.pixerex-contact-form-anim-yes .wpcf7-span.is-focused::after' => 'background-color: {{VALUE}};',
				],
			]
		);
                
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_button_shadow',
				'selector' => '{{WRAPPER}} .pixerex-cf7-container input.wpcf7-text, {{WRAPPER}} .pixerex-cf7-container textarea.wpcf7-textarea, {{WRAPPER}} .pixerex-cf7-container .wpcf7-file',
			]
		);
     
        $this->end_controls_section();
		  
		
		$this->start_controls_section('section_contact_form_typography',
			[
				'label' => __( 'Labels', 'pixerex-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
                
        $this->add_control('pixerex_elements_heading_default',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Default Typography', 'pixerex-elements' ),
			]
		);
		
		$this->add_control('pixerex_elements_contact_form_color',
			[
				'label' => __( 'Default Font Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
                'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container, {{WRAPPER}} .pixerex-cf7-container label' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pixerex_elements_contact_form_default_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pixerex-cf7-container',
			]
		);
        
      $this->add_control('pixerex_elements_heading_input',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Input Typography', 'pixerex-elements' ),
                'separator' => 'before',
			]
		);
		
		$this->add_control('pixerex_elements_contact_form_field_color',
			[
				'label' => __( 'Input Text Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
                'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-text, {{WRAPPER}} .pixerex-cf7-container textarea.wpcf7-textarea' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pixerex_elements_contact_form_field_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pixerex-cf7-container input.wpcf7-text, {{WRAPPER}} .pixerex-cf7-container textarea.wpcf7-textarea',
			]
		);
        
		
		$this->add_control('pixerex_elements_contact_form_placeholder_color',
			[
				'label' => __( 'Placeholder Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container ::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pixerex-cf7-container ::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pixerex-cf7-container ::-ms-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);
	
		
		$this->end_controls_section();
                         
        $this->start_controls_section('section_contact_form_submit_button_styles',
			[
				'label' => __( 'Button', 'pixerex-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'section_title_pixerex_btn_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit',
			]
		);
		
		$this->add_responsive_control('section_title_pixerex_btn_padding',
			[
				'label' => __( 'Padding', 'pixerex-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		
		
		$this->start_controls_tabs( 'pixerex_elements_button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'pixerex-elements' ) ] );

		$this->add_control('pixerex_elements_button_text_color',
			[
				'label' => __( 'Text Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control('pixerex_elements_button_background_color',
			[
				'label' => __( 'Background Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
                'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pixerex_elements_btn_border',
				'selector' => '{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit',
			]
		);
		
		$this->add_responsive_control('pixerex_elements_btn_border_radius',
			[
				'label' => __( 'Border Radius', 'pixerex-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit' => 'border-radius: {{SIZE}}px;',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab('pixerex_elements_hover',
            [
                'label' => __( 'Hover', 'pixerex-elements' )
            ]
        );

		$this->add_control('pixerex_elements_button_hover_text_color',
			[
				'label' => __( 'Text Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control('pixerex_elements_button_hover_background_color',
			[
				'label' => __( 'Background Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control('pixerex_elements_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pixerex-cf7-container input.wpcf7-submit',
			]
		);
		
		$this->end_controls_section();
        
                
    }
        
    protected function get_wpcf_forms() {

        if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
            return array();
        }

        $forms = \WPCF7_ContactForm::find( array(
            'orderby' => 'title',
            'order'   => 'ASC',
        ) );

        if ( empty( $forms ) ) {
            return array();
        }

        $result = array();

        foreach ( $forms as $item ) {
            $key            = sprintf( '%1$s::%2$s', $item->id(), $item->title() );
            $result[ $key ] = $item->title();
        }

        return $result;
    }
    
    protected function render() {

		$settings = $this->get_settings();

		if ( ! empty( $settings['pixerex_wpcf7_form'] ) ) { 
		
			$this->add_render_attribute( 'container', 'class', 'pixerex-cf7-container' );
			
		?>

            <div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
    			<?php echo do_shortcode( '[contact-form-7 id="' . $settings['pixerex_wpcf7_form'] . '" ]' ); ?>
            </div>
        
		<?php
		}

	}
}