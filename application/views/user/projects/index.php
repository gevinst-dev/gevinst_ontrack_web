<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-6">
                <div class="page-header-title">
                    <i class="fas fa-rocket bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="text-right">

                    <?php if($section == "issues" || $section == "board") { ?>
                        <button data-modal="issues/add?project_id=<?= $project['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Issue') ?></button>
                    <?php } ?>

          
                    <?php if($section == "tickets") { ?>
                        <button data-modal="tickets/add?project_id=<?= $project['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Ticket') ?></button>
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
                                    <a class="nav-link <?php if($section == "details") echo "active"; ?>" href="<?= base_url('projects/details/'.$project['id']) ?>"><?= __('Details') ?></a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "issues") echo "active"; ?>" href="<?= base_url('projects/issues/'.$project['id']) ?>"><?= __('Issues') ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "tickets") echo "active"; ?>" href="<?= base_url('projects/tickets/'.$project['id']) ?>"><?= __('Tickets') ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "milestones") echo "active"; ?>" href="<?= base_url('projects/milestones/'.$project['id']) ?>"><?= __('Milestones') ?></a>
                                </li>




                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($section == "details") echo "show active"; ?>" id="details" role="tabpanel">
                            <?php if($section == "details") $this->load->view('user/projects/sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "issues") echo "show active"; ?>" id="issues" role="tabpanel">
                            <?php if($section == "issues") $this->load->view('user/projects/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "tickets") echo "show active"; ?>" id="tickets" role="tabpanel">
                            <?php if($section == "tickets") $this->load->view('user/projects/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "milestones") echo "show active"; ?>" id="milestones" role="tabpanel">
                            <?php if($section == "milestones") $this->load->view('user/projects/sections/'.$section); ?>
                        </div>

                        

                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>





