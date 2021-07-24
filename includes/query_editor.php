<?php
function shapeSpace_add_var($url, $key, $value) {

    $url = preg_replace('/(.*)(?|&)'. $key .'=[^&]+?(&)(.*)/i', '$1$2$4', $url .'&');
    $url = substr($url, 0, -1);

    if (strpos($url, '?') === false) {
        return ($url .'?'. $key .'='. $value);
    } else {
        return ($url .'&'. $key .'='. $value);
    }
}
?>