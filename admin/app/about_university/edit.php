<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    $id = intval($_GET['id']);
    $contentResult = $conn->query("SELECT * FROM about_university WHERE ID = $id");
    $content = $contentResult->fetch_assoc();
}
?>

<div class="modal-header">
    <h5 class="modal-title">Edit About Content</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-edit-content" action="/admin/app/about_university/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $content['ID'] ?>">

            <div class="mb-3 col-md-12">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?= $content['Title'] ?>" name="title" placeholder="Enter a Title.." required>
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Subtitle <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?= $content['Subtitle'] ?>" name="subtitle" placeholder="Enter a Subtitle.." required>
            </div>

            <div class="mb-3 col-md-12 syllabus_file">
                <label class="form-label">Photo <span class="text-danger">*</span></label>
                <input type="hidden" name="updated_file" value="<?= $content['Image'] ?>">
                <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('Image')" accept="image/png, image/jpg, image/jpeg, image/svg">
                <?php if (!empty($id) && !empty($content['Image'])) { ?>
                    <img src="/admin<?= $content['Image'] ?>" height="70" />
                <?php } ?>
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Content <span class="text-danger">*</span></label>
                <textarea class="ckeditor" id="edit-editor" name="content" rows="10" required><?= $content['Content'] ?></textarea>
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
        $('#form-edit-content').validate({
            rules: {
                title: {
                    required: true
                },
                subtitle: {
                    required: true
                },
                content: {
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

        $("#form-edit-content").on("submit", function(e) {
            if ($('#form-edit-content').valid()) {
                var editorContent = CKEDITOR.instances['edit-editor'].getData();
                if (editorContent == '') {
                    $("#edit-content-error").text("This field is required.");
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
