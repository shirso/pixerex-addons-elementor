<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Progressbar extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-progressbar';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Progress Bar', 'pixerex-elements') );
	}
    
    public function get_icon() {
        return 'eicon-skill-bar';
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
            'elementor-waypoints',
            'pixerex-elements-js'
        ];
    }

    // Adding the controls fields for the progress bar widget
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /* Start Progress Content Section */
        $this->start_controls_section('pixerex_progressbar_labels',
                [
                    'label'         => __('Progress Bar Settings', 'pixerex-elements'),
                    ]
                );
        $this->add_control('pixerex_progressbar_select_label', 
                [
                    'label'         => __('Number of Labels', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       =>'left_right_labels',
                    'options'       => [
                        'left_right_labels'    => __('Left & Right Labels', 'pixerex-elements'),
                        'more_labels'          => __('Multiple Labels', 'pixerex-elements'),
                        ],
                ]
        );
        
        /*Left Label*/ 
        $this->add_control('pixerex_progressbar_left_label',
                [
                    'label'         => __('Title', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('My Skill','pixerex-elements'),
                    'label_block'   => true,
                    'condition'     =>[
                        'pixerex_progressbar_select_label' => 'left_right_labels'
                    ]
                ]
                );

        /*Right Label*/ 
        $this->add_control('pixerex_progressbar_right_label',
                [
                    'label'         => __('Percentage', 'pixerex-elements'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('50%','pixerex-elements'),
                    'label_block'   => true,
                    'condition'     =>[
                        'pixerex_progressbar_select_label' => 'left_right_labels'
                    ]
                ]
                );
        
        $repeater = new REPEATER();
        
        $repeater->add_control('text',
            [
                'label'             => __( 'Label','pixerex-elements' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'label_block'       => true,
                'placeholder'       => __( 'label','pixerex-elements' ),
                'default'           => __( 'label', 'pixerex-elements' ),
            ]
        );
        
        $repeater->add_control('number',
            [
                'label'             => __( 'Percentage', 'pixerex-elements' ),
                'dynamic'           => [ 'active' => true ],
                'type'              => Controls_Manager::TEXT,
                'default'           => 50,
            ]
        );
        
        $this->add_control('pixerex_progressbar_multiple_label',
            [
                'label'     => __('Label','pixerex-elements'),
                'type'      => Controls_Manager::REPEATER,
                'default'   => [
                    [
                        'text' => __( 'Label','pixerex-elements' ),
                        'number' => 50
                    ]
                    ],
                'fields'    => array_values( $repeater->get_controls() ),
                'condition' => [
                    'pixerex_progressbar_select_label'  =>'more_labels'
                ] 
            ]
        );
        
        $this->add_control('pixerex_progress_bar_space_percentage_switcher',
                [
                    'label'      => __('Enable Percentage', 'pixerex-elements'),
                    'type'       => Controls_Manager::SWITCHER,
                    'default'     => 'yes',
                    'description' => __('Enable percentage for labels','pixerex-elements'),
                    'condition'   => [
                        'pixerex_progressbar_select_label'=>'more_labels',
                        ]
                ]
        );
        
        $this->add_control('pixerex_progressbar_select_label_icon', 
                [
                    'label'         => __('Labels Indicator', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       =>'line_pin',
                    'options'       => [
                        ''            => __('None','pixerex-elements'),
                        'line_pin'    => __('Pin', 'pixerex-elements'),
                        'arrow'       => __('Arrow','pixerex-elements'),
                        ],
                    'condition'     =>[
                        'pixerex_progressbar_select_label' => 'more_labels'
                    ]
                ]
        );
        
        $this->add_control('pixerex_progressbar_more_labels_align',
                [
                    'label'         => __('Labels Alignment','pixerex-elements'),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                            'left'      => [
                                        'title'=> __( 'Left', 'pixerex-elements' ),
                                        'icon' => 'fa fa-align-left',   
                                    ],
                            'center'     => [
                                        'title'=> __( 'Center', 'pixerex-elements' ),
                                        'icon' => 'fa fa-align-center',
                                    ],
                            'right'     => [
                                        'title'=> __( 'Right', 'pixerex-elements' ),
                                        'icon' => 'fa fa-align-right',
                                    ],
                    ],
                    'default'       => 'center',
                    'condition'     =>[
                        'pixerex_progressbar_select_label' => 'more_labels'
                    ]
                    
                ]
        );
    
        /*Progressbar Width*/
        $this->add_control('pixerex_progressbar_progress_percentage',
            [
                'label'             => __('Value', 'pixerex-elements'),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'default'           => 50
            ]
        );
        
        /*Progress Bar Style*/
        $this->add_control('pixerex_progressbar_progress_style', 
                [
                    'label'         => __('Type', 'pixerex-elements'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'solid',
                    'options'       => [
                        'solid'    => __('Solid', 'pixerex-elements'),
                        'stripped' => __('Striped', 'pixerex-elements'),
                        ],
                    ]
                );
        
        $this->add_control('pixerex_progressbar_speed',
            [
                'label'             => __('Speed (milliseconds)', 'pixerex-elements'),
                'type'              => Controls_Manager::NUMBER
            ]
        );
        
        /*Progress Bar Animated*/
        $this->add_control('pixerex_progressbar_progress_animation', 
                [
                    'label'         => __('Animated', 'pixerex-elements'),
                    'type'          => Controls_Manager::SWITCHER,
                    'condition'     => [
                        'pixerex_progressbar_progress_style'    => 'stripped'
                        ]
                    ]
                );
        
        /*End Progress General Section*/
        $this->end_controls_section();

        /*Start Styling Section*/
        /*Start progressbar Settings*/
        $this->start_controls_section('pixerex_progressbar_progress_bar_settings',
            [
                'label'             => __('Progress Bar', 'pixerex-elements'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        /*Progressbar Height*/ 
        $this->add_control('pixerex_progressbar_progress_bar_height',
                [
                    'label'         => __('Height', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'default'       => [
                        'size'  => 25,
                        ],
                    'label_block'   => true,
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-progressbar-progress, {{WRAPPER}} .pixerex-progressbar-progress-bar' => 'height: {{SIZE}}px;',   
                    ]
                ]
                );

        /*Border Radius*/
        $this->add_control('pixerex_progressbar_progress_bar_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'default'       => [
                        'unit'  => 'px',
                        'size'  => 0,
                        ],
                    'range'         => [
                        'px'  => [
                            'min' => 0,
                            'max' => 60,
                            ],
                        ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-progressbar-progress-bar, {{WRAPPER}} .pixerex-progressbar-progress' => 'border-radius: {{SIZE}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->add_control('pixerex_progressbar_ind_background_hint',
                [
                    'label'             =>  __('Indicator Background', 'pixerex-elements'),
                    'type'              => Controls_Manager::HEADING,
                ]
                );
        
        /*Progress Bar Color Type*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_progressbar_progress_color',
                    'types'             => [ 'classic' , 'gradient' ],
                    'default'           => [
                        'color' => '#26beca',
                    ],
                    'selector'          => '{{WRAPPER}} .pixerex-progressbar-progress-bar',
                    ]
                );
        
        $this->add_control('pixerex_progressbar_main_background_hint',
                [
                    'label'             =>  __('Main Background', 'pixerex-elements'),
                    'type'              => Controls_Manager::HEADING,
                ]
                );
        
        /*Progress Bar Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_progressbar_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-progressbar-progress',
                    ]
                );
        $this->add_responsive_control('pixerex_progressbar_container_margin',
            [
                'label'             => __('Margin', 'pixerex-elements'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-progressbar-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        /*End Progress Bar Section*/
        $this->end_controls_section();

        /*Start Labels Settings Section*/
        $this->start_controls_section('pixerex_progressbar_labels_section',
                [
                    'label'         => __('Labels', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pixerex_progressbar_select_label'  => 'left_right_labels'
                    ]
                ]
                );
        
        $this->add_control('pixerex_progressbar_left_label_hint',
                [
                    'label'             =>  __('Title', 'pixerex-elements'),
                    'type'              => Controls_Manager::HEADING,
                ]
                );
        
        /*Left Label Color*/
        $this->add_control('pixerex_progressbar_left_label_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-left-label' => 'color: {{VALUE}};',
                ]
            ]
         );
        
        /*Left Label Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'left_label_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-progressbar-left-label',
                    ]
                );
        
        
        /*Left Label Margin*/
        $this->add_responsive_control('pixerex_progressbar_left_label_margin',
            [
                'label'             => __('Margin', 'pixerex-elements'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-progressbar-left-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('pixerex_progressbar_right_label_hint',
                [
                    'label'             =>  __('Percentage', 'pixerex-elements'),
                    'type'              => Controls_Manager::HEADING,
                    'separator'         => 'before'
                ]
                );
        
        /*Right Label Color*/
        $this->add_control('pixerex_progressbar_right_label_color',
             [
                'label'             => __('Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-right-label' => 'color: {{VALUE}};',
                ]
            ]
         );
        
        /*Right Label Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'right_label_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-progressbar-right-label',
                    ]
                );
        
        /*Right Label Margin*/
        $this->add_responsive_control('pixerex_progressbar_right_label_margin',
            [
                'label'             => __('Margin', 'pixerex-elements'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-progressbar-right-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        

        /*End Labels Settings Section*/
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_progressbar_multiple_labels_section',
                [
                    'label'         => __('Multiple Labels', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     =>[
                        'pixerex_progressbar_select_label'  => 'more_labels'
                    ]
                ]
                );
        $this->add_control('pixerex_progressbar_multiple_label_color',
             [
                'label'             => __('Labels\' Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-center-label' => 'color: {{VALUE}};',
                ]
            ]
         );
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [   
                    'label'         => __('Labels\' Typography', 'pixerex-elements'),
                    'name'          => 'more_label_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-progressbar-center-label',
                        
                    ]
                );
        $this->add_control('pixerex_progressbar_value_label_color',
             [
                'label'             => __('Percentage Color', 'pixerex-elements'),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                 'condition'       =>[
                     'pixerex_progress_bar_space_percentage_switcher'=>'yes'
                 ],
                'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-percentage' => 'color: {{VALUE}};',
                ]
            ]
         );
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [   
                    'label'         => __('Percentage Typography','pixerex-elements'),
                    'name'          => 'percentage_typography',
                    'condition'       =>[
                         'pixerex_progress_bar_space_percentage_switcher'=>'yes'
                    ],
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-progressbar-percentage',
                    ]
                );
         $this->end_controls_section();
         $this->start_controls_section('pixerex_progressbar_multiple_labels_arrow_section',
                [
                    'label'         => __('Arrow', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     =>[
                        'pixerex_progressbar_select_label'  => 'more_labels',
                        'pixerex_progressbar_select_label_icon' => 'arrow'
                    ]
                ]
                );
        
         /*Arrow color*/
        $this->add_control('pixerex_progressbar_arrow_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'          => Scheme_Color::get_type(),
                        'value'         => Scheme_Color::COLOR_1,
                    ],
                    'condition'     =>[
                        'pixerex_progressbar_select_label_icon' => 'arrow'
                    ],
                     'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-arrow' => 'color: {{VALUE}};'
                ]
            ]
         );
                
        /*Arrow Size*/
	 $this->add_responsive_control('pixerex_arrow_size',
            [
                    'label'	       => __('Size','pixerex-elements'),
                    'type'             =>Controls_Manager::SLIDER,
                    'size_units'       => ['px', "em"],
                    'condition'        =>[
                        'pixerex_progressbar_select_label_icon' => 'arrow'
                    ],
                    'selectors'          => [
                        '{{WRAPPER}} .pixerex-progressbar-arrow' => 'border-width: {{SIZE}}{{UNIT}};'
                        ]
            ]
        );
       $this->end_controls_section();
       $this->start_controls_section('pixerex_progressbar_multiple_labels_pin_section',
                [
                    'label'         => __('Indicator', 'pixerex-elements'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     =>[
                        'pixerex_progressbar_select_label'  => 'more_labels',
                        'pixerex_progressbar_select_label_icon' => 'line_pin'
                    ]
                ]
                );
        
       $this->add_control('pixerex_progressbar_line_pin_color',
                [
                    'label'             => __('Color', 'pixerex-elements'),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'               => Scheme_Color::get_type(),
                        'value'              => Scheme_Color::COLOR_2,
                    ],
                    'condition'         =>[
                        'pixerex_progressbar_select_label_icon' =>'line_pin'
                    ],
                     'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-pin' => 'border-color: {{VALUE}};'
                ]
            ]
         );
        $this->add_responsive_control('pixerex_pin_size',
            [
                    'label'	       => __('Size','pixerex-elements'),
                    'type'             =>Controls_Manager::SLIDER,
                    'size_units'       => ['px', "em"],
                    'condition'        =>[
                        'pixerex_progressbar_select_label_icon' => 'line_pin'
                    ],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-progressbar-pin' => 'border-left-width: {{SIZE}}{{UNIT}};'
                        ]
            ]
        );
        $this->add_responsive_control('pixerex_pin_height',
            [
                    'label'	       => __('Height','pixerex-elements'),
                    'type'             =>Controls_Manager::SLIDER,
                    'size_units'       => ['px', "em"],
                    'condition'        =>[
                        'pixerex_progressbar_select_label_icon' => 'line_pin'
                    ],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-progressbar-pin' => 'height: {{SIZE}}{{UNIT}};'
                        ]
            ]
        );
        $this->end_controls_section();
    }

    protected function render(){
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes('pixerex_progressbar_left_label');
        $this->add_inline_editing_attributes('pixerex_progressbar_right_label');
        
        $length = isset ( $settings['pixerex_progressbar_progress_percentage']['size'] ) ? $settings['pixerex_progressbar_progress_percentage']['size'] : $settings['pixerex_progressbar_progress_percentage'];
        
        $progressbar_settings = [
            'progress_length'   => $length,
            'speed'             => !empty( $settings['pixerex_progressbar_speed'] ) ? $settings['pixerex_progressbar_speed'] : 1000
        ];
?>

   <div class="pixerex-progressbar-container">
        <?php if ($settings['pixerex_progressbar_select_label'] === 'left_right_labels') :?>
            <p class="pixerex-progressbar-left-label"><span <?php echo $this->get_render_attribute_string('pixerex_progressbar_left_label'); ?>><?php echo $settings['pixerex_progressbar_left_label'];?></span></p>
        <p class="pixerex-progressbar-right-label"><span <?php echo $this->get_render_attribute_string('pixerex_progressbar_right_label'); ?>><?php echo $settings['pixerex_progressbar_right_label'];?></span></p>
        <?php endif;?>
        <?php if ($settings['pixerex_progressbar_select_label'] === 'more_labels'):?>
            <div class="pixerex-progressbar-container-label" style="position:relative;">
            <?php foreach($settings['pixerex_progressbar_multiple_label'] as $item){
                if($this->get_settings('pixerex_progressbar_more_labels_align') === 'center'){
                    if($settings['pixerex_progress_bar_space_percentage_switcher'] === 'yes'){
                       if($settings['pixerex_progressbar_select_label_icon'] === 'arrow')
                       { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                       }
                       elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){

                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        }
                        else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p></div>';

                        }
                    }
                    else{
                        if($settings['pixerex_progressbar_select_label_icon'] === 'arrow')
                       { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].'</p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                       }
                       elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){

                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%)">'.$item['text'].'</p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        }
                        else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].'</p></div>';

                        }
                    }
                }
                elseif($this->get_settings('pixerex_progressbar_more_labels_align') === 'left'){
                    if($settings['pixerex_progress_bar_space_percentage_switcher'] === 'yes'){
                       if($settings['pixerex_progressbar_select_label_icon'] === 'arrow')
                       { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-10%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                       }
                       elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){

                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        }
                        else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p></div>';

                        }
                    }
                    else{
                        if($settings['pixerex_progressbar_select_label_icon'] === 'arrow')
                       { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-10%);">'.$item['text'].'</p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                       }
                       elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){

                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].'</p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        }
                        else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].'</p></div>';

                        }
                    }
                }
                else{
                    if($settings['pixerex_progress_bar_space_percentage_switcher'] === 'yes'){
                       if($settings['pixerex_progressbar_select_label_icon'] === 'arrow')
                       { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-82%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                       }
                       elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){

                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-95%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        }
                        else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-96%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p></div>';

                        }
                    }
                    else{
                        if($settings['pixerex_progressbar_select_label_icon'] === 'arrow')
                       { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-71%);">'.$item['text'].'</p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                       }
                       elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){

                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-97%);">'.$item['text'].'</p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        }
                        else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-96%);">'.$item['text'].'</p></div>';

                        }
                    }
                }

               }?>
            </div>
        <?php endif;?>
            <div class="clearfix"></div>
            <div class="pr-progress pixerex-progressbar-progress">
                <div class="pixerex-progressbar-progress-bar progress-bar <?php if( $settings['pixerex_progressbar_progress_style'] === 'solid' ){ echo "";} elseif( $settings['pixerex_progressbar_progress_style'] === 'stripped' ){ echo "progress-bar-striped";}?> <?php if( $settings['pixerex_progressbar_progress_animation'] === 'yes' ){ echo "active";}?>" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-settings='<?php echo wp_json_encode($progressbar_settings); ?>'>
                </div>
            </div>
        </div>
    <?php
    }
}