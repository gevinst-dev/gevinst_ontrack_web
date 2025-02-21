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

                    <?php if(has_permission('attributes-add')) { ?>
                        <?php if($section == "asset_categories") { ?>
                            <button data-modal="admin/inventory/attributes/add_asset_category" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Asset Category') ?></button>
                        <?php } ?>

                        <?php if($section == "license_categories") { ?>
                            <button data-modal="admin/inventory/attributes/add_license_category" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add License Category') ?></button>
                        <?php } ?>

                        <?php if($section == "status_labels") { ?>
                            <button data-modal="admin/inventory/attributes/add_status_label" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Status Label') ?></button>
                        <?php } ?>

                        <?php if($section == "manufacturers") { ?>
                            <button data-modal="admin/inventory/attributes/add_manufacturer" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Manufacturer') ?></button>
                        <?php } ?>

                        <?php if($section == "asset_models") { ?>
                            <button data-modal="admin/inventory/attributes/add_asset_model" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Model') ?></button>
                        <?php } ?>

                        <?php if($section == "locations") { ?>
                            <button data-modal="admin/inventory/attributes/add_location" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Location') ?></button>
                        <?php } ?>

                        <?php if($section == "suppliers") { ?>
                            <button data-modal="admin/inventory/attributes/add_supplier" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Supplier') ?></button>
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
                                     <a class="nav-link <?php if($section == "asset_categories") echo "active"; ?>" href="<?= base_url('admin/inventory/attributes/asset_categories') ?>"><?= __('Asset Categories') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "license_categories") echo "active"; ?>" href="<?= base_url('admin/inventory/attributes/license_categories') ?>"><?= __('License Categories') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "status_labels") echo "active"; ?>" href="<?= base_url('admin/inventory/attributes/status_labels') ?>"><?= __('Status Labels') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "manufacturers") echo "active"; ?>" href="<?= base_url('admin/inventory/attributes/manufacturers') ?>"><?= __('Manufacturers') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "asset_models") echo "active"; ?>" href="<?= base_url('admin/inventory/attributes/asset_models') ?>"><?= __('Models') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "locations") echo "active"; ?>" href="<?= base_url('admin/inventory/attributes/locations') ?>"><?= __('Locations') ?></a>
                                     <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                     <a class="nav-link <?php if($section == "suppliers") echo "active"; ?>" href="<?= base_url('admin/inventory/attributes/suppliers') ?>"><?= __('Suppliers') ?></a>
                                     <div class="slide"></div>
                                </li>

                             </ul>
                             <!-- Tab panes -->
                             <div class="tab-content tabs-left-content card-block w-100">

                                <div class="tab-pane fade <?php if($section == "asset_categories") echo "show active"; ?>" id="asset_categories" role="tabpanel">
                                    <?php if($section == "asset_categories") $this->load->view('admin/inventory/attributes/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "license_categories") echo "show active"; ?>" id="license_categories" role="tabpanel">
                                    <?php if($section == "license_categories") $this->load->view('admin/inventory/attributes/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "status_labels") echo "show active"; ?>" id="status_labels" role="tabpanel">
                                    <?php if($section == "status_labels") $this->load->view('admin/inventory/attributes/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "manufacturers") echo "show active"; ?>" id="manufacturers" role="tabpanel">
                                    <?php if($section == "manufacturers") $this->load->view('admin/inventory/attributes/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "asset_models") echo "show active"; ?>" id="asset_models" role="tabpanel">
                                    <?php if($section == "asset_models") $this->load->view('admin/inventory/attributes/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "locations") echo "show active"; ?>" id="locations" role="tabpanel">
                                    <?php if($section == "locations") $this->load->view('admin/inventory/attributes/sections/'.$section); ?>
                                </div>

                                <div class="tab-pane fade <?php if($section == "suppliers") echo "show active"; ?>" id="suppliers" role="tabpanel">
                                    <?php if($section == "suppliers") $this->load->view('admin/inventory/attributes/sections/'.$section); ?>
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
