<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VoltDropImpedanceTable
{
    public static function fetch_Xc_Rc($cable_size, $flag){
        switch($flag){
            case 'xc':
                return self::reactance_Table_30($cable_size);
            case 'rc':
                return self::resistance_Table_35($cable_size);
            default:
                return "Cable size error!";
        }
    }

    public static function reactance_Table_30($Xc)
    {
        // multicore->circular->PVC
        $multicore_circular_pvc = [
            '1' => 0.119,
            '1.5' => 0.111,
            '2.5' => 0.102,
            '4' => 0.102,
            '6' => 0.0967,
            '10' => 0.0906,
            '16' => 0.0861,
            '25' => 0.0853,
            '35' => 0.0826,
            '50' => 0.0797,
            '70' => 0.0770,
            '95' => 0.0766,
            '120' => 0.0743,
            '150' => 0.0745,
            '185' => 0.0744,
            '240' => 0.0735,
            '300' => 0.0732,
            '400' => 0.0728,
            '500' => 0.0723,
        ];

        foreach ($multicore_circular_pvc as $key => $value) {
            if ((float) $key >= (float) $Xc) {
                return round($value, 4);
            }
        }
        // alt+numpad(0178)
        return 'Cable/Conductor size = ' . $value . 'mm² (sq mm). ' . "But accepted conductor/cable size is greater than 0 mm² to 500 mm².";
    }
    // -----------------------------------------------------------------------------
    public static function resistance_Table_35($Rc)
    {
        // multicore->circular->copper->at temperature 75°C (Alt+numpad 0176)
        $multicore_circular_copper_75 = [
            '1' => 25.8,
            '1.5' => 16.5,
            '2.5' => 9.01,

            '4' => 5.61,
            '6' => 3.75,
            '10' => 2.23,

            '16' => 1.40,
            '25' => 0.884,
            '35' => 0.638,

            '50' => 0.471,
            '70' => 0.327,
            '95' => 0.236,

            '120' => 0.188,
            '150' => 0.153,
            '185' => 0.123,

            '240' => 0.0955,
            '300' => 0.0778,
            '400' => 0.0630,

            '500' => 0.0525,
        ];

        foreach ($multicore_circular_copper_75 as $key => $value) {
            if ((float) $key >= (float) $Rc) {
                return round($value, 4);
            }
        }
        // alt+numpad(0178)
        return 'Cable/Conductor size = ' . $value . 'mm² (sq mm). ' . "But accepted conductor/cable size is greater than 0 mm² to 500 mm².";
    }
    // -----------------------------------------------------------------------------
    public static function impedance_Zc($cable_size)
    {
        $Xc = self::reactance_Table_30($cable_size);
        $Rc = self::resistance_Table_35($cable_size);

        $calculated_Zc = sqrt(pow($Rc, 2) + pow($Xc, 2));

        return round($calculated_Zc, 4);
    }
    // -----------------------------------------------------------------------------
}
