<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>

<div class="modal-header">
  <h5 class="modal-title">Add Program</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-stream" action="/admin/app/streams/store" method="POST" enctype="multipart/form-data">
      <div class="row">


        <div class="mb-3 col-md-6">
          <label class="form-label">Category<span class="text-danger">*</span></label>
          <?php $categoryArr = getcategoryFunc($conn); ?>
          <select name="category_id" id="category_id" class="form-control sumoselect" required>
            <option value="">Select category</option>
            <?php foreach ($categoryArr as $category) {  ?>
              <option value="<?= $category['ID'] ?>"><?= $category['Name'] ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Department<span class="text-danger">*</span></label>
          <select name="Department_ID" id="Department_ID" class="form-control sumoselect" required>
            <option value="">Select Department</option>
          </select>
        </div>
        <!-- <div class="mb-3 col-md-6">
          <label class="form-label">Department<span class="text-danger">*</span></label>
          <?php $departmentArr = getDepartmentFunc($conn); ?>
          <select name="Department_ID" id="Department_ID" class="form-control sumoselect" required>
            <option value="">Select Department</option>
            <?php foreach ($departmentArr as $department) { ?>
              <option value="<?= $department['ID'] ?>"><?= $department['Name'] ?></option>
            <?php } ?>
          </select>
        </div> -->

        <div class="mb-3 col-md-6">
          <label class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" placeholder="Enter a Program Name.." required>
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Short Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="Short_Name" placeholder="Enter a Short Name.." required>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Eligibility : <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="eligibility" placeholder="Enter a Eligibility .." required>
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Mode : <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="mode" placeholder="Enter a Mode ..">
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Duration : <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="duration" placeholder="Enter a Duration .." required>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Degree : <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="degree" placeholder="Enter a Degree ..">
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Photo <span class="text-danger">*</span></label>
          <input type="file" class="form-control" name="photo" required>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Short Description <span class="text-danger">*</span></label>
          <textarea class="form-control" cols="5" id="short_description" name="short_description" rows="5"></textarea>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Content <span class="text-danger">*</span></label>
          <textarea class="ckeditor" cols="80" id="editor" name="content" rows="10"></textarea>
        </div>




        <div class="mb-3 col-md-6">
          <label class="form-label">Meta Title
          </label>
          <input type="text" class="form-control" name="meta_title" placeholder="Enter a Meta Title..">
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Meta Key
          </label>
          <input type="text" class="form-control" name="meta_key" placeholder="Enter a Meta Key..">
        </div>
        <div class="mb-3 col-md-12">
          <label class="form-label">Meta Description</label>
          <textarea cols="2" class="form-control" name="meta_description" placeholder="Enter a Meta Description.."></textarea>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Order By <span class="text-danger">*</span></label>
          <input type="number" min="0" class="form-control" name="position" placeholder="Enter a Position.." required>
        </div>




      </div>
      <div class="modal-footer clearfix text-end">
        <div class="col-md-4 m-t-10 sm-m-t-10">
          <button aria-label="" type="submit" class="btn btn-primary btn-cons btn-animated from-left">
            <span>Save</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#category_id').change(function() {
      var categoryID = $(this).val();

      // Reset Department Dropdown
      $('#Department_ID').html('<option value="">Select Department</option>');

      if (categoryID) {
        $.ajax({
          url: '/admin/app/streams/get_department',
          type: 'POST',
          data: {
            category_id: categoryID
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              $.each(response.departments, function(key, department) {
                $('#Department_ID').append(
                  `<option value="${department.ID}">${department.Name}</option>`
                );
              });
            } else {
              toastr.error(response.message, 'Error');
            }
          },
          error: function(xhr, textStatus, errorThrown) {
            toastr.error('Error fetching departments: ' + errorThrown, 'Error');
          },
        });
      }
    });
  });
</script>


<script>
  $(document).ready(function() {
    $('#form-add-stream').validate({
      rules: {
        name: {
          required: true
        },
        Short_Name: {
          required: true
        },
        position: {
          required: true,
          number: true,
          min: 0
        }
      },
      messages: {
        position: {
          required: "Please enter the position.",
          number: "Please enter a valid number for the position.",
          min: "Position must be at least 0."
        }
      },
      highlight: function(element) {
        $(element).addClass('error');
        $(element).closest('.form-control').addClass('has-error');
      },
      unhighlight: function(element) {
        $(element).removeClass('error');
        $(element).closest('.form-control').removeClass('has-error');
      },
      submitHandler: function(form) {
        var formData = new FormData(form);
        formData.append('content', CKEDITOR.instances['editor'].getData());


        $.ajax({
          url: form.action,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(data) {
            if (data.status == 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#streams-table').DataTable().ajax.reload(null, false);
            } else {
              $(':input[type="submit"]').prop('disabled', false);
              toastr.error(data.message, 'Error');
            }
          },
          error: function(xhr, textStatus, errorThrown) {
            toastr.error('Error submitting form: ' + errorThrown, 'Error');
          }
        });
        return false;
      }
    });
  });
</script>

<script>
  $('.ckeditor').each(function() {
    CKEDITOR.replace($(this).attr('id'));
  });
</script>