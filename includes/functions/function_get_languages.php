<?php
// return array
$plugeshin_langs = array();

// we walk the lang root
$lang_dir = PLUGESHIN_PATH . PLUGESHIN_GESHI_VERSION . '/geshi/geshi/';
$dir = dir($lang_dir);

// foreach entry
while (false !== ($entry = $dir->read()))
{
    $full_path = $lang_dir.$entry;

    // Skip all dirs
    if (is_dir($full_path)) {
        continue;
    }

    // we only want lang.php files
    if (!preg_match('/^([^.]+)\.php$/', $entry, $matches)) {
        continue;
    }

    // Raw lang name is here
    $langname = $matches[1];                  
    $fullname = $langname;       
    
    $language_data = false;
    include $full_path;    
    
    if (is_array($language_data))
        $fullname = $language_data['LANG_NAME'];                 
    $plugeshin_langs[$langname] = $fullname;
}
// A return here will still be inside the function!
?>