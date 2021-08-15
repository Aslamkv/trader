<?php

declare(strict_types=1);

namespace Trader;

use DateTime;

final class Stock{
  private $date;
  private $name;
  private $price;

  public function __construct($date,$name,$price){
    try{
      $this->date=$date;
      $this->name=$name;
      $this->price=$price;
    }catch(Throwable $t){
      throw $t;
    }
  }

  public function isValidStock(StockTicker $ticker): bool {
    try{
      if(!DateValidator::isValidDate($this->date))
        return false;

      if(!is_numeric($this->price))
        return false;

      if(!$ticker->checkStockExists($this->name))
        return false;

      return true;
    }catch(Throwable $t){
      throw $t;
    }
  }

  public function isEligibleStock($stock_to_analyse,$from_date,$to_date): bool {
    try{
      $stock_to_analyse=trim(
        mb_strtoupper(
          $stock_to_analyse
        )
      );
      if($this->name!=$stock_to_analyse)
        return false;

      $formatted_from_date=DateTime::createFromFormat('d-m-Y',$from_date);
      $formatted_to_date=DateTime::createFromFormat('d-m-Y',$to_date);
      $formatted_date=DateTime::createFromFormat('d-m-Y',$this->date);

      if($formatted_date<$formatted_from_date)
        return false;

      if($formatted_date>$formatted_to_date)
        return false;

      return true;
    }catch(Throwable $t){
      throw $t;
    }
  }

  public function getStockDate(){
    try{
      return $this->date;
    }catch(Throwable $t){
      throw $t;
    }
  }

  public function getStockName(){
    try{
      return $this->name;
    }catch(Throwable $t){
      throw $t;
    }
  }

  public function getStockPrice(){
    try{
      return $this->price;
    }catch(Throwable $t){
      throw $t;
    }
  }
}
