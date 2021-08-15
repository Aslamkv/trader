<?php
require_once(__DIR__.'/../vendor/autoload.php');

use Trader\App;
use Implementations\StandardStockTicker;

function getFileIterator($path): iterable {
  $file_handle=fopen($path,'r');
  if($file_handle){
    while(($data=fgetcsv($file_handle,1000))!==FALSE){
      yield $data;
    }
  }
  fclose($file_handle);
}

function process_api(){
  try{
    if(
      isset($_FILES['stock_file']) &&
      isset($_POST['stock_to_analyse']) &&
      isset($_POST['from_date']) &&
      isset($_POST['to_date'])
    ){
      $file_iterator=getFileIterator($_FILES['stock_file']['tmp_name']);
      $standard_stock_ticker=new StandardStockTicker(
        json_decode(
          file_get_contents(__DIR__.'/../tests/mocks/tickers.json'),
          true
        )
      );
      $app=new App(
        $file_iterator,
        $standard_stock_ticker
      );
      $analysis=$app->analyse(
        $_POST['stock_to_analyse'],
        $_POST['from_date'],
        $_POST['to_date']
      );
      http_response_code(200);
      header('Content-Type: application/vnd.api+json');
      echo json_encode($analysis, JSON_UNESCAPED_SLASHES);
    }
  }catch(Throwable $t){
    http_response_code(500);
    header('Content-Type: application/vnd.api+json');
    echo json_encode(
      [
        'error'=>$t->getMessage()
      ],
      JSON_UNESCAPED_SLASHES
    );
  }
}

process_api();
