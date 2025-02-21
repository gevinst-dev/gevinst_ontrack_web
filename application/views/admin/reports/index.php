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

            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                <div class="row">

                    <?php if(has_permission('reports_sales-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-dollar-sign"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Sales'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with all sales.') ?></p>
                                <a href="<?= base_url('admin/reports/sales') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <?php if(has_permission('reports_expenses-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-credit-card"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Expenses'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with all expenses.') ?></p>
                                <a href="<?= base_url('admin/reports/expenses') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <?php if(has_permission('reports_finance-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-chart-bar"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Finance Overview'); ?></h3>
                                <p class="report-details"><?= __('Collection of summarized reports with financial indicators.') ?></p>
                                <a href="<?= base_url('admin/reports/finance') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <?php if(has_permission('reports_clients-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-sitemap"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Clients'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with department statistics.') ?></p>
                                <a href="<?= base_url('admin/reports/clients') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <?php if(has_permission('reports_assets-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-laptop"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Assets'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with all assets.') ?></p>
                                <a href="<?= base_url('admin/reports/assets') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <?php if(has_permission('reports_licenses-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-certificate"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Licenses'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with all licenses.') ?></p>
                                <a href="<?= base_url('admin/reports/licenses') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <?php if(has_permission('reports_domains-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-globe"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Domains'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with all domains.') ?></p>
                                <a href="<?= base_url('admin/reports/domains') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if(has_permission('reports_projects-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-rocket"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Projects'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with project details.') ?></p>
                                <a href="<?= base_url('admin/reports/projects') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if(has_permission('reports_users-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-users"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Users'); ?></h3>
                                <p class="report-details"><?= __('Generate a detailed report with all users and their assignments.') ?></p>
                                <a href="<?= base_url('admin/reports/users') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <?php if(has_permission('reports_issues-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-tasks"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Issues'); ?></h3>
                                <p class="report-details"><?= __('Generate a report with all the tasks in the selected period.') ?></p>
                                <a href="<?= base_url('admin/reports/issues') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if(has_permission('reports_tickets-view')) { ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card social-card">
                            <div class="card-body text-center">
                                <h2 class="text-facebook m-b-20"><i class="fas fa-ticket-alt"></i></h2>
                                <h3 class="text-facebook f-w-700"><?= __('Tickets'); ?></h3>
                                <p class="report-details"><?= __('Generate a report with all the tickets in the selected period.') ?></p>
                                <a href="<?= base_url('admin/reports/tickets') ?>" class="btn btn-primary btn-outline-primary btn-sm waves-effect waves-light"><?= __('Open') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>



                </div>




                   














                </div>
                </div>
            </div>
        </div>
    </div>


</div>
