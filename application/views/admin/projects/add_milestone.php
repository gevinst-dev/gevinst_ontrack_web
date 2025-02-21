<div class="modal-content">
    <?= form_open(base_url('admin/projects/add_milestone/'.$project['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="form-group">
                <label class=""><?= __("Name") ?></label>
                <input type="text" class="form-control" name="name" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="form-group">
                <label class=""><?= __("Due Date") ?></label>
                <input type="text" class="form-control" name="due_date" id="datepicker">
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" rows="6" class="form-control" ></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>
