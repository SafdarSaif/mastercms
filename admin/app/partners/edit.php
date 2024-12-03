<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    $id = intval($_GET['id']);
    $partnerResult = $conn->query("SELECT * FROM partners WHERE ID = $id");
    $partner = $partnerResult->fetch_assoc();
}
?>

<div class="modal-header">
    <h5 class="modal-title">Edit Partner</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-edit-partner" action="/admin/app/partners/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $partner['ID'] ?>">

            <div class="mb-3 col-md-12">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?= $partner['Name'] ?>" name="name" placeholder="Enter Partner Name.." required>
            </div>

            <div class="mb-3 col-md-12 ">
                <label class="form-label">Photo <span class="text-danger">*</span></label>
                <input type="hidden" name="updated_file" value="<?= $partner['Image'] ?>">
                <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('Image')" accept="image/png, image/jpg, image/jpeg, image/svg">
                <?php if (!empty($id) && !empty($partner['Image'])) { ?>
                    <img src="/admin<?php echo !empty($id) ? $partner['Image'] : ''; ?>" height="70" />
                <?php } ?>
            </div>

            <div class="modal-footer clearfix text-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        $('#form-edit-partner').validate({
            rules: {
                name: {
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

        $("#form-edit-partner").on("submit", function(e) {
            e.preventDefault();
            if ($('#form-edit-partner').valid()) {
                var formData = new FormData(this);
                $.ajax({
                    url: this.action,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.status === 200) {
                            $('.modal').modal('hide');
                            toastr.success(data.message, 'Success');
                            $('#partners-table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(data.message, 'Error');
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred while saving the partner.', 'Error');
                    }
                });
            }
        });
    });
</script>
