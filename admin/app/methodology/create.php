<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';
?>

<div class="modal-header">
  <h5 class="modal-title">Add Methodology</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-methodology" action="/admin/app/methodology/store" method="POST" enctype="multipart/form-data">
      <div class="mb-3 col-md-12">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="name" placeholder="Enter the methodology name" required>
      </div>

      <div class="mb-3 col-md-12">
        <label class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpg, image/jpeg, image/svg">
      </div>

      <div class="mb-3 col-md-12">
        <label class="form-label">Short Description <span class="text-danger">*</span></label>
        <textarea class="form-control" name="short_description" rows="5" ></textarea>
      </div>

      <div class="mb-3 col-md-12">
        <label class="form-label">Full Description <span class="text-danger">*</span></label>
        <textarea class="ckeditor" cols="80" id="editor" name="full_description" rows="10" required></textarea>
        <span id="content-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
      </div>

      <div class="modal-footer clearfix text-end">
        <div class="col-md-4 mt-10 sm-mt-10">
          <button type="submit" class="btn btn-primary btn-cons btn-animated from-left">
            <span>Save</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
$(function() {
  $('#form-add-methodology').validate({
    rules: {
      name: { required: true },
      full_description: { required: true }
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

  $("#form-add-methodology").on("submit", function(e) {
    if ($('#form-add-methodology').valid()) {
      var editorContent = CKEDITOR.instances.editor.getData();
      if (editorContent == '') {
        $("#content-error").text("This field is required.");
        return false;
      }
      var formData = new FormData(this);
      formData.append('full_description', editorContent);
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
            $('#methodology-table').DataTable().ajax.reload(null, false);
          } else {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });

  CKEDITOR.replace('editor');
});
</script>

