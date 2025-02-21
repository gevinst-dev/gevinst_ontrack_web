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

                <div class="col-md-8">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>


                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class=""><?= __("Client") ?></label>
                                <select class="select2 select2_clients form-control" name="client_id" >
                                    <option value="0"><?= __("- Nobody -") ?></option>

                                </select>
                            </div>

                        </div>


                        <div class="col-md-6">


                            <div class="form-group">
                                <label class=""><?= __("Location") ?></label>

                                <div class="row">
                                    <div class="col-md-10">
                                        <select class="select2 form-control" name="location_id" id="location_id" >
                                            <option value="0"><?= __("- Select or add new -") ?></option>
                                            <?php foreach($locations as $location) { ?>
                                                <option value="<?= $location['id'] ?>" ><?= $location['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary btn-sm asset-new-location" type="button" >+</button>
                                        </div>
                                    </div>


                                    <div class="col-md-12 dynamic-input-group" id="new_location">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="new_location" placeholder="<?= __("Location Name") ?>">
                                        </div>


                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class=""><?= __("Purchase Date") ?></label>
                                <input type="text" class="form-control datepicker" name="purchase_date" >
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>




                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=""><?= __("Warranty Expiration Date") ?></label>
                                <input type="text" class="form-control datepicker" name="warranty_end" >
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=""><?= __("Serial Number") ?></label>
                                <input type="text" class="form-control" name="serial_number" >
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


                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=""><?= __("Asset Photo") ?></label>
                                <input type="file" class="form-control" name="userfile">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>
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
                                    <button class="btn btn-secondary btn-sm asset-new-status" type="button" >+</button>
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
                                    <?php foreach($asset_categories as $asset_category) { ?>
                                        <option value="<?= $asset_category['id'] ?>" ><?= $asset_category['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm asset-new-asset-category" type="button" >+</button>
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
                                    <button class="btn btn-secondary btn-sm asset-new-supplier" type="button" >+</button>
                                </div>
                            </div>


                            <div class="col-md-12 dynamic-input-group" id="new_supplier">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_supplier" placeholder="<?= __("Supplier Name") ?>">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <label class=""><?= __("Manufacturer") ?></label>

                        <div class="row">
                            <div class="col-md-10">
                                <select class="select2 form-control" name="manufacturer_id" id="manufacturer_id" >
                                    <option value="0"><?= __("- Select or add new -") ?></option>
                                    <?php foreach($manufacturers as $manufacturer) { ?>
                                        <option value="<?= $manufacturer['id'] ?>" ><?= $manufacturer['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm asset-new-manufacturer" type="button" >+</button>
                                </div>
                            </div>


                            <div class="col-md-12 dynamic-input-group" id="new_manufacturer">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_manufacturer" placeholder="<?= __("Manufacturer Name") ?>">
                                </div>
                            </div>

                        </div>

                    </div>



                    <div class="form-group">
                        <label class=""><?= __("Model") ?></label>

                        <div class="row">
                            <div class="col-md-10">
                                <select class="select2 form-control" name="model_id"  id="model_id" >
                                    <option value="0"><?= __("- Select or add new -") ?></option>
                                    <?php foreach($models as $model) { ?>
                                        <option value="<?= $model['id'] ?>" ><?= $model['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm asset-new-model" type="button">+</button>
                                </div>
                            </div>


                            <div class="col-md-12 dynamic-input-group" id="new_model">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="new_model" placeholder="<?= __("Model Name") ?>">
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
