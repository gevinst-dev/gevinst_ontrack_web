<div class="modal-content">
    <?= form_open(base_url('admin/setup/staff/edit/'.$staff['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" value="<?= $staff['name'] ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label class=""><?= __("Language") ?></label>
                        <select class="select2 form-control" name="language_id" required>
                            <?php foreach($languages as $language) { ?>
                                <option value="<?= $language['id'] ?>" <?php if($language['id'] == $staff['language_id']) echo "selected"; ?> ><?= $language['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label class=""><?= __("Role") ?></label>
                        <select class="select2 form-control" name="role_id" required>
                            <?php foreach($roles as $role) { ?>
                                <option value="<?= $role['id'] ?>" <?php if($role['id'] == $staff['role_id']) echo "selected"; ?>><?= $role['name'] ?></option>
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

            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="status" value="Inactive">
                        <input type="checkbox" name="status" value="Active" <?php if($staff['status'] == "Active") echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Active") ?></span>
                    </label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Staff Account") ?></button>
        </div>

    <?= form_close(); ?>

</div>
