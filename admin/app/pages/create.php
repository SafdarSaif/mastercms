<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>

<div class="modal-header">
  <h3 class="modal-title">Add pages</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal">
  </button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-pages" action="/admin/app/pages/store" method="POST" enctype="multipart/form-data">
      <div class="row">



        <div class="mb-3 col-md-12">
          <label class="form-label">Name
            <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" placeholder="Enter a Pages Name.." required>
        </div>

        <div class="mb-3 col-md-12 syllabus_file">
          <label class="form-label">Photo </label>
          <input type="file" name="photo" id="photo" class="form-control" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif">
        </div>

        <!-- <div class="mb-3 col-md-12">
          <label class="form-label">Short Description<span class="text-danger">*</span></label>
          <textarea cols="2" class="form-control" name="description" placeholder="Enter a Short Description.." required></textarea>
        </div> -->

        <div class="mb-3 col-md-12 ">
          <label class="form-label">Content <span class="text-danger">*</span></label>
          <textarea class="ckeditor" cols="80" id="editor" name="editor" rows="10" required></textarea>
          <span id="content-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
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

      </div>
      <div class=" modal-footer clearfix text-end">
        <div class="col-md-4 m-t-10 sm-m-t-10">
          <button aria-label="" type="submit" class="btn btn-primary btn-cons btn-animated from-left">
            <span>Save</span>
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

        </div>
      </div>
  </div>
  </form>
</div>
</div>



<!-- <script>
  $(function() {
    $('#form-add-departments').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  });

  $("#form-add-departments").on("submit", function(e) {
    if ($('#form-add-departments').valid()) {
      // $(':input[type="submit"]').prop('disabled', true);

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
            $('#departments-table').DataTable().ajax.reload(null, false);
          } else {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });
</script> -->

<script>
  $(function() {
    $('#form-add-pages').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-pages").on("submit", function(e) {
    if ($('#form-add-pages').valid()) {
      // $(':input[type="submit"]').prop('disabled', true);

      var editorContent = CKEDITOR.instances.editor.getData();
      if (editorContent == '') {
        $("#content-error").text("This field is required.");
        return false;
      }
      var formData = new FormData(this);
      formData.append('content', editorContent);

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

            $('#pages-table').DataTable().ajax.reload(null, false);
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

<script>
  CKEDITOR.replace('editor');
</script>