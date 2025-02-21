<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-sitemap bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">

                    <?php if(has_permission('assets-add')) { ?>
                    <?php if($section == "assets") { ?>
                        <button data-modal="admin/clients/add_asset/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Asset') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('licenses-add')) { ?>
                    <?php if($section == "licenses") { ?>
                        <button data-modal="admin/clients/add_license/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add License') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('domains-add')) { ?>
                    <?php if($section == "domains") { ?>
                        <button data-modal="admin/clients/add_domain/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Domain') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('credentials-add')) { ?>
                    <?php if($section == "credentials") { ?>
                        <button data-modal="admin/clients/add_credential/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Credential') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('projects-add')) { ?>
                    <?php if($section == "projects") { ?>
                        <button data-modal="admin/clients/add_project/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Project') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('tickets-add')) { ?>
                    <?php if($section == "tickets") { ?>
                        <button data-modal="admin/clients/add_ticket/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Ticket') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('issues-add')) { ?>
                    <?php if($section == "issues") { ?>
                        <button data-modal="admin/clients/add_issue/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Issue') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('reminders-add')) { ?>
                    <?php if($section == "reminders") { ?>
                        <button data-modal="admin/clients/add_reminder/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Reminder') ?></button>
                    <?php } ?>
                    <?php } ?>


                    <?php if($section == "proposals") { ?>
                        <?php if(has_permission('proposals-add')) { ?>
                        <button data-modal="admin/sales/proposals/select_currency" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Proposal') ?></button>
                        <?php } ?>
                    <?php } ?>


                    <?php if($section == "proformas") { ?>
                        <?php if(has_permission('proformas-add')) { ?>
                        <button data-modal="admin/sales/proformas/select_currency" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Proforma') ?></button>
                        <?php } ?>

                    <?php } ?>


                    <?php if($section == "invoices") { ?>
                        <?php if(has_permission('invoices-add')) { ?>
                        <button data-modal="admin/sales/invoices/select_currency" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Invoice') ?></button>
                        <?php } ?>
                    <?php } ?>


                    <?php if($section == "recurring") { ?>
                        <?php if(has_permission('recurring-add')) { ?>
                        <a href="<?= base_url('admin/sales/recurring/add'); ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Recurrence') ?></a>
                        <?php } ?>
                    <?php } ?>


                    <?php if(has_permission('clients-edit')) { ?>
                    <?php if($section == "files") { ?>
                        <button data-modal="admin/clients/upload_file/<?= $client['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Upload File') ?></button>
                    <?php } ?>
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
                                     <a class="nav-link <?php if($section == "overview") echo "active"; ?>" href="<?= base_url('admin/clients/overview/'.$client['id']) ?>"><?= __('Overview') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <?php if(has_permission('clients-edit')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "edit") echo "active"; ?>" href="<?= base_url('admin/clients/edit/'.$client['id']) ?>"><?= __('Edit') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('assets-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "assets") echo "active"; ?>" href="<?= base_url('admin/clients/assets/'.$client['id']) ?>"><?= __('Assets') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('licenses-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "licenses") echo "active"; ?>" href="<?= base_url('admin/clients/licenses/'.$client['id']) ?>"><?= __('Licenses') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>


                                <?php if(has_permission('domains-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "domains") echo "active"; ?>" href="<?= base_url('admin/clients/domains/'.$client['id']) ?>"><?= __('Domains') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>


                                <?php if(has_permission('credentials-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "credentials") echo "active"; ?>" href="<?= base_url('admin/clients/credentials/'.$client['id']) ?>"><?= __('Credentials') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('projects-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "projects") echo "active"; ?>" href="<?= base_url('admin/clients/projects/'.$client['id']) ?>"><?= __('Projects') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('tickets-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "tickets") echo "active"; ?>" href="<?= base_url('admin/clients/tickets/'.$client['id']) ?>"><?= __('Tickets') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('issues-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "issues") echo "active"; ?>" href="<?= base_url('admin/clients/issues/'.$client['id']) ?>"><?= __('Issues') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('reminders-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "reminders") echo "active"; ?>" href="<?= base_url('admin/clients/reminders/'.$client['id']) ?>"><?= __('Reminders') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('proposals-view')) { ?>
                                <li class="nav-item ">
                                     <a class="nav-link <?php if($section == "proposals") echo "active"; ?>" href="<?= base_url('admin/clients/proposals/'.$client['id']) ?>"><?= __('Proposals') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>


                                <?php if(has_permission('proformas-view')) { ?>
                                <li class="nav-item ">
                                     <a class="nav-link <?php if($section == "proformas") echo "active"; ?>" href="<?= base_url('admin/clients/proformas/'.$client['id']) ?>"><?= __('Proformas') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('invoices-view')) { ?>
                                <li class="nav-item ">
                                     <a class="nav-link <?php if($section == "invoices") echo "active"; ?>" href="<?= base_url('admin/clients/invoices/'.$client['id']) ?>"><?= __('Invoices') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('recurring-view')) { ?>
                                <li class="nav-item ">
                                     <a class="nav-link <?php if($section == "recurring") echo "active"; ?>" href="<?= base_url('admin/clients/recurring/'.$client['id']) ?>"><?= __('Recurring') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>


                                <?php if(has_permission('clients-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "files") echo "active"; ?>" href="<?= base_url('admin/clients/files/'.$client['id']) ?>"><?= __('Files') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('clients-view')) { ?>
                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "notes") echo "active"; ?>" href="<?= base_url('admin/clients/notes/'.$client['id']) ?>"><?= __('Notes') ?></a>
                                     <div class="slide"></div>
                                </li>
                                <?php } ?>

                             </ul>
                             <!-- Tab panes -->
                             <div class="tab-content tabs-left-content card-block w-100">


                                <div class="tab-pane fade <?php if($section == "overview") echo "show active"; ?>" id="overview" role="tabpanel">
                                    <?php if($section == "overview") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "edit") echo "show active"; ?>" id="edit" role="tabpanel">
                                    <?php if($section == "edit") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "assets") echo "show active"; ?>" id="assets" role="tabpanel">
                                    <?php if($section == "assets") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "licenses") echo "show active"; ?>" id="licenses" role="tabpanel">
                                    <?php if($section == "licenses") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "domains") echo "show active"; ?>" id="domains" role="tabpanel">
                                    <?php if($section == "domains") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "credentials") echo "show active"; ?>" id="credentials" role="tabpanel">
                                    <?php if($section == "credentials") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "projects") echo "show active"; ?>" id="projects" role="tabpanel">
                                    <?php if($section == "projects") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "tickets") echo "show active"; ?>" id="tickets" role="tabpanel">
                                    <?php if($section == "tickets") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "issues") echo "show active"; ?>" id="issues" role="tabpanel">
                                    <?php if($section == "issues") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "reminders") echo "show active"; ?>" id="reminders" role="tabpanel">
                                    <?php if($section == "reminders") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "proposals") echo "show active"; ?>" id="proposals" role="tabpanel">
                                    <?php if($section == "proposals") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>


                                <div class="tab-pane fade <?php if($section == "proformas") echo "show active"; ?>" id="proformas" role="tabpanel">
                                    <?php if($section == "proformas") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>


                                <div class="tab-pane fade <?php if($section == "invoices") echo "show active"; ?>" id="invoices" role="tabpanel">
                                    <?php if($section == "invoices") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "recurring") echo "show active"; ?>" id="recurring" role="tabpanel">
                                    <?php if($section == "recurring") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>


                                <div class="tab-pane fade <?php if($section == "files") echo "show active"; ?>" id="files" role="tabpanel">
                                    <?php if($section == "files") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "notes") echo "show active"; ?>" id="notes" role="tabpanel">
                                    <?php if($section == "notes") $this->load->view('admin/clients/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "xxx") echo "show active"; ?>" id="xxx" role="tabpanel">
                                    <?php if($section == "xxx") $this->load->view('admin/clients/sections/'.$section); ?>
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
