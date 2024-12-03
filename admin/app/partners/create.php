<?php 
require '../../includes/db-config.php';
require '../../includes/helper.php'; 
?>

<div class="modal-header">
  <h5 class="modal-title">Add Partner</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" id="form-add-partner" action="/admin/app/partners/store" method="POST" enctype="multipart/form-data">
      <div class="mb-3 col-md-12">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="name" placeholder="Enter Partner Name" required>
      </div>

      <div class="mb-3 col-md-12">
        <label class="form-label">Image</label>
        <input type="file" name="photo" id="photo" class="form-control" accept="image/png, image/jpg, image/jpeg, image/svg">
      </div>

      <div class="modal-footer clearfix text-end">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
    $(function() {
        $('#form-add-partner').validate({
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

        $("#form-add-partner").on("submit", function(e) {
            e.preventDefault();
            if ($('#form-add-partner').valid()) {
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
