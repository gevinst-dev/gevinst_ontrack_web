<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header-title">
                    <i class="fas fa-certificate bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-right">

                    <?php if(has_permission('licenses-edit')) { ?>
                        <?php if($license['user_id'] == "0") { ?>
                            <button data-modal="admin/inventory/licenses/assign_user/<?= $license['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Assign User') ?></button>
                        <?php } ?>

                        <?php if($license['user_id'] != "0") { ?>
                            <button data-modal="admin/inventory/licenses/release_user/<?= $license['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Release User') ?></button>
                        <?php } ?>
                    


                        <button data-modal="admin/inventory/licenses/edit/<?= $license['id'] ?>" class="btn btn-success btn-md waves-effect waves-light"><?= __('Edit License') ?></button>
                    <?php } ?>

                    <?php if(has_permission('issues-add')) { ?>
                    <?php if($section == "issues" || $section == "board") { ?>
                        <button data-modal="admin/inventory/licenses/add_issue/<?= $license['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Issue') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if(has_permission('tickets-add')) { ?>
                    <?php if($section == "tickets") { ?>
                        <button data-modal="admin/inventory/licenses/add_ticket/<?= $license['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Ticket') ?></button>
                    <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <!-- Page Body start -->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills nav-fill card-header-pills">


                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "details") echo "active"; ?>" href="<?= base_url('admin/inventory/licenses/details/'.$license['id']) ?>"><?= __('Details') ?></a>
                                </li>

                                <?php if(has_permission('issues-view')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "issues") echo "active"; ?>" href="<?= base_url('admin/inventory/licenses/issues/'.$license['id']) ?>"><?= __('Issues') ?></a>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('tickets-view')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "tickets") echo "active"; ?>" href="<?= base_url('admin/inventory/licenses/tickets/'.$license['id']) ?>"><?= __('Tickets') ?></a>
                                </li>
                                <?php } ?>




                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "notes") echo "active"; ?>" href="<?= base_url('admin/inventory/licenses/notes/'.$license['id']) ?>"><?= __('Notes') ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "history") echo "active"; ?>" href="<?= base_url('admin/inventory/licenses/history/'.$license['id']) ?>"><?= __('History') ?></a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($section == "details") echo "show active"; ?>" id="details" role="tabpanel">
                            <?php if($section == "details") $this->load->view('admin/inventory/licenses/sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "issues") echo "show active"; ?>" id="issues" role="tabpanel">
                            <?php if($section == "issues") $this->load->view('admin/inventory/licenses/sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "tickets") echo "show active"; ?>" id="tickets" role="tabpanel">
                            <?php if($section == "tickets") $this->load->view('admin/inventory/licenses/sections/'.$section); ?>
                        </div>



                        <div class="tab-pane fade <?php if($section == "notes") echo "show active"; ?>" id="notes" role="tabpanel">
                            <?php if($section == "notes") $this->load->view('admin/inventory/licenses/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "history") echo "show active"; ?>" id="history" role="tabpanel">
                            <?php if($section == "history") $this->load->view('admin/inventory/licenses/sections/'.$section); ?>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>

