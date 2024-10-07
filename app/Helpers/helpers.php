<?php

if (!function_exists('format_number')) {
    /**
     * Format a number with commas in thousands or lakhs without decimals.
     * 
     * @param int $number
     * @param bool $isIndianFormat
     * @return string
     */
    function format_number($number, $isIndianFormat = true)
    {
        if ($isIndianFormat) {
            $integerPart = (string)$number;

            $lastThree = substr($integerPart, -3);
            $remainingUnits = substr($integerPart, 0, -3);

            if (strlen($remainingUnits) > 0) {
                $remainingUnits = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remainingUnits);
                return $remainingUnits . ',' . $lastThree;
            }
            return $integerPart;
        } else {
            return number_format($number, 0, '.', ',');
        }
    }
}
