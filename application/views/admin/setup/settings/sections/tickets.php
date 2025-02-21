<div class="row">
    <div class="col-md-12">

        <?= form_open(base_url('admin/setup/settings/tickets'), 'data-toggle="validator"'); ?>

            <div class="form-group">
                <label class=""><?= __("IMAP Server") ?></label>
                <input type="text" class="form-control" name="imap_server" value="<?= get_setting('imap_server'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("IMAP Username") ?></label>
                <input type="text" class="form-control" name="imap_user" value="<?= get_setting('imap_user'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("IMAP Password") ?></label>
                <input type="text" class="form-control" name="imap_pass" value="<?= get_setting('imap_pass'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("IMAP Port") ?></label>
                <input type="number" step="1" class="form-control" name="imap_port" value="<?= get_setting('imap_port'); ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("IMAP Encryption") ?></label>
                <select class="select2 form-control" name="imap_encryption">
                    <option value="" <?php if(get_setting('imap_encryption') == '') echo "selected"; ?>><?= __("None") ?></option>
                    <option value="/ssl" <?php if(get_setting('imap_encryption') == '/ssl') echo "selected"; ?>><?= __("SSL") ?></option>
                    <option value="/tls" <?php if(get_setting('imap_encryption') == '/tls') echo "selected"; ?>><?= __("TLS") ?></option>
                </select>
            </div>

            <div class="form-group">
                <label class=""><?= __("Auto close answered tickets older than") ?></label>
                <input type="number" step="1" class="form-control" name="tickets_autoclose" value="<?= get_setting('tickets_autoclose'); ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
                <span class="help-block text-muted"><?= __("Time (in hours) of inactivity after which ticket is closed (0 to disable)") ?></span>
            </div>



            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="tickets_autoclose_notif" value="0">
                        <input type="checkbox" name="tickets_autoclose_notif" value="1" <?php if(get_setting('tickets_autoclose_notif') == '1') echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Send auto close notification") ?></span>
                    </label>
                </div>
            </div>


            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
            </div>

        <?= form_close(); ?>

    </div>
</div>
