<?php

if (!function_exists('terbilang')) {
    /**
     * Convert number to words in Indonesian.
     *
     * @param float|int $number
     * @return string
     */
    function terbilang($number)
    {
        $number = abs($number);
        $words = ["", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS"];
        $temp = "";

        if ($number < 12) {
            $temp = " " . $words[$number];
        } else if ($number < 20) {
            $temp = terbilang($number - 10) . " BELAS";
        } else if ($number < 100) {
            $temp = terbilang((int)($number / 10)) . " PULUH" . terbilang($number % 10);
        } else if ($number < 200) {
            $temp = " SERATUS" . terbilang($number - 100);
        } else if ($number < 1000) {
            $temp = terbilang((int)($number / 100)) . " RATUS" . terbilang($number % 100);
        } else if ($number < 2000) {
            $temp = " SERIBU" . terbilang($number - 1000);
        } else if ($number < 1000000) {
            $temp = terbilang((int)($number / 1000)) . " RIBU" . terbilang($number % 1000);
        } else if ($number < 1000000000) {
            $temp = terbilang((int)($number / 1000000)) . " JUTA" . terbilang($number % 1000000);
        } else if ($number < 1000000000000) {
            $temp = terbilang((int)($number / 1000000000)) . " MILIAR" . terbilang($number % 1000000000);
        } else if ($number < 1000000000000000) {
            $temp = terbilang((int)($number / 1000000000000)) . " TRILIUN" . terbilang($number % 1000000000000);
        }

        return trim($temp);
    }
}
