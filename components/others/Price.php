<?php

namespace app\components\others;

class Price
{
    /**
     * @param $price
     * @return string
     */
    public static function pretty($price): string
    {
        if (!$price) {
            return '';
        }
        $price = (string)$price;
        $isHasDot = stripos($price, '.');
        if ($isHasDot !== false) {
            $partPrice = explode('.', $price);
            $leftPartPrice = $partPrice[0];
            $rightPartPrice = $partPrice[1];
            $leftPartPrice = self::reconstruct($leftPartPrice);
            return $leftPartPrice . '.' . $rightPartPrice;
        }
        return self::reconstruct($price);
    }

    /**
     * @param string $price
     * @return string
     */
    protected static function reconstruct(string $price): string
    {
        $priceAsArray = str_split($price);
        $charsCount = count($priceAsArray);
        $priceAsArray = array_reverse($priceAsArray);
        $prettyPrice = [];
        for ($i = 0; $i < $charsCount; $i++) {
            $char = $priceAsArray[$i];
            if ($i == 3 || $i == 6 || $i == 9) {
                $prettyPrice[] = ' ';
            }
            $prettyPrice[] = $char;
        }
        return implode('', array_reverse($prettyPrice));
    }
}