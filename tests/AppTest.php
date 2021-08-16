<?php

declare(strict_types=1);

use Implementations\StandardStockTicker;
use PHPUnit\Framework\TestCase;
use Trader\App;

final class AppTest extends TestCase {
  public function testAppCanAnalyseStock(): void {
    $stock_iterator=$this->getMockStockIterator();
    $standard_stock_ticker=new StandardStockTicker(
      json_decode(
        file_get_contents(__DIR__.'/mocks/tickers.json'),
        true
      )
    );
    $app=new App(
      $stock_iterator,
      $standard_stock_ticker
    );
    $stock_to_analyse='GOOGL';
    $from_date='11-02-2020';
    $to_date='23-02-2020';
    $analysis=$app->analyse(
      $stock_to_analyse,
      $from_date,
      $to_date
    );
    $this->assertAnalysisIsValid(
      $analysis
    );
  }

  private function assertAnalysisIsValid($analysis): void {
    $this->assertEquals(
      1509.8571428571,
      $analysis['mean']
    );
    $this->assertEquals(
      18.649652109611,
      $analysis['standard_deviation']
    );
    $this->assertEquals(
      22,
      $analysis['total_profit']
    );
    $this->assertEquals(
      2,
      count($analysis['buying_and_selling_dates'])
    );
    $this->assertEquals(
      '11-02-2020',
      $analysis['buying_and_selling_dates'][0]['buying_date']
    );
    $this->assertEquals(
      '16-02-2020',
      $analysis['buying_and_selling_dates'][0]['selling_date']
    );
    $this->assertEquals(
      20,
      $analysis['buying_and_selling_dates'][0]['profit']
    );
    $this->assertEquals(
      '21-02-2020',
      $analysis['buying_and_selling_dates'][1]['buying_date']
    );
    $this->assertEquals(
      '22-02-2020',
      $analysis['buying_and_selling_dates'][1]['selling_date']
    );
    $this->assertEquals(
      2,
      $analysis['buying_and_selling_dates'][1]['profit']
    );
  }

  private function getMockStockIterator(): iterable {
    $file_handle=fopen(__DIR__.'/mocks/sample_stock_price_list.csv','r');
    while(($data=fgetcsv($file_handle,1000))!==FALSE){
      yield $data;
    }
    fclose($file_handle);
  }

  public function testAppCanAnalyseReallyBigStockList(): void {
    $stock_iterator=$this->getReallyBigMockStockIterator();
    $standard_stock_ticker=new StandardStockTicker(
      json_decode(
        file_get_contents(__DIR__.'/mocks/tickers.json'),
        true
      )
    );
    $app=new App(
      $stock_iterator,
      $standard_stock_ticker
    );
    $stock_to_analyse='GOOGL';
    $from_date=date('d-m-Y');
    $to_date=date('d-m-Y',strtotime("+10000 days"));
    $analysis=$app->analyse(
      $stock_to_analyse,
      $from_date,
      $to_date
    );
    $this->assertAnalysisOnReallyBigStockListIsValid(
      $analysis
    );
  }

  private function getReallyBigMockStockIterator(): iterable {
    $price=100;
    for($i=0;$i<10000;$i++){
      yield [
        $i,
        date('d-m-Y',strtotime("+$i days")),
        'GOOGL',
        $price+$i
      ];
    }
  }

  private function assertAnalysisOnReallyBigStockListIsValid($analysis): void {
    $this->assertEquals(
      5099.5,
      $analysis['mean']
    );
    $this->assertEquals(
      2886.8956799072,
      $analysis['standard_deviation']
    );
    $this->assertEquals(
      9999,
      $analysis['total_profit']
    );
    $this->assertEquals(
      1,
      count($analysis['buying_and_selling_dates'])
    );
    $this->assertEquals(
      date('d-m-Y'),
      $analysis['buying_and_selling_dates'][0]['buying_date']
    );
    $this->assertEquals(
      date('d-m-Y',strtotime("+9999 days")),
      $analysis['buying_and_selling_dates'][0]['selling_date']
    );
    $this->assertEquals(
      9999,
      $analysis['buying_and_selling_dates'][0]['profit']
    );
  }

  public function testAppCanAnalyseDecrementingStockList(): void {
    $stock_iterator=$this->getDecrementingStockIterator();
    $standard_stock_ticker=new StandardStockTicker(
      json_decode(
        file_get_contents(__DIR__.'/mocks/tickers.json'),
        true
      )
    );
    $app=new App(
      $stock_iterator,
      $standard_stock_ticker
    );
    $stock_to_analyse='GOOGL';
    $from_date=date('d-m-Y');
    $to_date=date('d-m-Y',strtotime("+10000 days"));
    $analysis=$app->analyse(
      $stock_to_analyse,
      $from_date,
      $to_date
    );
    $this->assertAnalysisOnDecrementingStockListIsValid(
      $analysis
    );
  }

  private function getDecrementingStockIterator(): iterable {
    $price=100;
    for($i=0;$i<10000;$i++){
      yield [
        $i,
        date('d-m-Y',strtotime("+$i days")),
        'GOOGL',
        $price-$i
      ];
    }
  }

  private function assertAnalysisOnDecrementingStockListIsValid($analysis): void {
    $this->assertEquals(
      -4899.5,
      $analysis['mean']
    );
    $this->assertEquals(
      2886.8956799072,
      $analysis['standard_deviation']
    );
    $this->assertEquals(
      0,
      $analysis['total_profit']
    );
    $this->assertEquals(
      0,
      count($analysis['buying_and_selling_dates'])
    );
  }
}
