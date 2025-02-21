<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-chart-bar bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">
                    <div class="row">




                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">




                    <div class="card">
                        <div class="card-block">



                            <div class="dt-responsive table-responsive">

                                <table id="DataTables" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th><?= __('Name') ?></th>
                                            <th><?= __('Users') ?></th>
                                            <th><?= __('Assets') ?></th>
                                            <th><?= __('Licenses') ?></th>
                                            <th><?= __('Domains') ?></th>
                                            <th><?= __('Credentials') ?></th>
                                            <th><?= __('Projects') ?></th>
                                            <th><?= __('Tickets') ?></th>
                                            <th><?= __('Issues') ?></th>
                                            <th><?= __('Reminders') ?></th>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php foreach ($items as $item) { ?>
                                            <tr>


                                                <td>
                                                    <?= $item['name']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("core_users")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_assets")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_licenses")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_domains")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_credentials")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_projects")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_tickets")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_issues")->count_all_results(); ?>
                                                </td>

                                                <td>
                                                    <?php echo $this->db->where('client_id', $item['id'])->from("app_reminders")->count_all_results(); ?>
                                                </td>



                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                    <tfoot>

                                    </tfoot>

                                </table>

                            </div>


                        </div>

                    </div>





                </div>
            </div>
        </div>
    </div>


</div>


<script type="text/javascript">
    $(document).ready(function() {

        $('#DataTables').DataTable({
            "processing": true,
            "stateSave": true,
            "fixedHeader": true,
  
            'autoWidth':false,

            <?php if($this->session->staff_language_rtl == '1') { ?>
                "language": {
                    "url": "<?= base_url()?>public/components/datatables/ar.json"
                },
            <?php } ?>

            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p><'dtbuttons'B>>",
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
            ]

        });

    });
</script>
