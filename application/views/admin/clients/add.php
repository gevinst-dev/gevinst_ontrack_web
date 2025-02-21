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
                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" id="name">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-6">


                    <div class="form-group ">
                        <label class=""><?= __("Tax/VAT ID") ?></label>
                        <input type="text" class="form-control" name="company_taxid" id="company_taxid">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>

                <div class="col-md-6 ">
                    <div class="form-group">
                        <label class=""><?= __("Company ID") ?></label>
                        <input type="text" class="form-control" name="company_id" id="company_id">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="form-group">
                        <label class=""><?= __("Phone") ?></label>
                        <input type="text" class="form-control" name="phone" id="phone">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label class=""><?= __("Website") ?></label>
                        <input type="text" class="form-control" name="website" id="website">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="form-group">
                        <label class=""><?= __("Email") ?></label>
                        <input type="email" class="form-control" name="email" id="email">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-8 ">
                    <div class="form-group">
                        <label class=""><?= __("Address") ?></label>
                        <input type="text" class="form-control" name="address" id="address">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="form-group">
                        <label class=""><?= __("Country") ?></label>
                        <input type="text" class="form-control" name="country" id="country">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4 ">
                    <div class="form-group">
                        <label class=""><?= __("City") ?></label>
                        <input type="text" class="form-control" name="city" id="city">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="form-group">
                        <label class=""><?= __("State") ?></label>
                        <input type="text" class="form-control" name="state" id="state">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="form-group">
                        <label class=""><?= __("Zip/Postal Code") ?></label>
                        <input type="text" class="form-control" name="zip_code" id="zip_code">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <input type="text" class="form-control" name="description" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>







            </div>

            <div class="row" id="customfields">
                <?php foreach ($customfields as $customfield) { ?>
                    <div class="col-md-6">
                        <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], "", $customfield['description']) ?>
                    </div>
                <?php } ?>
            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Client") ?></button>
        </div>

    <?= form_close(); ?>

</div>
