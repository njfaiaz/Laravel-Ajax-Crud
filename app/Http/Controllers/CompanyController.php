<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(){
        return view('home');
    }

// handle insert a new employee ajax request ----------------------------------------------------------
	public function store(Request $request) {

		// $file = $request->file('avatar');
		// $fileName = time() . '.' . $file->getClientOriginalExtension();
		// $file->storeAs('public/images', $fileName);

		$empData = ['company_name' => $request->company_name, 'company_address' => $request->company_address, 'company_official_email' => $request->company_official_email, 'company_number' => $request->company_number, 'company_web_addr' => $request->company_web_addr]; // 'avatar' => $fileName
		Company::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}


// handle fetch all Company ajax request-------------------------------------------
	public function fetchAll() {
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
	}

    // <td><img src="storage/images/' . $emp->avatar . '" width="50" class="img-thumbnail rounded-circle"></td>


	// handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Company::find($id);
		return response()->json($emp);
	}

	// handle update an employee ajax request
	public function update(Request $request) {
		// $fileName = '';
		$emp = Company::find($request->emp_id);
		// if ($request->hasFile('avatar')) {
		// 	$file = $request->file('avatar');
		// 	$fileName = time() . '.' . $file->getClientOriginalExtension();
		// 	$file->storeAs('public/images', $fileName);
		// 	if ($emp->avatar) {
		// 		Storage::delete('public/images/' . $emp->avatar);
		// 	}
		// } else {
		// 	$fileName = $request->emp_avatar;
		// }

		$empData = ['company_name' => $request->company_name, 'company_address' => $request->company_address, 'company_official_email' => $request->company_official_email, 'company_number' => $request->company_number, 'company_web_addr' => $request->company_web_addr]; //'avatar' => $fileName

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete an employee ajax request
	public function delete(Request $request) {
		$id = $request->id;
        Company::destroy($id);
		// if (Storage::delete('public/images/' . $emp->avatar)) {
		// 	Company::destroy($id);
		// }
	}
}
