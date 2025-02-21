<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header-title">
                    <i class="fas fa-chart-bar bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-left">
                    <?= form_open(base_url('admin/reports/index/set_filters')); ?>

                        <div class="row">



                            <div class="col-md-6">

                                <select class="form-control select2 onchange-submit" name="filter_client_id" required>
                                    <option value=""><?= __('- All Clients -') ?></option>
                                    <?php foreach ($clients as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_client_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>

                                <p>&nbsp;</p>
                            </div>

                        </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">


                    <div class="row">
                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header">
                                    <h5><?= __('Assets by Category') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_bar" class="g-chart-default"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            //BAR CHART
                                            google.charts.load('current', { packages: ['corechart', 'bar'] });
                                            google.charts.setOnLoadCallback(drawStacked);

                                            function drawStacked() {
                                                var data = google.visualization.arrayToDataTable([
                                                    ['<?= __('Category') ?>', '<?= __('Assets') ?>'],

                                                    <?php foreach($asset_categories as $asset_category) { ?>
                                                        ['<?= $asset_category['name'] ?>', <?= $asset_category['count']; ?>],
                                                    <?php } ?>


                                                ]);

                                                var options = {
                                
                                                    chartArea: { width: '50%' },
                                                    isStacked: true,
                                                    hAxis: {
                                                        title: '<?= __('Assets') ?>',
                                                        minValue: 0,
                                                    },
                                                    vAxis: {
                                                        title: '<?= __('Category') ?>'
                                                    },
                                
                                                };
                                                var chart = new google.visualization.BarChart(document.getElementById('chart_bar'));
                                                chart.draw(data, options);
                                            }



                                        });
                                    </script>


                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header">
                                    <h5><?= __('Assets Status Overview') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_Priority" class="g-chart-square"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            google.charts.load("current", { packages: ["corechart"] });
                                            google.charts.setOnLoadCallback(drawChartDonut);

                                            function drawChartDonut() {
                                                var dataDonut = google.visualization.arrayToDataTable([
                                                    ['<?= __('Status') ?>', '<?= __('Assets') ?>'],

                                                    <?php foreach($status_labels as $status_label) { ?>
                                                        ['<?= $status_label['name'] ?>', <?= $status_label['count']; ?>],
                                                    <?php } ?>



                                                ]);

                                                var optionsDonut = {
                                                    pieHole: 0.4,
                                                };

                                                var chart = new google.visualization.PieChart(document.getElementById('chart_Priority'));
                                                chart.draw(dataDonut, optionsDonut);
                                            }

                                        });
                                    </script>


                                </div>
                            </div>

                        </div>



                    </div>


                    <div class="card">
                        <div class="card-block">



                            <div class="dt-responsive table-responsive">

                                <table id="DataTables" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th><?= __('ID') ?></th>

                                            <th><?= __('Name') ?></th>
                                            <th><?= __('Tag') ?></th>
                                            <th><?= __('Client') ?></th>

                                            <th><?= __('Category') ?></th>
                                            <th><?= __('Status') ?></th>
                                            <th><?= __('User') ?></th>
                                            <th><?= __('Location') ?></th>
                                            <th><?= __('Supplier') ?></th>
                                            <th><?= __('Manufacturer') ?></th>
                                            <th><?= __('Model') ?></th>
                                            <th><?= __('Purchase Date') ?></th>
                                            <th><?= __('Warranty Expiration') ?></th>
                                            <th><?= __('Serial Number') ?></th>

                                            <?php foreach ($customfields as $customfield) { ?>
                                                <th><?= __($customfield['name']); ?></th>
                                            <?php } ?>

                                            <th><?= __('Date Added') ?></th>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php foreach ($items as $item) { ?>
                                            <tr>

                                                <td><?= $item['id']; ?></td>

                                                <td><?= $item['name']; ?></td>
                                                <td><?= $item['tag']; ?></td>
                                                <td><?= get_client_name($item['client_id']); ?></td>

                                                <td><?= get_asset_category_name($item['category_id']); ?></td>
                                                <td><?= get_status_name($item['status_id']); ?></td>
                                                <td><?= get_user_name($item['user_id']); ?></td>
                                                <td><?= get_location_name($item['location_id']); ?></td>
                                                <td><?= get_supplier_name($item['supplier_id']); ?></td>
                                                <td><?= get_manufacturer_name($item['manufacturer_id']); ?></td>
                                                <td><?= get_model_name($item['model_id']); ?></td>
                                                <td><?= date_display($item['purchase_date']); ?></td>
                                                <td><?= date_display($item['warranty_end']); ?></td>
                                                <td><?= $item['serial_number']; ?></td>

                                                <?php foreach ($customfields as $customfield) { ?>
                                                    <td><?= extract_value($customfield['id'],$item['custom_fields_values']); ?></td>
                                                <?php } ?>

                                                <td data-sort="<?= $item['created_at']; ?>">
                                                    <?= datetime_display($item['created_at']); ?>
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
