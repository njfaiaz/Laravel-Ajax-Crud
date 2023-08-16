<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function MeetingIndex(){
        $contact = Contact::latest()->get();
        return view('meeting',compact('contact'));
    } // End Method

    // handle insert a new Meeting ajax request ----------------------------------------------------------
	public function MeetingStore(Request $request) {
		$empData = [
			'contact_person_id' => $request->contact_person_id,
			'meeting_title' => $request->meeting_title,
			'meeting_purpose' => $request->meeting_purpose,
			'meeting_discussion' => $request->meeting_discussion,
			'meeting_result' => $request->meeting_result,
			'next_meeting' => $request->next_meeting
		];
		Meeting::create($empData);
		return response()->json([
			'status' => 200,
		]);
	} // End Method


// handle fetch all Meeting ajax request-------------------------------------------
	public function MeetingFetchAll() {
		$comps = Meeting::all();
		$output = '';
		if ($comps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Contact Person Name</th>
                <th>Meeting title</th>
                <th>Purpose</th>
                <th>Discussion</th>
                <th>Result</th>
                <th>Next meeting date time</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="tbody">';
			foreach ($comps as $emp) {
				$output .= '<tr>
                <td>' . $emp->id . '</td>
                <td>' . $emp->contact->contact_name . '</td>
                <td>' . $emp->meeting_title . '</td>
                <td>' . $emp->meeting_purpose . '</td>
                <td>' . $emp->meeting_discussion . '</td>
                <td>' . $emp->meeting_result . '</td>
                <td>' . $emp->next_meeting . '</td>
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



	// handle edit an Meeting ajax request ------------------------------------------------------
	public function MeetingEdit(Request $request) {
		$id = $request->id;
		$meeting = Meeting::find($id)->toArray();
		return response()->json($meeting);
	}


	// handle update an Meeting ajax request --------------------------------------------------
	public function MeetingUpdate(Request $request) {
		$emp = Meeting::find($request->emp_id);
		$empData = ['contact_person_id' => $request->contact_person_id, 'meeting_title' => $request->meeting_title, 'meeting_purpose' => $request->meeting_purpose, 'meeting_discussion' => $request->meeting_discussion, 'meeting_result' => $request->meeting_result, 'next_meeting' => $request->next_meeting];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	} // End Method

	// handle delete an Meeting ajax request -------------------------------------------------
	public function MeetingDelete(Request $request) {
		$id = $request->id;
        Meeting::destroy($id);
	} // End Method

	// handle Search an Meeting ajax request -------------------------------------------------

    public function MeetingSearch(Request $request){
        $query = Meeting::query();
        if ($request->ajax()) {
            $users = $query->where('meeting_title','LIKE','%'.$request->search.'%')
            ->orWhere('meeting_title', 'LIKE', '%'.$request->search.'%')
            ->orWhere('next_meeting', 'LIKE', '%'.$request->search.'%')
            ->get();
            return response()->json(['users'=>$users]);
        }
        else{
            $users =  $query->get();
            return view('meeting',compact('users'));
        }
    }

}
