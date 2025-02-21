<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-6">
                <div class="page-header-title">
                    <i class="fas fa-laptop bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="text-right">

                    <?php if(user_has_permission('issues')) { ?>
                        <?php if($section == "issues" || $section == "board") { ?>
                            <button data-modal="issues/add?asset_id=<?= $asset['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Issue') ?></button>
                        <?php } ?>
                    <?php } ?>

                    <?php if(user_has_permission('tickets')) { ?>
                        <?php if($section == "tickets") { ?>
                            <button data-modal="tickets/add?asset_id=<?= $asset['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Ticket') ?></button>
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
                                    <a class="nav-link <?php if($section == "details") echo "active"; ?>" href="<?= base_url('inventory/asset_details/'.$asset['id']) ?>"><?= __('Details') ?></a>
                                </li>

                                <?php if(user_has_permission('issues')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "issues") echo "active"; ?>" href="<?= base_url('inventory/asset_issues/'.$asset['id']) ?>"><?= __('Issues') ?></a>
                                </li>
                                <?php } ?>

                                <?php if(user_has_permission('tickets')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "tickets") echo "active"; ?>" href="<?= base_url('inventory/asset_tickets/'.$asset['id']) ?>"><?= __('Tickets') ?></a>
                                </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($section == "details") echo "show active"; ?>" id="details" role="tabpanel">
                            <?php if($section == "details") $this->load->view('user/inventory/asset_sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "issues") echo "show active"; ?>" id="issues" role="tabpanel">
                            <?php if($section == "issues") $this->load->view('user/inventory/asset_sections/'.$section); ?>
                        </div>


                        <div class="tab-pane fade <?php if($section == "tickets") echo "show active"; ?>" id="tickets" role="tabpanel">
                            <?php if($section == "tickets") $this->load->view('user/inventory/asset_sections/'.$section); ?>
                        </div>



                    

                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>




