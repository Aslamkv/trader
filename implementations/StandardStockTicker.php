<?php

declare(strict_types=1);

namespace Implementations;

use Trader\StockTicker;

final class StandardStockTicker implements StockTicker {
  private $tickers=[];

  public function __construct($tickers){
    $this->tickers=$tickers;
  }

  public function checkStockExists($stock_name): bool {
    try{
      $formatted_stock_name=trim(
        mb_strtoupper(
          $stock_name
        )
      );
      return array_search(
        $formatted_stock_name,
        array_keys($this->tickers)
      )!==FALSE;
    }catch(Throwable $t){
      throw $t;
    }
  }
}
