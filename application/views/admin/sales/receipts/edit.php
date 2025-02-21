<div class="modal-content">
    <?= form_open(base_url('admin/sales/receipts/edit/'.$receipt['id']), 'id="modal-form"'); ?>

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
                                <option value="<?= $item['id'] ?>" <?php if($receipt['entity_id'] == $item['id']) echo 'selected'; ?> ><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Method") ?></label>
                        <select class="select2 form-control" name="paymentmethod_id" required>
                            <?php foreach($paymentmethods as $item) { ?>
                                <option value="<?= $item['id'] ?>" <?php if($receipt['paymentmethod_id'] == $item['id']) echo 'selected'; ?> ><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Currency") ?></label>
                        <select class="select2 form-control" name="currency_id" required>
                            <?php foreach($currencies as $item) { ?>
                                <option value="<?= $item['id'] ?>" <?php if($receipt['currency_id'] == $item['id']) echo 'selected'; ?> ><?= $item['code'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Date") ?></label>
                        <input type="text" class="form-control" name="date" id="datepicker" value="<?php echo date_display($receipt['date']); ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Client") ?></label>
                        <select class="select2_clients_none form-control" name="client_id" id="client_id" required>
                            <?php if($receipt['client_id'] == "0") { ?>
                                <option value="0" selected="selected"><?= __("None") ?></option>
                            <?php } else { ?>
                                <option value="<?= $receipt['client_id'] ?>" selected="selected"><?= $client['name'] ?> (<?= $client['company_taxid'] ?>)</option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Amount") ?></label>
                        <input type="number" class="form-control" name="amount" step="any" value="<?= $receipt['amount'] ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Rate") ?></label>
                        <input type="number" class="form-control" name="rate" step="any" value="<?= $receipt['rate'] ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?php _e('Status'); ?></label>
                        <select class="form-control select2" name="status" required>
                                <option value="Valid" <?php if($receipt['status'] == "Valid") echo "selected"; ?> ><?php _e('Valid'); ?></option>
                                <option value="Canceled" <?php if($receipt['status'] == "Canceled") echo "selected"; ?> ><?php _e('Canceled'); ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-8">
                    <div class="form-group">
                        <label class=""><?= __("Tag Invoices") ?></label>
                        <select class="select2_unpaid_invoices_edit form-control" name="tagged_invoices[]" multiple>
                            <?php
                                if($receipt['tagged_invoices'] != "") {
                                    $tagged_invoices = unserialize($receipt['tagged_invoices']);
                                    foreach ($tagged_invoices as $tagged_invoice) {
                                        $invoice = $this->db->get_where('app_invoices', array('id' => $tagged_invoice))->row_array();
                                        ?>
                                            <option value="<?= $tagged_invoice; ?>" selected><?= $invoice['number']; ?> | <?= date_display($invoice['date']); ?></option>
                                        <?php
                                    }

                                }

                            ?>

                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Reference") ?></label>
                        <input type="text" class="form-control" name="reference" value="<?= $receipt['reference'] ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


            </div>



            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinputX"><?= $receipt['description'] ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <input type="hidden" name="receipt_id" id="receipt_id" value="<?= $receipt['id'] ?>">


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>


            <a href="<?= base_url('admin/sales/receipts/pdf/view/'.$receipt['id']); ?>" class="btn btn-primary waves-effect" target="_blank"><?= __('Print Receipt') ?></a>
            <a href="<?= base_url('admin/sales/receipts/pdf/download/'.$receipt['id']); ?>" class="btn btn-primary waves-effect"><?= __('Download Receipt') ?></a>


            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Receipt") ?></button>
        </div>

    <?= form_close(); ?>

</div>
