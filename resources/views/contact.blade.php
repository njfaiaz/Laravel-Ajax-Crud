@section('title', 'Contact')
    <div class="container-fluit mt-3">
        @include('nav')
    </div>


{{-- add new contact modal start --}}

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
                <label for="company_name">Company Name</label>

                <select name="company_id" class="form-select mb-3" aria-label="Default select example">
                    <option selected=""> select Company Id</option>
                    @foreach ($company as $item)
                        <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-2">
                <label for="contact_name">Contact Name</label>
                <input type="text" name="contact_name" class="form-control" placeholder="Contact Name" required>
            </div>

            <div class="my-2">
                <label for="contact_designation">Contact Designation</label>
                <input type="text" name="contact_designation" class="form-control" placeholder="Contact Designation" required>
            </div>

            <div class="my-2">
                <label for="contact_number">Phone</label>
                <input type="text" name="contact_number" class="form-control" placeholder="Phone" required>
            </div>

            <div class="my-2">
                <label for="company_web_addr">Contact E-mail</label>
                <input type="enail" name="contact_email" class="form-control" placeholder="Contact E-mail" required>
            </div>

            <div class="my-2">
                <label for="contact_whatsapp">Contact Whatsapp</label>
                <input type="text" name="contact_whatsapp" class="form-control" placeholder="Contact Whatsapp" required>
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
{{-- add new contact modal end --}}


{{-- edit contact modal start --}}
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
      <select name="company_id" id="company_id_dropdown" class="form-select mb-3" aria-label="Default select example">
          <option selected=""> select Company Id</option>
          @foreach ($company as $item)
              <option value="{{ $item->id }}">{{ $item->company_name }}</option>
          @endforeach
      </select>

        <div class="my-2">
            <label for="contact_name">Contact Name</label>
            <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Contact Name" required>
        </div>

        <div class="my-2">
            <label for="contact_designation">Contact Designation</label>
            <input type="text" name="contact_designation" id="contact_designation" class="form-control" placeholder="Contact Designation" required>
        </div>

        <div class="my-2">
            <label for="contact_number">Phone</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Phone" required>
        </div>

        <div class="my-2">
            <label for="company_web_addr">Contact E-mail</label>
            <input type="enail" name="contact_email" id="contact_email" class="form-control" placeholder="Contact E-mail" required>
        </div>

        <div class="my-2">
            <label for="contact_whatsapp">Contact Whatsapp</label>
            <input type="text" name="contact_whatsapp" id="contact_whatsapp" class="form-control" placeholder="Contact Whatsapp" required>
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



{{-- edit contact modal end --}}
<div class="container">
  <div class="row my-5">
    <div class="col-lg-12">
      <div class="card shadow">
        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
          <h3 class="text-light">Manage Contacts</h3>
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



<script type="text/javascript">
$(function() {

// fetch all contacts ajax request ------------------------------------
    fetchAllEmployees();

  function fetchAllEmployees() {
    $.ajax({
        url: '{{ route('contact.fetchAll') }}',
        method: 'get',
        success: function(response) {
        $("#show_all_companys").html(response);
        $("table").DataTable({
            order: [0, 'desc']
        });
        }
    });
  }

// edit contact ajax request ----------------------------------------------
    $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('contact.edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(res) {
            console.log(res);
            $("#company_id_dropdown").val(res.company_id);
            $("#contact_name").val(res.contact_name);
            $("#contact_designation").val(res.contact_designation);
            $("#contact_number").val(res.contact_number);
            $("#contact_email").val(res.contact_email);
            $("#contact_whatsapp").val(res.contact_whatsapp);
            $("#emp_id").val(res.id);
          }
        });
      });


// add new contact ajax request-------------------------------------------------
      $("#add_company_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_company_btn").text('Adding...');
        $.ajax({
          url: '{{ route('contact.store') }}',
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



// update contact ajax request ------------------------------------------
      $("#edit_company_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_company_btn").text('Updating...');
        $.ajax({
          url: '{{ route('contact.update') }}',
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

// delete contact ajax request --------------------------------------------
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
              url: '{{ route('contact.delete') }}',
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
