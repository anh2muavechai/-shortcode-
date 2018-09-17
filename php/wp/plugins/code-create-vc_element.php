<?php
if(!class_exists('SHOW_TEXT_SHORTCODE')){
    class SHOW_TEXT_SHORTCODE{
        public function __construct()
        {
            add_shortcode('show_text', array($this, 'shortcode_show_text'));
            add_action('vc_before_init', array($this, 'show_text_integrate_vc'));
        }

        public function shortcode_show_text($atts){
         $text = '';
            $atts = shortcode_atts(array(
                'text' => '',
            ), $atts);

            return $text;
        }

        public function show_text_integrate_vc()
        {
            vc_map( array(
                'name' => esc_html__('Show Text', 'dgt-framework'),
                'base' => 'show_text',
                'category' => esc_html__('', 'dgt-framework'),
                'icon' => 'dgt-show_text',
                "params" => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Enter Text', 'dgt-framework' ),
                        'param_name' => 'text',
                        'description' => esc_html__( '', 'dgt-framework' )
                    )
                )
            ) );
        }
    }
    new SHOW_TEXT_SHORTCODE();
}
?>
<?php
vc_map(
    array(
        'base' => 'your_shortcode',
        'params' => array(
            array(
                'type' => 'textfield',
                'value' => '',
                'heading' => 'Title',
                'param_name' => 'simple_textfield',
            ),
            // params group
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'titles',
                // Note params is mapped inside param-group:
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Enter your title(multiple field)',
                        'param_name' => 'title',
                    )
                )
            )
        )
    )
)
