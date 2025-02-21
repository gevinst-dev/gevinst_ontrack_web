<div class="row">
    <div class="col-lg-12">
        <div class="card">


            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="DataTables-SS" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Name') ?></th>

                        
                                <th><?= __('Assigned To') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Priority') ?></th>
                                <th><?= __('Due Date') ?></th>
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
                "url": "<?= base_url(); ?>inventory/json_asset_issues/<?= $asset['id'] ?>",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },


                { "data": "assigned_to" },
                { "data": "status" },
                { "data": "priority" },
                { "data": "due_date" },
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],
            "order": [[ 1, "desc" ]],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip()
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip()
            },


        });

    });
</script>
