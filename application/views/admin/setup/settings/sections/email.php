<div class="row">
    <div class="col-md-12">

        <?= form_open(base_url('admin/setup/settings/email'), 'data-toggle="validator"'); ?>

            <div class="form-group">
                <label class=""><?= __("From Name") ?></label>
                <input type="text" class="form-control" name="email_from_name" value="<?= get_setting('email_from_name'); ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("From Address") ?></label>
                <input type="text" class="form-control" name="email_from_address" value="<?= get_setting('email_from_address'); ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="email_smtp" value="0">
                        <input type="checkbox" name="email_smtp" value="1" <?php if(get_setting('email_smtp') == '1') echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Deliver using SMTP server") ?></span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class=""><?= __("SMTP Server") ?></label>
                <input type="text" class="form-control" name="email_smtp_host" value="<?= get_setting('email_smtp_host'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("SMTP Port") ?></label>
                <input type="text" class="form-control" name="email_smtp_port" value="<?= get_setting('email_smtp_port'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("SMTP Crypto") ?></label>
                <select class="select2 form-control" name="email_smtp_crypto">
                    <option value="" <?php if(get_setting('email_smtp_crypto') == '') echo "selected"; ?>><?= __("None") ?></option>
                    <option value="ssl" <?php if(get_setting('email_smtp_crypto') == 'ssl') echo "selected"; ?>><?= __("SSL") ?></option>
                    <option value="tls" <?php if(get_setting('email_smtp_crypto') == 'tls') echo "selected"; ?>><?= __("TLS") ?></option>
                </select>
            </div>

            <div class="form-group">
                <label class=""><?= __("SMTP Username") ?></label>
                <input type="text" class="form-control" name="email_smtp_user" value="<?= get_setting('email_smtp_user'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("SMTP Password") ?></label>
                <input type="text" class="form-control" name="email_smtp_pass" value="<?= get_setting('email_smtp_pass'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="form-group">
                <label class=""><?= __("Signature") ?></label>
                <textarea class="form-control" id="tinymceinput" name="email_signature"><?= get_setting('email_signature'); ?></textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
            </div>

        <?= form_close(); ?>

    </div>
</div>
