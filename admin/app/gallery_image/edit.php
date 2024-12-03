<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    $id = intval($_GET['id']);
    $getdataQuery = $conn->query("SELECT * FROM gallery_image WHERE ID = $id");
    $getdata = $getdataQuery->fetch_assoc();
}
?>

<div class="modal-header">
    <h3 class="modal-title">Edit Gallery</h3>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="card-body">
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-add-blogs" action="/admin/app/gallery_image/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $getdata['id'] ?>">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label class="form-label">Images name<span class="text-danger">*</span></label>
                    <?php $galleryArr = getgalleryFunc($conn); ?>
                    <select name="gallery_id" id="gallery_id" class="form-control sumoselect" required>
                        <option value="">Select Names</option>
                        <?php foreach ($galleryArr as $gallery) { ?>
                            <option value="<?= $gallery['id'] ?>" <?php if ($getdata['gallery_id'] == $gallery['id']) {
                                echo "selected";
                            } ?>>
                                <?= $gallery['image_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Images</label>
                        <div id="add_new_images">
                            <?php
                            $existingImages = explode(', ', $getdata['image_url']);
                            $i=1;
                            foreach ($existingImages as  $image) { $i++; ?>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="existing_images[]"  value="<?= $image ?>">
                                    <input type="file" class="form-control image-upload"  id="photo_<?=$i ?>" onchange="fileValidation('photo_<?=$i ?>')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif" name="new_images[]">
                                    <?php if (!empty($id) && !empty($image)) { ?>
                                        <img src="/admin<?= $image ?>" height="50" />
                                    <?php } ?>
                                    <button type="button" class="btn btn-danger remove-image">Remove</button>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="input-group mb-3">
                            <button type="button" class="btn btn-primary add-image">Add Image</button>
                        </div>
                    </div>
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
    var count = 0;

    $('.add-image').on('click', function() {
        count++;
        var html = '<div class="input-group mb-3">' +
            '<input type="file" class="form-control image-upload" id="photo' + count + '" onchange="fileValidation(\'photo' + count + '\')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif" name="new_images[]">' +
            '<button type="button" class="btn btn-danger remove-image">Remove</button>' +
            '</div>';
        $('#add_new_images').append(html);
    });

    $('#add_new_images').on('click', '.remove-image', function() {
        $(this).closest('.input-group').remove();
    });

    $('#form-add-blogs').validate({
        errorPlacement: function(error, element) {
            if (element.is("select")) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        rules: {}
    });

    $("#form-add-blogs").on("submit", function(e) {
        if ($('#form-add-blogs').valid()) {
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
                        $('#gallery_image-table').DataTable().ajax.reload(null, false);
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

    // console.log(fi);
    // alert(id);
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