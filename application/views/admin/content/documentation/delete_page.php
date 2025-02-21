<div class="modal-content">
    <?= form_open(base_url('admin/content/documentation/delete_page/'.$page['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p><?= __("Are you sure you want to delete the following page?") ?></p>

            <p><strong><?= $page['name'] ?></strong></p>

            <p><b><?= __("This will also delete any subpages of this page.") ?></b></p>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-danger waves-effect waves-light "><?= __("Delete") ?></button>
        </div>

    <?= form_close(); ?>

</div>
