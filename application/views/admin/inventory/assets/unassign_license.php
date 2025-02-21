<div class="modal-content">
    <?= form_open(base_url('admin/inventory/assets/unassign_license/'.$assigned_license['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="row">


                <div class="col-md-12">

                    <p>
                        <?= __('Are you sure you want to unassign this license?') ?>
                    </p>

                    <p>
                        <b><?= $license['tag']; ?> - <?= $license['name']; ?></b>
                    </p>

                </div>


            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Unassign") ?></button>
        </div>

    <?= form_close(); ?>

</div>
