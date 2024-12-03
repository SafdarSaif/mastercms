
 <!-- Modals -->
 <div class="modal fade" tabindex="-1" role="dialog" data-bs-focus="false" data-keyboard="false" data-backdrop="static" id="modalGrid">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content" id="md-modal-content">
     </div>
   </div>
 </div>
 <!-- <div class="modal fade" tabindex="-1" role="dialog" data-bs-focus="false"  data-keyboard="false" data-backdrop="static" id="lgmodalGrid">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content" id="lg-modal-content">
     </div>
   </div>
 </div> -->
 <!-- <div class="modal fade" tabindex="-1" role="dialog" data-bs-focus="false" data-keyboard="false" data-backdrop="static" id="lgmodalGrid">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content" id="lg-modal-content">
     </div>
   </div>
 </div> -->

 <div class="modal fade" id="lgmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-hidden="false">
  <div class="modal-dialog modal-lg modal-simple modal-add-new-address modal-dialog-scrollable">
    <div class="modal-content-wrapper">
      <div class="modal-content" id="lg-modal-content">
       

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade fill-in" id="xlmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content" id="xl-modal-content">

    </div>
  </div>
</div>

 <div class="footer">
   <div class="copyright">
     <p>Copyright &copy;2024 Knowledge Nest. All Rights Reserved</p>
   </div>
 </div>
 </div>
 <!-- Required vendors -->
 <script src="/admin/admin-assets/vendor/global/global.min.js"></script>
 <script src="/admin/admin-assets/vendor/chart.js/Chart.bundle.min.js"></script>
 <script src="/admin/admin-assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
 <!-- <script src="/admin/admin-assets/vendor/apexchart/apexchart.js"></script> -->

 <!-- Dashboard 1 -->
 <script src="/admin/admin-assets/js/dashboard/dashboard-1.js"></script>
 <script src="/admin/admin-assets/vendor/draggable/draggable.js"></script>
 <script src="/admin/admin-assets/vendor/swiper/js/swiper-bundle.min.js"></script>
 <script src="/admin/admin-assets/vendor/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>

 <!-- tagify -->
 <script src="/admin/admin-assets/vendor/tagify/dist/tagify.js"></script>
 <script src="/admin/admin-assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
 <script src="/admin/admin-assets/vendor/datatables/js/dataTables.buttons.min.js"></script>
 <script src="/admin/admin-assets/vendor/datatables/js/buttons.html5.min.js"></script>
 <script src="/admin/admin-assets/vendor/datatables/js/jszip.min.js"></script>
 <script src="/admin/admin-assets/js/plugins-init/datatables.init.js"></script>

 <!-- Apex Chart -->
 <script src="/admin/admin-assets/vendor/toastr/js/toastr.min.js"></script>
 <script src="/admin/admin-assets/js/plugins-init/toastr-init.js"></script>

 <!-- Vectormap -->
 <script src="/admin/admin-assets/vendor/jqvmap/js/jquery.vmap.min.js"></script>
 <script src="/admin/admin-assets/vendor/jqvmap/js/jquery.vmap.world.js"></script>
 <script src="/admin/admin-assets/vendor/jqvmap/js/jquery.vmap.usa.js"></script>
 <script src="/admin/admin-assets/js/custom.js"></script>
 <script src="/admin/admin-assets/js/deznav-init.js"></script>
 <script src="/admin/admin-assets/js/demo.js"></script>
 <script src="/admin/admin-assets/js/styleSwitcher.js"></script>
 <!-- code-highlight -->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <!-- <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script> -->
 <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
 <!-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script> -->




 <!-- sumoselect  -->
 <script src="/admin/admin-assets/plugins/sumo-select/js/jquery.sumoselect.min.js"></script>
 <script src="/admin/admin-assets/plugins/sumo-select/js/jquery.sumoselect.js"></script>

 <script>
   // hljs.highlightAll();
   // hljs.configure({
   // 	ignoreUnescapedHTML: true
   // })


 </script>

 <script>
   document.addEventListener('DOMContentLoaded', (event) => {
     document.querySelectorAll('pre code').forEach((el) => {
       hljs.highlightElement(el);
     });
   });
 </script>
 <script type="text/javascript">
   function add(url, modal) {
     // alert(model);
     $.ajax({
       url: '/admin/app/' + url + '/create',
       type: 'GET',
       success: function(data) {
         $('#' + modal + '-modal-content').html(data);
         //  alert('#' + modal + 'modal');
         $('#' + modal + 'modal').modal('show');
       }
     })
   }
 </script>
 <script type="text/javascript">
   function edit(url, id, modal) {

     $.ajax({
       url: '/admin/app/' + url + '/edit?id=' + id,
       type: 'GET',
       success: function(data) {
         $('#' + modal + '-modal-content').html(data);
         $('#' + modal + 'modal').modal('show');
         $('#modalGrid').modal('show');
       }
     })
   }
 </script>
 <script type="text/javascript">
   function destroy(url, id) {
     $(".modal").modal('hide');
     Swal.fire({
       title: 'Are you sure?',
       text: "You won't be able to revert this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, delete it!'
     }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: "/admin/app/" + url + "/destroy?id=" + id,
           type: 'DELETE',
           dataType: 'json',
           success: function(data) {
             if (data.status == 200) {
               toastr.success(data.message, 'Success');
               $('.table').DataTable().ajax.reload(null, false);;
             } else {
               toastr.error(data.message, 'Error');
             }
           }
         });
       }
     })
   }
 </script>
 <script type="text/javascript">
   function changeStatus(table, id, column = null) {
     $.ajax({
       url: '/admin/app/status/update',
       type: 'post',
       data: {
         table,
         id,
         column
       },
       dataType: 'json',
       success: function(data) {
         if (data.status == 200) {
           toastr.success(data.message, 'Success');
           var datatable = table == 'Students' ? 'application' : table.toLowerCase();
           //  alert('#' + datatable + '-table');
           $('#' + datatable + '-table').DataTable().ajax.reload(null, false);;
         } else {
           toastr.error(data.message, 'Error');
           $('#' + table + '-table').DataTable().ajax.reload(null, false);;
         }
       }
     });
   }
 </script>