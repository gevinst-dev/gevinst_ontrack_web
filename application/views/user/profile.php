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


                            <?= form_open(base_url('profile'), 'data-toggle="validator"'); ?>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class=""><?= __("Name") ?></label>
                                            <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?= __("Language") ?></label>
                                            <select class="select2 form-control" name="language_id" required>
                                                <?php foreach($languages as $language) { ?>
                                                    <option value="<?= $language['id'] ?>" <?php if($language['id'] == $user['language_id']) echo "selected"; ?> ><?= $language['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-8">

                                        <div class="form-group">
                                            <label class=""><?= __("Email Address") ?></label>
                                            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label class=""><?= __("Designation") ?></label>
                                            <input type="text" class="form-control" name="designation" value="<?= $user['designation'] ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>

                                    </div>


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
