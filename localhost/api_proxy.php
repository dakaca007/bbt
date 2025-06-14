<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$api_data = file_get_contents('https://api.kuleu.com/api/MP4_xiaojiejie?type=json'); 
echo $api_data;
