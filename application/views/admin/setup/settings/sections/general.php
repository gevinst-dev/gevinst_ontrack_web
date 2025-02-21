<div class="row">
    <div class="col-md-12">

        <?= form_open(base_url('admin/setup/settings/general'), 'data-toggle="validator"'); ?>

            <div class="form-group">
                <label class=""><?= __("App Name") ?></label>
                <input type="text" class="form-control" name="app_name" value="<?= get_setting('app_name'); ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="form-group">
                <label class=""><?php _e('Default Tax Rate'); ?></label>
                <select class="form-control select2" name="default_taxrate" required>
                    <?php foreach ($taxrates as $taxrate) { ?>
                        <option <?php if(get_setting('default_taxrate') == $taxrate['id']) echo 'selected'; ?> value="<?php echo $taxrate['id']; ?>"><?php echo $taxrate['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label class=""><?php _e('Default Currency'); ?></label>
                <select class="form-control select2" name="default_currency" required>
                    <?php foreach ($currencies as $currency) { ?>
                        <option <?php if(get_setting('default_currency') == $currency['id']) echo 'selected'; ?> value="<?php echo $currency['id']; ?>"><?php echo $currency['code']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <p class="alert alert-warning"><?= __('Changing the default currency is not recommended if you already have issued invoices.') ?></p>



            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="google_recaptcha" value="0">
                        <input type="checkbox" name="google_recaptcha" value="1" <?php if(get_setting('google_recaptcha') == '1') echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Enable Google reCAPTCHA") ?></span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class=""><?= __("Google reCAPTCHA Site Key") ?></label>
                <input type="text" class="form-control" name="google_recaptcha_sitekey" value="<?= get_setting('google_recaptcha_sitekey'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Google reCAPTCHA Secret Key") ?></label>
                <input type="text" class="form-control" name="google_recaptcha_secretkey" value="<?= get_setting('google_recaptcha_secretkey'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="form-group hidden">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="multi_entity" value="0">
                        <input type="checkbox" name="multi_entity" value="1" <?php if(get_setting('multi_entity') == '1') echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Enable Multi Entity") ?></span>
                    </label>
                </div>
            </div>

            

            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
            </div>

        <?= form_close(); ?>

    </div>
</div>
