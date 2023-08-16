@section('title', 'Meeting')
    <div class="container-fluit mt-3">
        @include('nav')
    </div>



    {{-- add new employee modal start --}}
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add New </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="" method="POST" id="add_company_form" enctype="multipart/form-data">
      @csrf
      <div class="modal-body p-4 bg-light">

            <div class="my-2">
                <label for="company_name">Contact Person ID</label>

                <select name="contact_person_id" class="form-select mb-3" aria-label="Default select example">
                    <option selected=""> Select Contact Person ID</option>
                    @foreach ($contact as $item)
                        <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-2">
                <label for="meeting_title">Meeting title</label>
                <input type="text" name="meeting_title" class="form-control" placeholder="Meeting title" required>
            </div>

            <div class="my-2">
                <label for="meeting_purpose">Purpose</label>
                <input type="text" name="meeting_purpose" class="form-control" placeholder="Purpose" required>
            </div>

            <div class="my-2">
                <label for="meeting_discussion">Discussion</label>
                <input type="text" name="meeting_discussion" class="form-control" placeholder="Discussion" required>
            </div>

            <div class="my-2">
                <label for="meeting_result">Result</label>
                <input type="enail" name="meeting_result" class="form-control" placeholder="Result" required>
            </div>

            <div class="my-2">
                <label for="next_meeting">Next meeting date time</label>
                <input type="datetime-local" name="next_meeting" class="form-control" placeholder="Next meeting date time" required>
            </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="add_company_btn" class="btn btn-primary">Add</button>
      </div>
    </form>
  </div>
</div>
</div>


{{-- edit employee modal start --}}
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="#" method="POST" id="edit_company_form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="emp_id" id="emp_id">
      {{-- <input type="hidden" name="emp_avatar" id="emp_avatar"> --}}
      <div class="modal-body p-4 bg-light">
        <div class="my-2">
          <label for="company_name">Contact Person ID</label>

          <select name="contact_person_id" id="contact_person_id" class="form-select mb-3" aria-label="Default select example">
              <option selected=""> Select Contact Person ID</option>
              @foreach ($contact as $item)
                  <option value="{{ $item->id }}">{{ $item->contact_name }}</option>
              @endforeach
          </select>
      </div>

      <div class="my-2">
          <label for="meeting_title">Meeting title</label>
          <input type="text" name="meeting_title" id="meeting_title" class="form-control" placeholder="Meeting title" required>
      </div>

      <div class="my-2">
          <label for="meeting_purpose">Purpose</label>
          <input type="text" name="meeting_purpose" id="meeting_purpose" class="form-control" placeholder="Purpose" required>
      </div>

      <div class="my-2">
          <label for="meeting_discussion">Discussion</label>
          <input type="text" name="meeting_discussion" id="meeting_discussion" class="form-control" placeholder="Discussion" required>
      </div>

      <div class="my-2">
          <label for="meeting_result">Result</label>
          <input type="enail" name="meeting_result" id="meeting_result" class="form-control" placeholder="Result" required>
      </div>

      <div class="my-2">
        <label for="next_meeting">Next meeting date time</label>
        <input type="datetime-local" name="next_meeting" id="next_meeting" class="form-control" placeholder="Next meeting date time" required>
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="edit_company_btn" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>
</div>
{{-- edit employee modal end --}}



<div class="container">
  <div class="row my-5">
    <div class="col-lg-12">
      <div class="card shadow">
        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
          <h3 class="text-light">Manage Meeting</h3>
          <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addCompanyModal"><i
              class="bi-plus-circle me-2"></i>Add New </button>
        </div>
        <div class="card-body" id="show_all_companys">
          <h1 class="text-center text-secondary my-5">Loading...</h1>
        </div>
      </div>
    </div>
  </div>
</div>

@include('js')



<script>
    $(function() {

// fetch all employees ajax request ------------------------------------
    fetchAllEmployees();

    function fetchAllEmployees() {
    $.ajax({
        url: '{{ route('meeting.fetchAll') }}',
        method: 'get',
        success: function(response) {
        $("#show_all_companys").html(response);
        $("table").DataTable({
            order: [0, 'desc']
        });
        }
    });
    }

// edit employee ajax request ----------------------------------------------
    $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('meeting.edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(res) {
            $("#contact_person_id").val(res.contact_person_id);
            $("#meeting_title").val(res.meeting_title);
            $("#meeting_purpose").val(res.meeting_purpose);
            $("#meeting_discussion").val(res.meeting_discussion);
            $("#meeting_result").val(res.meeting_result);
            $("#next_meeting").val(res.next_meeting);
            $("#emp_id").val(res.id);
          }
        });
      });


// add new employee ajax request-------------------------------------------------
      $("#add_company_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_company_btn").text('Adding...');
        $.ajax({
          url: '{{ route('meeting.store') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Company Added Successfully!',
                'success'
              )
              fetchAllEmployees();
            }
            $("#add_company_btn").text('Add Company');
            $("#add_company_form")[0].reset();
            $("#addCompanyModal").modal('hide');
          }
        });
      });



// update employee ajax request ------------------------------------------
      $("#edit_company_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_company_btn").text('Updating...');
        $.ajax({
          url: '{{ route('meeting.update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Company Updated Successfully!',
                'success'
              )
              fetchAllEmployees();
            }
            $("#edit_company_btn").text('Update Company');
            $("#edit_company_form")[0].reset();
            $("#editCompanyModal").modal('hide');
          }
        });
      });

// delete employee ajax request ------------------------------------------------------
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('meeting.delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllEmployees();
              }
            });
          }
        })
      });
    });
  </script>

</body>
</html>
