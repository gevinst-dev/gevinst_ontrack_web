<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <?= form_open(base_url('admin/inventory/assets/edit_notes/'.$asset['id'])); ?>
                <div class="card-block">
                    <div class="form-group">
                        <textarea class="form-controlsssss" id="tinymceinput" name="notes"><?= $asset['notes'] ?></textarea>
                    </div>
                </div>

                <?php if(has_permission('assets-edit')) { ?>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                </div>
                <?php } ?>

            <?= form_close(); ?>

        </div>
    </div>
</div>
