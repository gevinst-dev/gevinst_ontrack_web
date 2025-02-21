<div class="modal-content">
    <?= form_open(base_url('admin/issues/set_inprogress/'.$issue['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p><?= __("Are you sure you want to set the following issue as in progress?") ?></p>

            <p><strong><?= $issue['name'] ?></strong></p>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Set") ?></button>
        </div>

    <?= form_close(); ?>

</div>
