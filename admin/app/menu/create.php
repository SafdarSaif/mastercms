<?php require '../../includes/db-config.php'; ?>
<?php require '../../includes/helper.php'; ?>

<div class="modal-header text-white">
  <h3 class="modal-title">Add Menu</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="card">
    <div class="card-body">
      <form class="needs-validation" id="form-add-menu" action="/admin/app/menu/store" method="POST" enctype="multipart/form-data" novalidate>
        <div class="row g-3">

          <!-- Name -->
          <div class="col-md-6">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Enter a Menu Name..." required>
          </div>

          <!-- Photo -->
          <div class="col-md-6">
            <label class="form-label">Photo <span class="text-danger">*</span></label>
            <input type="file" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg, image/avif" name="photo" required>
          </div>

          <!-- Menu Options -->
          <div class="col-md-12">
            <div id="checkbox-info" class="text-primary mb-2">
              Please note: Only one option can be selected at a time.
            </div>
            <label class="form-label">Menu Options</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="has_page" name="has_page" value="1">
              <label class="form-check-label" for="has_page">Has Page</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="has_url" name="has_url" value="1">
              <label class="form-check-label" for="has_url">Has URL</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="has_parent" name="has_parent" value="1">
              <label class="form-check-label" for="has_parent">Has Parent</label>
            </div>
            <div id="checkbox-warning" class="text-danger mt-2" style="display: none;">
              You can select only one option at a time.
            </div>
          </div>

          <!-- Dynamic Fields -->
          <div class="col-md-6" id="page_url_div" style="display: none;">
            <label class="form-label">Page</label>
            <select class="form-control" name="page_url">
              <option value="">Select a Page</option>
              <?php
              $pagesQuery = mysqli_query($conn, "SELECT ID, Name FROM categories WHERE Status = 1");
              while ($page = mysqli_fetch_assoc($pagesQuery)) { ?>
                <option value="<?= $page['ID'] ?>"><?= $page['Name'] ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="col-md-6" id="custom_url_div" style="display: none;">
            <label class="form-label">Custom URL</label>
            <input type="text" class="form-control" name="custom_url" placeholder="Enter the URL...">
          </div>

          <div class="col-md-6" id="parent_menu_div" style="display: none;">
            <label class="form-label">Parent Menu</label>
            <select name="parent_menu" id="parent_menu" class="form-control">
              <option value="">Select Parent Menu</option>
              <?php
              $parentMenus = mysqli_query($conn, "SELECT ID, Name FROM categories WHERE Status = 1");
              while ($menu = mysqli_fetch_assoc($parentMenus)) { ?>
                <option value="<?= $menu['ID'] ?>"><?= $menu['Name'] ?></option>
              <?php } ?>
            </select>
          </div>

          
          <!-- Order By -->
          <div class="col-md-6" id="order_div" style="display: none;">
            <label class="form-label">Order By <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control" name="position" placeholder="Enter a Position..." required>
          </div>

          <!-- Meta Information -->
          <div class="col-md-6">
            <label class="form-label">Meta Title</label>
            <input type="text" class="form-control" name="meta_title" placeholder="Enter a Meta Title...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Meta Key</label>
            <input type="text" class="form-control" name="meta_key" placeholder="Enter a Meta Key...">
          </div>
          <div class="col-md-12">
            <label class="form-label">Meta Description</label>
            <textarea class="form-control" name="meta_description" rows="2" placeholder="Enter a Meta Description..."></textarea>
          </div>

          <!-- Position -->
          <div class="col-md-12">
            <label class="form-label">Order By <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control" name="position" placeholder="Enter a Position..." required>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('input[type="checkbox"]').change(function() {
      $('input[type="checkbox"]').not(this).prop('checked', false);

      $('#page_url_div, #custom_url_div, #parent_menu_div,  #order_div').hide();

      if ($('#has_page').is(':checked')) {
        $('#page_url_div').show();
      }
      if ($('#has_url').is(':checked')) {
        $('#custom_url_div').show();
      }
      if ($('#has_parent').is(':checked')) {
        $('#parent_menu_div').show();
        // $('#parent_name_div').show();
        $('#order_div').show();

      }

      if ($('#has_page').is(':checked') || $('#has_url').is(':checked') || $('#has_parent').is(':checked')) {
        // $('#order_div').show();
      }
    });
  });

  $(function() {
    $('#form-add-menu').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  });

  // Submit form via AJAX
  $("#form-add-menu").on("submit", function(e) {
    if ($('#form-add-menu').valid()) {
      e.preventDefault();

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
            $('#menu-table').DataTable().ajax.reload(null, false);
          } else {
            toastr.error(data.message, 'Error');
          }
        }
      });
    }
  });
</script>