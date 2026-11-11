<?php

namespace App\Http\Controllers;

use App\Helpers\CableSizeVoltDrops;
use App\Helpers\CurrentCarryingCapacities;
use App\Helpers\DeratingFactors;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CableSizeController extends Controller
{
	public function cableSizeCalculate(Request $request)
	{
		try {
			// ------our content starts here--------
			$validator = Validator::make($request->all(), [
				'phase' => 'required|string|in:1-phase,3-phase,dc',
				'voltage' => 'nullable|numeric',
				'load_current' => 'required|numeric|min:1|max:800',
				'installation_type' => 'required|string',
				'cable_type' => 'required|string',
				'cable_core' => 'required|string|in:single,multi',
				'circuit_per_row' => 'nullable|numeric', // only if cable_core=single

				'support_condition' => ['required', 'string', 'regex:/^[A-Za-z0-9\-\._]*$/'],
				'spacing' => ['required', 'string', 'regex:/^[A-Za-z0-9\-\._]*$/'],
				// 'cable_supports' => 'required|numeric|in:1,2,3',
				'cable_supports' => 'required|numeric', // Flutter face problems with this in: validation
				'total_cables' => 'required|numeric',

				'conductor_temperature' => 'required|string',
				'power_factor' => 'required|string',
				'cable_length' => 'required|numeric|min:0.1',
				'max_volt_drop' => 'required|numeric|min:1|max:12',
			], [
				'load_current.min' => 'Minimum working current is 1A (AS/NZS 3008.1.1:2017, Clause 2.1)',
				'load_current.max' => 'Maximum working current is 800A (AS/NZS 3008.1.1:2017, Clause 2.1)',
				// 'cable_supports.in' => "Selected cable supports/row numbers is unsupported by the standard AS/NZS-3008 (Table-24). Allowed values 1,2 or 3." // Flutter face problems with this validation
			]);
			
			if ($validator->fails()) {
				return response()->json([
					'status' => 422,
					'message' => 'validation error',
					'data' => $validator->errors()->all()
				]);
			}
			// dd($request->all());

		// -----------VARIABLES:USER-INPUTS-----------
			$PHASE = trim(strtolower($request->phase));
			$VOLTAGE = round((float) ($request->voltage));
			$LOAD_CURRENT = (float) $request->load_current;
			
			$INSTALLATION_TYPE = $request->installation_type;
			$CABLE_TYPE = trim(strtolower($request->cable_type));
			$CABLE_CORE = trim(strtolower($request->cable_core));
			$CIRCUIT_PER_ROW = (int) $request->circuit_per_row ?? null; // only for table-23 single core

			$SUPPORT_CONDITION = $request->support_condition;
			$SPACING = $request->spacing;
			$CABLE_SUPPORTS = (int) $request->cable_supports;
			$TOTAL_CABLES = (int) $request->total_cables;

			$CONDUCTOR_TEMPERATURE = $request->conductor_temperature;
			$POWER_FACTOR = $request->power_factor;
			$MAX_VOLT_DROP = $request->max_volt_drop;
			$CABLE_LENGTH = $request->cable_length;
		// -----------VARIABLES:USER-INPUTS-----------

		// -----------VARIABLES:CALCULATED-----------
			$DERATING_FACTOR = 0;
			$DERATING_MESSAGE = "";

			$MIN_CURRENT_CARRYING_CAPACITY = 0;
			$MIN_CABLE_SIZE = 0;
		// -----------VARIABLES:CALCULATED-----------


		// -----------DERATING FACTOR-----------
			$deratingResult = null;

			if ($CABLE_CORE === 'single') {
				
				$deratingResult = DeratingFactors::findDeratingFactorSingleTab23($SUPPORT_CONDITION, $SPACING, $CABLE_SUPPORTS, $CIRCUIT_PER_ROW);

			} else if ($CABLE_CORE === 'multi') {

				$deratingResult = DeratingFactors::findDeratingFactorMultiTab24($SUPPORT_CONDITION, $SPACING, $CABLE_SUPPORTS, $TOTAL_CABLES);

			} else {
				return response()->json([
					'status' => 422,
					'process' => "unprocessable input data",
					'message' => $CABLE_CORE . " is a wrong cable-core type for finding derating factor!",
				]);
			}
			
			$DERATING_FACTOR = $deratingResult['factor'];
			$DERATING_MESSAGE = $deratingResult['message'];
			$deratingFLAG = $deratingResult['FLAG'];

			if ($deratingFLAG == 0 || $DERATING_FACTOR == 0) {	// 0 = unprocessable, 1 = okay
				return response()->json([
					'status' => 422,
					'data' => "Derating factor = " . $DERATING_FACTOR,
					'process' => "unprocessable input data",
					'message' => $DERATING_MESSAGE,
				]);
			}
		// -----------DERATING FACTOR-----------


		// -----------FIND MIN CABLE SIZE VIA MINIMUM CURRENT CARRYING CAPACITY -----------

			$MIN_CURRENT_CARRYING_CAPACITY = round((float) ($LOAD_CURRENT * (1 / $DERATING_FACTOR)), 2);
			$mccResult = null;

			if ($CABLE_CORE === 'single') {

				$mccResult = CurrentCarryingCapacities::findMCC_CapacitySinglecoreTab7($INSTALLATION_TYPE, $CABLE_TYPE, $MIN_CURRENT_CARRYING_CAPACITY);

			} else if ($CABLE_CORE === 'multi') {

				$mccResult = CurrentCarryingCapacities::findMCC_CapacityMulticoreTab13($INSTALLATION_TYPE, $CABLE_TYPE, $MIN_CURRENT_CARRYING_CAPACITY);

			} else {
				return response()->json([
					'status' => 422,
					'process' => "unprocessable input data",
					'message' => $CABLE_CORE . " is a wrong cable-core type for finding min current carrying capacity!",
				]);
			}

			$MIN_CABLE_SIZE = round((float) $mccResult['minCableSize'], 2);
		
		// -----------FIND MIN CABLE SIZE VIA MINIMUM CURRENT CARRYING CAPACITY-----------


		// -----------FINAL CABLE SIZE VIA VOLT DROP-----------

			$finalCableSize = null;

			if ($CABLE_TYPE !== 'aluminium' && $CABLE_CORE === 'single') {

				$finalCableSize = CableSizeVoltDrops::phase3_Vd_singlecore_sheathed_copper_tab40($CONDUCTOR_TEMPERATURE, $POWER_FACTOR, $MIN_CABLE_SIZE, $CABLE_LENGTH, $LOAD_CURRENT, $MAX_VOLT_DROP, $PHASE);

			} else if ($CABLE_TYPE === 'aluminium' && $CABLE_CORE === 'single') {

				$finalCableSize = CableSizeVoltDrops::phase3_Vd_singlecore_sheathed_aluminium_tab44($CONDUCTOR_TEMPERATURE, $POWER_FACTOR, $MIN_CABLE_SIZE, $CABLE_LENGTH, $LOAD_CURRENT, $MAX_VOLT_DROP, $PHASE);

			} else if ($CABLE_TYPE === 'aluminium' && $CABLE_CORE === 'multi') {

				$finalCableSize = CableSizeVoltDrops::phase3_Vd_multicore_circular_Al_tab45($CONDUCTOR_TEMPERATURE, $POWER_FACTOR, $MIN_CABLE_SIZE, $CABLE_LENGTH, $LOAD_CURRENT, $MAX_VOLT_DROP, $PHASE);

			} else {

				$finalCableSize = CableSizeVoltDrops::phase3_Vd_multicore_circular_copper_tab42($CONDUCTOR_TEMPERATURE, $POWER_FACTOR, $MIN_CABLE_SIZE, $CABLE_LENGTH, $LOAD_CURRENT, $MAX_VOLT_DROP, $PHASE);

			}

		// -----------FINAL CABLE SIZE VIA VOLT DROP-----------

			if ($finalCableSize['FLAG'] === 0) {
				return response()->json([
					'status' => 422,
					'Table_used' => $deratingResult['Table'] ."|". $mccResult['Table'] ."|". $finalCableSize['Table'],
					'derating_factor' => $DERATING_FACTOR,
					'min_cc_capacity' => $MIN_CURRENT_CARRYING_CAPACITY,
					'max_allowed_volt_drop' => $MAX_VOLT_DROP,
					'cable_volt_drop' => $finalCableSize['cableVoltDrop'],
					'cable_size_suggestion' => $finalCableSize['cable_size'],
					'message' => $finalCableSize['message'],
				]);
			}
			else {
				return response()->json([
					'status' => 200,
					'Table_used' => $deratingResult['Table'] ."|". $mccResult['Table'] ."|". $finalCableSize['Table'],
					'derating_factor' => $DERATING_FACTOR,
					'min_cc_capacity' => $MIN_CURRENT_CARRYING_CAPACITY,
					'max_allowed_volt_drop' => $MAX_VOLT_DROP,
					'cable_volt_drop' => $finalCableSize['cableVoltDrop'],
					'first_suggestion' => $finalCableSize['first_suggested_cable_size'] . "mm²",
					'cable_size_suggestion' => $finalCableSize['cable_size'],
					'message' => $finalCableSize['message'],
				]);
			}

			// ------our content ends here--------
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error/Faulty value inserted: ' . $e->getMessage()
			]);
		}
	}
}


// ---------------- UI change note --------------------
# varaible entries must come with dropdown with details but the value="" with be fixed matching the database/model