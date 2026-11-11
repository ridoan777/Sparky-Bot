<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DeratingFactors
{
	public static function findDeratingFactorSingleTab23($support_condition, $spacing, $cable_supports, $circuit_per_row)
	{

		$table_23_singlecore = [
			"unperforated_tray" => [
				"touching" => [
					1 => [1 => 0.95, 2 => 0.85, 3 => 0.84],
					2 => [1 => 0.92, 2 => 0.83, 3 => 0.79],
					3 => [1 => 0.91, 2 => 0.82, 3 => 0.76],
				],
				"spaced" => [
					1 => [1 => 0.95, 2 => 0.95, 3 => 0.94],
					2 => [1 => 0.94, 2 => 0.93, 3 => 0.87],
					3 => [1 => 0.91, 2 => 0.90, 3 => 0.85],
				],
			],
			"perforated_tray" => [
				"touching" => [
					1 => [1 => 0.97, 2 => 0.89, 3 => 0.87],
					2 => [1 => 0.94, 2 => 0.85, 3 => 0.81],
					3 => [1 => 0.93, 2 => 0.84, 3 => 0.79],
				],
				"spaced" => [
					1 => [1 => 0.97, 2 => 0.97, 3 => 0.96],
					2 => [1 => 0.94, 2 => 0.93, 3 => 0.89],
					3 => [1 => 0.93, 2 => 0.92, 3 => 0.86],
				],
			],
			"ladder_racks_cleats" => [
				"touching" => [
					1 => [1 => 1.00, 2 => 0.95, 3 => 0.94],
					2 => [1 => 0.95, 2 => 0.90, 3 => 0.88],
					3 => [1 => 0.95, 2 => 0.89, 3 => 0.85],
				],
				"spaced" => [
					1 => [1 => 1.00, 2 => 1.00, 3 => 1.00],
					2 => [1 => 0.95, 2 => 0.95, 3 => 0.93],
					3 => [1 => 0.95, 2 => 0.94, 3 => 0.90],
				],
			],
			"vertical_perforated_tray" => [
				"touching" => [
					1 => [1 => 0.94, 2 => 0.85, 3 => null],
					2 => [1 => 0.92, 2 => 0.83, 3 => null],
				],
				"spaced" => [
					1 => [1 => 1.00, 2 => 0.91, 3 => 0.89],
					2 => [1 => 1.00, 2 => 0.90, 3 => 0.86],
				],
			],

		];

		if (
			isset($table_23_singlecore[$support_condition]) &&
			isset($table_23_singlecore[$support_condition][$spacing]) &&
			isset($table_23_singlecore[$support_condition][$spacing][$cable_supports]) &&
			array_key_exists($circuit_per_row, $table_23_singlecore[$support_condition][$spacing][$cable_supports])
		) {
			$factor = $table_23_singlecore[$support_condition][$spacing][$cable_supports][$circuit_per_row];

			return [
				'factor' => $factor,
				'Table' => "table-23",
				'message' => $factor === null ? 'Value not defined in AS/NZS 3008 (Table 23).' : "",
				'FLAG' => $factor === null ? 0 : 1,
			];
		}
		return [
			'factor' => null,
			'Table' => "table-23",
			'message' => 'Invalid input combination (not in AS/NZS 3008, unmatched for single-core).',
			'FLAG' => 0,
		];
	}
	// -----------------------------------------------------------------------------
	public static function findDeratingFactorMultiTab24($support_condition, $spacing, $cable_supports, $total_cables)
	{

		$table_24_multicore = [
			"unperforated_tray" => [
				"touching" => [
					1 => [1 => 0.97, 2 => 0.85, 3 => 0.78, 4 => 0.75, 6 => 0.71, 9 => 0.68],
					2 => [1 => 0.97, 2 => 0.84, 3 => 0.76, 4 => 0.73, 6 => 0.68, 9 => 0.63],
					3 => [1 => 0.97, 2 => 0.83, 3 => 0.75, 4 => 0.72, 6 => 0.66, 9 => 0.61],
				],
				"spaced" => [
					1 => [1 => 0.97, 2 => 0.96, 3 => 0.94, 4 => 0.93, 6 => 0.90, 9 => null],
					2 => [1 => 0.97, 2 => 0.95, 3 => 0.92, 4 => 0.90, 6 => 0.86, 9 => null],
					3 => [1 => 0.97, 2 => 0.94, 3 => 0.91, 4 => 0.89, 6 => 0.86, 9 => null],
				]
			],
			"perforated_tray" => [
				"touching" => [
					1 => [1 => 1.00, 2 => 0.88, 3 => 0.82, 4 => 0.78, 6 => 0.76, 9 => 0.73],
					2 => [1 => 1.00, 2 => 0.87, 3 => 0.80, 4 => 0.76, 6 => 0.73, 9 => 0.68],
					3 => [1 => 1.00, 2 => 0.86, 3 => 0.79, 4 => 0.75, 6 => 0.71, 9 => 0.66],
				],
				"spaced" => [
					1 => [1 => 1.00, 2 => 1.00, 3 => 0.98, 4 => 0.95, 6 => 0.91, 9 => null],
					2 => [1 => 1.00, 2 => 0.99, 3 => 0.96, 4 => 0.92, 6 => 0.87, 9 => null],
					3 => [1 => 1.00, 2 => 0.98, 3 => 0.95, 4 => 0.91, 6 => 0.85, 9 => null],
				]
			],
			"ladder_racks_cleats" => [
				"touching" => [
					1 => [1 => 1.00, 2 => 0.87, 3 => 0.82, 4 => 0.80, 6 => 0.79, 9 => 0.78],
					2 => [1 => 1.00, 2 => 0.86, 3 => 0.80, 4 => 0.78, 6 => 0.76, 9 => 0.73],
					3 => [1 => 1.00, 2 => 0.85, 3 => 0.79, 4 => 0.76, 6 => 0.73, 9 => 0.70],
				],
				"spaced" => [
					1 => [1 => 1.00, 2 => 1.00, 3 => 1.00, 4 => 1.00, 6 => 1.00, 9 => null],
					2 => [1 => 1.00, 2 => 0.99, 3 => 0.98, 4 => 0.97, 6 => 0.96, 9 => null],
					3 => [1 => 1.00, 2 => 0.98, 3 => 0.97, 4 => 0.96, 6 => 0.93, 9 => null],
				]
			],
			"vertical_perforated_tray" => [
				"touching" => [
					1 => [1 => 1.00, 2 => 0.88, 3 => 0.82, 4 => 0.77, 6 => 0.73, 9 => 0.72],
					2 => [1 => 1.00, 2 => 0.88, 3 => 0.81, 4 => 0.76, 6 => 0.72, 9 => 0.70],
				],
				"spaced" => [
					1 => [1 => 1.00, 2 => 0.91, 3 => 0.89, 4 => 0.88, 6 => 0.87, 9 => null],
					2 => [1 => 1.00, 2 => 0.91, 3 => 0.88, 4 => 0.87, 6 => 0.86, 9 => null],
				]
			],
		];

		$lastValueOfPFactor = null;
		$pFactorForSixCables = null;
		$message = null;

		if ($support_condition === "vertical_perforated_tray" && $cable_supports > 2) {
			return [
				'factor' => $lastValueOfPFactor,
				'Table' => "table-24",
				'Condition' => "support_condition === vertical_perforated_tray && cable_supports > 2",
				'message' => "Unsupported cable supports/row numbers for Vertical Perforated Tray. Allowed number is 1 or 2 by the standard AS/NZS 3008 table-24",
				'FLAG' => 0
			];
		}

		foreach (($table_24_multicore[$support_condition][$spacing][$cable_supports] ?? []) as $cables => $d_factor) {
			$lastValueOfPFactor = $d_factor;

			if ($cables == 6) {
				$pFactorForSixCables = $d_factor;
			}

			if ($total_cables <= $cables) {
				if ($d_factor === null) {
					$message = "The derating value for {$total_cables} cables is null (by the standard AS/NZS 3008 table-24). Reduce the number of cables. Here the closest derating factor (for 6-cables) is used!";
					return [
						'factor' => $pFactorForSixCables,
						'Table' => "table-24",
						'Condition' => "d_factor === null",
						'message' => $message,
						'FLAG' => 1
					];
				}

				return [
					'factor' => $d_factor,
					'Table' => "table-24",
					'Condition' => "total_cables <= $cables",
					'message' => null,
					'FLAG' => 1
				];
			}
		}

		if ($total_cables > 9 && $lastValueOfPFactor !== null) {
			$message = "The number of {$total_cables} cables are not supported (by the standard AS/NZS 3008 table-24). This calculation used the closest derating value for {$cables}-cables. Be extra cautious before applying!";
			return [
				'factor' => $lastValueOfPFactor,
				'Table' => "table-24",
				'Condition' => "total_cables > 9 && D_factor !== null",
				'message' => $message,
				'FLAG' => 1
			];
		}
		// runs when total_cables > 9 & also Df of 9 = null
		if ($total_cables > 9 && $lastValueOfPFactor === null) {
			$message = "The derating value for {$total_cables} cables is undefined by the standard AS/NZS 3008 (Table-24). Reduce the number of cables or use the derating factor of 6-cables with caution!";
			return [
				'factor' => $lastValueOfPFactor,
				'Table' => "table-24",
				'Condition' => "total_cables > 9 && D_factor +== null",
				'message' => $message,
				'FLAG' => 0
			];
		}
	}
	// -----------------------------------------------------------------------------

}
