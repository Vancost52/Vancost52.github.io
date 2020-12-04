<?php
function done(array $response, $response_code = 200) {
  http_response_code($response_code);
  header('Content-Type: application/json; charset=utf8');
  header('Access-Control-Allow-Origin: *');

  echo(json_encode($response));
  exit();
}

function array_keys_exists(array $arr, array $keys) {
  foreach ($keys as $key) {
    if (!array_key_exists($key, $arr)) {
      return false;
    }
  }
  
  return true;
}