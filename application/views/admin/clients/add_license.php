<div class="modal-content">
    <?= form_open(NULL, 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>



        <div class="modal-body">



            <div class="row">

                <div class="col-md-8">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>




                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class=""><?= __("Serial Number") ?></label>
                                <input type="text" class="form-control" name="serial_number" >
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Seats") ?></label>
                                <input type="number" class="form-control" name="seats" step="1" >
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                    </div>


                    <div class="row" id="customfields">


                        <?php foreach ($customfields as $customfield) { ?>

                            <div class="col-md-12">
                                <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], "", $customfield['description']) ?>
                            </div>


                        <?php } ?>


                    </div>


                </div>


                <div class="col-md-4">

                    <div class="form-group">
                        <label class=""><?= __("Tag") ?></label>
                        <input type="text" class="form-control" name="tag" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>


                    <div class="form-group">
                        <label class=""><?= __("Status") ?></label>

                        <div class="row">
                            <div class="col-md-10">
                                <select class="select2 form-control" name="status_id" id="status_id" >
                                    <option value="0"><?= __("- Select or add new -") ?></option>
                                    <?php foreach($status_labels as $status_label) { ?>
                                        <option value="<?= $status_label['id'] ?>" ><?= $status_label['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm license-new-status" type="button">+</button>
                                </div>
                            </div>

                            <div class="col-md-12 dynamic-input-group" id="new_status">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_status" placeholder="<?= __("Status Name") ?>">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_status_color" id="colorpicker" value="#000000" placeholder="<?= __("Status Color") ?>">
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <label class=""><?= __("Category") ?></label>

                        <div class="row">
                            <div class="col-md-10">
                                <select class="select2 form-control" name="category_id" id="category_id" >
                                    <option value="0"><?= __("- Select or add new -") ?></option>
                                    <?php foreach($license_categories as $license_category) { ?>
                                        <option value="<?= $license_category['id'] ?>" ><?= $license_category['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm license-new-asset-category" type="button" >+</button>
                                </div>
                            </div>


                            <div class="col-md-12 dynamic-input-group" id="new_asset_category">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_asset_category" placeholder="<?= __("Category Name") ?>">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_asset_category_color" id="colorpicker2" value="#000000" placeholder="<?= __("Status Color") ?>">
                                </div>
                            </div>

                        </div>

                    </div>



                    <div class="form-group">
                        <label class=""><?= __("Supplier") ?></label>

                        <div class="row">
                            <div class="col-md-10">
                                <select class="select2 form-control" name="supplier_id" id="supplier_id" >
                                    <option value="0"><?= __("- Select or add new -") ?></option>
                                    <?php foreach($suppliers as $supplier) { ?>
                                        <option value="<?= $supplier['id'] ?>" ><?= $supplier['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm license-new-supplier" type="button" >+</button>
                                </div>
                            </div>


                            <div class="col-md-12 dynamic-input-group" id="new_supplier">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_supplier" placeholder="<?= __("Supplier Name") ?>">
                                </div>
                            </div>

                        </div>

                    </div>








                </div>



                <div class="col-md-8">


                </div>

            </div>






        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>
