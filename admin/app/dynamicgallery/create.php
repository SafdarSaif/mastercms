<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>

<div class="modal-header">
  <h3 class="modal-title">Add Gallery</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-gallery" action="/admin/app/dynamicgallery/store" method="POST" enctype="multipart/form-data">
      <div class="row">
        <!-- <div class="col-md-12">
          <div class="form-group mb-3">
            <label class="form-label">Video Link</label>
            <div id="add_new_video_link">
              <div class="input-group mb-3">
                <input class="form-control video-link" placeholder="Video Link" name="video_links[]" required>
                <button type="button" class="btn btn-danger remove-video-link">Remove</button>
              </div>
            </div>
            <button type="button" class="btn btn-primary add-video-link">Add Video Link</button>
          </div>
        </div> -->

        <div class="mb-3 col-md-12">
          <label class="form-label">Name
            <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="image_names" placeholder="Enter a Image Name.." required>
        </div>
        <div class="mb-3 col-md-12 syllabus_file">
          <label class="form-label">Photo </label>
          <input type="file" name="images" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif">
        </div>
   

        <div class="modal-footer clearfix text-end">
          <div class="col-md-4 m-t-10 sm-m-t-10">
            <button aria-label="" type="submit" class="btn btn-primary btn-cons btn-animated from-left">
              <span>Save</span>
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('#form-add-gallery').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    $("#form-add-gallery").on("submit", function(e) {
      if ($('#form-add-gallery').valid()) {
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
              $('#gallery-table').DataTable().ajax.reload(null, false);
            } else {
              $(':input[type="submit"]').prop('disabled', false);
              toastr.error(data.message, 'Error');
            }
          }
        });
        e.preventDefault();
      }
    });
  });
</script>
<script>
  function fileValidation(id) {
    var fi = document.getElementById(id);
    if (fi.files.length > 0) {
      for (var i = 0; i <= fi.files.length - 1; i++) {
        var fsize = fi.files.item(i).size;
        var file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 500) {
          $('#' + id).val('');
          // alert("File too Big, each file should be less than or equal to 500KB");
          toastr.error("File too Big, each file should be less than or equal to 500KB");
        }
      }
    }
  }
</script>
