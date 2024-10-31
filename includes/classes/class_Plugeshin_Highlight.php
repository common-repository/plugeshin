<?php
/*
 * The front end highlighting class.
 * 
 */ 

new Plugeshin_Highlight;
class Plugeshin_Highlight {

    private $geshi;  
    private $line_nums;
    private $default_nums;
    private $language;  
    private $default;   
    private $start;  

    public function __construct() {
        
        add_action(   'wp_print_styles', array(&$this, 'geshi_styling'));
        add_shortcode('geshi'          , array(&$this, 'geshi_shortcode'));
                                        
        // Include the GeSHi library        
        include(PLUGESHIN_PATH . PLUGESHIN_GESHI_VERSION . '/geshi/geshi.php');
                        
        $plugeshin_options  = Plugeshin::$options_array;
                
        $path               = PLUGESHIN_PATH . PLUGESHIN_GESHI_VERSION . '/geshi/geshi/'; 
        $source             = 'echo;';
        
        // These values represent the stored default value in the options 
        $this->default          = $plugeshin_options['default'];
        $this->default_nums     = $plugeshin_options['lines'];
        $this->default_target   = $plugeshin_options['target'];
        
        // These values represent what the GeSHi instance is currently set to
        $this->line_nums    = $this->default_nums;        
        $this->language     = $this->default;        
        $this->start        = 1;
        $this->target       = $this->default_target;
                
        $this->geshi        = new GeSHi($source, $this->language, $path); 
                        
        $this->geshi->enable_classes();   
        $this->geshi->set_overall_class(PLUGESHIN);
        
        // Set show line numbers to the retrieved default
        if ($this->line_nums) {
            $this->geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);                            
        } else {
            $this->geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);
        }                    
    } 
    public function geshi_styling() {    
        wp_register_style( 'geshi', PLUGESHIN_URL . '/style.css');
        wp_enqueue_style(  'geshi' );
    }  
    // Filter the content using the PluGeSHin shortcode
    public function geshi_shortcode( $atts, $content = null ) {
        // undo curly quotes & nbsp
        $find    = array(   '/&nbsp;|&#160;/'  ,   
                            '/&#8220;|&#8221;/' ,
                            '/&#8216;|&#8217;/');
        $replace = array(   ' '                 ,
                            '"'                 ,
                            "'");
        $content = preg_replace($find, $replace, $content);         
        
        // no idea which ones will be left out, so null out all (cannot do w default values in method)
        $lang = null; $nums = null; $highlight = null; $start = null; $target = null;
        // Get user attributes
        if (is_array($atts))
            extract($atts);
        
        if ($highlight) $highlight = explode(',', $highlight);        
        
        // Remove WP HTML, trim, and keep code HTML        
        $content = $this->highlight(html_entity_decode(trim(strip_tags($content))), $lang, $nums, $start, $highlight, $target);
        
        return $content;
    }           
    private function highlight($source, $lang, $nums, $start, $highlight, $target) {
            
        // Get the Source
        $this->geshi->set_source($source);
        
        // Set line numbers
        // Set property
        if (is_null($nums)) {
            if ($this->line_nums != $this->default_nums  ) {
                $nums = $this->default_nums;                
            }
        }
        
        // Set the language
        if ($lang && $lang != $this->language) {
            if (array_key_exists($lang, Plugeshin::$options_array['languages'])) {
                $this->geshi->set_language($lang);
                $this->language = $lang;                
            }                               
        }
        // Reset to default lang if no lang specified
        if (is_null($lang) && $this->language != $this->default) {
            $this->geshi->set_language($this->default);
            $this->language = $this->default;            
        }                
                
        // Set to show line numbering        
        // Set GeSHi
        if ($nums) {
            if (! $this->line_nums) {
                $this->geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
                $this->line_nums = true;                
            }
            
            // Set starting line number
            // Only makes sense if line nubmers are going to show
            if (! is_null($start)) {
                $this->geshi->start_line_numbers_at($start);
            }            
                         
        } elseif (! is_null($nums) and ! $nums) {
            if ($this->line_nums) {
                $this->geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);
                $this->line_nums = false;
            }
        }             
          
        // Set highlighting of certain lines (is this remembered?)   
        if (is_array($highlight)) {
           $this->geshi->highlight_lines_extra($highlight); 
        }      
        
        // Set link targets
        if (is_string($target)) {
            $this->geshi->set_link_target($target);
        } else {
            $this->geshi->set_link_target($this->default_target);
        }
                      
        // and simply dump the code!        
        $code = $this->geshi->parse_code(); 

        // Reset line number
        if (! is_null($start)) {
            $this->geshi->start_line_numbers_at(1);
        }
                
        // Write errors to file
        if ($this->geshi->error()) {
            $file = PLUGESHIN_PATH . "/plugeshin_errors.html";
            file_put_contents($file, $this->geshi->error(),  FILE_APPEND | LOCK_EX);
            return '<pre class="geshi-error">' . $source . '</pre>';    
        }   else
            return  $code;                 
    }        
}
?>