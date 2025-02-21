<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-4">
                <div class="page-header-title">
                    <i class="fas fa-retweet bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-8">

                <div class="text-left">
                        <div class="row">

                            <div class="col-md-3">
                                <?= form_open(base_url('admin/sales/recurring/set_filters')); ?>
                                <select class="form-control select2 text-left onchange-submit" name="recurring_status_filter" required>
                                    <option value=""><?= __('All States') ?></option>

                                    <option value="Draft" <?php if($this->session->recurring_status_filter == "Draft") echo "selected"; ?> ><?= __('Draft') ?></option>
                                    <option value="Active" <?php if($this->session->recurring_status_filter == "Active") echo "selected"; ?> ><?= __('Active') ?></option>
                                    <option value="Suspended" <?php if($this->session->recurring_status_filter == "Suspended") echo "selected"; ?> ><?= __('Suspended') ?></option>
                                    <option value="Canceled" <?php if($this->session->recurring_status_filter == "Canceled") echo "selected"; ?> ><?= __('Canceled') ?></option>


                                </select>

                                <?= form_close(); ?>
                            </div>


                            <div class="col-md-3">
                                <?= form_open(base_url('admin/sales/recurring/set_filters')); ?>
                                <select class="form-control select2 text-left onchange-submit" name="global_filter_entity" required>
                                    <option value=""><?= __('All Entities') ?></option>
                                    <?php foreach ($entities as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->global_filter_entity == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>

                                <?= form_close(); ?>
                            </div>

                            <div class="col-md-3">
                                <?= form_open(base_url('admin/sales/recurring/set_filters')); ?>
                                <select class="form-control select2 onchange-submit" name="data_filter_agent_id" required>
                                    <option value="0"><?= __('All Staff') ?></option>
                                    <?php foreach ($agents as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->data_filter_agent_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <?= form_close(); ?>
                            </div>


                            <div class="col-md-3">
                                <div class="text-right">
                                    <?php if(has_permission('recurring-add')) { ?>
                                    <a href="<?= base_url('admin/sales/recurring/add'); ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Recurrence') ?></a>
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
                                            <th><?= __('ID #') ?></th>
                                            <th><?= __('Entity') ?></th>
                                            <th><?= __('Client') ?></th>
                                            <th><?= __('Name') ?></th>
                                            <th><?= __('Type') ?></th>
                                            <th><?= __('Frequency') ?></th>
                                            <th><?= __('Emissions') ?></th>
                                            <th><?= __('Next Date') ?></th>
                                            <th><?= __('Status') ?></th>
                                            <th><?= __('Agent') ?></th>
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
                "url": "<?= base_url(); ?>admin/sales/recurring/json_all",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "entity_name" },
                { "data": "client_name" },
                { "data": "name" },
                { "data": "type" },
                { "data": "frequency" },
                { "data": "emissions" },
                { "data": "next_date" },
                { "data": "status" },
                { "data": "agent_name" },
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 0, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('recurring-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('recurring-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('recurring-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('recurring-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('recurring-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('recurring-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
