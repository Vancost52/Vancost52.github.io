<?php
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/functions.php');

use xPaw\SourceQuery\SourceQuery;

if (!array_keys_exists($_GET, ['address', 'port', 'timeout', 'engine', 'type'])) {
  done([
    'success' => false,
    'reason'  => 'Invalid request'
  ], 400);
}

$Query      = new SourceQuery();
$Data       = [];
$Exception  = null;

try {
  $Query->Connect( $_GET['address'], intval($_GET['port']), intval($_GET['timeout']), intval($_GET['engine']) );

  switch (intval($_GET['type'])) {
    case 0:
      $Data = $Query->GetInfo();
      break;
    case 1:
      $Data = $Query->GetPlayers();
      break;
    case 2:
      $Data = $Query->GetRules();
      break;
    default:
      done([
        'success' => false,
        'reason'  => 'Unknown query type'
      ], 500);
      break;
  }
} catch (Exception $e) {
  $Exception = $e;
}

$Query->Disconnect();

if ($Exception === null) {
  done([
    'success' => true,
    'data'    => $Data
  ]);
}

done([
  'success'   => false,
  'exception' => [
    'type'    => get_class($Exception),
    'text'    => $Exception->getMessage(),
  ],
]);