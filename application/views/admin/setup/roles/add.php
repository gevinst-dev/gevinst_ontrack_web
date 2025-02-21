<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-header-title">
                    <i class="feather icon-lock bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/dashboard') ?>"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!"><?= __('Setup') ?></a></li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/dashboard/setup/roles') ?>"><?= __('Roles') ?></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!"><?= __('Add Role') ?></a></li>
                    </ul>
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
                        <?= form_open(NULL, 'data-toggle="validator"'); ?>

                            <input type="hidden" name="permissions[]" value="default">
                            <div class="card-block">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class=""><?= __("Name") ?></label>
                                            <input type="text" class="form-control" name="name" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Assets') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="assets-view" <?php if(in_array('assets-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="assets-add" <?php if(in_array('assets-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="assets-edit" <?php if(in_array('assets-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="assets-delete" <?php if(in_array('assets-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Licenses') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="licenses-view" <?php if(in_array('licenses-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="licenses-add" <?php if(in_array('licenses-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="licenses-edit" <?php if(in_array('licenses-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="licenses-delete" <?php if(in_array('licenses-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Domains') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="domains-view" <?php if(in_array('domains-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="domains-add" <?php if(in_array('domains-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="domains-edit" <?php if(in_array('domains-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="domains-delete" <?php if(in_array('domains-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Credentials') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="credentials-view" <?php if(in_array('credentials-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="credentials-add" <?php if(in_array('credentials-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="credentials-edit" <?php if(in_array('credentials-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="credentials-delete" <?php if(in_array('credentials-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Attributes') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="attributes-view" <?php if(in_array('attributes-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="attributes-add" <?php if(in_array('attributes-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="attributes-edit" <?php if(in_array('attributes-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="attributes-delete" <?php if(in_array('attributes-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Clients') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="clients-view" <?php if(in_array('clients-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="clients-add" <?php if(in_array('clients-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="clients-edit" <?php if(in_array('clients-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="clients-delete" <?php if(in_array('clients-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Users') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="users-view" <?php if(in_array('users-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="users-add" <?php if(in_array('users-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="users-edit" <?php if(in_array('users-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="users-delete" <?php if(in_array('users-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>


                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Projects') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="projects-view" <?php if(in_array('projects-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="projects-add" <?php if(in_array('projects-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="projects-edit" <?php if(in_array('projects-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="projects-delete" <?php if(in_array('projects-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Tickets') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="tickets-view" <?php if(in_array('tickets-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="tickets-add" <?php if(in_array('tickets-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="tickets-edit" <?php if(in_array('tickets-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="tickets-delete" <?php if(in_array('tickets-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Issues') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="issues-view" <?php if(in_array('issues-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="issues-add" <?php if(in_array('issues-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="issues-edit" <?php if(in_array('issues-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="issues-delete" <?php if(in_array('issues-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Leads') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="leads-view" <?php if(in_array('leads-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="leads-add" <?php if(in_array('leads-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="leads-edit" <?php if(in_array('leads-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="leads-delete" <?php if(in_array('leads-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Proposals') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proposals-view" <?php if(in_array('proposals-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proposals-add" <?php if(in_array('proposals-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proposals-edit" <?php if(in_array('proposals-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proposals-delete" <?php if(in_array('proposals-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Proformas') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proformas-view" <?php if(in_array('proformas-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proformas-add" <?php if(in_array('proformas-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proformas-edit" <?php if(in_array('proformas-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="proformas-delete" <?php if(in_array('proformas-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Invoices') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="invoices-view" <?php if(in_array('invoices-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="invoices-add" <?php if(in_array('invoices-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="invoices-edit" <?php if(in_array('invoices-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="invoices-delete" <?php if(in_array('invoices-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Recurring Sales') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurring-view" <?php if(in_array('recurring-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurring-add" <?php if(in_array('recurring-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurring-edit" <?php if(in_array('recurring-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurring-delete" <?php if(in_array('recurring-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Items') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="items-view" <?php if(in_array('items-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="items-add" <?php if(in_array('items-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="items-edit" <?php if(in_array('items-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="items-delete" <?php if(in_array('items-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Receipts') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="receipts-view" <?php if(in_array('receipts-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="receipts-add" <?php if(in_array('receipts-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="receipts-edit" <?php if(in_array('receipts-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="receipts-delete" <?php if(in_array('receipts-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Suppliers') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="suppliers-view" <?php if(in_array('suppliers-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="suppliers-add" <?php if(in_array('suppliers-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="suppliers-edit" <?php if(in_array('suppliers-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="suppliers-delete" <?php if(in_array('suppliers-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Expenses') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="expenses-view" <?php if(in_array('expenses-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="expenses-add" <?php if(in_array('expenses-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="expenses-edit" <?php if(in_array('expenses-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="expenses-delete" <?php if(in_array('expenses-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Recurring Expenses') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurringexp-view" <?php if(in_array('recurringexp-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurringexp-add" <?php if(in_array('recurringexp-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurringexp-edit" <?php if(in_array('recurringexp-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="recurringexp-delete" <?php if(in_array('recurringexp-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Calendar') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="calendar-view" <?php if(in_array('calendar-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="calendar-add" <?php if(in_array('calendar-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="calendar-edit" <?php if(in_array('calendar-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="calendar-delete" <?php if(in_array('calendar-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>




                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Reminders') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reminders-view" <?php if(in_array('reminders-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reminders-add" <?php if(in_array('reminders-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reminders-edit" <?php if(in_array('reminders-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reminders-delete" <?php if(in_array('reminders-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Knowledge Base') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="kb-view" <?php if(in_array('kb-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="kb-add" <?php if(in_array('kb-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="kb-edit" <?php if(in_array('kb-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="kb-delete" <?php if(in_array('kb-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Documentation') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="documentation-view" <?php if(in_array('documentation-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="documentation-add" <?php if(in_array('documentation-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="documentation-edit" <?php if(in_array('documentation-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="documentation-delete" <?php if(in_array('documentation-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Predefined Replies') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="pr-view" <?php if(in_array('pr-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="pr-add" <?php if(in_array('pr-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="pr-edit" <?php if(in_array('pr-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="pr-delete" <?php if(in_array('pr-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Reports') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports-view" <?php if(in_array('reports-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Reports") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_sales-view" <?php if(in_array('reports_sales-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Sales") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_expenses-view" <?php if(in_array('reports_expenses-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Expenses") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_finance-view" <?php if(in_array('reports_finance-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Finance") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_clients-view" <?php if(in_array('reports_clients-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Clients") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_assets-view" <?php if(in_array('reports_assets-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Assets") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_licenses-view" <?php if(in_array('reports_licenses-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Licenses") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_domains-view" <?php if(in_array('reports_domains-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Domains") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_projects-view" <?php if(in_array('reports_projects-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Projects") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_users-view" <?php if(in_array('reports_users-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Users") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_issues-view" <?php if(in_array('reports_issues-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Issues") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="reports_tickets-view" <?php if(in_array('reports_tickets-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Tickets") ?></span>
                                            </label>
                                        </div>



                        
                                    </div>





                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Staff Accounts') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="staff-view" <?php if(in_array('staff-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="staff-add" <?php if(in_array('staff-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="staff-edit" <?php if(in_array('staff-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="staff-delete" <?php if(in_array('staff-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Roles') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="roles-view" <?php if(in_array('roles-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="roles-add" <?php if(in_array('roles-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="roles-edit" <?php if(in_array('roles-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="roles-delete" <?php if(in_array('roles-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>





                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Custom fields') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="cf-view" <?php if(in_array('cf-view', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("View") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="cf-add" <?php if(in_array('cf-add', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Add") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="cf-edit" <?php if(in_array('cf-edit', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Edit") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="cf-delete" <?php if(in_array('cf-delete', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Delete") ?></span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 m-bottom-25">
                                        <h4 class="sub-title"><?= __('Other') ?></h4>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="filemanager" <?php if(in_array('filemanager', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("File Manager") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="logs" <?php if(in_array('logs', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Logs") ?></span>
                                            </label>
                                        </div>

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="settings" <?php if(in_array('settings', $permissions)) echo "checked"; ?> >
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span><?= __("Settings") ?></span>
                                            </label>
                                        </div>


                                    </div>

                                </div>



                            </div>

                            <div class="card-block text-right">
                                <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Role") ?></button>
                            </div>

                        <?= form_close(); ?>

                    </div>

                    <!-- [ page content ] ends -->
                </div>
            </div>
        </div>
    </div>


</div>
