<div class="row">
    <div class="col-md-12">

        <?= form_open_multipart(base_url('admin/setup/settings/user_area'), 'data-toggle="validator"'); ?>






            <div class="form-group">
                <label class=""><?= __("User Area Accent Color") ?></label>
                <input type="text" class="form-control" id="colorpicker" name="user_accent_color" value="<?= get_setting('user_accent_color'); ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("User Area Logo") ?></label>
                        <input type="file" class="form-control" name="logo_user_area">
                        <span class="help-block text-muted"><?= __("Select new file to change existing. PNG, transparent") ?></span>
                    </div>
                </div>

                <div class="col-md-6 padding-20">
                    <?php if(file_exists(FCPATH . 'public/logo_user_area.png')) { ?>
                        <img src='<?= base_url('public/logo_user_area.png')?>' style="background-color:<?= get_setting('user_accent_color'); ?>;" class="logo-user-area">
                    <?php } else { ?>

                        <p><?= __("No image has been uploaded.") ?></p>
                    <?php } ?>
                </div>
            </div>



            <h5><?= __('Default user permissions') ?></h5>
            <hr>

            <div class="row">

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_assets" value="0">
                            <input type="checkbox" name="user_permission_assets" value="1" <?php if(get_setting('user_permission_assets') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Assets") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_licenses" value="0">
                            <input type="checkbox" name="user_permission_licenses" value="1" <?php if(get_setting('user_permission_licenses') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Licenses") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_domains" value="0">
                            <input type="checkbox" name="user_permission_domains" value="1" <?php if(get_setting('user_permission_domains') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Domains") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_credentials" value="0">
                            <input type="checkbox" name="user_permission_credentials" value="1" <?php if(get_setting('user_permission_credentials') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Credentials") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_projects" value="0">
                            <input type="checkbox" name="user_permission_projects" value="1" <?php if(get_setting('user_permission_projects') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Projects") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_tickets" value="0">
                            <input type="checkbox" name="user_permission_tickets" value="1" <?php if(get_setting('user_permission_tickets') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Tickets") ?></span>
                        </label>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_issues" value="0">
                            <input type="checkbox" name="user_permission_issues" value="1" <?php if(get_setting('user_permission_issues') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Issues") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_kb" value="0">
                            <input type="checkbox" name="user_permission_kb" value="1" <?php if(get_setting('user_permission_kb') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Knowledge Base") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_ducumentation" value="0">
                            <input type="checkbox" name="user_permission_ducumentation" value="1" <?php if(get_setting('user_permission_ducumentation') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Documentation") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_invoices" value="0">
                            <input type="checkbox" name="user_permission_invoices" value="1" <?php if(get_setting('user_permission_invoices') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Invoices") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_proformas" value="0">
                            <input type="checkbox" name="user_permission_proformas" value="1" <?php if(get_setting('user_permission_proformas') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Proformas") ?></span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_proposals" value="0">
                            <input type="checkbox" name="user_permission_proposals" value="1" <?php if(get_setting('user_permission_proposals') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Proposals") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_receipts" value="0">
                            <input type="checkbox" name="user_permission_receipts" value="1" <?php if(get_setting('user_permission_receipts') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Transactions") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_profile" value="0">
                            <input type="checkbox" name="user_permission_profile" value="1" <?php if(get_setting('user_permission_profile') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Profile") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="user_permission_client" value="0">
                            <input type="checkbox" name="user_permission_client" value="1" <?php if(get_setting('user_permission_client') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Client Details") ?></span>
                        </label>
                    </div>
                </div>


            </div>


            <h5><?= __('Public') ?></h5>
            <hr>

            <div class="row">

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="public_kb" value="0">
                            <input type="checkbox" name="public_kb" value="1" <?php if(get_setting('public_kb') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Knowledge Base") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="public_documentation" value="0">
                            <input type="checkbox" name="public_documentation" value="1" <?php if(get_setting('public_documentation') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Documentation") ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="hidden" name="public_submit_ticket" value="0">
                            <input type="checkbox" name="public_submit_ticket" value="1" <?php if(get_setting('public_submit_ticket') == '1') echo "checked"; ?> >
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span><?= __("Ticket Submission") ?></span>
                        </label>
                    </div>
                </div>



            </div>








            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
            </div>

        <?= form_close(); ?>

    </div>
</div>
