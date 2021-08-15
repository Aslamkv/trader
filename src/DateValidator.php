<?php

declare(strict_types=1);

namespace Trader;

use DateTime;

final class DateValidator{
  public static function isValidDate($date,$format='d-m-Y'): bool {
    try{
      $created_date=DateTime::createFromFormat($format,$date);
      if(!$created_date)
        return false;

      return $created_date->format($format)==$date;
    }catch(Throwable $t){
      throw $t;
    }
  }

  public static function isValidDateRange($from_date,$to_date,$format='d-m-Y'): bool {
    try{
      $from_date=DateTime::createFromFormat($format,$from_date);
      $to_date=DateTime::createFromFormat($format,$to_date);
      return $from_date<=$to_date;
    }catch(Throwable $t){
      throw $t;
    }
  }
}
