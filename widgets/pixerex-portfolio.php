<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class Pixerex_Portfolio extends Widget_Base {
    protected $templateInstance;
    public function getTemplateInstance() {
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }
    public function get_name() {
        return 'pixerex-elements-portfolio';
    }
    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Portfolio', 'pixerex-elements') );
    }
    public function get_icon() {
        return 'eicon-gallery-justified';
    }
    public function get_categories() {
        return [ 'pixerex-elements'];
    }
}