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

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Entity") ?></label>
                        <select class="select2 form-control" name="entity_id" required>
                            <?php foreach($entities as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Method") ?></label>
                        <select class="select2 form-control" name="paymentmethod_id" required>
                            <?php foreach($paymentmethods as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Currency") ?></label>
                        <select class="select2 form-control" name="currency_id" required>
                            <?php foreach($currencies as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['code'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Date") ?></label>
                        <input type="text" class="form-control" name="date" id="datepicker" value="<?php echo date_display(date('Y-m-d')); ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Client") ?></label>
                        <select class="select2_clients_none form-control" name="client_id" id="client_id">

                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Amount") ?></label>
                        <input type="number" class="form-control" name="amount" step="any" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Rate") ?></label>
                        <input type="number" class="form-control" name="rate" step="any" value="1.00" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-8">
                    <div class="form-group">
                        <label class=""><?= __("Tag Invoices") ?></label>
                        <select class="select2_unpaid_invoices form-control" name="tagged_invoices[]" multiple>


                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="auto_tag" value="0">
                                <input type="checkbox" name="auto_tag" id="auto_tag" value="1">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Automatically tag invoices") ?></span>
                            </label>
                        </div>
                    </div>

                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Reference") ?></label>
                        <input type="text" class="form-control" name="reference" id="reference_input">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="receipt" value="0">
                                <input type="checkbox" name="receipt" id="receipt_checkbox" value="1">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Auto-increment reference") ?></span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">


                </div>

            </div>

            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinputX"></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="form-group">

            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Receipt") ?></button>
        </div>

    <?= form_close(); ?>

</div>



<script>



    $(document).ready(function() {







    });

</script>
