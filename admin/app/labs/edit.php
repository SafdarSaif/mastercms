<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    $id = intval($_GET['id']);
    $labResult = $conn->query("SELECT * FROM labs WHERE id = $id");
    $lab = $labResult->fetch_assoc();
}
?>

<div class="modal-header">
    <h5 class="modal-title">Edit Lab</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-edit-lab" action="/admin/app/labs/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $lab['ID'] ?>">

            <div class="mb-3 col-md-12">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?= $lab['Name'] ?>" name="name" placeholder="Enter a Lab Name.." required>
            </div>

            <!-- <div class="mb-3 col-md-12">
                <label class="form-label">Image</label>
                <input type="file" name="photo" id="lab-photo" class="form-control" accept="image/png, image/jpg, image/jpeg, image/svg">
            </div> -->
            <div class="mb-3 col-md-12 syllabus_file">
          <label class="form-label">Photo <span class="text-danger">*</span></label>
          <input type="hidden" name="updated_file" value="<?= $lab['Image'] ?>">
          <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('Image')" accept="image/png, image/jpg, image/jpeg, image/svg">
          <?php if (!empty($id) && !empty($lab['Image'])) { ?>
            <img src="/admin<?php echo !empty($id) ? $lab['Image'] : ''; ?>" height="70" />
          <?php } ?>
        </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                <textarea class="form-control" name="short_description" rows="5" required><?= $lab['Short_Description'] ?></textarea>
            </div>
            <div class="mb-3 col-md-12">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="ckeditor" id="edit-editor" name="description" rows="10" required><?= $lab['Description'] ?></textarea>
                <span id="edit-content-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
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
    $(function() {
        $('#form-edit-lab').validate({
            rules: {
                name: {
                    required: true
                },
                short_description: {
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

        $("#form-edit-lab").on("submit", function(e) {
            if ($('#form-edit-lab').valid()) {
                var editorContent = CKEDITOR.instances['edit-editor'].getData();
                if (editorContent == '') {
                    $("#edit-content-error").text("This field is required.");
                    return false;
                }
                var formData = new FormData(this);
                formData.append('description', editorContent);
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
                            $('#labs-table').DataTable().ajax.reload(null, false);
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

    CKEDITOR.replace('edit-editor');
</script>
