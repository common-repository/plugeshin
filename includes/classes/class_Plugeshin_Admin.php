<?php
/*
 * The back end admin class that shows that admin page for Plugeshin.
 * This only run if we're on the admin side
 * 
 */
 
new Plugeshin_Admin;
class Plugeshin_Admin extends Plugeshin {
    public function __construct() {
        add_action( 'add_meta_boxes',   array( &$this, 'add_plugeshin_meta_box' )); // Language reminder metabox
        add_action( 'admin_menu',       array( &$this, 'plugeshin_menu'         )); // PluGeSHin settings page
        add_action( 'init',             array( &$this, 'plugeshin_mce_buttons'  )); // PluGeSHin TinyMCE button
        add_action( 'init',             array( &$this, 'admin_scripts'          )); // Queue scripts and related styles           
    }
    public function admin_scripts() {
        wp_enqueue_script (  'plugeshin-custom'                                 ,  // handle                    
                            PLUGESHIN_URL . '/includes/js/plugeshin.js'         ,  // source
                            array('jquery-ui-dialog'));                            // dependencies

        wp_enqueue_style (  'plugeshin-custom-css'                              ,  // handle
                            PLUGESHIN_URL . '/includes/css/plugeshin.custom.css'); // source
        wp_enqueue_style (  'wp-jquery-ui-dialog');                                // handle
    }
    public function add_plugeshin_meta_box()
    {        
        $post_types = get_post_types();
        $exclude = array('attachment', 'revision', 'nav_menu_item');
        
        // Get all post types except for excluded one
        // TODO: Option on settings page for which to include?
        $post_types = array_diff($post_types, $exclude);
        foreach ($post_types as $one_type) {
            add_meta_box(   'plugeshin-meta-box'                                ,
                            __( 'PluGeSHin Language Reminder', PLUGESHIN_SLUG ) ,
                            array( &$this, 'render_meta_box_content' )          ,
                            $one_type                                           ,
                            'advanced'                                          ,
                            'high'                                              ,
                            $post_types );            
        }
    }
    // The meta box is displayed as a modal
    public function render_meta_box_content($post, $array) 
    {        
        $plugeshin_options = Plugeshin::$options_array;
        ?> 
        <div id="plugeshin-dialog"  title="PluGeSHin Helper">  
            <form> 
                <h3>Pick a language:</h3>
                <select name="plugeshin-language"> 
                    <option value="">Use default language</option>  
                    <?php
                    array_multisort($plugeshin_options['languages']);
                    foreach($plugeshin_options['languages'] as $langname => $fullname) {
                        ?>
                        <option value="<?php echo $langname; ?>" <?php if ($plugeshin_options['default'] == $langname) echo ' selected = "selected" '; ?>><?php echo $fullname; ?><?php echo str_pad("Code: $langname", 74 - strlen($fullname), '.', STR_PAD_LEFT); ?></option>    
                        <?php
                    }
                    ?>                                             
                </select>
                                
                <h3>Line Numbers:</h3> 
                <input type="radio" name="plugeshin-line-numbers" value="0" <?php checked( $plugeshin_options['lines'], false ); ?> /> Off &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="plugeshin-line-numbers" value="1" <?php checked( $plugeshin_options['lines'], true ); ?> /> On 
                
                <h3>Start line numbers at:</h3>
                <span id="plugeshin-num-notice">(must have line numbers on to use)<br/></span>               
                <input style="background-color:#AEAEAE;" type="text" disabled="disabled" name="plugeshin-start" />                               
                
                <h3>Draw attention to lines:</h3>
                (coma separate line numbers relative to first line shown):<br/>
                <input type="text" name="plugeshin-extra" />  
                
                <h3>Target for Manual Linkgs:</h3>
                <div id="target-selection">
                    <?php     
                    $target_attributes  = array('_blank','_parent','_self','_top');                   
                    foreach($target_attributes as $target_attr) {
                        ?>
                        <input type="radio" name="plugeshin-target" value="<?php echo $target_attr; ?>" <?php if ($plugeshin_options['target'] == $target_attr) echo 'checked = "checked"'; ?> /> <?php echo $target_attr; ?> &nbsp;&nbsp;&nbsp;&nbsp;                            
                        <?php
                    }
                    if (!in_array($plugeshin_options['target'],$target_attributes)) $target_value = $plugeshin_options['target'];
                    else $target_value = "";
                    ?>
                    Frame Name: <input type="text" name="plugeshin-target-frame" value="<?php echo $target_value; ?>" />
                </div>                              
            </form>     
        </div>
        <?php
    }    
    public function plugeshin_mce_buttons() {
       if (!current_user_can(PLUGESHIN_CAPABILITY)) {
           return;
       }
        
        if ( get_user_option('rich_editing') == 'true' ) {
            add_filter( 'mce_external_plugins', array(&$this, 'add_mce_plugin' ));
            add_filter( 'mce_buttons',          array(&$this, 'register_mce_button' ));
        }       
    }
    public function add_mce_plugin() {
       $plugin_array['plugeshin'] = PLUGESHIN_URL . '/includes/js/plugeshin-mce.js';       
       return $plugin_array;
    }
    public function register_mce_button($buttons) {
        array_push( $buttons, "|", "plugeshin" );
        return $buttons ;   
    }        
    public function plugeshin_menu() {
        add_options_page(PLUGESHIN . ' Settings',               // Page title
                         PLUGESHIN,                             // Menu title
                         PLUGESHIN_CAPABILITY,                  // Capability / role required to view menu
                         PLUGESHIN_SLUG,                        // Menu slug
                         array(&$this, 'display_plugeshin_settings')); // Function called for output of menu      
    }
    // Display the PluGeSHin Settings page
    public function display_plugeshin_settings() {        
        include PLUGESHIN_PATH . '/includes/functions/function_display_plugeshin_settings.php';        
    }
    // Draft a test post with PluGeSHin examples
    private function add_test_post() {        
        $contents = file_get_contents(PLUGESHIN_PATH . '/includes/sample_post.txt');
    
        $new_post = array(
            'post_title'    => 'Plugeshin Test Post',
            'post_content'  => $contents,     
            'post_status'   => 'draft',
            'post_date'     => date('Y-m-d H:i:s'),
            'post_author'   => $GLOBALS['user_ID'],
            'post_type'     => 'post',
            'post_category' => array(0) );
        return wp_insert_post($new_post);        
    }
}
?>