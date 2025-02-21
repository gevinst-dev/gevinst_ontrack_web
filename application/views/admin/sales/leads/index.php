<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-sign-out-alt bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
              <div class="text-right">
                    <?php if(has_permission('proposals-add')) { ?>
                        <button data-modal="admin/sales/proposals/select_currency" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Proposal') ?></button>
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
                                    <a class="nav-link <?php if($section == "details") echo "active"; ?>" href="<?= base_url('admin/sales/leads/details/'.$lead['id']) ?>"><?= __('Details') ?></a>
                                </li>

                                <?php if(has_permission('proposals-view')) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "proposals") echo "active"; ?>" href="<?= base_url('admin/sales/leads/proposals/'.$lead['id']) ?>"><?= __('Proposals') ?></a>
                                </li>
                                <?php } ?>

                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "notes") echo "active"; ?>" href="<?= base_url('admin/sales/leads/notes/'.$lead['id']) ?>"><?= __('Notes') ?></a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($section == "details") echo "show active"; ?>" id="details" role="tabpanel">
                            <?php if($section == "details") $this->load->view('admin/sales/leads/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "proposals") echo "show active"; ?>" id="proposals" role="tabpanel">
                            <?php if($section == "proposals") $this->load->view('admin/sales/leads/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "notes") echo "show active"; ?>" id="notes" role="tabpanel">
                            <?php if($section == "notes") $this->load->view('admin/sales/leads/sections/'.$section); ?>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>


