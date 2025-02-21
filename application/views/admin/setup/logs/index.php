<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="feather icon-users bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">

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
                                    <a class="nav-link <?php if($section == "staff_activity") echo "active"; ?>" href="<?= base_url('admin/setup/logs/staff_activity') ?>"><?= __('Staff Activity Log') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "user_activity") echo "active"; ?>" href="<?= base_url('admin/setup/logs/user_activity') ?>"><?= __('User Activity Log') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($section == "email_log") echo "active"; ?>" href="<?= base_url('admin/setup/logs/email_log') ?>"><?= __('Email Log') ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($section == "staff_activity") echo "show active"; ?>" id="staff_activity" role="tabpanel">
                            <?php if($section == "staff_activity") $this->load->view('admin/setup/logs/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "user_activity") echo "show active"; ?>" id="user_activity" role="tabpanel">
                            <?php if($section == "user_activity") $this->load->view('admin/setup/logs/sections/'.$section); ?>
                        </div>

                        <div class="tab-pane fade <?php if($section == "email_log") echo "show active"; ?>" id="email_log" role="tabpanel">
                            <?php if($section == "email_log") $this->load->view('admin/setup/logs/sections/'.$section); ?>
                        </div>

                    </div>




                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>
