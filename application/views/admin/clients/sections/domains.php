<div class="row">
    <div class="col-lg-12">

        <div class="dt-responsive table-responsive">

            <table id="DataTables-SS" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Domain') ?></th>
                        <th><?= __('Expiry Date') ?></th>

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
                "url": "<?= base_url(); ?>admin/clients/json_domains/<?= $client['id'] ?>",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "domain" },
                { "data": "exp_date" },


                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 1, "asc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('domains-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('domains-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('domains-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                <?php if(!has_permission('domains-view')) { ?>$('.table .btn-primary').hide();$('.table .btn-inverse').hide();<?php } ?>
                <?php if(!has_permission('domains-edit')) { ?>$('.table .btn-success').hide();<?php } ?>
                <?php if(!has_permission('domains-delete')) { ?>$('.table .btn-danger').hide();<?php } ?>
            },


        });

    });
</script>
