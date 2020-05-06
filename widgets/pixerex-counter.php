<?php 

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if( ! defined( 'ABSPATH' ) ) exit; // No access of directly access

class Pixerex_Counter extends Widget_Base {

	public function get_name() {
		return 'pixerex-counter';
	}

	public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Counter', 'pixerex-elements') );
	}

	public function get_icon() {
		return 'eicon-counter';
	}
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }

	public function get_script_depends() {
		return [
            'jquery-numerator',
            'elementor-waypoints',
            'pixerex-elements-js',
        ];
	}

	public function get_categories() {
		return [ 'pixerex-elements'];
	}

    // Adding the controls fields for the counter widget
	// This will controls the animation, colors and background, dimensions etc
	protected function _register_controls() {
		$this->start_controls_section('pixerex_counter_global_settings',
			[
				'label'         => __( 'Counter', 'pixerex-elements' )
			]
		);
        
        $this->add_control('pixerex_counter_title',
			[
				'label'			=> __( 'Title', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Enter title for stats counter block', 'pixerex-elements'),
			]
		);
        
		$this->add_control('pixerex_counter_start_value',
			[
				'label'			=> __( 'Starting Number', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 0
			]
		);
        
        $this->add_control('pixerex_counter_end_value',
			[
				'label'			=> __( 'Ending Number', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 500
			]
		);

		$this->add_control('pixerex_counter_t_separator',
			[
				'label'			=> __( 'Thousands Separator', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Separator converts 125000 into 125,000', 'pixerex-elements' ),
				'default'		=> ','
			]
		);

		$this->add_control('pixerex_counter_d_after',
			[
				'label'			=> __( 'Digits After Decimal Point', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 0
			]
		);

		$this->add_control('pixerex_counter_preffix',
			[
				'label'			=> __( 'Value Prefix', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Enter prefix for counter value', 'pixerex-elements' )
			]
		);

		$this->add_control('pixerex_counter_suffix',
			[
				'label'			=> __( 'Value suffix', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Enter suffix for counter value', 'pixerex-elements' )
			]
		);

		$this->add_control('pixerex_counter_speed',
			[
				'label'			=> __( 'Rolling Time', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> __( 'How long should it take to complete the digit?', 'pixerex-elements' ),
				'default'		=> 3
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_display_options',
			[
				'label'         => __( 'Display Options', 'pixerex-elements' )
			]
		);

		$this->add_control('pixerex_counter_icon_image',
		  	[
		     	'label'			=> __( 'Icon Type', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SELECT,
                'description'   => __('Use a font awesome icon or upload a custom image', 'pixerex-elements'),
		     	'options'		=> [
		     		'icon'  => __('Font Awesome', 'pixerex-elements'),
		     		'custom'=> __( 'Custom Image', 'pixerex-elements')
		     	],
		     	'default'		=> 'icon'
		  	]
		);

		$this->add_control('pixerex_counter_icon_updated',
		  	[
		     	'label'			=> __( 'Select an Icon', 'pixerex-elements' ),
		     	'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_counter_icon',
                'default' => [
                    'value'     => 'fas fa-clock',
                    'library'   => 'fa-solid',
                ],
			  	'condition'		=> [
			  		'pixerex_counter_icon_image' => 'icon'
			  	]
		  	]
		);

		$this->add_control('pixerex_counter_image_upload',
		  	[
		     	'label'			=> __( 'Upload Image', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::MEDIA,
			  	'condition'			=> [
			  		'pixerex_counter_icon_image' => 'custom'
			  	],
			  	'default'		=> [
			  		'url' => Utils::get_placeholder_image_src(),
			  	]
		  	]
		);
        
        $this->add_control('pixerex_counter_icon_position',
			[
				'label'			=> __( 'Icon Position', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
                'description'	=> __( 'Choose a position for your icon', 'pixerex-elements'),
				'default'		=> 'no-animation',
				'options'		=> [
					'top'   => __( 'Top', 'pixerex-elements' ),
					'right' => __( 'Right', 'pixerex-elements' ),
					'left'  => __( 'Left', 'pixerex-elements' ),
					
				],
				'default' 		=> 'top',
				'separator' 	=> 'after'
			]
		);
        
        $this->add_control('pixerex_counter_icon_animation', 
            [
                'label'         => __('Animations', 'pixerex-elements'),
                'type'          => Controls_Manager::ANIMATION,
                'render_type'   => 'template'
            ]
            );
        
		
		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_icon_style_tab',
			[
				'label'         => __( 'Icon' , 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_control('pixerex_counter_icon_color',
		  	[
				'label'         => __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .icon i' => 'color: {{VALUE}};'
				],
			  	'condition'     => [
			  		'pixerex_counter_icon_image' => 'icon'
			  	]
			]
		);
        
        $this->add_responsive_control('pixerex_counter_icon_size',
		  	[
		     	'label'			=> __( 'Size', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SLIDER,
		     	'default' => [
					'size' => 70,
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			  	'condition'     => [
			  		'pixerex_counter_icon_image' => 'icon'
			  	]
		  	]
		);

		$this->add_responsive_control('pixerex_counter_image_size',
		  	[
		     	'label'			=> __( 'Size', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SLIDER,
		     	'default' => [
					'size' => 60,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon img.custom-image' => 'width: {{SIZE}}%;'
				],
			  	'condition'     => [
			  		'pixerex_counter_icon_image' => 'custom'
			  	]
		  	]
		);

		$this->add_control('pixerex_counter_icon_style',
		  	[
				'label' 		=> __( 'Style', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::SELECT,
                'description'   => __('We are giving you three quick preset if you are in a hurry. Otherwise, create your own with various options', 'pixerex-elements'),
				'options'		=> [
					'simple'=> __( 'Simple', 'pixerex-elements' ),
					'circle'=> __( 'Circle Background', 'pixerex-elements' ),
					'square'=> __( 'Square Background', 'pixerex-elements' ),
					'design'=> __( 'Design Your Own', 'pixerex-elements' )
				],
				'default' 		=> 'simple'
			]
		);

		$this->add_control('pixerex_counter_icon_bg',
			[
				'label' 		=> __( 'Background Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'condition'		=> [
					'pixerex_counter_icon_style!' => 'simple'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .icon-bg' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control('pixerex_counter_icon_bg_size',
		  	[
		     	'label'			=> __( 'Background size', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SLIDER,
		     	'default' => [
					'size' => 150,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 600,
					]
				],
				'condition'		=> [
					'pixerex_counter_icon_style!' => 'simple'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon span.icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
				]
		  	]
		);

		$this->add_responsive_control('pixerex_counter_icon_v_align',
		  	[
		     	'label'			=> __( 'Vertical Alignment', 'pixerex-elements' ),
		     	'type' 			=> Controls_Manager::SLIDER,
		     	'default' => [
					'size' => 150,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 600,
					]
				],
				'condition'		=> [
					'pixerex_counter_icon_style!' => 'simple'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon span.icon' => 'line-height: {{SIZE}}{{UNIT}};'
				]
		  	]
		);
        
        
        $this->add_group_control(
        Group_Control_Border::get_type(),
            [
                'name'          => 'pixerex_icon_border',
                'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .design',
                'condition'		=> [
					'pixerex_counter_icon_style' => 'design'
				]
            ]
            );

        $this->add_control('pixerex_icon_border_radius',
                [
                    'label'     => __('Border Radius', 'pixerex-elements'),
                    'type'      => Controls_Manager::SLIDER,
                    'size_units'=> ['px', '%' ,'em'],
                    'default'   => [
                        'unit'      => 'px',
                        'size'      => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .design' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ],
                    'condition'	=> [
					'pixerex_counter_icon_style' => 'design'
				]
                ]
                );
        
        $this->end_controls_section();
        
        
		$this->start_controls_section('pixerex_counter_title_style',
			[
				'label'         => __( 'Title' , 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control('pixerex_counter_title_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-title' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_title_typho',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-title',
			]
		);
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'pixerex_counter_title_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-title',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_value_style',
            [
                'label'         => __('Value', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
            );
        
		$this->add_control('pixerex_counter_value_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-init' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_value_typho',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-init',
				'separator'		=> 'after'
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_suffix_prefix_style',
            [
                'label'         => __('Prefix & Suffix', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
            );
        
        $this->add_control('pixerex_counter_prefix_color',
			[
				'label' 		=> __( 'Prefix Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pixerex-counter-area span#prefix' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_prefix_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area span#prefix',
                'separator'     => 'after',
			]
		);

		$this->add_control('pixerex_counter_suffix_color',
			[
				'label' 		=> __( 'Suffix Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pixerex-counter-area span#suffix' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_suffix_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area span#suffix',
                'separator'     => 'after',
			]
		);

		$this->end_controls_section();

	}
    
    public function get_counter_content($settings, $direction) {

        $start_value = $settings['pixerex_counter_start_value'];
        
    ?>
    
        <div class="pixerex-init-wrapper <?php echo $direction; ?>">

            <?php if ( ! empty( $settings['pixerex_counter_preffix'] ) ) : ?>
                <span id="prefix" class="counter-su-pre"><?php echo $settings['pixerex_counter_preffix']; ?></span>
            <?php endif; ?>

            <span class="pixerex-counter-init" id="counter-<?php echo esc_attr($this->get_id()); ?>"><?php echo $start_value; ?></span>

            <?php if ( ! empty( $settings['pixerex_counter_suffix'] ) ) : ?>
                <span id="suffix" class="counter-su-pre"><?php echo $settings['pixerex_counter_suffix']; ?></span>
            <?php endif; ?>

            <?php if ( ! empty( $settings['pixerex_counter_title'] ) ) : ?>
                <h4 class="pixerex-counter-title">
                    <div <?php echo $this->get_render_attribute_string('pixerex_counter_title'); ?>>
                        <?php echo $settings['pixerex_counter_title'];?>
                    </div>
                </h4>
            <?php endif; ?>
        </div>

    <?php   
    }
    
    public function get_counter_icon( $settings, $direction ) {
        
        $icon_style = $settings['pixerex_counter_icon_style'] != 'simple' ? ' icon-bg ' . $settings['pixerex_counter_icon_style'] : '';
        
        $animation = $settings['pixerex_counter_icon_animation'];
        
        if ( $settings['pixerex_counter_icon_image'] === 'icon' ) {
            if ( ! empty ( $settings['pixerex_counter_icon'] )  ) {
                $this->add_render_attribute( 'icon', 'class', $settings['pixerex_counter_icon'] );
                $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
            }
            
            $migrated = isset( $settings['__fa4_migrated']['pixerex_counter_icon_updated'] );
            $is_new = empty( $settings['pixerex_counter_icon'] ) && Icons_Manager::is_migration_allowed();
        } else {
            $alt = esc_attr( Control_Media::get_image_alt( $settings['pixerex_counter_image_upload'] ) );
            
            $this->add_render_attribute( 'image', 'class', 'custom-image' );
            $this->add_render_attribute( 'image', 'src', $settings['pixerex_counter_image_upload']['url'] );
            $this->add_render_attribute( 'image', 'alt', $alt );
        }
        
        $flex_width = '';
 		if( $settings['pixerex_counter_icon_image'] == 'custom' && $settings['pixerex_counter_icon_style'] == 'simple' ) {
 			$flex_width = ' flex-width ';
 		}
        
        ?>

        <div class="pixerex-counter-icon <?php echo $direction; ?>">
            
            <span class="icon<?php echo $flex_width; ?><?php echo $icon_style; ?>" data-animation="<?php echo $animation; ?>">
            
                <?php if( $settings['pixerex_counter_icon_image'] === 'icon' ) {
        
                    if ( $is_new || $migrated ) :
                        Icons_Manager::render_icon( $settings['pixerex_counter_icon_updated'], [ 'aria-hidden' => 'true' ] );
                    else: ?>
                        <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                    <?php endif;
                } else { ?>
                    <img <?php echo $this->get_render_attribute_string('image'); ?>>
                <?php } ?>
            
            </span>
        </div>

    <?php
    }

	protected function render() {
        
		$settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('pixerex_counter_title');
         
		$position = $settings['pixerex_counter_icon_position'];
		
        $center = $position == 'top' ? ' center' : '';
        
        $left = $position == 'left' ? ' left' : '';
        
 		$flex_width = '';
 		if( $settings['pixerex_counter_icon_image'] == 'custom' && $settings['pixerex_counter_icon_style'] == 'simple' ) {
 			$flex_width = ' flex-width ';
 		}
        
        $this->add_render_attribute( 'counter', [
                'class' 			=> [ 'pixerex-counter', 'pixerex-counter-area' . $center ],
				'data-duration' 	=> $settings['pixerex_counter_speed'] * 1000,
				'data-from-value' 	=> $settings['pixerex_counter_start_value'],
				'data-to-value' 	=> $settings['pixerex_counter_end_value'],
                'data-delimiter'	=>  empty( $settings['pixerex_counter_t_separator'] ) ? ',' : $settings['pixerex_counter_t_separator'],
                'data-rounding' 	=> empty ( $settings['pixerex_counter_d_after'] ) ? 0  : $settings['pixerex_counter_d_after']
            ]
        );

		?>

        <div <?php echo $this->get_render_attribute_string('counter'); ?>>
            <?php if( $position == 'right' ) {
                $this->get_counter_content( $settings, $position );
                if( ! empty( $settings['pixerex_counter_icon_updated']['value'] ) || ! empty( $settings['pixerex_counter_icon'] ) || ! empty( $settings['pixerex_counter_image_upload']['url'] ) ) {
                    $this->get_counter_icon( $settings, $position );
                }
            
            } else { 
                if( ! empty( $settings['pixerex_counter_icon_updated']['value'] ) || ! empty( $settings['pixerex_counter_icon'] ) || ! empty( $settings['pixerex_counter_image_upload']['url'] ) ) {
                    $this->get_counter_icon( $settings, $left );
                } 
                $this->get_counter_content( $settings, $left );
            ?>

            <?php } ?>

        </div>

		<?php
	}
    
    protected function _content_template() {
        ?>
        <#
            
            var iconImage,
                position,
                center,
                left;
                
        
            view.addInlineEditingAttributes('title');
            
            position = settings.pixerex_counter_icon_position;

            center = 'top' === position ? ' center' : '';

            left = 'left' === center ? ' left' : '';

            var delimiter = '' === settings.pixerex_counter_t_separator ? ',' : settings.pixerex_counter_t_separator,
                round     = '' === settings.pixerex_counter_d_after ? 0 : settings.pixerex_counter_d_after;
            
            view.addRenderAttribute( 'counter', 'class', [ 'pixerex-counter', 'pixerex-counter-area' + center ] );
            view.addRenderAttribute( 'counter', 'data-duration', settings.pixerex_counter_speed * 1000 );
			view.addRenderAttribute( 'counter', 'data-from-value', settings.pixerex_counter_start_value );
            view.addRenderAttribute( 'counter', 'data-to-value', settings.pixerex_counter_end_value );
            view.addRenderAttribute( 'counter', 'data-delimiter', delimiter );
            view.addRenderAttribute( 'counter', 'data-rounding', round );
            
            function getCounterContent( direction ) {
            
                var startValue = settings.pixerex_counter_start_value;
                
                view.addRenderAttribute( 'counter_wrap', 'class', [ 'pixerex-init-wrapper', direction ] );
                
                view.addRenderAttribute( 'value', 'id', 'counter-' + view.getID() );
                
                view.addRenderAttribute( 'value', 'class', 'pixerex-counter-init' );
                
            #>
            
                <div {{{ view.getRenderAttributeString('counter_wrap') }}}>

                    <# if ( '' !== settings.pixerex_counter_preffix ) { #>
                        <span id="prefix" class="counter-su-pre">{{{ settings.pixerex_counter_preffix }}}</span>
                    <# } #>

                    <span {{{ view.getRenderAttributeString('value') }}}>{{{ startValue }}}</span>

                    <# if ( '' !== settings.pixerex_counter_suffix ) { #>
                        <span id="suffix" class="counter-su-pre">{{{ settings.pixerex_counter_suffix }}}</span>
                    <# } #>

                    <# if ( '' !== settings.pixerex_counter_title ) { #>
                        <h4 class="pixerex-counter-title">
                            <div {{{ view.getRenderAttributeString('title') }}}>
                                {{{ settings.pixerex_counter_title }}}
                            </div>
                        </h4>
                    <# } #>
                </div>
            
            <#
            }
            
            function getCounterIcon( direction ) {
            
                var iconStyle = 'simple' !== settings.pixerex_counter_icon_style ? ' icon-bg ' + settings.pixerex_counter_icon_style : '',
                    animation = settings.pixerex_counter_icon_animation,
                    flexWidth = '';
                
                var iconHTML = elementor.helpers.renderIcon( view, settings.pixerex_counter_icon_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                    migrated = elementor.helpers.isIconMigrated( settings, 'pixerex_counter_icon_updated' );
                    
                if( 'custom' === settings.pixerex_counter_icon_image && 'simple' ===  settings.pixerex_counter_icon_style ) {
                    flexWidth = ' flex-width ';
                }
                
                view.addRenderAttribute( 'icon_wrap', 'class', [ 'pixerex-counter-icon', direction ] );
                
                var iconClass = 'icon' + flexWidth + iconStyle;
            
            #>

            <div {{{ view.getRenderAttributeString('icon_wrap') }}}>
                <span data-animation="{{ animation }}" class="{{ iconClass }}">
                    <# if( 'icon' === settings.pixerex_counter_icon_image ) {
                        if ( iconHTML && iconHTML.rendered && ( ! settings.pixerex_counter_icon || migrated ) ) { #>
                            {{{ iconHTML.value }}}
                        <# } else { #>
                            <i class="{{ settings.pixerex_counter_icon }}" aria-hidden="true"></i>
                        <# } #>
                    <# } else { #>
                        <img class="custom-image" src="{{ settings.pixerex_counter_image_upload.url }}">
                    <# } #>
                </span>
            </div>
            
            <#
            }
           
        #>
        
        <div {{{ view.getRenderAttributeString('counter') }}}>
            <# if( 'right' === position  ) {
            
                getCounterContent( position );
                
                if(  '' !== settings.pixerex_counter_icon_updated.value || '' !== settings.pixerex_counter_icon || '' !== settings.pixerex_counter_image_upload.url ) {
                    getCounterIcon( position );
                }
            
            } else {
            
                if(  '' !== settings.pixerex_counter_icon_updated.value || '' !== settings.pixerex_counter_icon || '' !== settings.pixerex_counter_image_upload.url ) {
                    getCounterIcon( position );
                }
                
                getCounterContent( position );
            
            } #>
        </div>
        
        <?php
    }
}