<div class="modal-content">
    <?= form_open(base_url('admin/projects/add_asset_assignment/'.$project['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="form-group">
                <label class=""><?= __("Asset") ?></label>
                <select class="select2_assets_none form-control" name="asset_id" >

                </select>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Notes") ?></label>
                <textarea name="notes" rows="6" class="form-control" ></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>
