<div class="modal-content">
    <?= form_open_multipart(base_url('admin/expenses/expenses/edit/'.$expense['id']), 'id="modal-form"'); ?>

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
                                <option value="<?php echo $entity['id']; ?>" <?php if($entity['id'] == $expense['entity_id']) echo "selected";  ?> ><?php echo $entity['name']; ?></option>
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
                                <option value="<?php echo $supplier['id']; ?>" <?php if($supplier['id'] == $expense['supplier_id']) echo "selected";  ?> ><?php echo $supplier['name']; ?></option>
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
                                <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $expense['category_id']) echo "selected";  ?> ><?php echo $item['name']; ?></option>
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
                                <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $expense['project_id']) echo "selected";  ?> ><?php echo $item['name']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?php _e('Status'); ?></label>
                        <select class="form-control select2" name="status" required>
                                <option value="Valid" <?php if("Valid" == $expense['status']) echo "selected";  ?>  ><?php _e('Valid'); ?></option>
                                <option value="Draft" <?php if("Draft" == $expense['status']) echo "selected";  ?> ><?php _e('Draft'); ?></option>
                                <option value="Canceled" <?php if("Canceled" == $expense['status']) echo "selected";  ?> ><?php _e('Canceled'); ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Date") ?></label>
                        <input type="text" class="form-control" name="date" id="datepicker" value="<?php echo date_display($expense['date']); ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>





                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <input type="text" class="form-control" name="description" value="<?= $expense['description'] ?>"  >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Value") ?>*</label>
                        <input type="number" step="any" class="form-control" name="value" id="value" value="<?= $expense['value'] ?>" required >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Tax") ?>*</label>
                        <input type="number" step="any" class="form-control" name="tax" id="tax" value="<?= $expense['tax'] ?>" required >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class=""><?= __("Total") ?>*</label>
                        <input type="number" step="any" class="form-control" name="total" id="total" value="<?= $expense['total'] ?>" value="0.00" required readonly >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class=""><?php _e('Currency'); ?>*</label>
                        <select class="form-control select2" name="currency_id" required>
                            <option value=""><?php _e('-- Select --'); ?></option>
                            <?php foreach ($currencies as $item) { ?>
                                <option value="<?php echo $item['id']; ?>" <?php if($item['id'] == $expense['currency_id']) echo "selected";  ?> ><?php echo $item['code']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                </div>

                <div class="col-md-2 ">
                    <div class="form-group">
                        <label class=""><?= __("Exchange Rate") ?>*</label>
                        <input type="number" step="any" class="form-control" name="rate" value="<?= $expense['rate'] ?>" required  >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>




                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Attachment") ?></label>
                        <input type="file" class="form-control" name="userfile">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                    <div class="alert alert-info">
                        <?= __("Select file only if you want to replace the current file.") ?>
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
