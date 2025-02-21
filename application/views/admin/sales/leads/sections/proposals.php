<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="DataTables-SS" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th><?= __('Proposal #') ?></th>
                                <th><?= __('Entity') ?></th>

                                <th><?= __('Date') ?></th>
                                <th><?= __('Valid Until') ?></th>
                                <th><?= __('Total') ?></th>
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



<script type="text/javascript">
    $(document).ready(function() {


        $('#DataTables-SS').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedHeader": true,
            "iDisplayLength": 50,
            "ajax": {
                "url": "<?= base_url(); ?>admin/sales/leads/json_proposals/<?= $lead['id']; ?>",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "number" },
                { "data": "entity_name" },
            
                { "data": "date" },
                { "data": "valid_until" },
                { "data": "total" },
                { "data": "status" },
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 0, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('proposals-view')) { ?>$('.table .btn-primary').hide();<?php } ?>
                <?php if(!has_permission('proposals-view')) { ?>$('.table .btn-inverse').hide();<?php } ?>

                <?php if(!has_permission('proposals-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('proposals-add')) { ?>$('.table .btn-warning').hide();<?php } ?>

                <?php if(!has_permission('proposals-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('proposals-view')) { ?>$('.table .btn-primary').hide();<?php } ?>
                <?php if(!has_permission('proposals-view')) { ?>$('.table .btn-inverse').hide();<?php } ?>

                <?php if(!has_permission('proposals-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('proposals-add')) { ?>$('.table .btn-warning').hide();<?php } ?>

                <?php if(!has_permission('proposals-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
