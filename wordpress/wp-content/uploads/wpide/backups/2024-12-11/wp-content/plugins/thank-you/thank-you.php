<?php  
/* 
Plugin Name: Thank You
*/


add_filter("the_content","Xu_ly");
function Xu_ly($content){
    
    $content = $content . "xin cam on";
    return $content;
    
}