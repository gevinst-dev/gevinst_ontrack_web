<div class="modal-content">
    <?= form_open(base_url('admin/sales/invoices/manage_payment/'.$invoice['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">


            <p><b><?= __("Invoice Total") ?>: </b> <?= $invoice['total']; ?> </p>
            <div class="form-group">
                <label class=""><?= __("Amount Received") ?></label>
                <input type="number" step="any" class="form-control" name="paid" value="<?= $invoice['paid'] ?>">
                <span class="help-block with-errors messages text-danger"></span>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
