<div class="modal-content">
    <?= form_open(base_url('admin/inventory/attributes/edit_supplier/'.$supplier['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">


            <div class="form-group">
                <label class=""><?= __("Name") ?></label>
                <input type="text" class="form-control" name="name" value="<?= $supplier['name']; ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="form-group">
                <label class=""><?= __("Contact Name") ?></label>
                <input type="text" class="form-control" name="contact_name" value="<?= $supplier['contact_name']; ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Phone") ?></label>
                <input type="text" class="form-control" name="phone" value="<?= $supplier['phone']; ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Email") ?></label>
                <input type="text" class="form-control" name="email" value="<?= $supplier['email']; ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Web Address") ?></label>
                <input type="text" class="form-control" name="web_address" value="<?= $supplier['web_address']; ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="form-group">
                <label class=""><?= __("Address") ?></label>
                <textarea class="form-control" name="address"><?= $supplier['address']; ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Notes") ?></label>
                <textarea class="form-control" name="notes" id="tinymceinput"><?= $supplier['notes']; ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
