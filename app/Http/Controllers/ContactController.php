<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function ContactIndex(){
        $company = Company::latest()->get();
        return view('contact',compact('company'));
    } // End Method

    // handle insert a new Contact ajax request ----------------------------------------------------------
	public function ContactStore(Request $request) {
		$empData = [
            'company_id' => $request->company_id,
            'contact_name' => $request->contact_name,
            'contact_designation' => $request->contact_designation,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email,
            'contact_whatsapp' => $request->contact_whatsapp
        ];

		Contact::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}// End Method


// handle fetch all Company ajax request-------------------------------------------
	public function ContactFetchAll() {
		$comps = Contact::all();
		$output = '';
		if ($comps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Company Name</th>
                <th>Contact Name</th>
                <th>Contact Designation</th>
                <th>Contact Number</th>
                <th>Contact Email</th>
                <th>Contact Whatsapp</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($comps as $emp) {
				$output .= '<tr>
                <td>' . $emp->id . '</td>
                <td>' . $emp->company->company_name . '</td>
                <td>' . $emp->contact_name . '</td>
                <td>' . $emp->contact_designation . '</td>
                <td>' . $emp->contact_number . '</td>
                <td>' . $emp->contact_email . '</td>
                <td>' . $emp->contact_whatsapp . '</td>
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
	} // End Method



	// handle edit an Contact ajax request ---------------------------------------------------
	public function ContactEdit(Request $request) {
		$id = $request->id;
		$emp = Contact::find($id)->toArray();
		return response()->json($emp);
	} // End Method


	// handle update an Contact ajax request -------------------------------------------------
	public function ContactUpdate(Request $request) {
		$emp = Contact::find($request->emp_id);
		$empData = [
            'company_id' => $request->company_id,
            'contact_name' => $request->contact_name,
            'contact_designation' => $request->contact_designation,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email,
            'contact_whatsapp' => $request->contact_whatsapp
        ];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	} // End Method

	// handle delete an Contact ajax request -----------------------------------------------------------
	public function ContactDelete(Request $request) {
		$id = $request->id;
        Contact::destroy($id);
	} // End Method


}
