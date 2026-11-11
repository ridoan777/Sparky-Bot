<?php

namespace App\Helpers;

class CableSizeVoltDrops
{
	public static $first_cable_size = null;

	public static function phase3_Vd_singlecore_sheathed_copper_tab40($temperature, $power_factor, $cable_size, $cable_length, $load_current, $max_volt_drop, $phase)
	{
		$FLAG = 0;

		$installation_type = trim(strtolower($temperature));
		$cable_type = trim(strtolower($power_factor));

		$phase3_Vd_singlecore_sheathed_copper_table40 = [
			'temp_75' => [
				'pf_max' => [
					'1' => 44.7,
					'1.5' => 28.6,
					'2.5' => 15.6,
					'4' => 9.71,
					'6' => 6.49,
					'10' => 3.86,
					'16' => 2.43,
					'25' => 1.54,
					'35' => 1.12,
					'50' => 0.834,
					'70' => 0.589,
					'95' => 0.439,
					'120' => 0.359,
					'150' => 0.305,
					'185' => 0.261,
					'240' => 0.221,
					'300' => 0.198,
					'400' => 0.181,
					'500' => 0.168,
					'630' => 0.157,
				],
				'pf_0.8' => [
					'1' => 44.7,
					'1.5' => 28.6,
					'2.5' => 15.6,
					'4' => 9.71,
					'6' => 6.49,
					'10' => 3.86,
					'16' => 2.43,
					'25' => 1.54,
					'35' => 1.12,
					'50' => 0.834,
					'70' => 0.589,
					'95' => 0.439,
					'120' => 0.359,
					'150' => 0.305,
					'185' => 0.261,
					'240' => 0.220,
					'300' => 0.195,
					'400' => 0.173,
					'500' => 0.156,
					'630' => 0.142,
				],
			],
			'temp_90' => [
				'pf_max' => [
					'1' => 46.8,
					'1.5' => 30.0,
					'2.5' => 16.4,
					'4' => 10.2,
					'6' => 6.81,
					'10' => 4.05,
					'16' => 2.55,
					'25' => 1.62,
					'35' => 1.17,
					'50' => 0.872,
					'70' => 0.615,
					'95' => 0.457,
					'120' => 0.373,
					'150' => 0.316,
					'185' => 0.269,
					'240' => 0.227,
					'300' => 0.202,
					'400' => 0.183,
					'500' => 0.170,
					'630' => 0.159,
				],
				'pf_0.8' => [
					'1' => 46.8,
					'1.5' => 30.0,
					'2.5' => 16.4,
					'4' => 10.2,
					'6' => 6.81,
					'10' => 4.05,
					'16' => 2.55,
					'25' => 1.62,
					'35' => 1.17,
					'50' => 0.872,
					'70' => 0.615,
					'95' => 0.457,
					'120' => 0.373,
					'150' => 0.316,
					'185' => 0.269,
					'240' => 0.227,
					'300' => 0.199,
					'400' => 0.176,
					'500' => 0.158,
					'630' => 0.144,
				],
			],
		];

		$voltDropFromTable40 = $phase3_Vd_singlecore_sheathed_copper_table40[$temperature][$power_factor][$cable_size];

		return self::finalCableSizeResult($voltDropFromTable40, $cable_size, $cable_length, $load_current, $max_volt_drop, $temperature, $power_factor, $phase, "table-40");

	}

	// -----------------------------------------------------------------------------

	public static function phase3_Vd_multicore_circular_copper_tab42($temperature, $power_factor, $cable_size, $cable_length, $load_current, $max_volt_drop, $phase)
	{

		$FLAG = 0;

		$installation_type = trim(strtolower($temperature));
		$cable_type = trim(strtolower($power_factor));

		$phase3_Vd_multicore_circular_copper_table42 = [
			'temp_75' => [
				'pf_max' => [
					'1' => 44.7,
					'1.5' => 28.6,
					'2.5' => 15.6,
					'4' => 9.71,
					'6' => 6.49,
					'10' => 3.86,
					'16' => 2.43,
					'25' => 1.54,
					'35' => 1.11,
					'50' => 0.829,
					'70' => 0.583,
					'95' => 0.431,
					'120' => 0.351,
					'150' => 0.296,
					'185' => 0.251,
					'240' => 0.210,
					'300' => 0.186,
					'400' => 0.168,
					'500' => 0.156,
				],
				'pf_0.8' => [
					'1' => 44.7,
					'1.5' => 28.6,
					'2.5' => 15.6,
					'4' => 9.71,
					'6' => 6.49,
					'10' => 3.86,
					'16' => 2.43,
					'25' => 1.54,
					'35' => 1.11,
					'50' => 0.829,
					'70' => 0.583,
					'95' => 0.431,
					'120' => 0.351,
					'150' => 0.296,
					'185' => 0.251,
					'240' => 0.210,
					'300' => 0.185,
					'400' => 0.164,
					'500' => 0.148,
				],
			],
			'temp_90' => [
				'pf_max' => [
					'1' => 46.8,
					'1.5' => 30.0,
					'2.5' => 16.4,
					'4' => 10.2,
					'6' => 6.80,
					'10' => 4.05,
					'16' => 2.55,
					'25' => 1.61,
					'35' => 1.17,
					'50' => 0.868,
					'70' => 0.609,
					'95' => 0.450,
					'120' => 0.366,
					'150' => 0.307,
					'185' => 0.259,
					'240' => 0.216,
					'300' => 0.190,
					'400' => 0.171,
					'500' => 0.158,
				],
				'pf_0.8' => [
					'1' => 46.8,
					'1.5' => 30.0,
					'2.5' => 16.4,
					'4' => 10.2,
					'6' => 6.80,
					'10' => 4.05,
					'16' => 2.55,
					'25' => 1.61,
					'35' => 1.17,
					'50' => 0.868,
					'70' => 0.609,
					'95' => 0.450,
					'120' => 0.366,
					'150' => 0.307,
					'185' => 0.259,
					'240' => 0.216,
					'300' => 0.189,
					'400' => 0.167,
					'500' => 0.151,
				],
			],
		];

		$voltDropFromTable42 = $phase3_Vd_multicore_circular_copper_table42[$temperature][$power_factor][$cable_size];

		return self::finalCableSizeResult($voltDropFromTable42, $cable_size, $cable_length, $load_current, $max_volt_drop, $temperature, $power_factor, $phase, "table-42");

	}

	// -----------------------------------------------------------------------------

	public static function phase3_Vd_singlecore_sheathed_aluminium_tab44($temperature, $power_factor, $cable_size, $cable_length, $load_current, $max_volt_drop, $phase)
	{

		$FLAG = 0;

		$installation_type = trim(strtolower($temperature));
		$cable_type = trim(strtolower($power_factor));

		$phase3_Vd_singlecore_sheathed_aluminium_table44 = [
			'temp_75' => [
				'pf_max' => [
					'16' => 4.05,
					'25' => 2.55,
					'35' => 1.85,
					'50' => 1.37,
					'70' => 0.956,
					'95' => 0.702,
					'120' => 0.565,
					'150' => 0.472,
					'185' => 0.391,
					'240' => 0.319,
					'300' => 0.276,
					'400' => 0.240,
					'500' => 0.216,
					'630' => 0.197,
				],
				'pf_0.8' => [
					'16' => 4.05,
					'25' => 2.55,
					'35' => 1.85,
					'50' => 1.37,
					'70' => 0.956,
					'95' => 0.702,
					'120' => 0.565,
					'150' => 0.472,
					'185' => 0.391,
					'240' => 0.319,
					'300' => 0.275,
					'400' => 0.238,
					'500' => 0.209,
					'630' => 0.185,
				],
			],
			'temp_90' => [
				'pf_max' => [
					'16' => 4.25,
					'25' => 2.67,
					'35' => 1.94,
					'50' => 1.44,
					'70' => 1.00,
					'95' => 0.733,
					'120' => 0.589,
					'150' => 0.491,
					'185' => 0.404,
					'240' => 0.327,
					'300' => 0.281,
					'400' => 0.243,
					'500' => 0.243,
					'630' => 0.198,
				],
				'pf_0.8' => [
					'16' => 4.25,
					'25' => 2.67,
					'35' => 1.94,
					'50' => 1.44,
					'70' => 1.00,
					'95' => 0.733,
					'120' => 0.589,
					'150' => 0.491,
					'185' => 0.404,
					'240' => 0.327,
					'300' => 0.281,
					'400' => 0.242,
					'500' => 0.211,
					'630' => 0.188,
				],
			],
		];

		$voltDropFromTable44 = $phase3_Vd_singlecore_sheathed_aluminium_table44[$temperature][$power_factor][$cable_size];

		return self::finalCableSizeResult($voltDropFromTable44, $cable_size, $cable_length, $load_current, $max_volt_drop, $temperature, $power_factor, $phase, "table-44");

	}

	// -----------------------------------------------------------------------------

	public static function phase3_Vd_multicore_circular_Al_tab45($temperature, $power_factor, $cable_size, $cable_length, $load_current, $max_volt_drop, $phase)
	{

		$FLAG = 0;

		$installation_type = trim(strtolower($temperature));
		$cable_type = trim(strtolower($power_factor));

		$phase3_Vd_multicore_circular_Al_table45 = [
			'temp_75' => [
				'pf_max' => [
					'16' => 4.04,
					'25' => 2.54,
					'35' => 1.84,
					'50' => 1.36,
					'70' => 0.948,
					'95' => 0.691,
					'120' => 0.552,
					'150' => 0.457,
					'185' => 0.373,
					'240' => 0.297,
					'300' => 0.251,
					'400' => 0.212,
					'500' => 0.186,
				],
				'pf_0.8' => [
					'16' => 4.04,
					'25' => 2.54,
					'35' => 1.84,
					'50' => 1.36,
					'70' => 0.948,
					'95' => 0.691,
					'120' => 0.552,
					'150' => 0.457,
					'185' => 0.373,
					'240' => 0.297,
					'300' => 0.251,
					'400' => 0.212,
					'500' => 0.185,
				],
			],
			'temp_90' => [
				'pf_max' => [
					'16' => 4.24,
					'25' => 2.67,
					'35' => 1.93,
					'50' => 1.43,
					'70' => 0.993,
					'95' => 0.723,
					'120' => 0.577,
					'150' => 0.476,
					'185' => 0.388,
					'240' => 0.307,
					'300' => 0.258,
					'400' => 0.216,
					'500' => 0.189,
				],
				'pf_0.8' => [
					'16' => 4.24,
					'25' => 2.67,
					'35' => 1.93,
					'50' => 1.43,
					'70' => 0.993,
					'95' => 0.723,
					'120' => 0.577,
					'150' => 0.476,
					'185' => 0.388,
					'240' => 0.307,
					'300' => 0.258,
					'400' => 0.216,
					'500' => 0.189,
				],
			],
		];

		$voltDropFromTable45 = $phase3_Vd_multicore_circular_Al_table45[$temperature][$power_factor][$cable_size];

		return self::finalCableSizeResult($voltDropFromTable45, $cable_size, $cable_length, $load_current, $max_volt_drop, $temperature, $power_factor, $phase, "table-45");
	}

	// -----------------------------------------------------------------------------

	public static function finalCableSizeResult($Vc_fromTable, $cableSize, $cableLength, $loadCurrent, $maxVDrop, $temperature, $Pf, $phase, $tableNo)
	{
		$cableVoltDrop = round(($cableLength * $loadCurrent * $Vc_fromTable) / 1000, 2);

		if (self::$first_cable_size == null) {
			self::$first_cable_size = $cableSize;
		}

		if (trim(strtolower($phase)) !== '3-phase') {
			$cableVoltDrop *= 1.115;
		}

		// If supported, return success
		if ($cableVoltDrop <= $maxVDrop) {
			$MESSAGE = "";
			if ($cableSize !== self::$first_cable_size) {
				$MESSAGE = "Based on the inputs, the " . self::$first_cable_size . "mm² cable size was primarily suggested which does not support the voltage drop. The suggested cable size is: " . $cableSize . "mm².";
			} else {
				$MESSAGE = "Based on the inputs, The {$cableSize}mm² cable size is suggested & supported for your max volt drop rate.";
			}

			return [
				'FLAG' => 1,
				'Table' => $tableNo,
				'Vc_fromTable' => $Vc_fromTable,
				'cableVoltDrop' => $cableVoltDrop,
				'max_volt_drop_allowed' => $maxVDrop,
				'temperature' => $temperature,
				'power_factor' => $Pf,
				'first_suggested_cable_size' => self::$first_cable_size,
				'cable_size' => $cableSize,
				'message' => $MESSAGE,
			];
		}

		// Unsupported → try next cable size
		$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
		$caller = $trace[1]['function'];
		$class = $trace[1]['class'];

		$cableSizes = ['1', '1.5', '2.5', '4', '6', '10', '16', '25', '35', '50', '70', '95', '120', '150', '185', '240', '300', '400', '500'];
		$currentIndex = array_search((string) $cableSize, $cableSizes, true);

		if ($currentIndex !== false && isset($cableSizes[$currentIndex + 1])) {
			$nextSize = $cableSizes[$currentIndex + 1];

			return $class::$caller($temperature, $Pf, $nextSize, $cableLength, $loadCurrent, $maxVDrop, $phase);
		}

		// No larger size exists
		return [
			'FLAG' => 0,
			'Table' => $tableNo,
			'Vc_fromTable' => $Vc_fromTable,
			'cableVoltDrop' => $cableVoltDrop,
			'max_volt_drop_allowed' => $maxVDrop,
			'temperature' => $temperature,
			'power_factor' => $Pf,
			'first_suggested_cable_size' => self::$first_cable_size,
			'cable_size' => $cableSize,
			'message' => "No larger cable size available in {$tableNo}.",
		];
	}

}


