<?php



function description($value) {
    $new_value = substr($value, 0, 50);
    return $new_value;
}

function postDate($str) {
    return date("d m, Y", strtotime($str));
}