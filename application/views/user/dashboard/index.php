<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">


                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="row">

                        <?php if(user_has_permission('invoices')) { ?>
                        <!-- dashboard cards start -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-red">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __('Unpaid Invoices') ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= format_currency($unpaid_invoices, get_setting('default_currency')); ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-coins text-c-red f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("billing/invoices") ?>"><?= __('View invoices') ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(user_has_permission('assets')) { ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-blue">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __('Assets') ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= $assets_count ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-laptop text-c-blue f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("inventory/assets") ?>"><?= __('View all') ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(user_has_permission('licenses')) { ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-green">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __('Licenses') ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= $licenses_count ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-certificate text-c-green f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("inventory/licenses") ?>"><?= __('View all') ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(user_has_permission('projects')) { ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-yellow">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __('Projects') ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= $projects_count ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-rocket text-c-yellow f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("projects") ?>"><?= __('View all') ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>


                        <!-- dashboard cards end -->





                    </div>
                    <!-- [ page content ] ends -->


                    <div class="row">

                        <?php if(user_has_permission('tickets')) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Ongoing Tickets') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($ongoing_tickets)) { ?>
                                        <p class="alert alert-info"><?= __('There are no ongoing tickets.') ?></p>
                                    <?php } else { ?>

                                        <div class="table-responsive">
                                            <table class="table table-hover m-b-0">
                                                <thead>
                                                    <tr>
                                                        <th><?= __('Ticket') ?></th>
                                                        <th><?= __('Subject') ?></th>
                                                        <th class="text-right"></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php foreach($ongoing_tickets as $item) { ?>
                                                        <tr>
                                                            <td>#<?= $item['ticket'] ?></td>
                                                            <td><?= $item['subject'] ?></td>
                                                            <td class="text-right">
                                                                <div class="btn-group" role="group">
                                                                    <a href="<?= base_url('tickets/view/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Ticket') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>


                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>


                        <?php if(user_has_permission('issues')) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Ongoing Issues') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($ongoing_issues)) { ?>
                                        <p class="alert alert-info"><?= __('There are no ongoing issues.') ?></p>
                                    <?php } else { ?>

                                        <div class="table-responsive">

                                            <table class="table table-hover m-b-0">
                                                <thead>
                                                    <tr>
                                                        <th><?= __('Name') ?></th>
                                                        <th><?= __('Due Date') ?></th>
                                                        <th class="text-right"></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php foreach($ongoing_issues as $item) { ?>
                                                        <tr>
                                                            <td><?= $item['name'] ?></td>
                                                            <td><?= date_display($item['due_date']) ?></td>
                                                            <td class="text-right">
                                                                <div class="btn-group" role="group">
                                                                    <a href="<?= base_url('issues/view/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Task') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>


                        
                        <?php if(user_has_permission('assets')) { ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?= __('Assets by Category') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_bar" class="g-chart-square"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            //BAR CHART
                                            google.charts.load('current', { packages: ['corechart', 'bar'] });
                                            google.charts.setOnLoadCallback(drawStacked);

                                            function drawStacked() {
                                                var data = google.visualization.arrayToDataTable([
                                                    ['<?= __('Category') ?>', '<?= __('Assets') ?>'],

                                                    <?php foreach($asset_categories as $asset_category) { ?>
                                                        ['<?= $asset_category['name'] ?>', <?= $this->db->where('category_id', $asset_category['id'])->where('client_id', $this->session->client_id)->from("app_assets")->count_all_results() ?>],
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
                        <?php } ?>
                 

                        <?php if(user_has_permission('assets')) { ?>
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
                                                        ['<?= $status_label['name'] ?>', <?= $this->db->where('status_id', $status_label['id'])->where('client_id', $this->session->client_id)->from("app_assets")->count_all_results() ?>],
                                                    <?php } ?>



                                                ]);

                                                var optionsDonut = {
                     
                                                    pieHole: 0.4,
                                                    colors: ['#448aff', '#11c15b', '#ffe100', '#FE8A7D', '#ff5252']
                                                };

                                                var chart = new google.visualization.PieChart(document.getElementById('chart_Priority'));
                                                chart.draw(dataDonut, optionsDonut);
                                            }

                                        });
                                    </script>


                                </div>
                            </div>

                        </div>
                        <?php } ?>
                
                        <?php if(user_has_permission('licenses')) { ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?= __('Licenses by Category') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_bar_licenses" class="g-chart-square"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            //BAR CHART
                                            google.charts.load('current', { packages: ['corechart', 'bar'] });
                                            google.charts.setOnLoadCallback(drawStacked);

                                            function drawStacked() {
                                                var data = google.visualization.arrayToDataTable([
                                                    ['<?= __('Category') ?>', '<?= __('Licenses') ?>'],

                                                    <?php foreach($license_categories as $license_category) { ?>
                                                        ['<?= $license_category['name'] ?>', <?= $this->db->where('category_id', $license_category['id'])->where('client_id', $this->session->client_id)->from("app_licenses")->count_all_results() ?>],
                                                    <?php } ?>



                                                ]);

                                                var options = {

                                                    chartArea: { width: '50%' },
                                                    isStacked: true,
                                                    hAxis: {
                                                        title: '<?= __('Licenses') ?>',
                                                        minValue: 0,
                                                    },
                                                    vAxis: {
                                                        title: '<?= __('Category') ?>'
                                                    },
                                                    colors: ['#11c15b']
                                                };
                                                var chart = new google.visualization.BarChart(document.getElementById('chart_bar_licenses'));
                                                chart.draw(data, options);
                                            }



                                        });
                                    </script>


                                </div>
                            </div>

                        </div>
                        <?php } ?>
                       

                        <?php if(user_has_permission('licenses')) { ?>
                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header">
                                    <h5><?= __('Licenses Status Overview') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_LicStat" class="g-chart-square"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            google.charts.load("current", { packages: ["corechart"] });
                                            google.charts.setOnLoadCallback(drawChartDonut);

                                            function drawChartDonut() {
                                                var dataDonut = google.visualization.arrayToDataTable([
                                                    ['<?= __('Licenses') ?>', '<?= __('Assets') ?>'],

                                                    <?php foreach($status_labels as $status_label) { ?>
                                                        ['<?= $status_label['name'] ?>', <?= $this->db->where('status_id', $status_label['id'])->where('client_id', $this->session->client_id)->from("app_licenses")->count_all_results() ?>],
                                                    <?php } ?>



                                                ]);

                                                var optionsDonut = {
                           
                                                    pieHole: 0.4,
                                                    colors: ['#448aff', '#11c15b', '#ffe100', '#FE8A7D', '#ff5252']
                                                };

                                                var chart = new google.visualization.PieChart(document.getElementById('chart_LicStat'));
                                                chart.draw(dataDonut, optionsDonut);
                                            }

                                        });
                                    </script>


                                </div>
                            </div>

                        </div>
                        <?php } ?>
                   


                        <div class="col-md-6">

                        </div>


                        <div class="col-md-6">

                        </div>

                    </div>





                </div>
            </div>
        </div>
    </div>


</div>
