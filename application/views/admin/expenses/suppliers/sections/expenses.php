<div class="row">
    <div class="col-lg-12">
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
                                <th><?= __('Date') ?></th>
                                <th><?= __('Description') ?></th>
                                <th><?= __('Total') ?></th>

                                <th><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {


        $('#DataTables-SS').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedHeader": true,
            "ajax": {
                "url": "<?= base_url(); ?>admin/expenses/suppliers/json_expenses/<?= $supplier['id'] ?>",
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
                { "data": "date" },
                { "data": "description" },

                { "data": "total" },

                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 3, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('expenses-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('expenses-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('expenses-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('expenses-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('expenses-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('expenses-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
