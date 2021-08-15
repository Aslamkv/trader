<?php

declare(strict_types=1);

namespace Trader;

use DateTime;
use Exception;
use Throwable;

final class App {
  private $stock_iterator;
  private $ticker;

  public function __construct(iterable $stock_iterator,StockTicker $ticker){
    try{
      $this->stock_iterator=$stock_iterator;
      $this->ticker=$ticker;
    }catch(Throwable $t){
      throw $t;
    }
  }

  public function analyse($stock_to_analyse,$from_date,$to_date): array {
    try{
      $this->check_stock_to_analyse_exists($stock_to_analyse);
      $this->check_date_range($from_date,$to_date);

      $buying_and_selling_dates=[];
      $buying_date='';
      $local_minima=PHP_INT_MAX;
      $local_maxima=PHP_INT_MIN;
      $mean=0;
      $mean_for_variance=0;
      $previous_date='';
      $selling_date='';
      $standard_deviation=0;
      $status='FIND_LOCAL_MINIMA';
      $stock_count=0;
      $total_profit=0;
      $variance=0;

      foreach($this->stock_iterator as $item){
        if(count($item)<4){
          continue;
        }
        $current_stock=new Stock(
          $item[1],
          $item[2],
          $item[3]
        );

        if(!$current_stock->isValidStock($this->ticker)){
          continue;
        }
        if($previous_date==''){
          $previous_date=DateTime::createFromFormat(
            'd-m-Y',
            $current_stock->getStockDate()
          );
        }else{
          $current_date=DateTime::createFromFormat(
            'd-m-Y',
            $current_stock->getStockDate()
          );
          if($previous_date>$current_date){
            throw new Exception(
              'The application does not support unsorted stock list yet!'
            );
          }
        }
        if(!$current_stock->isEligibleStock($stock_to_analyse,$from_date,$to_date)){
          continue;
        }
        $mean+=$current_stock->getStockPrice();
        $stock_count++;
        $delta=$current_stock->getStockPrice()-$mean_for_variance;
        $mean_for_variance+=$delta/$stock_count;
        $variance+=$delta*($current_stock->getStockPrice()-$mean_for_variance);

        if($status=='FIND_LOCAL_MINIMA'){
          if($local_minima>$current_stock->getStockPrice()){
            $local_minima=$current_stock->getStockPrice();
            $buying_date=$current_stock->getStockDate();
          }else{
            $status='FIND_LOCAL_MAXIMA';
          }
        }

        if($status=='FIND_LOCAL_MAXIMA'){
          if($local_maxima<$current_stock->getStockPrice()){
            $local_maxima=$current_stock->getStockPrice();
            $selling_date=$current_stock->getStockDate();
          }else{
            $status='STORE_PROFIT';
          }
        }

        if($status=='STORE_PROFIT'){
          $profit=$local_maxima-$local_minima;
          $total_profit+=$profit;
          array_push($buying_and_selling_dates,[
            'buying_date'=>$buying_date,
            'selling_date'=>$selling_date,
            'profit'=>$profit
          ]);
          $local_minima=$current_stock->getStockPrice();
          $buying_date=$current_stock->getStockDate();
          $local_maxima=PHP_INT_MIN;
          $status='FIND_LOCAL_MINIMA';
        }
      }

      if($status=='FIND_LOCAL_MAXIMA'){
        $profit=$local_maxima-$local_minima;
        $total_profit+=$profit;
        array_push($buying_and_selling_dates,[
          'buying_date'=>$buying_date,
          'selling_date'=>$selling_date,
          'profit'=>$profit
        ]);
      }

      if($stock_count>0)
        $mean=$mean/$stock_count;

      if($stock_count>1){
        $variance=$variance/($stock_count-1);
        $standard_deviation=sqrt($variance);
      }


      return [
        'mean'=>$mean,
        'standard_deviation'=>$standard_deviation,
        'total_profit'=>$total_profit,
        'buying_and_selling_dates'=>$buying_and_selling_dates
      ];
    }catch(Throwable $t){
      throw $t;
    }
  }

  private function check_stock_to_analyse_exists($stock_to_analyse): void {
    try{
      if(!$this->ticker->checkStockExists($stock_to_analyse))
        throw new Exception('Invalid stock name!');
    }catch(Throwable $t){
      throw $t;
    }
  }

  private function check_date_range($from_date,$to_date): void {
    try{
      if(!DateValidator::isValidDate($from_date))
        throw new Exception('Invalid from date!');
      if(!DateValidator::isValidDate($to_date))
        throw new Exception('Invalid to date!');
      if(!DateValidator::isValidDateRange($from_date,$to_date))
        throw new Exception('Invalid date range!');
    }catch(Throwable $t){
      throw $t;
    }
  }
}
