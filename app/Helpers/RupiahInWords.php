<?php

if (!function_exists('rupiahInWords')) {

    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = [
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas"
        ];

        if ($nilai < 12) {
            return " " . $huruf[$nilai];
        } elseif ($nilai < 20) {
            return penyebut($nilai - 10) . " belas";
        } elseif ($nilai < 100) {
            return penyebut(intval($nilai / 10)) . " puluh" . penyebut($nilai % 10);
        } elseif ($nilai < 200) {
            return " seratus" . penyebut($nilai - 100);
        } elseif ($nilai < 1000) {
            return penyebut(intval($nilai / 100)) . " ratus" . penyebut($nilai % 100);
        } elseif ($nilai < 2000) {
            return " seribu" . penyebut($nilai - 1000);
        } elseif ($nilai < 1000000) {
            return penyebut(intval($nilai / 1000)) . " ribu" . penyebut($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            return penyebut(intval($nilai / 1000000)) . " juta" . penyebut($nilai % 1000000);
        } elseif ($nilai < 1000000000000) {
            return penyebut(intval($nilai / 1000000000)) . " milyar" . penyebut($nilai % 1000000000);
        } else {
            return penyebut(intval($nilai / 1000000000000)) . " triliun" . penyebut($nilai % 1000000000000);
        }
    }

    function rupiahInWords($nilai)
    {
        if ($nilai < 0) {
            return "Minus " . trim(penyebut($nilai)) . " rupiah";
        }

        return ucfirst(trim(penyebut($nilai))) . " rupiah";
    }
}
