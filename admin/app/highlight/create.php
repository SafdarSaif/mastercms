<?php 
require '../../includes/db-config.php';
require '../../includes/helper.php';
?>

<div class="modal-header">
  <h5 class="modal-title">Add Programme Highlight</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-highlight" action="/admin/app/highlight/store" method="POST" enctype="multipart/form-data">
      
      <div class="mb-3 col-md-12">
        <label class="form-label">Highlights<span class="text-danger">*</span></label>
        <textarea class="form-control" name="highlight" rows="5" required></textarea>
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
    $('#form-add-highlight').validate({
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
  });

  $("#form-add-highlight").on("submit", function(e) {
    if ($('#form-add-highlight').valid()) {
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
</script>
