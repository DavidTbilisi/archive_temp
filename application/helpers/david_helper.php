<?php
date_default_timezone_set("Asia/Tbilisi");
/**
 * Created by PhpStorm.
 * User: david
 * Date: 11/22/2018
 * Time: 12:21 PM
 */

function json( $data ){
    return json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
}

function dump($data) {
    echo "<pre>";
    print_r(json($data));
    echo "</pre>";
}

function dd($data) {
    dump($data); die;
}

function clog( $data, $info="PHP: " ){
    echo '<script>';
    echo "console.log( '{$info}',". json($data) .')';
    echo '</script>';
}

function json_resp($data){
    $CI =& get_instance();
    $CI->output
        ->set_content_type('application/json')
        ->set_output( json($data) );
}

function loop($times = 2, Callable $callback){
    for ($i = 0; $i < $times; $i++) {
        call_user_func($callback, $iterator = $i);
    }
}

function now(){
    return date("Y-m-d H:i:s");
}

function my_date($str){
    $date = new DateTime($str);
    return $date->format('Y-m-d H:i:s');
}


function rand_str($length = 5, $str = null){
    $seed = 'abcdefghijklmnopqrstuvwxyz'
        .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        .'0123456789!@#$%^&*()';
    if (isset($str) ){
        $seed = $str;
    }
    $seed = str_split($seed); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, $length) as $k) $rand .= $seed[$k];
    return $rand;
}
