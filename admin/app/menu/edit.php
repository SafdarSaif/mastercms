<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if (isset($_GET['id'])) {
  $menuId = $_GET['id'];
  $getData = mysqli_query($conn, "SELECT * FROM menus WHERE ID = $menuId");
  $menu = $getData->fetch_assoc();
}
?>

<div class="modal-header text-white">
  <h3 class="modal-title">Edit Menu</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="card">
    <div class="card-body">
      <form class="needs-validation" id="form-edit-menu" action="/admin/app/menu/update" method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="id" value="<?= $menu['ID'] ?>">
        <div class="row g-3">

          <!-- Name -->
          <div class="col-md-6">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="<?= $menu['Name'] ?>" placeholder="Enter a Menu Name..." required>
          </div>

          <!-- Photo -->
          <div class="mb-3 col-md-6">
            <label class="form-label">Photo <span class="text-danger">*</span></label>
            <input type="hidden" name="updated_file" value="<?= $menu['Photo'] ?>">
            <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg, image/avif">
            <?php if (!empty($menu['Photo'])) { ?>
              <img src="/admin<?= $menu['Photo'] ?>" height="50" alt="Menu Image" />
            <?php } ?>
          </div>


          <!-- Menu Options -->
          <div class="col-md-12">
            <div id="checkbox-info" class="text-primary mb-2">
              Please note: Only one option can be selected at a time.
            </div>
            <label class="form-label">Menu Options</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="has_page" name="has_page" value="1" <?= ($menu['Has_Page'] == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="has_page">Has Page</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="has_url" name="has_url" value="1" <?= ($menu['Has_Url'] == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="has_url">Has URL</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="has_parent" name="has_parent" value="1" <?= ($menu['Has_Parent'] == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="has_parent">Has Parent</label>
            </div>
            <div id="checkbox-warning" class="text-danger mt-2" style="display: none;">
              You can select only one option at a time.
            </div>
          </div>

          <!-- Dynamic Fields -->
          <div class="col-md-6" id="page_url_div" style="<?= ($menu['Has_Page'] == 1) ? 'display:block;' : 'display:none;' ?>">
            <label class="form-label">Page</label>
            <select class="form-control" name="page_url">
              <option value="">Select a Page</option>
              <?php
              $pagesQuery = mysqli_query($conn, "SELECT ID, Name FROM categories WHERE Status = 1");
              while ($page = mysqli_fetch_assoc($pagesQuery)) { ?>
                <option value="<?= $page['ID'] ?>" <?= ($page['ID'] == $menu['Page_Url']) ? 'selected' : ''; ?>><?= $page['Name'] ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="col-md-6" id="custom_url_div" style="<?= ($menu['Has_Url'] == 1) ? 'display:block;' : 'display:none;' ?>">
            <label class="form-label">Custom URL</label>
            <input type="text" class="form-control" name="custom_url" value="<?= $menu['Custom_Url'] ?>" placeholder="Enter the URL...">
          </div>

          <div class="col-md-6" id="parent_menu_div" style="<?= ($menu['Has_Parent'] == 1) ? 'display:block;' : 'display:none;' ?>">
            <label class="form-label">Parent Menu</label>
            <select name="parent_menu" id="parent_menu" class="form-control">
              <option value="">Select Parent Menu</option>
              <?php
              $parentMenus = mysqli_query($conn, "SELECT ID, Name FROM categories WHERE Status = 1");
              while ($menuItem = mysqli_fetch_assoc($parentMenus)) { ?>
                <option value="<?= $menuItem['ID'] ?>" <?= ($menuItem['ID'] == $menu['Parent_Menu_ID']) ? 'selected' : ''; ?>><?= $menuItem['Name'] ?></option>
              <?php } ?>
            </select>
          </div>

          <!-- Order By -->
          <div class="col-md-6" id="order_div" style="<?= ($menu['Has_Parent'] == 1) ? 'display:block;' : 'display:none;' ?>">
            <label class="form-label">Order By <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control" name="position" value="<?= $menu['Position'] ?>" placeholder="Enter a Position..." required>
          </div>

          <!-- Meta Information -->
          <div class="col-md-6">
            <label class="form-label">Meta Title</label>
            <input type="text" class="form-control" name="meta_title" value="<?= $menu['Meta_Title'] ?>" placeholder="Enter a Meta Title...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Meta Key</label>
            <input type="text" class="form-control" name="meta_key" value="<?= $menu['Meta_Key'] ?>" placeholder="Enter a Meta Key...">
          </div>
          <div class="col-md-12">
            <label class="form-label">Meta Description</label>
            <textarea class="form-control" name="meta_description" rows="2" placeholder="Enter a Meta Description..."><?= $menu['Meta_Description'] ?></textarea>
          </div>
          <!-- Position -->
          <div class="col-md-12">
            <label class="form-label">Order By <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control" name="position" value="<?= $menu['Position'] ?>" placeholder="Enter a Position..." required>
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
        $('#order_div').show();
      }
    });
  });

  $(function() {
    $('#form-edit-menu').validate({
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
  $("#form-edit-menu").on("submit", function(e) {
    if ($('#form-edit-menu').valid()) {
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