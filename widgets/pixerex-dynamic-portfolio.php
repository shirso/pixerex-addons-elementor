<?php
namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Dynamic_Portfolio extends Base {
    use \PixerexElements\Traits\Helper_Trait;
    protected $templateInstance;
    public function getTemplateInstance() {
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }
    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Portfolio', 'pixerex-elements') );
    }
    public function get_icon() {
        return 'px eicon-posts-grid';
    }
    protected function _register_controls() {

        /**
         * Query And Layout Controls!
         * @source includes/elementor-helper.php
         */
        $this->pixerex_query_controls();
        $this->pixerex_layout_controls();

    }

    protected function render() {
        $settings = $this->get_settings();
        $args = $this->pixerex_get_query_args( $settings );
        $filter = $settings['pixerex_portfolio_filter'];

        $taxonomies = $this->pixerex_get_categories($settings);
        //print_r($taxonomies);
        if ( 'yes' === $filter && $taxonomies ) {

            if ( ! empty( $settings['pixerex_portfolio_active_cat'] ) || 0 === $settings['pixerex_portfolio_active_cat'] ) {
               //print_r('sdada');
                if( 'yes' !== $settings['pixerex_portfolio_first_cat_switcher'] ) {
                    $active_index = $settings['pixerex_portfolio_active_cat'];
                  //  print_r($active_index);
                    $active_category= $settings['premium_gallery_cats_content'][$active_index]['premium_gallery_img_cat'];
                 //   $category= "." . $this->filter_cats( $active_category );
                    $active_category_index = $settings['pixerex_portfolio_active_cat'];

                } else {
                    $active_category_index  = $settings['pixerex_portfolio_active_cat'] - 1;
                }

            } else {
                $active_category_index = 'yes' === $settings['pixerex_portfolio_first_cat_switcher'] ? -1 : 0;
            }
          //  print_r($active_category_index);

            $is_all_active = ( 0 > $active_category_index ) ? "active" : "";

        }
        ?>
        <?php if( $filter == 'yes' && $taxonomies ) :
            $this->render_filter_tabs( $is_all_active, $active_category_index );
        endif; ?>
    <?php
    }


    protected function content_template() {
    }

    /*
     * Render Filter Tabs on the frontend
     *
     * @since 2.1.0
     * @access protected
     *
     * @param string $first Class for the first category
     * @param number $active_index active category index
     */
    protected function render_filter_tabs( $first, $active_index ) {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="premium-img-gallery-filter">
            <ul class="pixerex-portfolio-cats-container">
                 <?php if( 'yes' == $settings['pixerex_portfolio_first_cat_switcher'] ) : ?>
                    <li>
                        <a href="javascript:;" class="category <?php echo $first; ?>" data-filter="*">
                            <span><?php echo $settings['pixerex_portfolio_first_cat_label']; ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php
    }

}