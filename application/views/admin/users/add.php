<div class="modal-content">
    <?= form_open(NULL, 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label class=""><?= __("Client") ?></label>
                        <select class="select2 select2_clients form-control" name="client_id" required>
                           

                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>

                <div class="col-md-8">

                    <div class="form-group">
                        <label class=""><?= __("Email Address") ?></label>
                        <input type="email" class="form-control" name="email" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label class=""><?= __("Designation") ?></label>
                        <input type="text" class="form-control" name="designation" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>




                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Password") ?></label>
                        <input type="password" class="form-control" name="password" data-minlength="8" id="password" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Confirm Password") ?></label>
                        <input type="password" class="form-control" name="password_confirm" data-match="#password" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>







            </div>


            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="status" value="Inactive">
                        <input type="checkbox" name="status" value="Active" checked>
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Active") ?></span>
                    </label>
                </div>
            </div>

            <h5><?= __('Permissions') ?></h5>
            <hr>

            <div class="row">

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_assets" value="0">
                            <input type="checkbox" name="permission_assets" value="1" <?php if(get_setting('user_permission_assets') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Assets") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_licenses" value="0">
                            <input type="checkbox" name="permission_licenses" value="1" <?php if(get_setting('user_permission_licenses') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Licenses") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_domains" value="0">
                            <input type="checkbox" name="permission_domains" value="1" <?php if(get_setting('user_permission_domains') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Domains") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_credentials" value="0">
                            <input type="checkbox" name="permission_credentials" value="1" <?php if(get_setting('user_permission_credentials') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Credentials") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_projects" value="0">
                            <input type="checkbox" name="permission_projects" value="1" <?php if(get_setting('user_permission_projects') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Projects") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_tickets" value="0">
                            <input type="checkbox" name="permission_tickets" value="1" <?php if(get_setting('user_permission_tickets') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Tickets") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_issues" value="0">
                            <input type="checkbox" name="permission_issues" value="1" <?php if(get_setting('user_permission_issues') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Issues") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_kb" value="0">
                            <input type="checkbox" name="permission_kb" value="1" <?php if(get_setting('user_permission_kb') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Knowledge Base") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_ducumentation" value="0">
                            <input type="checkbox" name="permission_ducumentation" value="1" <?php if(get_setting('user_permission_ducumentation') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Documentation") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_invoices" value="0">
                            <input type="checkbox" name="permission_invoices" value="1" <?php if(get_setting('user_permission_invoices') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Invoices") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_proformas" value="0">
                            <input type="checkbox" name="permission_proformas" value="1" <?php if(get_setting('user_permission_proformas') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Proformas") ?></span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_proposals" value="0">
                            <input type="checkbox" name="permission_proposals" value="1" <?php if(get_setting('user_permission_proposals') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Proposals") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_receipts" value="0">
                            <input type="checkbox" name="permission_receipts" value="1" <?php if(get_setting('user_permission_receipts') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Transactions") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_profile" value="0">
                            <input type="checkbox" name="permission_profile" value="1" <?php if(get_setting('user_permission_profile') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Profile") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="permission_client" value="0">
                            <input type="checkbox" name="permission_client" value="1" <?php if(get_setting('user_permission_client') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Client Details") ?></span>
                        </label>
                    </div>
                </div>


            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add User") ?></button>
        </div>

    <?= form_close(); ?>

</div>
