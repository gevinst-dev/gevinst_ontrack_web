<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-4">
                <div class="page-header-title">
                    <i class="fas fa-sign-out-alt bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>



            <div class="col-md-8">


                <div class="text-left">
                        <div class="row">

                            <div class="col-md-3">
                                <?= form_open(base_url('admin/sales/proformas/set_filters')); ?>
                                <select class="form-control select2 text-left onchange-submit" name="global_filter_entity" required>
                                    <option value=""><?= __("All entities") ?></option>
                                    <?php foreach ($entities as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->global_filter_entity == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>

                                <?= form_close(); ?>
                            </div>

                            <div class="col-md-3">
                                <?= form_open(base_url('admin/sales/proformas/set_filters')); ?>
                                <select class="form-control select2 onchange-submit" name="data_filter_agent_id" required>
                                    <option value="0"><?= __("All staff") ?></option>
                                    <?php foreach ($agents as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->data_filter_agent_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <?= form_close(); ?>
                            </div>
                            <div class="col-md-2">
                                <?= form_open(base_url('admin/sales/proformas/set_filters')); ?>
                                <input type="text" class="form-control onchange-submit" name="data_filter_start" id="datepicker" value="<?= date_display($_SESSION['data_filter_start']) ?>">
                                <?= form_close(); ?>
                            </div>
                            <div class="col-md-2">
                                <?= form_open(base_url('admin/sales/proformas/set_filters')); ?>
                                <input type="text" class="form-control onchange-submit" name="data_filter_end" id="datepicker2" value="<?= date_display($_SESSION['data_filter_end']) ?>">
                                <?= form_close(); ?>
                            </div>

                            <div class="col-md-2">
                                <div class="text-right">
                                    <?php if(has_permission('proformas-add')) { ?>
                                    <button data-modal="admin/sales/proformas/select_currency" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Proforma') ?></button>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
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
                                            <th><?= __('Invoice #') ?></th>
                                            <th><?= __('Entity') ?></th>
                                            <th><?= __('Client') ?></th>
                                            <th><?= __('Date') ?></th>
                                            <th><?= __('Due Date') ?></th>

                                            <th><?= __('Total') ?></th>
                                            <th><?= __('Unpaid') ?></th>
                                            <th><?= __('Status') ?></th>

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
            "iDisplayLength": 50,
            "ajax": {
                "url": "<?= base_url(); ?>admin/sales/proformas/json_all",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "entity_name" },
                { "data": "client_name" },
                { "data": "date" },
                { "data": "due_date" },

                { "data": "total" },
                { "data": "unpaid" },
                { "data": "status" },

                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 0, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('proformas-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('proformas-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('proformas-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('proformas-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('proformas-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('proformas-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
