<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="feather icon-settings bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">

                    <?php if($section == "languages") { ?>
                        <button data-modal="admin/setup/settings/add_language" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Language') ?></button>
                    <?php } ?>



                    <?php if($section == "taxrates") { ?>
                        <button data-modal="admin/setup/settings/add_taxrate" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Tax Rate') ?></button>
                    <?php } ?>

                    <?php if($section == "currencies") { ?>
                        <button data-modal="admin/setup/settings/add_currency" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Currency') ?></button>
                    <?php } ?>

                    <?php if($section == "payment") { ?>
                        <button data-modal="admin/setup/settings/add_paymentmethod" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Payment Method') ?></button>
                    <?php } ?>


                    <?php if($section == "entities") { ?>
                        <button data-modal="admin/setup/settings/add_entity" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Entity') ?></button>
                    <?php } ?>

                    <?php if($section == "expense_categories") { ?>
                        <button data-modal="admin/setup/settings/add_expense_category" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Expense Category') ?></button>
                    <?php } ?>

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

                    <div class="card">
                        <div class="card-block">

                            <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "general") echo "active"; ?>" href="<?= base_url('admin/setup/settings/general') ?>"><?= __('General') ?></a>
                                     <div class="slide"></div>
                                </li>


                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "personalization") echo "active"; ?>" href="<?= base_url('admin/setup/settings/personalization') ?>"><?= __('Personalization') ?></a>
                                     <div class="slide"></div>
                                </li>


                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "user_area") echo "active"; ?>" href="<?= base_url('admin/setup/settings/user_area') ?>"><?= __('User Area') ?></a>
                                     <div class="slide"></div>
                                </li>


                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "localisation") echo "active"; ?>" href="<?= base_url('admin/setup/settings/localisation') ?>"><?= __('Localisation') ?></a>
                                     <div class="slide"></div>
                                </li>


                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "languages") echo "active"; ?>" href="<?= base_url('admin/setup/settings/languages') ?>"><?= __('Languages') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "taxrates") echo "active"; ?>" href="<?= base_url('admin/setup/settings/taxrates') ?>"><?= __('Tax Rates') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "currencies") echo "active"; ?>" href="<?= base_url('admin/setup/settings/currencies') ?>"><?= __('Currencies') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "payment") echo "active"; ?>" href="<?= base_url('admin/setup/settings/payment') ?>"><?= __('Payment Methods') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "expense_categories") echo "active"; ?>" href="<?= base_url('admin/setup/settings/expense_categories') ?>"><?= __('Expense Categories') ?></a>
                                     <div class="slide"></div>
                                </li>


                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "entities") echo "active"; ?>" href="<?= base_url('admin/setup/settings/entities') ?>"><?= __('Entities') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "email") echo "active"; ?>" href="<?= base_url('admin/setup/settings/email') ?>"><?= __('Email') ?></a>
                                     <div class="slide"></div>
                                </li>


                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "tickets") echo "active"; ?>" href="<?= base_url('admin/setup/settings/tickets') ?>"><?= __('Tickets') ?></a>
                                     <div class="slide"></div>
                                </li>


                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "email_templates") echo "active"; ?>" href="<?= base_url('admin/setup/settings/email_templates') ?>"><?= __('Email Templates') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "cron_job") echo "active"; ?>" href="<?= base_url('admin/setup/settings/cron_job') ?>"><?= __('Cron Job') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "about") echo "active"; ?>" href="<?= base_url('admin/setup/settings/about') ?>"><?= __('About') ?></a>
                                     <div class="slide"></div>
                                </li>

                             </ul>
                             <!-- Tab panes -->
                             <div class="tab-content tabs-left-content card-block w-100">


                                <div class="tab-pane fade <?php if($section == "general") echo "show active"; ?>" id="general" role="tabpanel">
                                    <?php if($section == "general") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>


                                <div class="tab-pane fade <?php if($section == "personalization") echo "show active"; ?>" id="personalization" role="tabpanel">
                                    <?php if($section == "personalization") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "user_area") echo "show active"; ?>" id="user_area" role="tabpanel">
                                    <?php if($section == "user_area") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>


                                <div class="tab-pane fade <?php if($section == "localisation") echo "show active"; ?>" id="localisation" role="tabpanel">
                                    <?php if($section == "localisation") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "languages") echo "show active"; ?>" id="languages" role="tabpanel">
                                    <?php if($section == "languages") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "taxrates") echo "show active"; ?>" id="taxrates" role="tabpanel">
                                    <?php if($section == "taxrates") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "currencies") echo "show active"; ?>" id="currencies" role="tabpanel">
                                    <?php if($section == "currencies") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "payment") echo "show active"; ?>" id="payment" role="tabpanel">
                                    <?php if($section == "payment") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "expense_categories") echo "show active"; ?>" id="expense_categories" role="tabpanel">
                                    <?php if($section == "expense_categories") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>


                                <div class="tab-pane fade <?php if($section == "entities") echo "show active"; ?>" id="entities" role="tabpanel">
                                    <?php if($section == "entities") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>




                                <div class="tab-pane fade <?php if($section == "email") echo "show active"; ?>" id="email" role="tabpanel">
                                    <?php if($section == "email") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "tickets") echo "show active"; ?>" id="tickets" role="tabpanel">
                                    <?php if($section == "tickets") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>


                                <div class="tab-pane fade <?php if($section == "email_templates") echo "show active"; ?>" id="email_templates" role="tabpanel">
                                    <?php if($section == "email_templates") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "cron_job") echo "show active"; ?>" id="cron_job" role="tabpanel">
                                    <?php if($section == "cron_job") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "about") echo "show active"; ?>" id="about" role="tabpanel">
                                    <?php if($section == "about") $this->load->view('admin/setup/settings/sections/'.$section); ?>
                                </div>


                             </div>

                        </div>
                    </div>



                    <!-- [ page content ] ends -->
                </div>
            </div>
        </div>
    </div>


</div>
