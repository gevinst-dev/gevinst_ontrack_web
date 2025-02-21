<div class="modal-content">
    <?= form_open(base_url('admin/inventory/licenses/assign_asset/'.$license['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="row">


                <div class="col-md-12">
                    <label class=""><?= __("Asset") ?></label>
                    <select class="select2 form-control" name="asset_id" id="asset_id" required >
                        <option value=""><?= __("- Select asset -") ?></option>
                        <?php foreach($assets as $asset) { ?>
                            <option value="<?= $asset['id'] ?>"  ><?= $asset['name'] ?> <?= $asset['tag'] ?></option>
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
