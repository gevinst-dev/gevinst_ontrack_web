<div class="modal-content">
    <?= form_open(base_url('admin/setup/settings/edit_currency/'.$currency['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label class=""><?= __("Currency Code") ?></label>
                <input type="text" class="form-control" name="code" value="<?= $currency['code'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Prefix") ?></label>
                <input type="text" class="form-control" name="prefix" value="<?= $currency['prefix'] ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Suffix") ?></label>
                <input type="text" class="form-control" name="suffix" value="<?= $currency['suffix'] ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Rate") ?></label>
                <input type="number" step="any" min="0" class="form-control" name="rate" value="<?= $currency['rate'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Currency") ?></button>
        </div>

    <?= form_close(); ?>

</div>
