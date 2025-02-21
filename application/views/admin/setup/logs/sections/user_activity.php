<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-block">

                <div class="dt-responsive table-responsive">

                    <table id="DataTables-SS-Users" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('User') ?></th>
                                <th><?= __('Timestamp') ?></th>
                                <th><?= __('IP Address') ?></th>
                                <th><?= __('Activity') ?></th>
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

        $('#DataTables-SS-Users').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedHeader": true,
            "ajax": {
                "url": "<?= base_url(); ?>admin/setup/logs/json_all_users_activity",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },

            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "created_at" },
                { "data": "ip_address" },
                { "data": "description" },
            ],

            "initComplete": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip()
            },

            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip()
            },


        });



    });
</script>
