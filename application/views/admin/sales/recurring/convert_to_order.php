<div class="modal-content">
    <?= form_open(base_url('admin/sales/proposals/convert_to_order/'.$proposal['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p><?= __("Are you sure you want to convert the following proposal to order?") ?></p>

            <p><strong><?= $proposal['number'] ?></strong></p>


            <div class="form-group">
                <label class=""><?= __("Delivery Date") ?></label>
                <input type="text" class="form-control" name="delivery_date" id="datepicker2" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("No") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Yes") ?></button>
        </div>

    <?= form_close(); ?>

</div>
