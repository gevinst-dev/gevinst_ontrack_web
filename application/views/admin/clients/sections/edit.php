<div class="row">
    <div class="col-md-12">

        <?= form_open_multipart(base_url('admin/clients/edit/'.$client['id']), 'data-toggle="validator"'); ?>


                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class=""><?= __("Name") ?></label>
                            <input type="text" class="form-control" name="name" value="<?= $client['name']; ?>" required>
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>


                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class=""><?= __("Tax/VAT ID") ?></label>
                            <input type="text" class="form-control" name="company_taxid" value="<?= $client['company_taxid']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class=""><?= __("Company ID") ?></label>
                            <input type="text" class="form-control" name="company_id" value="<?= $client['company_id']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class=""><?= __("Phone") ?></label>
                            <input type="text" class="form-control" name="phone" value="<?= $client['phone']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class=""><?= __("Website") ?></label>
                            <input type="text" class="form-control" name="website" value="<?= $client['website']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class=""><?= __("Email") ?></label>
                            <input type="email" class="form-control" name="email" value="<?= $client['email']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>



                    <div class="col-md-8 ">
                        <div class="form-group">
                            <label class=""><?= __("Address") ?></label>
                            <input type="text" class="form-control" name="address" value="<?= $client['address']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class=""><?= __("Country") ?></label>
                            <input type="text" class="form-control" name="country" value="<?= $client['country']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class=""><?= __("City") ?></label>
                            <input type="text" class="form-control" name="city" value="<?= $client['city']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class=""><?= __("State") ?></label>
                            <input type="text" class="form-control" name="state" value="<?= $client['state']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class=""><?= __("Zip/Postal Code") ?></label>
                            <input type="text" class="form-control" name="zip_code" value="<?= $client['zip_code']; ?>">
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="form-group">
                            <label class=""><?= __("Description") ?></label>
                            <input type="text" class="form-control" name="description" value="<?= $client['description']; ?>" >
                            <span class="help-block with-errors messages text-danger"></span>
                        </div>
                    </div>




                </div>



                <div class="row" id="customfields">
                    <?php foreach ($customfields as $customfield) { ?>
                        <div class="col-md-6">
                            <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], extract_value($customfield['id'],$client['custom_fields_values']), $customfield['description'] ) ?>
                        </div>
                    <?php } ?>
                 </div>



            <div class="text-right">
                <?php if(has_permission('clients-edit')) { ?>
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                <?php } ?>
            </div>

        <?= form_close(); ?>



    </div>
</div>
