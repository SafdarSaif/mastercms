<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>
<div class="modal-header">
  <h5 class="modal-title">Add Subject</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal">
  </button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-subjects" action="/admin/app/subjects/store" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="mb-3 col-md-6">
          <label class="form-label">Sector<span class="text-danger">*</span></label>
          <select name="sector_id" id="sector_id" class="form-control sumoselect" required onchange="getProgramFunc(this.value)">
            <?php $programArr = getStreamFunc($conn); ?>
            <option value="">Select Sector</option>
            <?php foreach ($programArr as $program) {  ?>
              <option value="<?= $program['ID'] ?>"><?= $program['Name'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Program<span class="text-danger">*</span></label>
          <select name="program" id="program_id" class="form-control sumoselect" required>
          <option value="">Select Program </option>

          </select>
        </div>
        <div class="mb-3 col-md-6 d-none">
          <label class="form-label">Specialization<span class="text-danger">*</span></label>
          <?php $programArr = getSpecializationFunc($conn); ?>
          <select name="sub_course" id="sub_course" class="form-control" required>
            <option value="">Select Specialization</option>
            <?php foreach ($programArr as $program) {  ?>
              <option value="<?= $program['ID'] ?>"><?= $program['Name'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Name
            <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" placeholder="Enter a Subject Name.." required>
        </div>
        <div class="mb-3 col-md-12">
          <label class="form-check-label" for="check1">Subject Mode<span class="text-danger">*</span></label>
        </div>
        <div class="row">
          <div class="mb-3 col-md-3">
            <div class="form-check mb-2">
              <input type="checkbox" class="form-check-input" id="check1" name="practical_mode" value="Practical" onchange="show_marks1()">
              <label class="form-check-label" for="check1">Practical</label>
            </div>
          </div>
          <div class="mb-3 col-md-4 practical_marks">
            <label class="form-label">Practical Marks
              <span class="text-danger">*</span></label>
            <input type="number" minimum="0" class="form-control " name="practical_marks" placeholder="Enter Practical Marks..">
          </div>
          <div class="mb-3 col-md-5 practical_passing_marks">
            <label class="form-label">Practical Passing Marks
              <span class="text-danger">*</span></label>
            <input type="number" minimum="0" class="form-control " name="practical_passing_marks" placeholder="Enter Practical Passing Marks..">
          </div>
        </div>

        <div class="row">
          <div class="mb-3 col-md-3">
            <div class="form-check mb-4">
              <input type="checkbox" class="form-check-input" id="check2" name="theory_mode" value="Theory" onchange="show_marks2()">
              <label class="form-check-label" for="check2">Theory</label>
            </div>
          </div>
          <div class="mb-3 col-md-4 theory_marks">
            <label class="form-label">Theory Marks
              <span class="text-danger">*</span></label>
            <input type="number" minimum="0" class="form-control " name="theory_marks" placeholder="Enter Theory Marks..">
          </div>
          <div class="mb-3 col-md-5 theory_passing_marks">
            <label class="form-label">Theory Passing Marks
              <span class="text-danger">*</span></label>
            <input type="number" minimum="0" class="form-control " name="theory_passing_marks" placeholder="Enter Theory Passing Marks..">
          </div>
        </div>
      </div>

      <div class=" modal-footer clearfix text-end">
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
    $('.sumoselect').SumoSelect({
        search: true,
        searchText: 'Enter here.'
    });
});
function getProgramFunc(sector_id) {
  $.ajax({
    type: "GET",
    url: '/admin/app/subjects/getProgram?sector_id=' + sector_id,
    success: function(data) {
      $("#program_id").html(data);
      $('#program_id')[0].sumo.reload();
    }
  });
}



  $(document).ready(function() {
    $('.practical_marks').hide();
    $('.theory_marks').hide();
    $(".practical_passing_marks").hide();
    $(".theory_passing_marks").hide();
  });

  function show_marks1() {
    if ($('#check1').is(":checked")) {
      $('.practical_marks').show();
      $(".practical_passing_marks").show();
    } else {
      $('.practical_marks').hide();
      $(".practical_passing_marks").hide();
    }
  }

  function show_marks2() {
    if ($('#check2').is(":checked")) {
      $('.theory_marks').show();
      $(".theory_passing_marks").show();
    } else {
      $('.theory_marks').hide();
      $(".theory_passing_marks").hide();
    }
  }


  $(function() {
    $('#form-add-subjects').validate({
      rules: {
        name: {
          required: true
        },
        university_id: {
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
      }
    });
  })

  $("#form-add-subjects").on("submit", function(e) {
    if ($('#form-add-subjects').valid()) {
      $(':input[type="submit"]').prop('disabled', true);
      var formData = new FormData(this);
      $.ajax({
        url: this.action,
        type: 'post',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data) {
          if (data.status == 200) {
            $('.modal').modal('hide');
            toastr.success(data.message, 'Success');

            $('#subjects-table').DataTable().ajax.reload(null, false);
          } else {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });
</script>