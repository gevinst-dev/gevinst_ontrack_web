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
                <div class="col-md-8">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Title") ?></label>
                        <input type="text" class="form-control" name="title" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>
            </div>












            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Invoice Prefix") ?></label>
                        <input type="text" class="form-control" name="invoice_prefix" value="" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Next Invoice Number") ?></label>
                        <input type="number" class="form-control" name="invoice_next" value="" required step="1" min="0">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Proforma Prefix") ?></label>
                        <input type="text" class="form-control" name="proforma_prefix" value="" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Next Proforma Number") ?></label>
                        <input type="number" class="form-control" name="proforma_next" value="" required step="1" min="0">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Proposal Prefix") ?></label>
                        <input type="text" class="form-control" name="proposal_prefix" value="" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Next Proposal Number") ?></label>
                        <input type="number" class="form-control" name="proposal_next" value="" required step="1" min="0">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Receipt Prefix") ?></label>
                        <input type="text" class="form-control" name="receipt_prefix" value="" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Next Receipt Number") ?></label>
                        <input type="number" class="form-control" name="receipt_next" value="" required step="1" min="0">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>









                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Contract Prefix") ?></label>
                        <input type="text" class="form-control" name="ctr_prefix" value="" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Next Contract Number") ?></label>
                        <input type="number" class="form-control" name="ctr_next" value="" required step="1" min="0">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>








            </div>


            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinput"></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Entity") ?></button>
        </div>

    <?= form_close(); ?>

</div>
