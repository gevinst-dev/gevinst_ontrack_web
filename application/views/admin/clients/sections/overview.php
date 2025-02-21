<div class="row">



    <div class="col-md-12">

        <div class="card">

            <div class="card-header">
                <h5><?= __('Client Overview') ?></h5>
            </div>


            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover m-b-0 without-header table-simple">
                        <tbody>

                            <tr>
                                <td ><b><?= __('Name') ?></b><br><?= $client['name']; ?><br></td>
                                <td ><b><?= __('Tax/VAT ID') ?></b><br><?= $client['company_taxid']; ?><br></td>
                                <td ><b><?= __('Company ID') ?></b><br><?= $client['company_id']; ?><br></td>
                            </tr>


                            <tr>
                                <td ><b><?= __('Phone') ?></b><br><?= $client['phone']; ?><br></td>
                                <td ><b><?= __('Website') ?></b><br><?= $client['website']; ?><br></td>
                                <td ><b><?= __('Email') ?></b><br><?= $client['email']; ?><br></td>
                            </tr>


                            <tr>
                                <td ><b><?= __('Address') ?></b><br><?= $client['address']; ?><br></td>
                                <td ><b><?= __('Country') ?></b><br><?= $client['country']; ?><br></td>
                                <td ><b><?= __('City') ?></b><br><?= $client['city']; ?><br></td>
                            </tr>

                            <tr>
                                <td ><b><?= __('State') ?></b><br><?= $client['state']; ?><br></td>
                                <td ><b><?= __('Zip/Postal Code') ?></b><br><?= $client['zip_code']; ?><br></td>
                                <td ><b><?= __('Description') ?></b><br><?= $client['description']; ?><br></td>
                            </tr>

                        </tbody>
                    </table>
                </div>


                <hr>



                <div class="row pp-main">
                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Assets') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_assets")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Licenses') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_licenses")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Domains') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_domains")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Projects') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_projects")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Users') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("core_users")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Credentials') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_credentials")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Tickets') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_tickets")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Issues') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_issues")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Reminders') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= $this->db->where('client_id', $client['id'])->from("app_reminders")->count_all_results(); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>




            </div>
        </div>

        <?php if(has_permission('invoices-view')) { ?>
        <div class="card ">

            <div class="card-header">
                <h5><?= __('Billing Overview') ?></h5>
            </div>

            <div class="card-body">

                <div class="row pp-main">
                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Total Sales') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-blue"><?= format_currency(client_total_invoiced($client['id']), get_setting('default_currency')); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Paid') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-green"><?= format_currency(client_total_paid($client['id']), get_setting('default_currency')); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="pp-cont">

                            <div class="row align-items-center m-b-20">
                                <div class="col-md-12">
                                    <span class="f-24 text-mute"><?= __('Outstanding') ?></span>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="m-b-0 text-c-red"><?= format_currency(client_total_unpaid($client['id']), get_setting('default_currency')); ?></h3>
                                </div>
                            </div>

                        </div>
                    </div>




                </div>

            </div>
        </div>
        <?php } ?>



        <div class="card">

            <div class="card-body">
                <div class="row">

                    <?php if(has_permission('assets-view')) { ?>
                    <div class="col-md-6">
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
                                            ['<?= $asset_category['name'] ?>', <?= $this->db->where('category_id', $asset_category['id'])->where('client_id', $client['id'])->from("app_assets")->count_all_results() ?>],
                                        <?php } ?>

                                    ]);

                                    var options = {
                                        title: 'Assets by Category',
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
                    <?php } ?>

                    <?php if(has_permission('licenses-view')) { ?>
                    <div class="col-md-6">
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
                                            ['<?= $license_category['name'] ?>', <?= $this->db->where('category_id', $license_category['id'])->where('client_id', $client['id'])->from("app_licenses")->count_all_results() ?>],
                                        <?php } ?>



                                    ]);

                                    var options = {
                                        title: 'Licenses by Category',
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
                    <?php } ?>

                </div>


            </div>

        </div>






        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Locations') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >
                        
                        <?php if(has_permission('clients-edit')) { ?>
                        <button data-modal="admin/inventory/attributes/add_location/<?= $client['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Add Location') ?>
                        </button>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <?php if(empty($locations)) { ?>
                    <?= __('No locations have been added.') ?>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0 without-header">
                            <tbody>
                                <?php foreach($locations as $location) { ?>
                                    <tr>
                                        <td><?= $location['name']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Comments') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <?php if(has_permission('clients-edit')) { ?>
                        <button data-modal="admin/clients/add_comment/<?= $client['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Add Comment') ?>
                        </button>
                        <?php } ?>

                    </div>



                </div>
            </div>





            <div class="card-body">
                <?php if(empty($comments)) { ?>
                    <?= __('No comments have been added.') ?>
                <?php } else { ?>
                    <div class="review-block">
                        <?php foreach($comments as $comment) { ?>
                            <div class="row m-b-10">
                                <div class="col-sm-auto p-r-0">
                                    <img src="<?= gravatar($this->staff->get_email($comment['added_by']), 50); ?>" alt="user image" class="img-radius profile-img cust-img m-b-15">
                                </div>
                                <div class="col">
                                    <div class="m-b-15">
                                        <span class="lead"><?= $this->staff->get_name($comment['added_by']); ?> <span class="text-muted f-size-12"><?= datetime_display($comment['created_at']); ?></span></span>
                                        <div class="float-right">
                                            <?php if(has_permission('clients-edit')) { ?>
                                            <a href="#" data-modal="admin/clients/edit_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Comment') ?>"><i class="far fa-fw fa-edit"></i></a>
                                            <?php } ?>

                                            <?php if(has_permission('clients-delete')) { ?>
                                            <a href="#" data-modal="admin/clients/delete_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Comment') ?>"><i class="fas fa-fw fa-trash"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <p class="m-t-15 m-b-0"><?= nl2br($comment['comment']); ?></p>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>



        </div>


    </div>




    <div class="col-md-4 hidden">
        <div class="table-responsive">
            <table class="table table-hover m-b-0 without-header table-simple">
                <tbody>

                    <tr>

                        <td class="text-right"><b><?= __('Name') ?></b><br><?= $client['name']; ?></td>
                    </tr>

                    <tr>

                        <td class="text-right"><b><?= __('Tax/VAT ID') ?></b><br><?= $client['company_taxid']; ?></td>
                    </tr>

                    <tr>

                        <td class="text-right"><b><?= __('Company ID') ?></b><br><?= $client['company_id']; ?></td>
                    </tr>

                    <tr>

                        <td class="text-right"><b><?= __('Phone') ?></b><br><?= $client['phone']; ?></td>
                    </tr>

                    <tr>

                        <td class="text-right"><b><?= __('Website') ?></b><br><?= $client['website']; ?></td>
                    </tr>


                    <tr>

                        <td class="text-right"><b><?= __('Email') ?></b><br><?= $client['email']; ?></td>
                    </tr>

                    <tr>

                        <td class="text-right"><b><?= __('Address') ?></b><br><?= $client['address']; ?></td>
                    </tr>

                    <tr>

                        <td class="text-right"><b><?= __('Country') ?></b><br><?= $client['country']; ?></td>
                    </tr>


                    <tr>

                        <td class="text-right"><b><?= __('City') ?></b><br><?= $client['city']; ?></td>
                    </tr>

                    <tr>

                        <td class="text-right"><b><?= __('State') ?></b><br><?= $client['state']; ?></td>
                    </tr>


                    <tr>

                        <td class="text-right"><b><?= __('Zip/Postal Code') ?></b><br><?= $client['zip_code']; ?></td>
                    </tr>




                </tbody>
            </table>

        </div>

    </div>


    <div class="col-md-12">










    </div>
</div>
