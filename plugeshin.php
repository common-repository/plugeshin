<?php
/*
Plugin Name: PluGeSHin
Plugin URI: http://netlumination.com/blog/plugeshin
Description: PluGeSHin uses shortcodes to highlight code with GeSHi.
Version: 2.5
Author: Peter Ajtai
Author URI: http://netlumination.com
*/

/*  Copyright 2011 - Peter Ajtai - peter@netlumination.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


// Global CONSTANTS
define( 'PLUGESHIN'              , 'PluGeSHin'                       ); 
define( 'PLUGESHIN_VERSION'      , '2.5'                             );
define( 'PLUGESHIN_GESHI_VERSION', 'GeSHi-1.0.8.10'                  );
define( 'PLUGESHIN_PATH'         , plugin_dir_path(__FILE__)         );
define( 'PLUGESHIN_BASENAME'     , plugin_basename( __FILE__ )       );
define( 'PLUGESHIN_SLUG'         , sanitize_title(PLUGESHIN_BASENAME));
define( 'PLUGESHIN_URL'          , WP_PLUGIN_URL . '/plugeshin'      );
define( 'PLUGESHIN_CAPABILITY'   , 'manage_options'                  );
define( 'PLUGESHIN_OPTIONS'      , '_plugeshin_'                     );
define( 'PLUGESHIN_RR'           , 'screenshot-5.png'                );  
define( 'PLUGESHIN_INI_DEFS'     , serialize(array( 'default'   => 'javascript',          
                                                    'lines'     => false,                                                  
                                                    'target'    => '_self',
                                                    'debug'     => false
                                                    // languages are handled separately
                                                    )));
// WP_PLUGIN_DIR - Plugins directory - WP Constant

require_once PLUGESHIN_PATH . '/includes/classes/class_Plugeshin.php';    
  
// TODO: Option for Plugeshin Capability
// TODO: Check that default langs, etc. filled in & valid when using Geshi class
// TODO: if something goes wrong with options, make sure to repopulate
// TODO: option to delete options on plugin deactivate
// TODO: make sure all scripts loaded as needed
// TODO: validate modal
// TODO: option for overall class and id, links, other geshi stuff, etc
// TODO: namesapce everything?
/*
Grammar: 
PluGeSHin       ::= '[geshi' (Attributes)? ']' CodeToBeHighlighted '[/geshi]'
Attributes      ::= (Language)? ( (LineNumbers) (StartNumber)? )? (DrawAttentionTo)? (Target)?
Language        ::= ' lang="' (Letter | Digit)+ '"'
LineNumbers     ::= ' nums="' ('0' | '1') '"'
StartNumber     ::= ' start="' (Digit)+ '"'
DrawAttentionTo ::= ' highlight="' (Digit)+ (',' (Digit)+)* '"' 
Target          ::= ' target="' ('_blank' | '_parent' | '_self' | '_top' | FranmeName) '"'
FrameName       ::= Letter (Letter | Number | SpecialCharacter)*
  
 * Update for each new Attribute
 * * Set a default value - make sure compatible w existing installs
 * * Add to default screen if applicable
 * * Add attrbiute to PluGeSHin modal helper
 * * Update Railroad diagram
*/
?>