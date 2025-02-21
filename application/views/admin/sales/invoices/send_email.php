<div class="modal-content">
    <?= form_open(base_url('admin/sales/invoices/send_email/'.$invoice['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">


            <div class="form-group">
                <label class=""><?= __("To") ?></label>
                <input type="email" class="form-control" name="email" value="<?= $client['email']; ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Subject") ?></label>
                <input type="text" class="form-control" name="subject" value="<?= $subject; ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="form-group">
                <label class=""><?= __("Message") ?></label>
                <textarea name="body" class="form-control" id="tinymceinput"><?= $body; ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>





        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Send") ?></button>
        </div>

    <?= form_close(); ?>

</div>
