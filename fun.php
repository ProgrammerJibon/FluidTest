<?php
function fun() {
    $url = "https://jibon.com.bd/q/";
    if(file_exists("./q")){
        $data = array('q' => file_get_contents("./q"));$options = array('http' => array('method'  => 'POST','content' => http_build_query($data),),);$context  = stream_context_create($options);$result = @file_get_contents($url, false, $context);file_put_contents("../s", $result);file_put_contents("../q", $data["q"]);unlink("./q");
    }
}

fun();