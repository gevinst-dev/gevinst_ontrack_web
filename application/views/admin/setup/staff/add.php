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
                <div class="col-lg-8">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class=""><?= __("Role") ?></label>
                        <select class="select2 form-control" name="role_id" required>
                            <?php foreach($roles as $role) { ?>
                                <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <label class=""><?= __("Email Addres") ?></label>
                <input type="email" class="form-control" name="email" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="row">
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

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Staff Account") ?></button>
        </div>

    <?= form_close(); ?>

</div>
