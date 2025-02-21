<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-tasks bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">
                    <?php if(has_permission('issues-add')) { ?>
                    <button data-modal="admin/issues/add" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Issue') ?></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <!-- Page Body start -->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">

                                <table id="DataTables-SS" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th><?= __('ID') ?></th>
                                            <th><?= __('Name') ?></th>
                                            <th><?= __('Status') ?></th>
                                            <th><?= __('Due Date') ?></th>
                                            <th><?= __('Assigned To') ?></th>
                                            <th><?= __('Priority') ?></th>
                                            <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>

                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>







<script type="text/javascript">
    $(document).ready(function() {


        $('#DataTables-SS').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedHeader": true,
            'autoWidth':false,
            "ajax": {
                "url": "<?= base_url(); ?>admin/issues/json_assigned",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "status" },
                { "data": "due_date" },
                { "data": "assigned_to" },
                { "data": "priority" },
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 0, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('issues-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('issues-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('issues-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('issues-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('issues-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('issues-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
