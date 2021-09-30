<?php

$types = [
    'js'=>"text/javascript",
    'css'=>"text/css",
    'json'=>'application/json',
];

$type = empty($types[$ext])?"application/octet-stream":$types[$ext];
//$content = IndexController::get_content($item);

header('Content-type: '.$type);
echo $content;
exit();