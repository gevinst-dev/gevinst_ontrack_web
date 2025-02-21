<div class="modal-content">
    <?= form_open(NULL, 'id="modal-form"'); ?>

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
                <label class=""><?= __("Related Client") ?></label>
                <select class="select2 select2_clients form-control" name="client_id" >
                    <option value="0"><?= __("Nobody") ?></option>

                </select>
            </div>



            <div class="form-group">
                <label class=""><?= __("Status") ?></label>
                <select class="select2 form-control" name="status" required>
                    <option value="Draft"><?= __("Draft") ?></option>
                    <option value="In Progress" selected><?= __("In Progress") ?></option>
                    <option value="Done"><?= __("Done") ?></option>
                </select>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="row" id="customfields">
                <?php foreach ($customfields as $customfield) { ?>
                    <div class="col-md-6">
                        <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], "", $customfield['description']) ?>
                    </div>
                <?php } ?>
            </div>


            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinput"></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Project") ?></button>
        </div>

    <?= form_close(); ?>

</div>
