<?php

namespace App\Http\Controllers;

use App\Helpers\VoltDropCalc;
use App\Helpers\VoltDropImpedanceTable;
use App\Models\VoltDrop;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VoltDropController extends Controller
{

	public function index()
	{
		try {
			return response()->json([
				'status' => 200,
				'message' => 'voltage-drop calculator page',
				'data' => ''
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

	public function voltdropCalculate(Request $request)
	{
		try {
			$validator = Validator::make($request->all(), [
				'email' => 'nullable|string',
				'phase' => ['required', 'string', 'regex:/^[A-Za-z0-9\-\._]*$/'],
				'cable_length' => 'required|numeric',
				'current' => 'required|numeric',
				'voltage' => 'required|numeric',
				'cable_size' => 'required|numeric|gt:0|max:500',
			], [
				'cable_size.max' => "Cable/Conductor size = " . $request->cable_size . "mm² (sq mm). " . "But accepted conductor/cable size is greater than 0 mm² to 500 mm²."
			]);
			if ($validator->fails()) {
				return response()->json([
					'status' => 422,
					'message' => 'validation error',
					'data' => $validator->errors()->all()
				]);
			}

			$validated = $validator->validated();

			// 1, 3 or DC which decides the formula
			$PHASE_PHI = strtolower($validated['phase']);
			$CABLE_LENGTH_L = $validated['cable_length'];
			$CURRENT_I = $validated['current'];
			$SUPPLY_VOLTAGE_V = $validated['voltage'];
			$CABLE_SIZE = $validated['cable_size'];  // decides the Xc, Rc and they decide Zc
			$IMPEDANCE_Zc = 0;
			$COEFFICIENT = 2;

			// --------- find impedance ------------
			if ($PHASE_PHI === '1-phase') {
				$IMPEDANCE_Zc = VoltDropImpedanceTable::IMPEDANCE_Zc($CABLE_SIZE);
			} else if ($PHASE_PHI === '3-phase') {
				$IMPEDANCE_Zc = VoltDropImpedanceTable::IMPEDANCE_Zc($CABLE_SIZE);
				$COEFFICIENT = sqrt(3);
			} else if ($PHASE_PHI === 'dc') {
				$RESISTANCE_Rc = VoltDropImpedanceTable::resistance_Table_35($CABLE_SIZE);

				$IMPEDANCE_Zc = $RESISTANCE_Rc;
				// for DC, there's no Zc. So, we used resistance, Rc as Zc to reuse the formula for VoltageDropValue
			} else {
				return response()->json([
					'status' => 422,
					'message' => 'Wrong "phase type" value',
					'data' => $validated
				]);
			}

			// --------- calculate result ------------
			$VoltageDropValue = round(
				VoltDropCalc::absolute_volt_drop($CURRENT_I, $CABLE_LENGTH_L, $COEFFICIENT, $IMPEDANCE_Zc),
				3
			);

			$VoltageDropPercentage = round(
				VoltDropCalc::volt_drop_percentage($SUPPLY_VOLTAGE_V, $VoltageDropValue),
				2
			);

			$REACTANCE_Xc = VoltDropImpedanceTable::fetch_Xc_Rc($validated['cable_size'], 'xc');	// table-30
			$RESISTANCE_Rc = VoltDropImpedanceTable::fetch_Xc_Rc($validated['cable_size'], 'rc');	//table-35

			$complianceMessage = "Compliant";

			if ($VoltageDropPercentage > 5) {
				$complianceMessage = "Not compliant! Ideal case is 5% or less.";
			}
			// --------- calculate result + Store Database ------------
			$voltDropCreate = VoltDrop::create([
				// 'email' => Auth::user()->email,
				'email' => $validated['email'] ?? 'N/A',
				'phase' => $PHASE_PHI,
				'volt_drop' => $VoltageDropValue . "V",
				'drop_percent' => $VoltageDropPercentage . "%",
				'cable_size' => round((float) $CABLE_SIZE, 4),
				'cable_length' => round((float) $CABLE_LENGTH_L, 4),
				'current' => round((float) $CURRENT_I, 4),
				'voltage' => round((float) $SUPPLY_VOLTAGE_V, 4),
				'react_Xc' => round((float) $REACTANCE_Xc, 4),
				'resis_Rc' => round((float) $RESISTANCE_Rc, 4),
				'imp_Zc' => round((float) $RESISTANCE_Rc, 4),
				'coeff' => $PHASE_PHI === '3-phase' ? "√3" : (string) $COEFFICIENT,
			]);

			// --------- To keep only lastest 10K results from all users ------------
			$totalRecord = VoltDrop::count();
			if ($totalRecord > 10000) {
				$keepIds = VoltDrop::latest()->take(10000)->pluck('id');
				VoltDrop::whereNotIn('id', $keepIds)->delete();
			}

			return response()->json([
				'status' => 200,
				'Voltage Drop' => $VoltageDropValue . 'V',
				'Percentage Drop' => $VoltageDropPercentage . '%',
				'Compliance Status' => $complianceMessage,
				'Input Data' => $voltDropCreate,
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		}
	}


	public function create()
	{
		try {
			// ------our contents starts here--------

			// ------our contents ends here--------

			return response()->json([
				'status' => 200,
				'message' => 'All tags fetched',
				'data' => ''
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

	public function demo_method()
	{
		try {
			// ------our contents starts here--------

			// ------our contents ends here--------

			return response()->json([
				'status' => 200,
				'message' => 'All tags fetched',
				'data' => ''
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

}
