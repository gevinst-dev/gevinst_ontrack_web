<div class="modal-content">


    <?php if($role['name'] != "Super Administrator") {  ?>
        <?= form_open(base_url('admin/setup/roles/delete/'.$role['id']), 'id="modal-form"'); ?>

            <div class="modal-header">
                <h4 class="modal-title"><?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p><?= __("Are you sure you want to delete the following role?") ?></p>

                <p><strong><?= $role['name'] ?></strong></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
                <button type="submit" class="btn btn-danger waves-effect waves-light "><?= __("Delete") ?></button>
            </div>

        <?= form_close(); ?>


    <?php } else { ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">

            <p class="alert alert-warning"><?= __('The Super Administrator role cannot be deleted.') ?></p>

        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>
            
        </div>

    <?php } ?>

</div>
