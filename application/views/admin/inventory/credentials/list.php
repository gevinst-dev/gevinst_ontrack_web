<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-asterisk bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">

                    <?php if(has_permission('credentials-add')) { ?>
                    <a href="<?= base_url('admin/inventory/credentials/import') ?>" class="btn btn-inverse btn-md waves-effect waves-light" ><?= __('Import') ?></a>
                    <button data-modal="admin/inventory/credentials/add" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Credential') ?></button>
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
                                            <th><?= __('Type') ?></th>
                                            <th><?= __('Username') ?></th>
                                            <th><?= __('Client') ?></th>
                                            <th><?= __('Asset') ?></th>
                                            <th><?= __('Project') ?></th>
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
            "ajax": {
                "url": "<?= base_url(); ?>admin/inventory/credentials/json_all",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "type" },
                { "data": "username" },
                { "data": "client_name" },
                { "data": "asset_name" },
                { "data": "project_name" },
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],

            <?php if($this->session->staff_language_rtl == '1') { ?>
                "language": {
                    "url": "<?= base_url()?>public/components/datatables/ar.json"
                },
            <?php } ?>
            
            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('credentials-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('credentials-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('credentials-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('credentials-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('credentials-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('credentials-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
