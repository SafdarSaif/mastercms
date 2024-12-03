<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $testimonial = $conn->query("SELECT * FROM testimonials WHERE ID = $id");
  $testimonial = $testimonial->fetch_assoc();
}
?>

<div class="modal-header">
  <h3 class="modal-title">Edit Testimonial (<a href="/testimonials?url=<?= $testimonial['ID'] ?>" style="color: #222B40;"><?= $testimonial['Name'] ?></a>)</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-edit-testimonial" action="/admin/app/testimonials/update" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $testimonial['ID'] ?>">
      <div class="row">
        <div class="mb-3 col-md-6">
          <label class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?= $testimonial['Name'] ?>" name="name" placeholder="Enter Name" required>
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Profile <span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?= $testimonial['Profile'] ?>" name="profile" placeholder="Enter Profile" required>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Image</label>
          <input type="hidden" name="updated_image" value="<?= $testimonial['Image'] ?>">
          <input type="file" name="image" id="image" class="form-control" onchange="fileValidation('image')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif">
          <?php if (!empty($testimonial['Image'])) { ?>
            <img src="/admin<?= $testimonial['Image'] ?>" height="50" />
          <?php } ?>
        </div>


        <!-- <div class="mb-3 col-md-6 syllabus_file">
          <label class="form-label">Photo <span class="text-danger">*</span></label>
          <input type="hidden" name="updated_file" value="<?= $blogsArr['Photo'] ?>">
          <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif">
          <?php if (!empty($id) && !empty($blogsArr['Photo'])) { ?>
            <img src="/admin<?php echo !empty($id) ? $blogsArr['Photo'] : ''; ?>" height="50" />
          <?php } ?>
        </div> -->

        <div class="mb-3 col-md-6">
          <label class="form-label">Rating <span class="text-danger">*</span></label>
          <input type="number" class="form-control" value="<?= $testimonial['Rating'] ?>" name="rating" placeholder="Enter Rating" min="1" max="5" required>
        </div>
        <div class="mb-3 col-md-12">
          <label class="form-label">Testimonial <span class="text-danger">*</span></label>
          <textarea class="ckeditor form-control" name="testimonial" rows="5"><?= $testimonial['Testimonial'] ?></textarea>
          <span id="testimonial-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
        </div>

      </div>
      <div class="modal-footer clearfix text-end">
        <div class="col-md-4 m-t-10 sm-m-t-10">
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
    $('#form-edit-testimonial').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    $("#form-edit-testimonial").on("submit", function(e) {
      e.preventDefault();
      if ($('#form-edit-testimonial').valid()) {
        var formData = new FormData(this);

        formData.append('testimonial_content', CKEDITOR.instances.testimonial.getData());

        $.ajax({
          url: this.action,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(data) {
            if (data.status == 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#testimonials-table').DataTable().ajax.reload(null, false);
            } else {
              toastr.error(data.message, 'Error');
            }
          },
          error: function(xhr, status, error) {
            toastr.error('An error occurred while saving the testimonial.', 'Error');
          }
        });
      }
    });
  });

  function fileValidation(id) {
    var fi = document.getElementById(id);
    if (fi.files.length > 0) {
      for (var i = 0; i <= fi.files.length - 1; i++) {
        var fsize = fi.files.item(i).size;
        var file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 500) {
          $('#' + id).val('');
          toastr.error("File too Big, each file should be less than or equal to 500KB");
        }
      }
    }
  }
</script>

<script>
  CKEDITOR.replace('testimonial', {
    height: 300
  });
</script>