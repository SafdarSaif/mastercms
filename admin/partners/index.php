<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/top-menu.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php'); ?>
<!-- row -->
<style>
    .modal-dialog.modal-dialog-centered {
        max-width: 850px !important;
    }
</style>
<div class="element-areaa">
    <div class="demo-view">
        <div class="container-fluid pt-0 ps-0 pe-lg-4 pe-0">

            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card dz-card" id="accordion-four">
                    <div class="card-header flex-wrap d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"> University Partners</h4>
                        </div>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" onclick="add('partners','md')" data-bs-target="#modalGrid">Add Partners </button>
                    </div>
                    <!-- /tab-content -->
                    <div class="tab-content" id="myTabContent-3">
                        <div class="tab-pane fade show active" id="withoutBorder" role="tabpanel" aria-labelledby="home-tab-3">
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table id="partners-table" class="display table" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <!-- <th>Subtitle</th> -->
                                                <!-- <th>Content</th> -->
                                                <th>Image</th>
                                                <th>Status </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="withoutBorder-html" role="tabpanel" aria-labelledby="home-tab-3">
                            <div class="card-body pt-0 p-0 code-area">

                            </div>
                        </div>
                    </div>
                    <!-- /tab-content -->
                </div>
            </div>
            <!-- Column ends -->
        </div>
    </div>

</div>
</div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-top.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#partners-table').DataTable({
            'processing': true,
            'ajax': {
                'url': '/admin/app/partners/server',
                'type': 'POST'
            },
            'columns': [{
                    data: 'No'
                },
                {
                    data: 'Names'
                },
               
                {
                    data: 'Images',
                    render: function(data, type, row) {
                        return '<img src="/admin/' + row.Images + '" width="70">';
                    },
                    visible: true

                },
                
                {
                    data: 'Status',
                    render: function(data, type, row) {
                        var active = data == 1 ? 'Active' : 'Inactive';
                        var checked = row.Status == 1 ? 'checked' : '';
                        return '<label class="switch" for="status-switch-' + row.ID + '"> <input onclick="changeStatus(&#39;partners&#39;, &#39;' + row.ID + '&#39;)" type="checkbox" ' + checked + ' id="status-switch-' + row.ID + '"><span class="slider round"></span></label>';
                    },
                    visible: true
                },

                {
                    data: 'ID',
                    render: function(data, type, row) {
                        return '<div class="ms-auto"><a href="javascript:void(0);" onclick="edit(&#39;partners&#39;, &#39;' + data + '&#39, &#39;md&#39;)" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a><a href="javascript:void(0);" onclick="destroy(&#39;partners&#39;, &#39;' + data + '&#39)" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a></div>';
                    },
                    visible: true
                },
            ],
            'searching': true,
            'paging': true,
            'lengthChange': true,
        });

        $('input[aria-controls="partners-table"]').keyup(function() {
            var searchValue = $(this).val();
            table.search(searchValue).draw();
        });
    });
</script>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-bottom.php');

?>