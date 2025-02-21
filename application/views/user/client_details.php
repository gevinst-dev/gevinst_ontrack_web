<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="feather icon-user bg-c-blue"></i>
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


                            <?= form_open(base_url('client_details'), 'data-toggle="validator"'); ?>


                                <div class="row">
          


                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class=""><?= __("Name") ?></label>
                                            <input type="text" class="form-control" name="name" value="<?= $client['name']; ?>" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-6 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Tax/VAT ID") ?></label>
                                            <input type="text" class="form-control" name="company_taxid" value="<?= $client['company_taxid']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-6 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Company ID") ?></label>
                                            <input type="text" class="form-control" name="company_id" value="<?= $client['company_id']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-4 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Phone") ?></label>
                                            <input type="text" class="form-control" name="phone" value="<?= $client['phone']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-4 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Website") ?></label>
                                            <input type="text" class="form-control" name="website" value="<?= $client['website']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-4 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Email") ?></label>
                                            <input type="email" class="form-control" name="email" value="<?= $client['email']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>



                                    <div class="col-8 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Address") ?></label>
                                            <input type="text" class="form-control" name="address" value="<?= $client['address']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-4 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Country") ?></label>
                                            <input type="text" class="form-control" name="country" value="<?= $client['country']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-4 ">
                                        <div class="form-group">
                                            <label class=""><?= __("City") ?></label>
                                            <input type="text" class="form-control" name="city" value="<?= $client['city']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-4 ">
                                        <div class="form-group">
                                            <label class=""><?= __("State") ?></label>
                                            <input type="text" class="form-control" name="state" value="<?= $client['state']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-4 ">
                                        <div class="form-group">
                                            <label class=""><?= __("Zip/Postal Code") ?></label>
                                            <input type="text" class="form-control" name="zip_code" value="<?= $client['zip_code']; ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class=""><?= __("Description") ?></label>
                                            <input type="text" class="form-control" name="description" value="<?= $client['description']; ?>" >
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>



                                </div>


    


                                <div class="text-right">
                                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
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
