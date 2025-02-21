<div class="modal-content">
    <?= form_open_multipart(base_url('admin/expenses/recurring/add/'), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">


            <div class="row">


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?php _e('Entity'); ?>*</label>
                        <select class="form-control select2" name="entity_id" required>
                            <?php foreach ($entities as $entity) { ?>
                                <option value="<?php echo $entity['id']; ?>"><?php echo $entity['name']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?php _e('Supplier'); ?>*</label>
                        <select class="form-control select2" name="supplier_id" required>
                            <option value=""><?php _e('-- Select --'); ?></option>
                            <?php foreach ($suppliers as $supplier) { ?>
                                <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?php _e('Category'); ?>*</label>
                        <select class="form-control select2" name="category_id" required>
                            <option value=""><?php _e('-- Select --'); ?></option>
                            <?php foreach ($expense_categories as $item) { ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?php _e('Project'); ?></label>
                        <select class="form-control select2" name="project_id" >
                            <option value=""><?php _e('-- Select --'); ?></option>
                            <?php foreach ($projects as $item) { ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?php _e('Status'); ?></label>
                        <select class="form-control select2" name="status" required>
                            <option value="Draft"><?= __("Draft") ?></option>
                            <option value="Active"><?= __("Active") ?></option>
                            <option value="Suspended"><?= __("Suspended") ?></option>
                            <option value="Canceled"><?= __("Canceled") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Start Date") ?></label>
                        <input type="text" class="form-control" name="start_date" id="datepicker" value="<?php echo date_display(date('Y-m-d', time() + 86400)); ?>" required>
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

                <div class="col-md-12">
                    <hr>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Value") ?>*</label>
                        <input type="number" step="any" class="form-control" name="value" id="value" required >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Tax") ?>*</label>
                        <input type="number" step="any" class="form-control" name="tax" id="tax" required >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class=""><?= __("Total") ?>*</label>
                        <input type="number" step="any" class="form-control" name="total" id="total" value="0.00" required readonly >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class=""><?php _e('Currency'); ?>*</label>
                        <select class="form-control select2" name="currency_id" required>
                            <option value=""><?php _e('-- Select --'); ?></option>
                            <?php foreach ($currencies as $item) { ?>
                                <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == get_setting('default_currency')) echo "selected";  ?> ><?php echo $item['code']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?php _e('Frequency'); ?></label>
                        <select class="form-control select2" name="frequency" required>
                            <option value=""><?php _e('Plesae select'); ?></option>

                            <option value="Monthly"><?php _e('Monthly'); ?></option>
                            <option value="Weekly"><?php _e('Weekly'); ?></option>
                            <option value="Daily"><?php _e('Daily'); ?></option>
                            <option value="At 2 Weeks"><?php _e('At 2 Weeks'); ?></option>
                            <option value="At 2 Months"><?php _e('At 2 Months'); ?></option>
                            <option value="At 3 Months"><?php _e('At 3 Months'); ?></option>
                            <option value="At 6 Months"><?php _e('At 6 Months'); ?></option>
                            <option value="Yearly"><?php _e('Yearly'); ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Limit") ?></label>
                        <input type="text" class="form-control" name="emission_limit" value="-1">
                        <span class="help-block with-errors messages text-danger"></span>
                        <span class="help-block with-errors messages text-muted"><?= __("-1 for unlimited.") ?></span>
                    </div>
                </div>




                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Attachment") ?></label>
                        <input type="file" class="form-control" name="userfile">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



            </div>






        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>







<script type="text/javascript">



    $(document).ready(function() {

        $('#value').on('input', function(e)
        {
   

            var value = $('#value').val();
            var tax = $('#tax').val();

            if(tax == "") tax = 0;

            total = parseFloat(value) + parseFloat(tax);

            $('#total').val( total.toFixed(2) );

        });



            $('#tax').on('input', function(e)
            {
     

                var value = $('#value').val();
                var tax = $('#tax').val();

                if(tax == "") tax = 0;

                total = parseFloat(value) + parseFloat(tax);

                $('#total').val( total.toFixed(2) );

            });



    });



</script>
