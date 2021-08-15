<?php

declare(strict_types=1);

namespace Trader;

interface StockTicker{
  public function checkStockExists($stock_name): bool;
}
