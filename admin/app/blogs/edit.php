<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $blogsArr = $conn->query("SELECT * FROM blogs WHERE ID = $id");
  $blogsArr = $blogsArr->fetch_assoc();
}
?>

<div class="modal-header">
  <h3 class="modal-title">Edit Blog (<a href="/blogs?url=<?= $blogsArr['Slug'] ?>" style="color: #222B40;"><?= $blogsArr['Name'] ?></a>)</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal">
  </button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-blogs" action="/admin/app/blogs/update" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $blogsArr['ID'] ?>">
      <div class="row">
    
        <div class="mb-3 col-md-6">
          <label class="form-label">Name
            <span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?= $blogsArr['Name'] ?>" name="name" placeholder="Enter a Blog Name.." required>
        </div>

        <div class="mb-3 col-md-6 syllabus_file">
          <label class="form-label">Photo <span class="text-danger">*</span></label>
          <input type="hidden" name="updated_file" value="<?= $blogsArr['Photo'] ?>">
          <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif">
          <?php if (!empty($id) && !empty($blogsArr['Photo'])) { ?>
            <img src="/admin<?php echo !empty($id) ? $blogsArr['Photo'] : ''; ?>" height="50" />
          <?php } ?>
        </div>
        
        <div class="mb-3 col-md-12">
          <label class="form-label">Short Description<span class="text-danger">*</span></label>
          <textarea cols="2" class="form-control" name="description" placeholder="Enter a Short Description.." required ><?= $blogsArr['Description'] ?></textarea>
        </div>
        <div class="mb-3 col-md-12 ">
          <label class="form-label">Content <span class="text-danger">*</span></label>
          <textarea class="ckeditor" cols="80" id="editor" name="editor" rows="10"><?= $blogsArr['Content'] ?></textarea>
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Meta Title
          </label>
          <input type="text" class="form-control" name="meta_title" placeholder="Enter a Meta Title.." value="<?= $blogsArr['Meta_Title'] ?>">
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Meta Key
          </label>
          <input type="text" class="form-control" name="meta_key" placeholder="Enter a Meta Key.." value="<?= $blogsArr['Meta_Key'] ?>" >
        </div>
        <div class="mb-3 col-md-12">
          <label class="form-label">Meta Description</label>
          <textarea cols="2" class="form-control" name="meta_description" placeholder="Enter a Meta Description.." ><?= $blogsArr['Meta_Description'] ?></textarea>
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
    $('#form-add-blogs').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-blogs").on("submit", function(e) {
    if ($('#form-add-blogs').valid()) {
     
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
            $('#blogs-table').DataTable().ajax.reload(null, false);
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

<script>
  CKEDITOR.replace('editor');
</script>