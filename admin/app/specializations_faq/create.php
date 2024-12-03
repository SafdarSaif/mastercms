<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';
?>

<div class="modal-header">
  <h5 class="modal-title">Add specializations_faq</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-specializations_faq" action="/admin/app/specializations_faq/store" method="POST" enctype="multipart/form-data">
      <div class="row">

        <div class="mb-3 col-md-6">
          <label class="form-label">Department<span class="text-danger">*</span></label>
          <?php $departmentArr = getDepartmentFunc($conn); ?>
          <select name="Department_ID" id="Department_ID" class="form-control sumoselect" required>
            <option value="">Select Department</option>
            <?php foreach ($departmentArr as $department) { ?>
              <option value="<?= $department['ID'] ?>"><?= $department['Name'] ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Program<span class="text-danger">*</span></label>
          <select name="Program_ID" id="Program_ID" class="form-control sumoselect" required>
            <option value="">Select Department First</option>
          </select>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Course<span class="text-danger">*</span></label>
          <select name="Course_ID" id="Course_ID" class="form-control sumoselect" required>
            <option value="">Select Program First</option>
          </select>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Specialization Name<span class="text-danger">*</span></label>
          <select name="Specialization_ID" id="Specialization_ID" class="form-control sumoselect" required>
            <option value="">Select Course First</option>
          </select>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Question <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="question" placeholder="Enter a Question.." required>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Answer <span class="text-danger">*</span></label>
          <textarea class="ckeditor" cols="80" id="editor" name="answer" rows="10" required></textarea>
          <span id="content-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
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
    $('#Department_ID').change(function() {
      var departmentID = $(this).val();
      if (departmentID) {
        $.ajax({
          type: 'POST',
          url: '/admin/app/specializations_faq/get_program',
          data: { department_id: departmentID },
          success: function(html) {
            $('#Program_ID').html(html);
            $('#Course_ID').html('<option value="">Select Program First</option>');
            $('#Specialization_ID').html('<option value="">Select Course First</option>');
          }
        });
      } else {
        $('#Program_ID').html('<option value="">Select Department First</option>');
        $('#Course_ID').html('<option value="">Select Program First</option>');
        $('#Specialization_ID').html('<option value="">Select Course First</option>');
      }
    });

    $('#Program_ID').change(function() {
      var programID = $(this).val();
      if (programID) {
        $.ajax({
          type: 'POST',
          url: '/admin/app/specializations_faq/get_course',
          data: { program_id: programID },
          success: function(html) {
            $('#Course_ID').html(html);
            $('#Specialization_ID').html('<option value="">Select Course First</option>');
          }
        });
      } else {
        $('#Course_ID').html('<option value="">Select Program First</option>');
        $('#Specialization_ID').html('<option value="">Select Course First</option>');
      }
    });

    $('#Course_ID').change(function() {
      var courseID = $(this).val();
      if (courseID) {
        $.ajax({
          type: 'POST',
          url: '/admin/app/specializations_faq/get_specialization',
          data: { course_id: courseID },
          success: function(html) {
            $('#Specialization_ID').html(html);
          }
        });
      } else {
        $('#Specialization_ID').html('<option value="">Select Course First</option>');
      }
    });

    $('.ckeditor').each(function() {
      CKEDITOR.replace($(this).attr('id'));
    });

    $('#form-add-specializations_faq').validate({
      rules: {
        question: {
          required: true
        },
        answer: {
          required: true
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
        formData.append('answer', CKEDITOR.instances['editor'].getData());

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
              $('#specializations_faq-table').DataTable().ajax.reload(null, false);
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
