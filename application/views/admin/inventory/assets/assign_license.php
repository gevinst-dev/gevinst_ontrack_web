<div class="modal-content">
    <?= form_open(base_url('admin/inventory/assets/assign_license/'.$asset['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="row">


                <div class="col-md-12">
                    <label class=""><?= __("License") ?></label>
                    <select class="select2 form-control" name="license_id" id="license_id" required >
                        <option value=""><?= __("- Select license -") ?></option>
                        <?php foreach($licenses as $license) { ?>
                            <option value="<?= $license['id'] ?>"  ><?= $license['name'] ?> <?= $license['tag'] ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Assign") ?></button>
        </div>

    <?= form_close(); ?>

</div>
