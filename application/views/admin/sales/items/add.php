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
                        <input type="text" class="form-control" name="name">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Type") ?></label>
                        <select class="select2 form-control" name="type" required>
                            <option value="Service"><?= __("Service") ?></option>
                            <option value="Product"><?= __("Product") ?></option>
                        </select>
                    </div>
                </div>




                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("SKU") ?></label>
                        <input type="text" class="form-control" name="sku">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Net Price") ?></label>
                        <input type="number" class="form-control" name="price" required step="any">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Tax Rate") ?></label>
                        <select class="select2 form-control" name="taxrate" required>
                            <?php foreach($taxrates as $taxrate) { ?>
                                <option value="<?= $taxrate['rate']; ?>"><?=$taxrate['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>



            </div>

            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinput"></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="form-group">
                <label class=""><?= __("Select File") ?></label>
                <input type="file" class="form-control" name="userfile">
                <span class="help-block with-errors messages text-danger"></span>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Item") ?></button>
        </div>

    <?= form_close(); ?>

</div>
