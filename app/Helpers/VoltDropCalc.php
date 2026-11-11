<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VoltDropCalc
{
    private static $fileName = '';
    private static $generatedFileName = '';

    // -----------------------------------------------------------------------------
    public static function absolute_volt_drop($current_I, $length_L, $coefficient, $impedance_Zc)
    {
        $dV = ($current_I * $length_L * $coefficient * $impedance_Zc) / 1000;

        return $dV;
    }
    // -----------------------------------------------------------------------------
    public static function volt_drop_percentage($supply_voltage, $dV)
    {
        $final_voltage_drop = ($dV * 100) / $supply_voltage;

        return $final_voltage_drop;
    }
}
