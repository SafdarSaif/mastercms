<?php include('../includes/header-top.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/top-menu.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php');
?>
<!-- row -->

<div class="element-areaa">
    <div class="demo-view">
        <div class="container-fluid pt-0 ps-0 pe-lg-4 pe-0">

            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card dz-card" id="accordion-four">
                    <div class="card-header flex-wrap d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Program</h4>
                        </div>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" onclick="add('streams','md')" data-bs-target="#modalGrid">Add Program</button>
                    </div>
                    <!-- /tab-content -->
                    <div class="tab-content" id="myTabContent-3">
                        <div class="tab-pane fade show active" id="withoutBorder" role="tabpanel" aria-labelledby="home-tab-3">
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table id="streams-table" class="display table" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>CategoryName</th>
                                                <th>DepartmentName</th>
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
<?php include('../includes/footer-top.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#streams-table').DataTable({
        'processing': true,
        'ajax': {
            'url': '/admin/app/streams/server',
            'type': 'POST'
        },
        'columns': [
            { data: 'No' },
            { data: 'Name' },
            { data: 'Category' },
            { data: 'Department' },
            {
                data: 'Status',
                render: function(data, type, row) {
                    var active = data == 1 ? 'Active' : 'Inactive';
                    var checked = row.Status == 1 ? 'checked' : '';
                    return '<label class="switch" for="status-switch-' + row.ID + '"> <input onclick="changeStatus(&#39;programs&#39;, &#39;' + row.ID + '&#39;)" type="checkbox" ' + checked + ' id="status-switch-' + row.ID + '"><span class="slider round"></span></label>';
                },
                visible: true
            },
           
            {
                data: 'ID',
                render: function(data, type, row) {
                //    console.log(data);
                    return '<div class="ms-auto"><a href="javascript:void(0);" onclick="edit(&#39;streams&#39;, &#39;' + row.ID + '&#39, &#39;md&#39;)" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a><a href="javascript:void(0);" onclick="destroy(&#39;streams&#39;, &#39;' + data + '&#39)" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a></div>';
                },
                visible: true
            },
        ],
        'searching': true,
        'paging': true,
        'lengthChange': true,
    });

    $('input[aria-controls="streams-table"]').keyup(function() {
    var searchValue = $(this).val();
    table.search(searchValue).draw();
});
});

</script>
<?php include('../includes/footer-bottom.php'); ?>