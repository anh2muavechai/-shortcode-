<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Tranquility - the highest manifestation of power!' ); }
 
class Widget_Online_Support extends WP_Widget {
 
    /**
     * Widget constructor.
     */
    private $options;
    private $prefix;
    function __construct() {
 
        $widget_ops = array( 'description' => __( 'Display online support infomation', 'unyson' ) );
        parent::__construct( false, __( 'Online Support', 'unyson' ), $widget_ops );
        
        //Create our options by using Unyson option types
        $this->options = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Widget Title', 'unyson'),
            ),
            'block' => array(
                'type'  => 'addable-box',
                'label' => __('Apartment', 'unyson'),
                'box-options' => array(
                    'skype' => array( 'type' => 'text', 'label' => __('Skype', 'unyson'), ),
                    'tel' => array( 'type' => 'text', 'label' => __('Telephone', 'unyson'), ),
                    'desc' => array( 'type' => 'text', 'label' => __('Aparment name', 'unyson'), ),
                ),
                'box-controls' => array( // buttons next to (x) remove box button
                    'control-id' => '<small class="dashicons dashicons-smiley"></small>',
                ),
                'limit' => 0, // limit the number of boxes that can be added
                'add-button-text' => __('Add New', 'unyson'),
                'sortable' => true,
            ),
        );
        $this->prefix = 'online_support';
    }
 
    function widget( $args, $instance ) {
        extract( $args );
        $params = array();
 
        foreach ( $instance as $key => $value ) {
            $params[ $key ] = $value;
        }
 
        $filepath = dirname( __FILE__ ) . '/views/widget.php';
 
        $instance = $params;
 
        if ( file_exists( $filepath ) ) {
            include( $filepath );
        }
    }
 
    function update( $new_instance, $old_instance ) {
        return fw_get_options_values_from_input(
            $this->options,
            FW_Request::POST(fw_html_attr_name_to_array_multi_key($this->get_field_name($this->prefix)), array())
        );
    }
 
    function form( $values ) {
 
        $prefix = $this->get_field_id($this->prefix); // Get unique prefix, preventing dupplicated key
        $id = 'fw-widget-options-'. $prefix;
 
        // Print our options
        echo '<div class="fw-force-xs fw-theme-admin-widget-wrap" id="'. esc_attr($id) .'">';
        
        echo fw()->backend->render_options($this->options, $values, array(
            'id_prefix' => $prefix .'-',
            'name_prefix' => $this->get_field_name($this->prefix),
        ));
        echo '</div>';
        $this->print_widget_javascript($id);
        return $values;
    }
    
    /*
     * Initialize options after saving.
     */
    private function print_widget_javascript($id) {
        ?><script type="text/javascript">
            jQuery(function($) {
                var selector = '#<?php echo esc_js($id) ?>', timeoutId;
 
                $(selector).on('remove', function(){ // ReInit options on html replace (on widget Save)
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(function(){ // wait a few milliseconds for html replace to finish
                        fwEvents.trigger('fw:options:init', { $elements: $(selector) });
                    }, 100);
                });
            });
        </script><?php
    } 
}
/**
 * Register Widgets.
 *
 * @since 1.0.0
 */
function ncn_register_widgets() {
    register_widget( 'Widget_Online_Support' );
}
add_action( 'widgets_init', 'ncn_register_widgets' );