<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    $id = intval($_GET['id']);
    $highlightResult = $conn->query("SELECT * FROM highlights WHERE id = $id");
    $highlight = $highlightResult->fetch_assoc();
}
?>

<div class="modal-header">
    <h5 class="modal-title">Edit Programme Highlight</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-edit-highlight" action="/admin/app/highlight/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $highlight['ID'] ?>">

            <div class="mb-3 col-md-12">
                <label class="form-label">Highlight <span class="text-danger">*</span></label>
                <textarea class="form-control" name="highlight" rows="5" required><?= $highlight['Highlight_Text'] ?></textarea>
            </div>
            
            <div class="modal-footer clearfix text-end">
                <div class="col-md-4 mt-10">
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
        $('#form-edit-highlight').validate({
            rules: {
                highlight: {
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

        $("#form-edit-highlight").on("submit", function(e) {
            if ($('#form-edit-highlight').valid()) {
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
                            $('#highlight-table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(data.message, 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                    }
                });
                e.preventDefault();
            }
        });
    });
</script>
