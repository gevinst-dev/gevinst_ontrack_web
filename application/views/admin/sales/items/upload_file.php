<div class="modal-content">
    <?= form_open_multipart(base_url('admin/sales/items/upload_file/'.$item['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label class=""><?= __("Select File") ?></label>
                <input type="file" class="form-control" name="userfile" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Upload") ?></button>
        </div>

    <?= form_close(); ?>

</div>
