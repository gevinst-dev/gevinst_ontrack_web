<div class="modal-content">
    <?= form_open(base_url('admin/tickets/delete/'.$ticket['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p><?= __("Are you sure you want to delete the following ticket?") ?></p>

            <p><strong>#<?= $ticket['ticket'] ?> - <?= $ticket['subject'] ?></strong></p>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-danger waves-effect waves-light "><?= __("Delete") ?></button>
        </div>

    <?= form_close(); ?>

</div>
