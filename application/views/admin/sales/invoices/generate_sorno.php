<div class="modal-content">
    <?= form_open(base_url('admin/sales/invoices/generate_storno/'.$invoice['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p>Sigur doriti sa generati factura storno?</p>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("No") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Generate") ?></button>
        </div>

    <?= form_close(); ?>

</div>
