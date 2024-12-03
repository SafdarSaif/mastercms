<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $categoriesArr = $conn->query("SELECT * FROM categories WHERE ID = $id");
  $categoriesArr = $categoriesArr->fetch_assoc();
}


?>
<?php
$categoryTypes = [
  "EXAM" => "Exam",
  "Courses" => "Courses",
  "Universities" => "Universities",
  "Countries" => "Countries"
];
?>

<div class="modal-header">
  <h3 class="modal-title">Edit Category (<a href="/categories?url=<?= $categoriesArr['Slug'] ?>" style="color: #222B40;"><?= $categoriesArr['Name'] ?></a>)</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal">
  </button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-categories" action="/admin/app/categories/update" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $categoriesArr['ID'] ?>">
      <div class="row">

        <div class="mb-3 col-md-6">
          <label class="form-label">Name
            <span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?= $categoriesArr['Name'] ?>" name="name" placeholder="Enter a Blog Name.." required>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Photo <span class="text-danger">*</span></label>
          <input type="hidden" name="updated_file" value="<?= $categoriesArr['Photo'] ?>">
          <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg, image/avif">
          <?php if (!empty($id) && !empty($categoriesArr['Photo'])) { ?>
            <img src="/admin<?php echo !empty($id) ? $categoriesArr['Photo'] : ''; ?>" height="50" />
          <?php } ?>
        </div>


        <div class="mb-3 col-md-6">
          <label class="form-label">Category Type <span class="text-danger">*</span></label>
          <select name="category_type" id="category_type" class="form-control sumoselect" required>
            <option value="">Select Category</option>
            <?php foreach ($categoryTypes as $key => $value) { ?>
              <option value="<?= $key ?>" <?= $categoriesArr['Type'] == $key ? 'selected' : '' ?>><?= $value ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3 col-md-12">
          <label class="form-label">Order By <span class="text-danger">*</span></label>
          <input type="number" min="0" class="form-control" value="<?= $categoriesArr['Position'] ?>" name="position" placeholder="Enter a Position.." required>
        </div>

      </div>
      <div class=" modal-footer clearfix text-end">
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
    $('#form-add-categories').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  });

  $("#form-add-categories").on("submit", function(e) {
    if ($('#form-add-categories').valid()) {
      // $(':input[type="submit"]').prop('disabled', true);

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
            $('#categories-table').DataTable().ajax.reload(null, false);
          } else {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });
</script>

<!-- <script>
  $(function() {
    $('#form-add-categories').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-categories").on("submit", function(e) {
    if ($('#form-add-categories').valid()) {
     
      var editorContent = CKEDITOR.instances.editor.getData();
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
            $('#categories-table').DataTable().ajax.reload(null, false);
          } else {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });
</script> -->

<script>
  function fileValidation(id) {
    var fi = document.getElementById(id);
    if (fi.files.length > 0) {
      for (var i = 0; i <= fi.files.length - 1; i++) {
        var fsize = fi.files.item(i).size;
        var file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 500) {
          $('#' + id).val('');
          alert("File too Big, each file should be less than or equal to 500KB");
        }
      }
    }
  }
</script>

<!-- <script>
  CKEDITOR.replace('editor');
</script> -->