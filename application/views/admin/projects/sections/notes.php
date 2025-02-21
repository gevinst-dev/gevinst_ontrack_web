<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <?= form_open(base_url('admin/projects/edit_notes/'.$project['id'])); ?>
                <div class="card-block">
                    <div class="form-group">
                        <textarea class="form-controlsssss" id="tinymceinput" name="notes"><?= $project['notes'] ?></textarea>
                    </div>
                </div>

                <?php if(has_permission('projects-edit')) { ?>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                    </div>
                <?php } ?>

            <?= form_close(); ?>

        </div>
    </div>
</div>
