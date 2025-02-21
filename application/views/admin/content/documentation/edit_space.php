<div class="modal-content">
    <?= form_open(base_url('admin/content/documentation/edit_space/'.$space['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="form-group">
                <label class=""><?= __("Name") ?></label>
                <input type="text" class="form-control" name="name" value="<?= $space['name'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="status" value="Draft">
                        <input type="checkbox" name="status" value="Published" <?php if($space['status'] == "Published") echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Published") ?></span>
                    </label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
