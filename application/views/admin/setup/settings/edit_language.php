<div class="modal-content">
    <?= form_open(base_url('admin/setup/settings/edit_language/'.$language['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label class=""><?= __("Language Code") ?></label>
                <input type="text" class="form-control" name="code" value="<?= $language['code'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Language Name") ?></label>
                <input type="text" class="form-control" name="name" value="<?= $language['name'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>





        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Language") ?></button>
        </div>

    <?= form_close(); ?>

</div>
