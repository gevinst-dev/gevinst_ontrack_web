<div class="modal-content">
    <?= form_open(base_url('admin/setup/settings/edit_email_template/'.$template['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label class=""><?= __("Subject") ?></label>
                <input type="text" class="form-control" name="subject" value="<?= $template['subject'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="form-group">
                <label class=""><?= __("Body") ?></label>
                <textarea class="form-controlsssss" id="tinymceinput" name="body"><?= $template['body'] ?></textarea>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Template") ?></button>
        </div>

    <?= form_close(); ?>

</div>
