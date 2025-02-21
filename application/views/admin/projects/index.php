<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header-title">
                    <i class="fas fa-rocket bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-right">

                    <?php if(has_permission('issues-add')) { ?>
                    <?php if($section == "issues" || $section == "board") { ?>
                        <button data-modal="admin/projects/add_issue/<?= $project['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Issue') ?></button>
                    <?php } ?>
                    <?php } ?>

                    <?php if($section == "milestones") { ?>
                        <button data-modal="admin/projects/add_milestone/<?= $project['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Milestone') ?></button>
                    <?php } ?>

                    <?php if(has_permission('projects-edit') && has_permission('assets-view')) { ?>
                    <?php if($section == "assets") { ?>
                        <button data-modal="admin/projects/add_asset_assignment/<?= $project['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Assign Asset') ?></button>
                    <?php } ?>
                    <?php } ?>


                    <?php if(has_permission('tickets-add')) { ?>
                    <?php if($section == "tickets") { ?>
                        <button data-modal="admin/projects/add_ticket/<?= $project['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Ticket') ?></button>
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
                                    <a class="nav-link <?php if($section == "details") echo "active"; ?>" href="<?= base_url('admin/projects/details/'.$project['id']) ?>"><?= __('Details') ?></a>
                                </li>

                                <?php if(has_permission('issues-view')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "board") echo "active"; ?>" href="<?= base_url('admin/projects/board/'.$project['id']) ?>"><?= __('Board') ?></a>
                                </li>
                                <?php } ?>


                                <?php if(has_permission('issues-viewadd')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "issues") echo "active"; ?>" href="<?= base_url('admin/projects/issues/'.$project['id']) ?>"><?= __('Issues') ?></a>
                                </li>
                                <?php } ?>

                                <?php if(has_permission('tickets-view')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "tickets") echo "active"; ?>" href="<?= base_url('admin/projects/tickets/'.$project['id']) ?>"><?= __('Tickets') ?></a>
                                </li>
                                <?php } ?>

                                
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "milestones") echo "active"; ?>" href="<?= base_url('admin/projects/milestones/'.$project['id']) ?>"><?= __('Milestones') ?></a>
                                </li>


                                <?php if(has_permission('assets-view')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "assets") echo "active"; ?>" href="<?= base_url('admin/projects/assets/'.$project['id']) ?>"><?= __('Assets') ?></a>
                                </li>
                                <?php } ?>


                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "notes") echo "active"; ?>" href="<?= base_url('admin/projects/notes/'.$project['id']) ?>"><?= __('Notes') ?></a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($section == "details") echo "show active"; ?>" id="details" role="tabpanel">
                            <?php if($section == "details") $this->load->view('admin/projects/sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "board") echo "show active"; ?>" id="board" role="tabpanel">
                            <?php if($section == "board") $this->load->view('admin/projects/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "issues") echo "show active"; ?>" id="issues" role="tabpanel">
                            <?php if($section == "issues") $this->load->view('admin/projects/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "tickets") echo "show active"; ?>" id="tickets" role="tabpanel">
                            <?php if($section == "tickets") $this->load->view('admin/projects/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "milestones") echo "show active"; ?>" id="milestones" role="tabpanel">
                            <?php if($section == "milestones") $this->load->view('admin/projects/sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "assets") echo "show active"; ?>" id="assets" role="tabpanel">
                            <?php if($section == "assets") $this->load->view('admin/projects/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "notes") echo "show active"; ?>" id="notes" role="tabpanel">
                            <?php if($section == "notes") $this->load->view('admin/projects/sections/'.$section); ?>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>

