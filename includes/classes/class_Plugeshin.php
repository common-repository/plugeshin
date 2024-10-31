<?php
new Plugeshin;
class Plugeshin {
    public static $options_array;
    function __construct() {
        register_activation_hook  ( __FILE__, array(&$this, 'plugeshin_activate'   ));
        register_deactivation_hook( __FILE__, array(&$this, 'plugeshin_deactivate' ));   
        
        // Internationalize
        load_plugin_textdomain(PLUGESHIN_SLUG, false, basename( dirname( __FILE__ ) ) . '/languages' );
        
        // TODO: Check plugeshin defaults and languages and replace if not valid
        $this->check_options(get_option( PLUGESHIN_OPTIONS ));
        
        if (! is_admin()) {
            
            // Front end    
            require_once PLUGESHIN_PATH . '/includes/classes/class_Plugeshin_Highlight.php';
        } else {
            
            // Back end
            require_once PLUGESHIN_PATH . '/includes/classes/class_Plugeshin_Admin.php';
        }                     
    }
    public function plugeshin_activate() {               
        add_option( PLUGESHIN_OPTIONS,                              // key 
                    PLUGESHIN_INI_DEFS,                             // value
                    '',                                             // deprecated
                    false);                                         // do not load into object cache each page
    }
    public function plugeshin_deactivate() {
       delete_option( PLUGESHIN_OPTIONS );
    }
    protected function check_options($plugeshin_options) {
        $ini_defs = unserialize(PLUGESHIN_INI_DEFS);        
        
        // Check languages
        if (empty($plugeshin_options['languages']) or ! is_array($plugeshin_options['languages'])) {
            $plugeshin_options['languages'] = $this->get_languages();
        }
        // Check default language
        if (empty($plugeshin_options['default']) or ! array_key_exists($plugeshin_options['default'], $plugeshin_options['languages'])) {
            // Assuming javascript hasn't been deleted
            $plugeshin_options['default'] = $ini_defs['default'];
        }
        // Check show lines        
        if (empty($plugeshin_options['lines']) or ! is_bool($plugeshin_options['lines'])) {
            $plugeshin_options['lines'] = $ini_defs['lines'];
        }
        // Check target
        if (empty($plugeshin_options['target']) or ! is_string($plugeshin_options['target'])) {
            $plugeshin_options['target'] = $ini_defs['target'];
        }        
        // Set options
        Plugeshin::$options_array = $plugeshin_options;
        return $plugeshin_options;     
    }
    protected function get_languages() {     
        include PLUGESHIN_PATH . '/includes/functions/function_get_languages.php';
        return $plugeshin_langs;
    }
}
?>