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
                            <h4 class="card-title">Syllabus</h4>
                        </div>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" onclick="add('syllabus','md')" data-bs-target="#modalGrid">Add Syllabus </button>
                    </div>
                    <!-- /tab-content -->
                    <div class="tab-content" id="myTabContent-3">
                        <div class="tab-pane fade show active" id="withoutBorder" role="tabpanel" aria-labelledby="home-tab-3">
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table id="syllabus-table" class="display table" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Subject</th>
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
    var table = $('#syllabus-table').DataTable({
        'processing': true,
        'ajax': {
            'url': '/admin/app/syllabus/server',
            'type': 'POST'
        },
        'columns': [
            { data: 'No' },
            { data: 'Subject' },
            {
                data: 'ID',
                render: function(data, type, row) {
                    console.log(row);
                    return '<div class="ms-auto"><a href="javascript:void(0);" onclick="edit(&#39;syllabus&#39;, &#39;' + data + '&#39;, &#39;md&#39;)" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a><a href="javascript:void(0);" onclick="destroy(&#39;syllabus&#39;, &#39;' + data + '&#39;)" class="btn btn-danger btn-xs sharp me-1"><i class="fa fa-trash"></i></a>' + (row.Syllabus_Type == 0 ? '<a href="/admin' + row.Syllabus_File + '" download class="btn btn-primary btn-xs sharp"> <i class="fa fa-download"></i></a>' : '') + '</div>';
                    // return '<div class="ms-auto"><a href="javascript:void(0);" onclick="edit(&#39;syllabus&#39;, &#39;' + data + '&#39, &#39;md&#39;)" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a><a href="javascript:void(0);" onclick="destroy(&#39;syllabus&#39;, &#39;' + data + '&#39)" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>if(row.Syllabus_Type==0){<a href="/admin'+row.Syllabus_File+'" download class="btn btn-danger btn-xs sharp"><i class="fa fa-download"></i></a>}</div>';
                },
                visible: true
            },
           
        ],
        'searching': true,
        'paging': true,
        'lengthChange': true,
    });

    $('input[aria-controls="syllabus-table"]').keyup(function() {
    var searchValue = $(this).val();
    table.search(searchValue).draw();
});
});

</script>
<?php include('../includes/footer-bottom.php'); ?>