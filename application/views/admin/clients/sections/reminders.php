<div class="row">
    <div class="col-lg-12">

        <div class="dt-responsive table-responsive">

            <table id="DataTables-SS" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Description') ?></th>
                        <th><?= __('Status') ?></th>
                        <th><?= __('Datetime') ?></th>
                        <th><?= __('Owner') ?></th>

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
                "url": "<?= base_url(); ?>admin/clients/json_reminders/<?= $client['id'] ?>",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "description" },
                { "data": "status" },
                { "data": "datetime" },
                { "data": "assigned_to" },

                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 0, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('reminders-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('reminders-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('reminders-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('reminders-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('reminders-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('reminders-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
