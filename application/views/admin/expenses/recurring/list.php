<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-3">
                <div class="page-header-title">
                    <i class="fas fa-sign-in-alt bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-9">


                <div class="text-left">

                    <div class="row">


                        <div class="col-md-2">
                            <?= form_open(base_url('admin/expenses/recurring/set_filters')); ?>
                            <select class="form-control select2 text-left onchange-submit" name="filter_entity_id" required>
                                <option value=""><?= __('All Entities'); ?></option>
                                <?php foreach ($entities as $item) { ?>
                                    <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_entity_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>

                            <?= form_close(); ?>
                        </div>

                        <div class="col-md-2">
                            <?= form_open(base_url('admin/expenses/recurring/set_filters')); ?>
                            <select class="form-control select2 text-left onchange-submit" name="filter_supplier_id" required>
                                <option value=""><?= __('All Suppliers'); ?></option>
                                <?php foreach ($suppliers as $item) { ?>
                                    <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_supplier_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>

                            <?= form_close(); ?>
                        </div>

                        <div class="col-md-2">
                            <?= form_open(base_url('admin/expenses/recurring/set_filters')); ?>
                            <select class="form-control select2 text-left onchange-submit" name="filter_expense_category_id"  required>
                                <option value=""><?= __('All Categories'); ?></option>
                                <?php foreach ($expense_categories as $item) { ?>
                                    <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_expense_category_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>

                            <?= form_close(); ?>
                        </div>

                        <div class="col-md-3">
                            <?= form_open(base_url('admin/expenses/recurring/set_filters')); ?>
                            <select class="form-control select2 text-left onchange-submit" name="filter_project_id"  required>
                                <option value=""><?= __('All Projects'); ?></option>
                                <?php foreach ($projects as $item) { ?>
                                    <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_project_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>

                            <?= form_close(); ?>
                        </div>




                        <div class="col-md-3">
                            <?php if(has_permission('recurringexp-add')) { ?>
                                <button data-modal="admin/expenses/recurring/add" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Recurring Expense') ?></button>
                            <?php } ?>
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
                                            <th><?= __('Entity') ?></th>
                                            <th><?= __('Supplier') ?></th>
                                            <th><?= __('Category') ?></th>
                                            <th><?= __('Project') ?></th>
                                            <th><?= __('Frequency') ?></th>
                                            <th><?= __('Emissions') ?></th>
                                            <th><?= __('Next Date') ?></th>
                                            <th><?= __('Description') ?></th>
                                            <th><?= __('Total') ?></th>
                                            <th><?= __('Status') ?></th>
                                            <th><?= __('Attachment') ?></th>
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
                "url": "<?= base_url(); ?>admin/expenses/recurring/json_all",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "entity_name" },
                { "data": "supplier_name" },
                { "data": "category_name" },
                { "data": "project_name" },
                { "data": "frequency" },
                { "data": "emissions" },
                { "data": "next_date" },
                { "data": "description" },

                { "data": "total" },
                { "data": "status" },



                { "data": "file" },
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 4, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('recurringexp-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('recurringexp-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('recurringexp-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('recurringexp-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('recurringexp-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('recurringexp-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
