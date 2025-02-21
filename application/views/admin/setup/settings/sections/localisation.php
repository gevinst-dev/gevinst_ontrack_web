<div class="row">
    <div class="col-md-12">

        <?= form_open(base_url('admin/setup/settings/localisation'), 'data-toggle="validator"'); ?>


            <div class="form-group">
                <label class=""><?php _e('Timezone'); ?></label>
                <select class="form-control select2" name="timezone" required>
                    <?php foreach ($timezones as $key => $value) { ?>
                        <option <?php if(get_setting('timezone') == $value) echo 'selected'; ?> value="<?php echo $value; ?>"><?php echo $key; ?></option>
                    <?php } ?>
                </select>
            </div>


            <div class="form-group">
                <label class=""><?= __("Date Format") ?></label>
                <select class="form-control select2" name="date_format" required>
                    <option <?php if(get_setting('date_format') == "d/m/Y;dd/mm/yyyy") echo 'selected'; ?> value="d/m/Y;dd/mm/yyyy">DD/MM/YYYY</option>
                    <option <?php if(get_setting('date_format') == "d.m.Y;dd.mm.yyyy") echo 'selected'; ?> value="d.m.Y;dd.mm.yyyy">DD.MM.YYYY</option>
                    <option <?php if(get_setting('date_format') == "d-m-Y;dd-mm-yyyy") echo 'selected'; ?> value="d-m-Y;dd-mm-yyyy">DD-MM-YYYY</option>
                    <option <?php if(get_setting('date_format') == "m/d/Y;mm/dd/yyyy") echo 'selected'; ?> value="m/d/Y;mm/dd/yyyy">MM/DD/YYYY</option>
                    <option <?php if(get_setting('date_format') == "Y/m/d;yyyy/mm/dd") echo 'selected'; ?> value="Y/m/d;yyyy/mm/dd">YYYY/MM/DD</option>
                    <option <?php if(get_setting('date_format') == "Y-m-d;yyyy-mm-dd") echo 'selected'; ?> value="Y-m-d;yyyy-mm-dd">YYYY-MM-DD</option>
                </select>
            </div>


            <div class="form-group">
                <label class=""><?= __("First Day of the Week") ?></label>
                <select class="form-control select2" name="week_start" required>
                    <option <?php if(get_setting('week_start') == "0") echo 'selected'; ?> value="0"><?= __("Sunday") ?></option>
                    <option <?php if(get_setting('week_start') == "1") echo 'selected'; ?> value="1"><?= __("Monday") ?></option>
                </select>
            </div>

            <div class="form-group">
                <label class=""><?php _e('Default Language'); ?></label>
                <select class="form-control select2" name="default_language" required>
                    <?php foreach ($languages as $language) { ?>
                        <option <?php if(get_setting('default_language') == $language['id']) echo 'selected'; ?> value="<?php echo $language['id']; ?>"><?php echo $language['name']; ?></option>
                    <?php } ?>
                </select>
            </div>


            <div class="form-group">
                <label class=""><?= __("Decimal Separator") ?></label>
                <select class="form-control select2" name="decimal_separator" required>
                    <option <?php if(get_setting('decimal_separator') == "0") echo 'selected'; ?> value=".">.</option>
                    <option <?php if(get_setting('decimal_separator') == ",") echo 'selected'; ?> value=",">,</option>
                </select>
            </div>

            <div class="form-group">
                <label class=""><?= __("Thousands Separator") ?></label>
                <select class="form-control select2" name="thousands_separator" >
                    <option <?php if(get_setting('thousands_separator') == "0") echo 'selected'; ?> value=".">.</option>
                    <option <?php if(get_setting('thousands_separator') == ",") echo 'selected'; ?> value=",">,</option>
                    <option <?php if(get_setting('thousands_separator') == " ") echo 'selected'; ?> value=" ">Space</option>
                </select>
            </div>



            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
            </div>

        <?= form_close(); ?>

    </div>
</div>
