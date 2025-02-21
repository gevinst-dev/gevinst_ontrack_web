<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <?= form_open(base_url('admin/sales/items/edit_notes/'.$item['id'])); ?>
                <div class="card-block">
                    <div class="form-group">
                        <textarea class="form-controlsssss" id="tinymceinput" name="notes"><?= $item['notes'] ?></textarea>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                </div>

            <?= form_close(); ?>

        </div>
    </div>
</div>
