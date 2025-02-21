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

                        <?php if (file_exists(FCPATH.'install')) { ?>
                            <div class="col-md-12">
                                <p class="alert alert-danger"><?= __('Please delete the install folder.') ?></p>
                            </div>
                        <?php } ?>


                        <!-- dashboard cards start -->
                        <?php if(has_permission('clients-view')) { ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-blue">
                                <div class="card-body">
                                    <div class="row align-items-center ">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __("Clients") ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= $clients_count ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users text-c-blue f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("admin/clients") ?>"><?= __("View All") ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(has_permission('assets-view')) { ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-green">
                                <div class="card-body">
                                    <div class="row align-items-center ">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __("Assets") ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= $assets_count ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-laptop text-c-green f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("admin/inventory/assets") ?>"><?= __("View All") ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>


                        <?php if(has_permission('licenses-view')) { ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-yellow">
                                <div class="card-body">
                                    <div class="row align-items-center ">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __("Licenses") ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= $licenses_count ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-certificate text-c-yellow f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("admin/inventory/licenses") ?>"><?= __("View All") ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>


                        <?php if(has_permission('projects-view')) { ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-red">
                                <div class="card-body">
                                    <div class="row align-items-center ">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?= __("Projects") ?></h6>
                                            <h3 class="m-b-0 f-w-700 text-white"><?= $projects_count ?></h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-rocket text-c-red f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0"><a class="text-white" href="<?= base_url("admin/projects") ?>"><?= __("View All") ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <!-- dashboard cards end -->



                    </div>

                    <?php if(has_permission('invoices-view') && has_permission('expenses-view')) { ?>
                    <?php if($staff['d_finance_overview'] == 1) { ?>
                    <div class="row">

                        <div class="col-xl-12 ">

                            <div class="card product-progress-card">
                                <div class="card-header">
                                    <h5><?= __('Finance Overview') ?></h5>
                                </div>
                                <div class="card-block">
                                    <div class="row pp-main">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                            <div class="row align-items-center m-b-20">
                                            <div class="col-md-1">
                                                <i class="fas fa-dollar-sign f-24 text-mute"></i>
                                            </div>
                                            <div class="col-md-10 text-right">
                                                <h3 class="m-b-0 text-c-blue" title="<?= __('Last month') ?> <?= format_currency($last_month_sales, get_setting('default_currency'));  ?>"><?= format_currency($this_month_sales, get_setting('default_currency'));  ?></h3>
                                            </div>
                                            </div>
                                            <div class="row align-items-center m-b-15">
                                            <div class="col-auto">
                                            <p class="m-b-0 f-12"><?= __('Sales this month') ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="<?= __('Compared to last month.') ?>"></i></p>
                                            </div>
                                            <div class="col text-right">
                                                <?php if($monthly_increase > 0) { ?>
                                                    <p class="m-b-0 text-c-green f-12"><i class="fas fa-long-arrow-alt-up m-r-10"></i><?= $monthly_increase ?>%</p>
                                                <?php } else { ?>
                                                    <p class="m-b-0 text-c-red f-12"><i class="fas fa-long-arrow-alt-down m-r-10"></i><?= $monthly_increase ?>%</p>
                                                <?php } ?>
                                            </div>
                                            </div>
                                            <div class="progress">
                                            <div class="progress-bar bg-c-blue" style="width:<?= $monthly_increase ?>%"></div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                            <div class="row align-items-center m-b-20">
                                            <div class="col-md-1">
                                                <i class="fas fa-dollar-sign f-24 text-mute"></i>
                                            </div>
                                            <div class="col-md-10 text-right">
                                                <h3 class="m-b-0 text-c-green" title="<?= __('Last year') ?> <?= format_currency($last_year_sales, get_setting('default_currency'));  ?>"><?= format_currency($this_year_sales, get_setting('default_currency'));  ?></h3>
                                            </div>
                                            </div>
                                            <div class="row align-items-center m-b-15">
                                            <div class="col-auto">
                                                <p class="m-b-0 f-12"><?= __('Sales this year') ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="<?= __('Compared to last year.') ?>"></i></p>
                                            </div>
                                            <div class="col text-right">

                                                <?php if($yearly_increase > 0) { ?>
                                                    <p class="m-b-0 text-c-green f-12"><i class="fas fa-long-arrow-alt-up m-r-10"></i><?= $yearly_increase ?>%</p>
                                                <?php } else { ?>
                                                    <p class="m-b-0 text-c-red f-12"><i class="fas fa-long-arrow-alt-down m-r-10"></i><?= $yearly_increase ?>%</p>
                                                <?php } ?>

                                            </div>
                                            </div>
                                            <div class="progress">
                                            <div class="progress-bar bg-c-red" style="width:<?= $yearly_increase ?>%"></div>
                                            </div>
                                            </div>
                                        </div>





                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                            <div class="row align-items-center m-b-20">
                                            <div class="col-md-1">
                                            <i class="fas fa-dollar-sign f-24 text-mute"></i>
                                            </div>
                                            <div class="col-md-10 text-right">
                                                <h3 class="m-b-0 text-c-yellow" title="<?= __('Last month') ?> <?= format_currency($last_month_expenses, get_setting('default_currency'));  ?>"><?= format_currency($this_month_expenses, get_setting('default_currency'));  ?></h3>
                                            </div>
                                            </div>
                                            <div class="row align-items-center m-b-15">
                                            <div class="col-auto">
                                                <p class="m-b-0 f-12"><?= __('Expenses this month') ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="<?= __('Compared to last month.') ?>"></i></p>
                                            </div>
                                            <div class="col text-right">
                                                <?php if($monthly_increase_exp > 0) { ?>
                                                    <p class="m-b-0 text-c-red f-12"><i class="fas fa-long-arrow-alt-up m-r-10"></i><?= $monthly_increase_exp ?>%</p>
                                                <?php } else { ?>
                                                    <p class="m-b-0 text-c-green f-12"><i class="fas fa-long-arrow-alt-down m-r-10"></i><?= $monthly_increase_exp ?>%</p>
                                                <?php } ?>
                                            </div>
                                            </div>
                                            <div class="progress">
                                            <div class="progress-bar bg-c-blue" style="width:<?= $monthly_increase_exp ?>%"></div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="pp-cont">
                                            <div class="row align-items-center m-b-20">
                                            <div class="col-md-1">
                                                <i class="fas fa-dollar-sign f-24 text-mute"></i>
                                            </div>
                                            <div class="col-md-10 text-right">
                                                <h3 class="m-b-0 text-c-red" title="<?= __('Last year') ?> <?= format_currency($last_year_expenses, get_setting('default_currency'));  ?>"><?= format_currency($this_year_expenses, get_setting('default_currency'));  ?></h3>
                                            </div>
                                            </div>
                                            <div class="row align-items-center m-b-15">
                                            <div class="col-auto">
                                                <p class="m-b-0 f-12"><?= __('Expenses this year') ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="<?= __('Compared to last year.') ?>"></i></p>
                                            </div>
                                            <div class="col text-right">

                                                <?php if($yearly_increase_exp > 0) { ?>
                                                    <p class="m-b-0 text-c-red f-12"><i class="fas fa-long-arrow-alt-up m-r-10"></i><?= $yearly_increase_exp ?>%</p>
                                                <?php } else { ?>
                                                    <p class="m-b-0 text-c-green f-12"><i class="fas fa-long-arrow-alt-down m-r-10"></i><?= $yearly_increase_exp ?>%</p>
                                                <?php } ?>

                                            </div>
                                            </div>
                                            <div class="progress">
                                            <div class="progress-bar bg-c-red" style="width:<?= $yearly_increase_exp ?>%"></div>
                                            </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <?php } ?>
                    <?php } ?>




                    <div class="row">


                        <?php if(has_permission('invoices-view') && has_permission('expenses-view')) { ?>
                        <?php if($staff['d_monthly_financials'] == 1) { ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?= __('Monthly Financials') ?></h5>

                                </div>
                                <div class="card-block">
                                    <div id="chart_bar_last" class="g-chart-square"></div>


                                    <script type="text/javascript">
                                        $(document).ready(function() {


                                            //BAR CHART
                                            google.charts.load('current', { packages: ['corechart', 'bar'] });
                                            google.charts.setOnLoadCallback(drawMultSeries);

                                            function drawMultSeries() {

                                                var data = new google.visualization.DataTable();

                                                data.addColumn('string', 's');
                                                data.addColumn('number', '<?= __('Sales') ?>');
                                                data.addColumn('number', '<?= __('Expenses') ?>');
                                                data.addColumn('number', '<?= __('Collections') ?>');

                                                data.addRows([
                                                    ['<?= $t_12; ?>', <?= sales_between($first_12, $last_12, 0); ?>, <?= expenses_between($first_12, $last_12, 0); ?>, <?= collections_between($first_12, $last_12, 0); ?>],
                                                    ['<?= $t_11; ?>', <?= sales_between($first_11, $last_11, 0); ?>, <?= expenses_between($first_11, $last_11, 0); ?>, <?= collections_between($first_11, $last_11, 0); ?>],
                                                    ['<?= $t_10; ?>', <?= sales_between($first_10, $last_10, 0); ?>, <?= expenses_between($first_10, $last_10, 0); ?>, <?= collections_between($first_10, $last_10, 0); ?>],
                                                    ['<?= $t_09; ?>', <?= sales_between($first_09, $last_09, 0); ?>, <?= expenses_between($first_09, $last_09, 0); ?>, <?= collections_between($first_09, $last_09, 0); ?>],
                                                    ['<?= $t_08; ?>', <?= sales_between($first_08, $last_08, 0); ?>, <?= expenses_between($first_08, $last_08, 0); ?>, <?= collections_between($first_08, $last_08, 0); ?>],
                                                    ['<?= $t_07; ?>', <?= sales_between($first_07, $last_07, 0); ?>, <?= expenses_between($first_07, $last_07, 0); ?>, <?= collections_between($first_07, $last_07, 0); ?>],
                                                    ['<?= $t_06; ?>', <?= sales_between($first_06, $last_06, 0); ?>, <?= expenses_between($first_06, $last_06, 0); ?>, <?= collections_between($first_06, $last_06, 0); ?>],
                                                    ['<?= $t_05; ?>', <?= sales_between($first_05, $last_05, 0); ?>, <?= expenses_between($first_05, $last_05, 0); ?>, <?= collections_between($first_05, $last_05, 0); ?>],
                                                    ['<?= $t_04; ?>', <?= sales_between($first_04, $last_04, 0); ?>, <?= expenses_between($first_04, $last_04, 0); ?>, <?= collections_between($first_04, $last_04, 0); ?>],
                                                    ['<?= $t_03; ?>', <?= sales_between($first_03, $last_03, 0); ?>, <?= expenses_between($first_03, $last_03, 0); ?>, <?= collections_between($first_03, $last_03, 0); ?>],
                                                    ['<?= $t_02; ?>', <?= sales_between($first_02, $last_02, 0); ?>, <?= expenses_between($first_02, $last_02, 0); ?>, <?= collections_between($first_02, $last_02, 0); ?>],
                                                    ['<?= $t_01; ?>', <?= sales_between($first_01, $last_01, 0); ?>, <?= expenses_between($first_01, $last_01, 0); ?>, <?= collections_between($first_01, $last_01, 0); ?>],
                                                    ['<?= $t_00; ?>', <?= sales_between($first_00, $last_00, 0); ?>, <?= expenses_between($first_00, $last_00, 0); ?>, <?= collections_between($first_00, $last_00, 0); ?>],
                                                ]);

                                                var options = {
                                                  hAxis: {
                               
                                                  },
                                                  vAxis: {
                                             
                                                    minValue: 0,
                                                  }
                                                };

                                                var chart = new google.visualization.ColumnChart(document.getElementById('chart_bar_last'));
                                                chart.draw(data, options);
                                            }



                                        });
                                    </script>


                                </div>
                            </div>

                        </div>
                        <?php } ?>
                        <?php } ?>


                        <?php if(has_permission('assets-view')) { ?>
                        <?php if($staff['d_assets_category'] == 1) { ?>
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
                                                        ['<?= $asset_category['name'] ?>', <?= $this->db->where('category_id', $asset_category['id'])->from("app_assets")->count_all_results() ?>],
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
                        <?php } ?>



                        <?php if(has_permission('assets-view')) { ?>
                        <?php if($staff['d_assets_status'] == 1) { ?>
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
                                                        ['<?= $status_label['name'] ?>', <?= $this->db->where('status_id', $status_label['id'])->from("app_assets")->count_all_results() ?>],
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
                        <?php } ?>


                        <?php if(has_permission('licenses-view')) { ?>
                        <?php if($staff['d_license_category'] == 1) { ?>
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
                                                        ['<?= $license_category['name'] ?>', <?= $this->db->where('category_id', $license_category['id'])->from("app_licenses")->count_all_results() ?>],
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
                        <?php } ?>

                            

                        <?php if(has_permission('licenses-view')) { ?>
                        <?php if($staff['d_license_status'] == 1) { ?>
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
                                                        ['<?= $status_label['name'] ?>', <?= $this->db->where('status_id', $status_label['id'])->from("app_licenses")->count_all_results() ?>],
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
                        <?php } ?>


                        <?php if(has_permission('assets-view')) { ?>
                        <?php if($staff['d_recent_assets'] == 1) { ?>
                        <div class="col-md-4">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Recent Assets') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($recent_assets)) { ?>
                                        <p class="alert alert-info"><?= __('You have no recent assets.') ?></p>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>
                                                    <th><?= __('Tag') ?></th>
                                                    <th><?= __('Name') ?></th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($recent_assets as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['tag'] ?></td>
                                                        <td><?= $item['name'] ?></td>
                                                        <td class="text-right">
                                                            <div class="btn-group" role="group">
                                                                <a href="<?= base_url('admin/inventory/assets/details/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Asset') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
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
                        <?php } ?>


                        <?php if(has_permission('licenses-view')) { ?>
                        <?php if($staff['d_recent_licenses'] == 1) { ?>
                        <div class="col-md-4">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Recent Licenses') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($recent_licenses)) { ?>
                                        <p class="alert alert-info"><?= __('You have no recent licenses.') ?></p>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>
                                                    <th><?= __('Tag') ?></th>
                                                    <th><?= __('Name') ?></th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($recent_licenses as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['tag'] ?></td>
                                                        <td><?= $item['name'] ?></td>
                                                        <td class="text-right">
                                                            <div class="btn-group" role="group">
                                                                <a href="<?= base_url('admin/inventory/licenses/details/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Asset') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
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
                        <?php } ?>


                        <?php if(has_permission('projects-view')) { ?>
                        <?php if($staff['d_recent_projects'] == 1) { ?>
                        <div class="col-md-4">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Recent Projects') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($recent_projects)) { ?>
                                        <p class="alert alert-info"><?= __('You have no recent projects.') ?></p>
                                    <?php } else { ?>
                                        <div class="table-responsive">

                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>

                                                    <th><?= __('Name') ?></th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($recent_projects as $item) { ?>
                                                    <tr>

                                                        <td><?= $item['name'] ?></td>
                                                        <td class="text-right">
                                                            <div class="btn-group" role="group">
                                                                <a href="<?= base_url('admin/projects/details/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Asset') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
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
                        <?php } ?>


                        <?php if(has_permission('tickets-view')) { ?>
                        <?php if($staff['d_assigned_tickets'] == 1) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Assigned Tickets') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($assigned_tickets)) { ?>
                                        <p class="alert alert-info"><?= __('You have no assigned tickets.') ?></p>
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
                                                <?php foreach($assigned_tickets as $item) { ?>
                                                    <tr>
                                                        <td>#<?= $item['ticket'] ?></td>
                                                        <td><?= $item['subject'] ?></td>
                                                        <td class="text-right">
                                                            <div class="btn-group" role="group">
                                                                <a href="<?= base_url('admin/tickets/view/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Ticket') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
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
                        <?php } ?>


                        <?php if(has_permission('issues-view')) { ?>
                        <?php if($staff['d_assigned_issues'] == 1) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Assigned Issues') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($assigned_issues)) { ?>
                                        <p class="alert alert-info"><?= __('You have no assigned issues.') ?></p>
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
                                                <?php foreach($assigned_issues as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['name'] ?></td>
                                                        <td><?= date_display($item['due_date']) ?></td>
                                                        <td class="text-right">
                                                            <div class="btn-group" role="group">
                                                                <a href="<?= base_url('admin/issues/view/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Task') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
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
                        <?php } ?>


                        <?php if(has_permission('reminders-view')) { ?>
                        <?php if($staff['d_upcoming_reminders'] == 1) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Upcoming Reminders') ?></h5>

                                    <div class="card-header-right">

                                        <div class="btn-group" role="group" >
                                            <a href="<?= base_url('admin/reminders') ?>" class="btn btn-inverse btn-mini waves-effect waves-dark"><?= __('View All') ?></a>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-block">
                                    <?php if(empty($upcoming_reminders)) { ?>
                                        <p class="alert alert-info"><?= __('You have no upcoming reminders.') ?></p>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>
                                                    <th><?= __('Reminder') ?></th>
                                                    <th><?= __('Date') ?></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($upcoming_reminders as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['description'] ?></td>
                                                        <td><?= datetime_display($item['datetime']) ?></td>
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
                        <?php } ?>


                        <?php if(has_permission('calendar-view')) { ?>
                        <?php if($staff['d_upcoming_events'] == 1) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card card-min-height">
                                <div class="card-header">
                                    <h5><?= __('Upcoming Events') ?></h5>

                                    <div class="card-header-right">

                                        <div class="btn-group" role="group" >
                                            <a href="<?= base_url('admin/calendar') ?>" class="btn btn-inverse btn-mini waves-effect waves-dark"><?= __('View Calendar') ?></a>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-block">
                                    <?php if(empty($upcoming_events)) { ?>
                                        <p class="alert alert-info"><?= __('You have no upcoming events.') ?></p>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>
                                                    <th><?= __('Name') ?></th>
                                                    <th><?= __('Date') ?></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($upcoming_events as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['title'] ?></td>
                                                        <td><?= datetime_display($item['start_date']) ?></td>
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
                        <?php } ?>


                        <?php if(has_permission('proposals-view')) { ?>
                        <?php if($staff['d_sent_proposals'] == 1) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card">
                                <div class="card-header">
                                    <h5><?= __('Sent Proposals') ?></h5>
                                </div>
                                <div class="card-block">
                                    <?php if(empty($sent_proposals)) { ?>
                                        <p class="alert alert-info"><?= __('You have no sent proposals.') ?></p>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>
                                                    <th><?= __('#') ?></th>
                                                    <th><?= __('Client') ?></th>
                                                    <th><?= __('Date') ?></th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($sent_proposals as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['number'] ?></td>
                                                        <td><?= get_client_name($item['client_id'])  ?></td>
                                                        <td><?= date_display($item['date']) ?></td>
                                                        <td class="text-right">
                                                            <div class="btn-group" role="group">
                                                                <?php if(has_permission('proposals-edit')) { ?>
                                                                <a href="<?= base_url('admin/sales/proposals/edit/'.$item['id']) ?>" data-toggle="tooltip" title="<?= __('View Proposal') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>
                                                                <?php } ?>
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
                        <?php } ?>



                        <?php if($staff['d_exchange_rates'] == 1) { ?>
                        <div class="col-md-6">
                            <div class="card sale-card">
                                <div class="card-header">
                                    <h5><?= __('Exchange Rates') ?></h5>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead>
                                                <tr>
                                                    <th><?= __('Currency') ?></th>
                                                    <th><?= __('Rate') ?></th>

                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php foreach($currencies as $item) { if($item['id'] == get_setting('default_currency')) continue; ?>

                                                    <tr>
                                                        <td><?= $item['code']; ?></td>
                                                        <td><?= $item['rate']; ?></td>
                                                    </tr>

                                                <?php } ?>

                   

                                            </tbody>
                                        </table>
                                    </div>

                                        <p class=""><?= __('Last sync') ?> <b><?= exrate_latest_date_formated(); ?></b></p>

                                </div>
                            </div>
                        </div>
                        <?php } ?>


                        <div class="col-md-12 text-right">
                            <a href="<?= base_url('admin/profile'); ?>"><?= __('Edit widgets') ?></a>
                        </div>


                    </div>





                    <div class="row">



                    </div>
                    <!-- [ page content ] ends -->
                </div>
            </div>
        </div>
    </div>


</div>
