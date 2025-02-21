<div class="row">
    <div class="col-lg-12">


            <?= form_open(base_url('admin/clients/edit_notes/'.$client['id'])); ?>
                <div class="card-block">
                    <div class="form-group">
                        <textarea class="form-controlsssss" id="tinymceinput" name="notes"><?= purify($client['notes'] )?></textarea>
                    </div>
                </div>

                <?php if(has_permission('clients-edit')) { ?>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                </div>
                <?php } ?>

            <?= form_close(); ?>

        
    </div>
</div>
