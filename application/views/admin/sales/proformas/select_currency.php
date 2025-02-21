<div class="modal-content">
    <?= form_open_multipart(NULL, 'id="modal-form"'); ?>

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
                        <label class=""><?php _e('Select Currency'); ?></label>
                        <select class="form-control select2" name="currency_id" required>
                            <?php foreach ($currencies as $currency) { ?>
                                <option <?php if(get_setting('default_currency') == $currency['id']) echo 'selected'; ?> value="<?php echo $currency['id']; ?>"><?php echo $currency['code']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Continue") ?></button>
        </div>

    <?= form_close(); ?>

</div>
