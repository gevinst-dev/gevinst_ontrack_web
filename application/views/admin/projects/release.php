<div class="modal-content">
    <?= form_open(base_url('admin/projects/release/'.$project['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label class=""><?= __("Milestone") ?></label>
                <select class="select2 form-control" name="milestone_id" required>
                    <option value=""><?= __("-- Please select --") ?></option>
                    <?php foreach($milestones as $item) { ?>
                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                    <?php } ?>
                </select>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <p class="alert alert-info"><?= __('This operation will mark all issues currently into the Done board and attach them to the selected milestone.') ?></p>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Release") ?></button>
        </div>

    <?= form_close(); ?>

</div>
