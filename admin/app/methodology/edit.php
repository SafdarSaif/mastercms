<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    $id = intval($_GET['id']);
    $methodologyResult = $conn->query("SELECT * FROM methodology WHERE id = $id");
    $methodology = $methodologyResult->fetch_assoc();
}
?>

<div class="modal-header">
    <h5 class="modal-title">Edit Methodology</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-edit-methodology" action="/admin/app/methodology/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $methodology['ID'] ?>">

            <div class="mb-3 col-md-12">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?= $methodology['Name'] ?>" name="name" placeholder="Enter a Methodology Title.." required>
            </div>

            <div class="mb-3 col-md-12 syllabus_file">
                <label class="form-label">Photo <span class="text-danger">*</span></label>
                <input type="hidden" name="updated_file" value="<?= $methodology['Image'] ?>">
                <input type="file" name="image" id="image" class="form-control" onchange="fileValidation('Image')" accept="image/png, image/jpg, image/jpeg, image/svg">
                <?php if (!empty($id) && !empty($methodology['Image'])) { ?>
                    <img src="/admin<?php echo !empty($id) ? $methodology['Image'] : ''; ?>" height="70" />
                <?php } ?>
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                <textarea class="form-control" name="short_description" rows="5"><?= $methodology['Short_Description'] ?></textarea>
            </div>
            <div class="mb-3 col-md-12">
                <label class="form-label">Full Description <span class="text-danger">*</span></label>
                <textarea class="ckeditor" id="edit-editor" name="full_description" rows="10" required><?= $methodology['Full_Description'] ?></textarea>
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
        $('#form-edit-methodology').validate({
            rules: {
                title: {
                    required: true
                },
                
                full_description: {
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

        $("#form-edit-methodology").on("submit", function(e) {
            if ($('#form-edit-methodology').valid()) {
                var editorContent = CKEDITOR.instances['edit-editor'].getData();
                if (editorContent == '') {
                    $("#edit-content-error").text("This field is required.");
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
    });

    CKEDITOR.replace('edit-editor');
</script>
