<?php
//namespace App\Helpers;
//
//use NumberFormatter;
//class Currency{
//    public function __invoke(...$params): bool|string
//    {
//        return static::format(...$params);
//    }
//    public static function format($amount,$currency=null): bool|string
//    {
//        $formatter=new NumberFormatter(config('app.locate'),NumberFormatter::CURRENCY);
//            if ($currency==null){
//                $currency=config('app.currency','USD');
//            }
//            return $formatter->formatCurrency($amount,$currency);
//    }
//}
