<?php
// The PluGeSHin settings page:

//must check that the user has the required capability 
if (!current_user_can(PLUGESHIN_CAPABILITY)) {
    wp_die( __('You do not have sufficient permissions to access this page.') );
}

// variables for the field and option names 
$hidden_field_name = 'plugeshin_submit_hidden';

// Read in existing option value from database
$plugeshin_options  = Plugeshin::$options_array;                                

// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
    // Read their posted values
    $lines          = empty($_POST['plugeshin-line-numbers'])   ? false : $_POST['plugeshin-line-numbers'];
    $default        = empty($_POST['plugeshin-language'])       ? false : $_POST['plugeshin-language'];
    $target         = empty($_POST['plugeshin-target'])         ? false : $_POST['plugeshin-target'];
    $target_frame   = empty($_POST['plugeshin-target-frame'])   ? false : $_POST['plugeshin-target-frame'];    
                       
    // Set posted value to options array
    $plugeshin_options['default'] = $default;
    $plugeshin_options['lines']   = ($lines == "On" ? true : false);
    $plugeshin_options['target']  = $target_frame ? $target_frame : $target;
        
    // Make sure received values are okay
    $plugeshin_options = $this->check_options($plugeshin_options);                      
    // Save the posted value in the database
    update_option( PLUGESHIN_OPTIONS, $plugeshin_options );
    $plugeshin_options = $plugeshin_options;

    // Put an settings updated message on the screen        
    ?>
    <div class="updated">
        <p><strong><?php _e('PluGeSHin Settings Updated and Saved.', PLUGESHIN_SLUG ); ?></strong></p>
    </div>
    <?php    
}

// Debug if on
$ini_defs = unserialize(PLUGESHIN_INI_DEFS);
if ($ini_defs['debug']) {
    echo "<pre>";
    print_r($plugeshin_options);
    echo "</pre>";
}  

// Notification for test post
if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y-Test' ) {    
    $draft_id  = $this->add_test_post(); 
    $permalink = get_permalink( $draft_id );
    ?>
    <div class="updated">
        <p><strong><?php _e('Test Post Drafted.', PLUGESHIN_SLUG ); ?>
            <a href="<?php echo $permalink; ?>">
                <?php _e('Preview it here.', PLUGESHIN_SLUG ); ?>
            </a></strong>
        </p>
    </div>
    <?php
}
    
// Now display the settings editing screen
?> 
<div class="wrap">
    <h2><?php _e( PLUGESHIN . ' Settings', PLUGESHIN_SLUG ); ?></h2> 
    <form name="form1" method="post" action="">
        <table class="wp-list-table widefat" cellspacing="0">
            <thead>
                <tr>
                    <th>Default</th><th>Value</th><th style="width:100%;">Description</th>   
                </tr>
            </thead>
        
            <tfoot>
                <tr>
                    <th>Default</th><th>Value</th><th>Description</th>
                </tr>
            </tfoot>
        
            <tbody id="plugeshin-lang-list">
                <tr>
                    <td>Language</td>
                    <td>                                                                                                 
                        <select name="plugeshin-language">   
                            <?php
                            array_multisort($plugeshin_options['languages']);
                            foreach($plugeshin_options['languages'] as $langname => $fullname) {
                                ?>
                                <option value="<?php echo $langname; ?>" <?php if ($plugeshin_options['default'] == $langname) echo ' selected = "selected" '; ?>><?php echo $fullname; ?><?php echo str_pad("Code: $langname", 74 - strlen($fullname), '.', STR_PAD_LEFT); ?></option>     
                                <?php
                            }
                            ?>                         
                            
                        </select>
                    </td>
                    <td>The language assumed if you don't use <code>lang = "..."</code>, but simply use the short tag like:
                        <code>[geshi]...[/geshi]</code>    
                    </td>
                </tr>
                <tr class="alternate">
                    <td>Line&nbsp;Numbers</td>
                    <td>
                        <input type="radio" name="plugeshin-line-numbers" value="Off" <?php checked( $plugeshin_options['lines'], false ); ?> /> Off &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="plugeshin-line-numbers" value="On" <?php checked( $plugeshin_options['lines'], true ); ?> /> On
                    </td>
                    <td>Whether the showing of line numbers is on or off if you don't use <code>lines = "..."</code></td>
                </tr>
                <tr id="target-selection">
                    <td>Target</td>
                    <td>
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
                    </td>
                    <td>The target attribute of links to manual pages.</td>
                </tr>                
            </tbody>
        </table>
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">           
                      
                  
        <p class="submit">
        <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>    
            
        
    </form>
    <form name="form2" method="post" action="">
        <p>
            You can draft a test Post that has several examples of how to use the <code>[geshi]</code> short code.
            This is a good post to use to check that PluGeSHin is working, and the defaults set are to your liking.
            The Post will be added as a Draft, so you can look at the Preview to see what it looks like, or you can choose to publish it.            
        </p>
        <p class="submit">
            <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y-Test">        
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Draft a Test Post') ?>" />
        </p>            
    </form>
    
    <form id="plugeshin-extras">
        <p class="submit">
            <input id="plugeshin-show-info" type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('PluGeSHin Shortcodes Help') ?>" />
        </p>
    </form>
      
    <div id="plugeshin-info" title="PluGeSHin Shortcodes Railroad Diagram">
        <div>
            <p>Thanks to the <a href="http://railroad.my28msec.com/rr/ui">Railroad Diagram Generator</a> for the diagrams:</p>
            <img src="<?php echo PLUGESHIN_URL . '/' . PLUGESHIN_RR; ?>" alt="PluGeSHin Shortcodes Railroad Diagram" />    
        </div>                
    </div>
   