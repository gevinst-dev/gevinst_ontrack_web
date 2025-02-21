<div class="row">
    <div class="col-lg-12">

        <div class="dt-responsive table-responsive">

            <table id="DataTables-SS" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('Invoice #') ?></th>
                        <th><?= __('Entity') ?></th>

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


<script type="text/javascript">
    $(document).ready(function() {


        $('#DataTables-SS').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedHeader": true,
            "ajax": {
                "url": "<?= base_url(); ?>admin/clients/json_invoices/<?= $client['id'] ?>",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "entity_name" },

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
                <?php if(!has_permission('invoices-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('invoices-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('invoices-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('invoices-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('invoices-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('invoices-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
