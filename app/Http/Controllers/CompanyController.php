<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function CompanyIndex(){
        return view('home');
    } //End Method

// handle insert a new Company ajax request ----------------------------------------------------------
	public function CompanyStore(Request $request) {

		$empData = [
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_official_email' => $request->company_official_email,
            'company_number' => $request->company_number,
            'company_web_addr' => $request->company_web_addr
        ];

		Company::create($empData);
		return response()->json([
			'status' => 200,
		]);
	} //End Method


// handle fetch all Company ajax request-------------------------------------------
	public function CompanyFetchAll() {
		$comps = Company::all();
		$output = '';
		if ($comps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Company Name</th>
                <th>Company Address</th>
                <th>E-mail</th>
                <th>Number</th>
                <th>Web Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($comps as $emp) {
				$output .= '<tr>
                <td>' . $emp->id . '</td>
                <td>' . $emp->company_name . '</td>
                <td>' . $emp->company_address . '</td>
                <td>' . $emp->company_official_email . '</td>
                <td>' . $emp->company_number . '</td>
                <td>' . $emp->company_web_addr . '</td>
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editCompanyModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	} //End Method


	// handle edit an Company ajax request ------------------------------------------------
	public function CompanyEdit(Request $request) {
		$id = $request->id;
		$emp = Company::find($id);
		return response()->json($emp);
	} //End Method

	// handle update an Company ajax request -------------------------------------------------
	public function CompanyUpdate(Request $request) {
		$emp = Company::find($request->emp_id);
		$empData = [
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_official_email' => $request->company_official_email,
            'company_number' => $request->company_number,
            'company_web_addr' => $request->company_web_addr
        ];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	} //End Method

	// handle delete an Company ajax request ---------------------------------------
	public function CompanyDelete(Request $request) {
		$id = $request->id;
        Company::destroy($id);
	} //End Method
}
