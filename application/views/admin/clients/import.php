<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-sitemap bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">

                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <!-- Page Body start -->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">
                        <div class="card-block">


                        <?= form_open_multipart(NULL, 'id="modal-form"'); ?>
                                <div class="form-group">
                                    <label class=""><?= __("Select File") ?></label>
                                    <input type="file" class="form-control" name="userfile" required>
                                    <span class="help-block with-errors messages text-danger"></span>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="hidden" name="skip_first_line" value="0">
                                            <input type="checkbox" name="skip_first_line" value="1" checked>
                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                            <span><?= __("Skip first line") ?></span>
                                        </label>
                                    </div>
                                </div>

                                <p class="alert alert-info">
                                    <?= __('CSV file only, comma separated, use provided sample file.'); ?>
                                </p>



                                <div class="modal-footer">
                                    <a href="<?= base_url('filestore/samples/clients_import.csv'); ?>" target="_blank" class="btn btn-default waves-effect" ><?= __("Download Sample File") ?></a>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Import") ?></button>
                                </div>

                            <?= form_close(); ?>


                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>




