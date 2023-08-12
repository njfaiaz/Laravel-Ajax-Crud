<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
    <link rel='stylesheet'
      href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
    <title>Laravel Ajax Crud</title>
</head>
<body>
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
                <label for="company_name">Company Name</label>
                <input type="text" name="company_name" class="form-control" placeholder="Company Name" required>
            </div>

            <div class="my-2">
                <label for="company_address">Company Address</label>
                <input type="text" name="company_address" class="form-control" placeholder="Company Address" required>
            </div>

            <div class="my-2">
                <label for="company_official_email">E-mail</label>
                <input type="email" name="company_official_email" class="form-control" placeholder="company_official_email" required>
            </div>

            <div class="my-2">
                <label for="company_number">Phone</label>
                <input type="tel" name="company_number" class="form-control" placeholder="Phone" required>
            </div>

            <div class="my-2">
                <label for="company_web_addr">Post</label>
                <input type="text" name="company_web_addr" class="form-control" placeholder="company_web_addr" required>
            </div>

            {{-- <div class="my-2">
                <label for="avatar">Select Avatar</label>
                <input type="file" name="avatar" class="form-control" required>
            </div> --}}
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="add_company_btn" class="btn btn-primary">Add</button>
      </div>
    </form>
  </div>
</div>
</div>
{{-- add new employee modal end --}}


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
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" required>
        </div>

        <div class="my-2">
            <label for="company_address">Company Address</label>
            <input type="text" name="company_address" id="company_address" class="form-control" placeholder="Company Address" required>
        </div>

        <div class="my-2">
            <label for="company_official_email">E-mail</label>
            <input type="email" name="company_official_email" id="company_official_email" class="form-control" placeholder="company_official_email" required>
        </div>

        <div class="my-2">
            <label for="company_number">Phone</label>
            <input type="tel" name="company_number" id="company_number" class="form-control" placeholder="Phone" required>
        </div>

        <div class="my-2">
            <label for="company_web_addr">Post</label>
            <input type="text" name="company_web_addr" id="company_web_addr" class="form-control" placeholder="company_web_addr" required>
        </div>

        {{-- <div class="my-2">
          <label for="avatar">Select Avatar</label>
          <input type="file" name="avatar" class="form-control">
        </div>
        <div class="mt-2" id="avatar">

        </div> --}}
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
          <h3 class="text-light">Manage Company</h3>
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

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Data Store Delete Edit with Image in Ajax -------------------------------------------------- --}}

<script>
    $(function() {

// fetch all employees ajax request ------------------------------------
    fetchAllEmployees();

    function fetchAllEmployees() {
    $.ajax({
        url: '{{ route('fetchAll') }}',
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
          url: '{{ route('edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(res) {
            $("#company_name").val(res.company_name);
            $("#company_address").val(res.company_address);
            $("#company_official_email").val(res.company_official_email);
            $("#company_number").val(res.company_number);
            $("#company_web_addr").val(res.company_web_addr);
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
          url: '{{ route('store') }}',
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
          url: '{{ route('update') }}',
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

      // delete employee ajax request
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
              url: '{{ route('delete') }}',
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
