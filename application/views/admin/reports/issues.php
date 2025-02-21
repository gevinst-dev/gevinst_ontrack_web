<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-4">
                <div class="page-header-title">
                    <i class="fas fa-chart-bar bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="text-left">
                    <?= form_open(base_url('admin/reports/index/set_filters')); ?>

                        <div class="row">



                            <div class="col-md-3">

                                <select class="form-control select2 onchange-submit" name="filter_client_id" required>
                                    <option value=""><?= __('- All Clients -') ?></option>
                                    <?php foreach ($clients as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_client_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>

                                <p>&nbsp;</p>
                            </div>

                            <div class="col-md-2">
                                <input type="text" class="form-control onchange-submit" name="filter_start" id="datepicker" value="<?= date_display($_SESSION['filter_start']) ?>">
                                <p>&nbsp;</p>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control onchange-submit" name="filter_end" id="datepicker2" value="<?= date_display($_SESSION['filter_end']) ?>">
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
                                    <h5><?= __('Issues by Status') ?></h5>

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
                                                    ['<?= __('Status') ?>', '<?= __('Issues') ?>'],
                                                    ['<?= __('To Do') ?>', <?= $todo_count; ?>],
                                                    ['<?= __('In Progress') ?>', <?= $inprogress_count; ?>],
                                                    ['<?= __('Done') ?>', <?= $done_count; ?>]

                                                ]);

                                                var options = {
                                 
                                                    chartArea: { width: '50%' },
                                                    isStacked: true,
                                                    hAxis: {
                                                        title: '<?= __('Issues') ?>',
                                                        minValue: 0,
                                                    },
                                                    vAxis: {
                                                        title: '<?= __('Status') ?>'
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
                                    <h5><?= __('Issues Priority Overview') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_Priority" class="g-chart-square"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            google.charts.load("current", { packages: ["corechart"] });
                                            google.charts.setOnLoadCallback(drawChartDonut);

                                            function drawChartDonut() {
                                                var dataDonut = google.visualization.arrayToDataTable([
                                                    ['<?= __('Priority') ?>', '<?= __('Issues') ?>'],
                                                    ['<?= __('Low') ?>', <?= $low_count; ?>],
                                                    ['<?= __('Normal') ?>', <?= $normal_count; ?>],
                                                    ['<?= __('High') ?>', <?= $high_count; ?>]
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


                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header">
                                    <h5><?= __('Issues by Type') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_bar_type" class="g-chart-square"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            //BAR CHART
                                            google.charts.load('current', { packages: ['corechart', 'bar'] });
                                            google.charts.setOnLoadCallback(drawStacked);

                                            function drawStacked() {
                                                var data = google.visualization.arrayToDataTable([
                                                    ['<?= __('Status') ?>', '<?= __('Issues') ?>'],
                                                    ['<?= __('Task') ?>', <?= $task_count; ?>],
                                                    ['<?= __('Maintenance') ?>', <?= $maintenance_count; ?>],
                                                    ['<?= __('Bug') ?>', <?= $bug_count; ?>],
                                                    ['<?= __('Improvement') ?>', <?= $improvement_count; ?>],
                                                    ['<?= __('New Feature') ?>', <?= $newfeature_count; ?>],
                                                    ['<?= __('Story') ?>', <?= $story_count; ?>],
                                                ]);


                                                var options = {
                                              
                                                    chartArea: { width: '50%' },
                                                    isStacked: true,
                                                    hAxis: {
                                                        title: '<?= __('Issues') ?>',
                                                        minValue: 0,
                                                    },
                                                    vAxis: {
                                                        title: '<?= __('Type') ?>'
                                                    },
                                      
                                                };
                                                var chart = new google.visualization.BarChart(document.getElementById('chart_bar_type'));
                                                chart.draw(data, options);
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
                                            <th><?= __('Type') ?></th>
                                            <th><?= __('Status') ?></th>
                                            <th><?= __('Priority') ?></th>
                                            <th><?= __('Due Date') ?></th>
                                            <th><?= __('Assigned To') ?></th>
                                            <th><?= __('Client') ?></th>
                                            <th><?= __('Asset') ?></th>
                                            <th><?= __('License') ?></th>
                                            <th><?= __('Project') ?></th>
                                            <th><?= __('Milestone') ?></th>

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
                                                <td><?= __($item['type']); ?></td>
                                                <td><?= __($item['status']); ?></td>
                                                <td><?= __($item['priority']); ?></td>
                                                <td data-sort="<?= $item['due_date']; ?>">
                                                    <?= date_display($item['due_date']); ?>
                                                </td>
                                                <td><?= get_staff_name($item['assigned_to']); ?></td>
                                                <td><?= get_client_name($item['client_id']); ?></td>


                                                <td><?= get_asset_name($item['asset_id']); ?></td>
                                                <td><?= get_license_name($item['license_id']); ?></td>

                                                <td><?= get_project_name($item['project_id']); ?></td>
                                                <td><?= get_milestone_name($item['milestone_id']); ?></td>



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
