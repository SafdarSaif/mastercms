<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    $id = intval($_GET['id']);
    $getdataQuery = $conn->query("SELECT * FROM courses WHERE ID = $id");
    $getdata = $getdataQuery->fetch_assoc();
    
    $programArr = [];
    if ($getdata['Department_ID']) {
        $programQuery = $conn->query("SELECT * FROM programs WHERE Department_ID = " . $getdata['Department_ID']);
        while ($program = $programQuery->fetch_assoc()) {
            $programArr[] = $program;
        }
    }
}
?>

<div class="modal-header">
  <h5 class="modal-title">Edit courses</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-courses" action="/admin/app/courses/update" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $getdata['ID'] ?>">

      <div class="row">
        <div class="mb-3 col-md-12">
          <label class="form-label">Department<span class="text-danger">*</span></label>
          <?php $departmentArr = getDepartmentFunc($conn); ?>
          <select name="Department_ID" id="Department_ID" class="form-control sumoselect" required>
            <option value="">Select Department</option>
            <?php foreach ($departmentArr as $department) { ?>
              <option value="<?= $department['ID'] ?>" <?= $getdata['Department_ID'] == $department['ID'] ? 'selected' : '' ?>><?= $department['Name'] ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Program<span class="text-danger">*</span></label>
          <select name="Program_ID" id="Program_ID" class="form-control sumoselect" required>
            <option value="">Select Department First</option>
            <?php foreach ($programArr as $program) { ?>
              <option value="<?= $program['ID'] ?>" <?= $getdata['Program_ID'] == $program['ID'] ? 'selected' : '' ?>><?= $program['Name'] ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" value="<?= $getdata['Name'] ?>" placeholder="Enter a courses Name.." required>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Short Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="Short_Name" value="<?= $getdata['Short_Name'] ?>" placeholder="Enter a Short Name.." required>
        </div>

        <!-- <div class="mb-3 col-md-12">
          <label class="form-label">Content <span class="text-danger">*</span></label>
          <textarea class="ckeditor" cols="80" id="editor_content" name="content" rows="10"><?= $getdata['Content'] ?></textarea>
        </div> -->

        <div class="mb-3 col-md-12">
          <label class="form-label">Order By <span class="text-danger">*</span></label>
          <input type="number" min="0" class="form-control" name="position" value="<?= $getdata['Position'] ?>" placeholder="Enter a Position.." required>
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

<!-- <script>
  $(document).ready(function() {
    function get_programs(departmentID) {
      if (departmentID) {
        $.ajax({
          type: 'POST',
          url: '/admin/app/courses/get_program',
          data: { department_id: departmentID },
          success: function(html) {
            $('#Program_ID').html(html);
            $('#Program_ID').val("<?= $getdata['Program_ID'] ?>").trigger('change');
          }
        });
      } else {
        $('#Program_ID').html('<option value="">Select Department First</option>');
      }
    }

    $('#Department_ID').change(function() {
      var departmentID = $(this).val();
      get_programs(departmentID);
    });

    $('.ckeditor').each(function() {
      CKEDITOR.replace($(this).attr('id'));
    });

    $('#form-add-courses').validate({
      rules: {
        name: {
          required: true
        },
        Short_Name: {
          required: true
        },
        content: {
          required: true
        },
        position: {
          required: true,
          number: true,
          min: 0
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
        
        for (var instance in CKEDITOR.instances) {
          formData.append(instance, CKEDITOR.instances[instance].getData());
        }

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
              $('#courses-table').DataTable().ajax.reload(null, false);
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

    get_programs($('#Department_ID').val());
  });
</script> -->

<script>
  $(document).ready(function() {
    $('#Department_ID').change(function() {
      var departmentID = $(this).val();
      if (departmentID) {
        $.ajax({
          type: 'POST',
          url: '/admin/app/courses/get_program',
          data: 'department_id=' + departmentID,
          success: function(html) {
            $('#Program_ID').html(html);
          }
        });
      } else {
        $('#Program_ID').html('<option value="">Select Department First</option>');
      }
    });

    $('#form-add-courses').validate({
      rules: {
        name: {
          required: true
        },
        Short_Name: {
          required: true
        },
        content: {
          required: true
        },
        position: {
          required: true,
          number: true,
          min: 0
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
              $('#courses-table').DataTable().ajax.reload(null, false);
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