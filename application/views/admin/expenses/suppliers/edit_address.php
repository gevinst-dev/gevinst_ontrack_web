<div class="modal-content">
    <?= form_open(base_url('admin/expenses/suppliers/edit_address/'.$address['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __(" Address Name") ?></label>
                        <input type="text" class="form-control" name="name" value="<?= $address['name']; ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Address") ?></label>
                        <input type="text" class="form-control" name="address" value="<?= $address['address']; ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("City") ?></label>
                        <input type="text" class="form-control" name="city" value="<?= $address['city']; ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("State") ?></label>
                        <input type="text" class="form-control" name="state" value="<?= $address['state']; ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Zip/Postal Code") ?></label>
                        <input type="text" class="form-control" name="zip_code" value="<?= $address['zip_code']; ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Phone") ?></label>
                        <input type="text" class="form-control" name="phone" value="<?= $address['phone']; ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Country") ?></label>
                        <input type="text" class="form-control" name="country" value="<?= $address['country']; ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Notes") ?></label>
                        <textarea name="notes" rows="6" class="form-control"><?= $address['notes']; ?></textarea>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Address") ?></button>
        </div>

    <?= form_close(); ?>

</div>
