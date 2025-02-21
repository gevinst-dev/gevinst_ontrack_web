<div class="row">
    <div class="col-md-12">

        <?= form_open_multipart(base_url('admin/setup/settings/personalization'), 'data-toggle="validator"'); ?>






            <div class="form-group">
                <label class=""><?= __("Document Accent Color") ?></label>
                <input type="text" class="form-control" id="colorpicker" name="invoice_accent_color" value="<?= get_setting('invoice_accent_color'); ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Logo Light") ?></label>
                        <input type="file" class="form-control" name="logo_light">
                        <span class="help-block text-muted"><?= __("Select new file to change existing. PNG") ?></span>
                    </div>
                </div>

                <div class="col-md-6 padding-20">
                    <?php if(file_exists(FCPATH . 'public/logo_light.png')) { ?>
                        <img src='<?= base_url('public/logo_light.png')?>' class="settings-logolo">
                    <?php } else { ?>

                        <p><?= __("No image has been uploaded.") ?></p>
                    <?php } ?>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Logo Dark") ?></label>
                        <input type="file" class="form-control" name="logo_dark">
                        <span class="help-block text-muted"><?= __("Select new file to change existing. PNG") ?></span>
                    </div>
                </div>

                <div class="col-md-6 padding-20">
                    <?php if(file_exists(FCPATH . 'public/logo_dark.png')) { ?>
                        <img src='<?= base_url('public/logo_dark.png')?>' class="main-logo-d">
                    <?php } else { ?>

                        <p><?= __("No image has been uploaded.") ?></p>
                    <?php } ?>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Documents Logo") ?></label>
                        <input type="file" class="form-control" name="logo_pdf">
                        <span class="help-block text-muted"><?= __("Select new file to change existing. JPG") ?></span>
                    </div>
                </div>

                <div class="col-md-6 padding-20">
                    <?php if(file_exists(FCPATH . 'public/logo_pdf.jpg')) { ?>
                        <img src='<?= base_url('public/logo_pdf.jpg')?>' class="main-logo-d">
                    <?php } else { ?>

                        <p><?= __("No image has been uploaded.") ?></p>
                    <?php } ?>
                </div>
            </div>






            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Favicon 152px") ?></label>
                        <input type="file" class="form-control" name="favicon">
                        <span class="help-block text-muted"><?= __("Select new file to change existing. PNG") ?></span>
                    </div>
                </div>

                <div class="col-md-6 padding-20">
                    <?php if(file_exists(FCPATH . 'public/favicon.png')) { ?>
                        <img src='<?= base_url('public/favicon.png')?>' class="main-logo-d">
                    <?php } else { ?>

                        <p><?= __("No image has been uploaded.") ?></p>
                    <?php } ?>
                </div>
            </div>





            <p class="alert alert-info"><?= __("Images may not change immediately, clear browser cache after upload.") ?></p>




            <div class="form-group">
                <label class=""><?= __("Proposal Footer Text") ?></label>
                <textarea class="form-control" name="proposal_text"><?= get_setting('proposal_text'); ?></textarea>
            </div>

            <div class="form-group">
                <label class=""><?= __("Invoice Footer Text") ?></label>
                <textarea class="form-control" name="invoice_text"><?= get_setting('invoice_text'); ?></textarea>
            </div>






            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
            </div>

        <?= form_close(); ?>

    </div>
</div>
