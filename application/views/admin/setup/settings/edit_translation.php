<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="feather icon-settings bg-c-blue"></i>
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



    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->

                    <div class="card">
                        <div class="card-block">


                            <?php $max_input_vars = ini_get('max_input_vars');
                            $reguired_vars = count($translations) + 10;
                            if($max_input_vars < $reguired_vars) { ?>
                                <p class="alert alert-danger">
                                    PHP <code>max_input_vars</code> is below the required value to edit this form.<br>
                                    Current value <b><?= $max_input_vars ?></b><br>
                                    A recommended value will be <b><?= $reguired_vars + 1000 ?></b>
                                </p>
                            <?php } ?>


                            <?php if($language_id == 1) { ?>
                                <p class="alert alert-warning">
                                     You are translating the main language (English). This will allow you overwrite default strings.
                                     
                                </p>
                            <?php } ?>

                            <?= form_open(base_url('admin/setup/settings/edit_translation/'.$language_id), 'data-toggle="validator"'); ?>

                            <table class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th><?= __('Original String') ?></th>
                                        <th><?= __('Translation') ?></th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($translations as $translation) { ?>
                                        <tr>
                                            <td><?= $translation['original_string']; ?></td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="<?= $translation['id']; ?>" value="<?= $translation['translated_string']; ?>" required>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>



                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                                </div>

                            <?= form_close(); ?>


                        </div>
                    </div>



                    <!-- [ page content ] ends -->
                </div>
            </div>
        </div>
    </div>


</div>
