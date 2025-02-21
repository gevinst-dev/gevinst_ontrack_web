<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="feather icon-user bg-c-blue"></i>
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
                        <div class="card-block">


                            <?= form_open(base_url('admin/profile'), 'data-toggle="validator"'); ?>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class=""><?= __("Name") ?></label>
                                            <input type="text" class="form-control" name="name" value="<?= $staff['name'] ?>" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class=""><?= __("Language") ?></label>
                                            <select class="select2 form-control" name="language_id" required>
                                                <?php foreach($languages as $language) { ?>
                                                    <option value="<?= $language['id'] ?>" <?php if($language['id'] == $staff['language_id']) echo "selected"; ?> ><?= $language['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <div class="form-group">
                                    <label class=""><?= __("Email Address") ?></label>
                                    <input type="email" class="form-control" name="email" value="<?= $staff['email'] ?>" required>
                                    <span class="help-block with-errors messages text-danger"></span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""><?= __("Password") ?></label>
                                            <input type="password" class="form-control" name="password" data-minlength="8" id="password" value="" autocomplete="off">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""><?= __("Confirm Password") ?></label>
                                            <input type="password" class="form-control" name="password_confirm" data-match="#password" value="" autocomplete="off">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <span class="help-block messages text-info"><?= __("Enter password only if you want to change.") ?></span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <hr>
                                        <h5><?= __("Dashboard Configuration") ?></h5>
                                        <br>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_finance_overview" value="0">
                                                    <input type="checkbox" name="d_finance_overview" value="1" <?php if($staff['d_finance_overview'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Finance Overview") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_monthly_financials" value="0">
                                                    <input type="checkbox" name="d_monthly_financials" value="1" <?php if($staff['d_monthly_financials'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Monthly Financials") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_assets_category" value="0">
                                                    <input type="checkbox" name="d_assets_category" value="1" <?php if($staff['d_assets_category'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Assets by Category") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_assets_status" value="0">
                                                    <input type="checkbox" name="d_assets_status" value="1" <?php if($staff['d_assets_status'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Assets Status Overview") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_license_category" value="0">
                                                    <input type="checkbox" name="d_license_category" value="1" <?php if($staff['d_license_category'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Licenses by Category") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_license_status" value="0">
                                                    <input type="checkbox" name="d_license_status" value="1" <?php if($staff['d_license_status'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Licenses Status Overview") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_recent_assets" value="0">
                                                    <input type="checkbox" name="d_recent_assets" value="1" <?php if($staff['d_recent_assets'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Recent Assets") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_recent_licenses" value="0">
                                                    <input type="checkbox" name="d_recent_licenses" value="1" <?php if($staff['d_recent_licenses'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Recent Licenses") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_recent_projects" value="0">
                                                    <input type="checkbox" name="d_recent_projects" value="1" <?php if($staff['d_recent_projects'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Recent Projects") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_assigned_tickets" value="0">
                                                    <input type="checkbox" name="d_assigned_tickets" value="1" <?php if($staff['d_assigned_tickets'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Assigned Tickets") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_assigned_issues" value="0">
                                                    <input type="checkbox" name="d_assigned_issues" value="1" <?php if($staff['d_assigned_issues'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Assigned Issues") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_upcoming_reminders" value="0">
                                                    <input type="checkbox" name="d_upcoming_reminders" value="1" <?php if($staff['d_upcoming_reminders'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Upcoming Reminders") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_upcoming_events" value="0">
                                                    <input type="checkbox" name="d_upcoming_events" value="1" <?php if($staff['d_upcoming_events'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Upcoming Events") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_sent_proposals" value="0">
                                                    <input type="checkbox" name="d_sent_proposals" value="1" <?php if($staff['d_sent_proposals'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Sent Proposals") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="hidden" name="d_exchange_rates" value="0">
                                                    <input type="checkbox" name="d_exchange_rates" value="1" <?php if($staff['d_exchange_rates'] == 1) echo "checked"; ?> >
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span><?= __("Exchange Rates") ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="text-right">
                                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                                </div>
                            <?= form_close(); ?>


                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>
