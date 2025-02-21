<div class="modal-content">
    <?= form_open(base_url('admin/inventory/domains/edit/'.$domain['id']), 'id="modal-form"'); ?>

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
                        <label class=""><?= __("Domain") ?></label>
                        <input type="text" class="form-control" name="domain" value="<?= $domain['domain']; ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Related Client") ?></label>
                        <select class="select2 select2_clients form-control" name="client_id" >
                            <?php if($client) { ?>
                                <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?> - <?php echo $client['company_taxid']; ?></option>
                            <?php } else { ?>

                                <option value="0"><?= __("Nobody") ?></option>
                            <?php } ?>


                        </select>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Notify") ?></label>
                        <select class="select2 form-control" name="notify[]" multiple="multiple" >

                            <?php foreach($staff as $item) { ?>
                                <option value="<?= $item['id'] ?>" <?php if(in_array($item['id'], $selected_notify)) echo "selected"; ?>  ><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>




                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Expiry Date") ?></label>
                        <input type="text" class="form-control" name="exp_date" id="datepicker" value="<?= date_display($domain['exp_date']) ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="notify_30" value="0">
                                <input type="checkbox" name="notify_30" value="1" <?php if($domain['notify_30'] == "1") echo "checked"; ?> >
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Notify staff 30 days before") ?></span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="notify_14" value="0">
                                <input type="checkbox" name="notify_14" value="1" <?php if($domain['notify_14'] == "1") echo "checked"; ?>>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Notify staff 14 days before") ?></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="notify_7" value="0">
                                <input type="checkbox" name="notify_7" value="1" <?php if($domain['notify_7'] == "1") echo "checked"; ?>>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Notify staff 7 days before") ?></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="notify_3" value="0">
                                <input type="checkbox" name="notify_3" value="1" <?php if($domain['notify_3'] == "1") echo "checked"; ?>>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Notify staff 3 days before") ?></span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="notify_0" value="0">
                                <input type="checkbox" name="notify_0" value="1" <?php if($domain['notify_0'] == "1") echo "checked"; ?>>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Notify staff on expiry") ?></span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="notify_client" value="0">
                                <input type="checkbox" name="notify_client" value="1" <?php if($domain['notify_client'] == "1") echo "checked"; ?>>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Notify the client too") ?></span>
                            </label>
                        </div>
                    </div>
                </div>












            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
