<?php  
/* 
Plugin Name: Thank You
*/


add_filter("the_content","Xu_ly");
function Xu_ly($content){
    
    $content = $content . " <p style='border:1px solid red; padding: 10px 10px'>xin cam on </p>";
    return $content;
    
}