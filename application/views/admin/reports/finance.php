<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-title">
                    <i class="fas fa-chart-bar bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12 m-t-20">

                <div class="text-left">
                    <?= form_open(base_url('admin/reports/index/set_filters')); ?>

                        <div class="row">


                        <div class="col-md-4">
                                <input type="text" class="form-control onchange-submit" name="filter_start" id="datepicker" value="<?= date_display($_SESSION['filter_start']) ?>">
                                <p>&nbsp;</p>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control onchange-submit" name="filter_end" id="datepicker2" value="<?= date_display($_SESSION['filter_end']) ?>" >
                                <p>&nbsp;</p>
                            </div>
                            
                       

                            <div class="col-md-4">

                                <select class="form-control select2 onchange-submit" name="filter_entity_id" required>
                                    <option value=""><?= __('- All Entities -') ?></option>
                                    <?php foreach ($entities as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_entity_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
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


                        <div class="col-md-4">
                            <div class="card">

                                <div class="card-header">
                                    <h5><?= __('Sales'); ?></h5>
                                </div>

                                <div class="card-block">



                                    <div class="dt-responsive table-responsive">

                                        <table id="DataTablesXXXX" class="table table-striped table-bordered nowrap">


                                            <tbody>

                                                <tr>
                                                    <th><?= __('Today'); ?></th>
                                                    <td><?= format_currency($sales_today, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('Yesterday'); ?></th>
                                                    <td><?= format_currency($sales_yesterday, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Week'); ?></th>
                                                    <td><?= format_currency($sales_this_week, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Month'); ?></th>
                                                    <td><?= format_currency($sales_this_month, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Year'); ?></th>
                                                    <td><?= format_currency($sales_this_year, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>



                                                <tr>
                                                    <th><?= __('Selected Range'); ?></th>
                                                    <td><?= format_currency($sales_custom, $default_currency) ?></td>
                                                </tr>

                                            </tbody>



                                        </table>

                                    </div>


                                </div>

                            </div>

                        </div>




                        <div class="col-md-4">
                            <div class="card">

                                <div class="card-header">
                                    <h5><?= __('Expenses'); ?></h5>
                                </div>

                                <div class="card-block">



                                    <div class="dt-responsive table-responsive">

                                        <table id="DataTablesXXXX" class="table table-striped table-bordered nowrap">


                                            <tbody>

                                                <tr>
                                                    <th><?= __('Today'); ?></th>
                                                    <td><?= format_currency($expenses_today, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('Yesterday'); ?></th>
                                                    <td><?= format_currency($expenses_yesterday, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Week'); ?></th>
                                                    <td><?= format_currency($expenses_this_week, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Month'); ?></th>
                                                    <td><?= format_currency($expenses_this_month, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Year'); ?></th>
                                                    <td><?= format_currency($expenses_this_year, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>



                                                <tr>
                                                    <th><?= __('Selected Range'); ?></th>
                                                    <td><?= format_currency($expenses_custom, $default_currency) ?></td>
                                                </tr>

                                            </tbody>



                                        </table>

                                    </div>


                                </div>

                            </div>

                        </div>




                        <div class="col-md-4">
                            <div class="card">

                                <div class="card-header">
                                    <h5><?= __('Profit'); ?></h5>
                                </div>

                                <div class="card-block">



                                    <div class="dt-responsive table-responsive">

                                        <table id="DataTablesXXXX" class="table table-striped table-bordered nowrap">


                                            <tbody>

                                                <tr>
                                                    <th><?= __('Today'); ?></th>
                                                    <td><?= format_currency($sales_today - $expenses_today, $default_currency)  ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('Yesterday'); ?></th>
                                                    <td><?= format_currency($sales_yesterday - $expenses_yesterday, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Week'); ?></th>
                                                    <td><?= format_currency($sales_this_week - $expenses_this_week, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Month'); ?></th>
                                                    <td><?= format_currency($sales_this_month - $expenses_this_month, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th><?= __('This Year'); ?></th>
                                                    <td><?= format_currency($sales_this_year - $expenses_this_year, $default_currency) ?></td>
                                                </tr>

                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>



                                                <tr>
                                                    <th><?= __('Selected Range'); ?></th>
                                                    <td><?= format_currency($sales_custom - $expenses_custom, $default_currency) ?></td>
                                                </tr>

                                            </tbody>



                                        </table>

                                    </div>


                                </div>

                            </div>

                        </div>


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
                                                    ['<?= $t_12; ?>', <?= sales_between($first_12, $last_12, 0, $entity_id); ?>, <?= expenses_between($first_12, $last_12, 0, $entity_id); ?>, <?= collections_between($first_12, $last_12, $entity_id); ?>],
                                                    ['<?= $t_11; ?>', <?= sales_between($first_11, $last_11, 0, $entity_id); ?>, <?= expenses_between($first_11, $last_11, 0, $entity_id); ?>, <?= collections_between($first_11, $last_11, $entity_id); ?>],
                                                    ['<?= $t_10; ?>', <?= sales_between($first_10, $last_10, 0, $entity_id); ?>, <?= expenses_between($first_10, $last_10, 0, $entity_id); ?>, <?= collections_between($first_10, $last_10, $entity_id); ?>],
                                                    ['<?= $t_09; ?>', <?= sales_between($first_09, $last_09, 0, $entity_id); ?>, <?= expenses_between($first_09, $last_09, 0, $entity_id); ?>, <?= collections_between($first_09, $last_09, $entity_id); ?>],
                                                    ['<?= $t_08; ?>', <?= sales_between($first_08, $last_08, 0, $entity_id); ?>, <?= expenses_between($first_08, $last_08, 0, $entity_id); ?>, <?= collections_between($first_08, $last_08, $entity_id); ?>],
                                                    ['<?= $t_07; ?>', <?= sales_between($first_07, $last_07, 0, $entity_id); ?>, <?= expenses_between($first_07, $last_07, 0, $entity_id); ?>, <?= collections_between($first_07, $last_07, $entity_id); ?>],
                                                    ['<?= $t_06; ?>', <?= sales_between($first_06, $last_06, 0, $entity_id); ?>, <?= expenses_between($first_06, $last_06, 0, $entity_id); ?>, <?= collections_between($first_06, $last_06, $entity_id); ?>],
                                                    ['<?= $t_05; ?>', <?= sales_between($first_05, $last_05, 0, $entity_id); ?>, <?= expenses_between($first_05, $last_05, 0, $entity_id); ?>, <?= collections_between($first_05, $last_05, $entity_id); ?>],
                                                    ['<?= $t_04; ?>', <?= sales_between($first_04, $last_04, 0, $entity_id); ?>, <?= expenses_between($first_04, $last_04, 0, $entity_id); ?>, <?= collections_between($first_04, $last_04, $entity_id); ?>],
                                                    ['<?= $t_03; ?>', <?= sales_between($first_03, $last_03, 0, $entity_id); ?>, <?= expenses_between($first_03, $last_03, 0, $entity_id); ?>, <?= collections_between($first_03, $last_03, $entity_id); ?>],
                                                    ['<?= $t_02; ?>', <?= sales_between($first_02, $last_02, 0, $entity_id); ?>, <?= expenses_between($first_02, $last_02, 0, $entity_id); ?>, <?= collections_between($first_02, $last_02, $entity_id); ?>],
                                                    ['<?= $t_01; ?>', <?= sales_between($first_01, $last_01, 0, $entity_id); ?>, <?= expenses_between($first_01, $last_01, 0, $entity_id); ?>, <?= collections_between($first_01, $last_01, $entity_id); ?>],
                                                    ['<?= $t_00; ?>', <?= sales_between($first_00, $last_00, 0, $entity_id); ?>, <?= expenses_between($first_00, $last_00, 0, $entity_id); ?>, <?= collections_between($first_00, $last_00, $entity_id); ?>],
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




        

                        <div class="col-md-6">

                            <div class="card">

                                <div class="card-header">
                                    <h5><?= __('Top Clients'); ?> <small><?= __('this year'); ?></small></h5>
                                </div>

                                <div class="card-block">

                                    <div class="dt-responsive table-responsive">

                                        <table id="DataTablesXXXX" class="table table-striped table-bordered nowrap">

                                            <tbody>

                                                <?php foreach($top_clients as $item) { ?>
                                                    <tr>
                                                        <th><?= get_client_name($item['client_id']); ?></th>
                                                        <td><?= format_currency($item['amount'], $default_currency); ?></td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>

                                        </table>

                                    </div>


                                </div>

                            </div>
                            </div>


                            <div class="col-md-6">

                            <div class="card">

                                <div class="card-header">
                                    <h5><?= __('Top Suppliers'); ?> <small><?= __('this year'); ?></small></h5>
                                </div>

                                <div class="card-block">

                                    <div class="dt-responsive table-responsive">

                                        <table id="DataTablesXXXX" class="table table-striped table-bordered nowrap">

                                            <tbody>

                                                <?php foreach($top_suppliers as $item) { ?>
                                                    <tr>
                                                        <th><?= get_supplier_name($item['supplier_id']); ?></th>
                                                        <td><?= format_currency($item['amount'], $default_currency); ?></td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>

                                        </table>

                                    </div>


                                </div>

                            </div>

                        </div>



                        <div class="col-md-6">
                            <div class="card">

                                <div class="card-header">
                                    <h5><?= __('Expenses by category'); ?> <small><?= __('selected range'); ?></small></h5>
                                </div>

                                <div class="card-block">



                                    <div class="dt-responsive table-responsive">

                                        <table id="DataTablesXXXX" class="table table-striped table-bordered nowrap">


                                            <tbody>

                                                <?php $total_c = 0; ?>

                                                <?php foreach($expensecategories as $category) { ?>

                                                    <?php
                                                    $value = expenses_by_category($this->session->filter_entity_id,$category['id'], $_SESSION['filter_start'], $_SESSION['filter_end']);
                                                    $total_c = $total_c+$value;
                                                    ?>
                                                    <tr>
                                                        <th><?= $category['name']; ?></th>
                                                        <td><?= format_currency($value, $default_currency)  ?></td>
                                                    </tr>
                                                <?php } ?>



                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                </tr>



                                                <tr>
                                                    <th>Total</th>
                                                    <td><?= format_currency($total_c, $default_currency) ?> </td>
                                                </tr>

                                            </tbody>



                                        </table>

                                    </div>


                                </div>

                            </div>

                        </div>

                        
                    </div>




                            


                 





                </div>
            </div>
        </div>
    </div>


</div>



