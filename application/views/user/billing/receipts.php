<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header-title">
                    <i class="fas fa-dollar-sign bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
               
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
                                            <th><?= __('Date') ?></th>
                                            <th><?= __('Method') ?></th>
                                            <th><?= __('Reference') ?></th>
                                        
                                            <th><?= __('Amount') ?></th>
                                 
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
                "url": "<?= base_url(); ?>billing//json_receipts",
                "type": "POST",
                data: function ( d ) {
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            "columns": [
                { "data": "date" },
                { "data": "paymentmethod_name" },
                { "data": "reference" },
            
                { "data": "amount" },
           
                { "data": "actions", 'searchable':false, 'orderable':false, 'className': 'text-right' },
            ],



            "order": [[ 0, "desc" ]],



        });

    });
</script>
