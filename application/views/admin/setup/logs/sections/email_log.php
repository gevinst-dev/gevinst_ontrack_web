<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-block">
                <div class="dt-responsive table-responsive">

                    <table id="DataTables-SS-Emails" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Email Address') ?></th>
                                <th><?= __('Subject') ?></th>
                                <th><?= __('Sent') ?></th>
                                <th><?= __('Timestamp') ?></th>
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




        $('#DataTables-SS-Emails').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedHeader": true,
            "ajax": {
                "url": "<?= base_url(); ?>admin/setup/logs/json_all_emails",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },

            "columns": [
                { "data": "id" },
                { "data": "email_address" },
                { "data": "subject" },
                { "data": "sent" },
                { "data": "created_at" },
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
