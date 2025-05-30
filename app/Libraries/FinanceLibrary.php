<?php
namespace App\Libraries;

class FinanceLibrary {
    //constructor
    public function __construct() {
    }

    /**
     * 財務関数 PMT() 元利均等返済
     *  利率(%)
     *  期間(年)
     *  現在価値
     **/
    public function pmt($interestRate, $term, $currentValue) {
        if ($interestRate <= 0) {
            throw new Exception('interestRate(利率)の指定に問題があります');
        }
        if ($term <= 0) {
            throw new Exception('term(期間(年))の指定に問題があります');
        }
        if ($currentValue <= 0) {
            throw new Exception('currentValue(現在価値)の指定に問題があります');
        }
        
        return (pow(1 + $interestRate, $term) * $interestRate / (pow(1 + $interestRate, $term) - 1)) * $currentValue;
    }

}
?>
