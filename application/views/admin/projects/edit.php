<div class="modal-content">
    <?= form_open(base_url('admin/projects/edit/'.$project['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label class=""><?= __("Name") ?></label>
                <input type="text" class="form-control" name="name" value="<?= $project['name']; ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="form-group">
                <label class=""><?= __("Related Client") ?></label>
                <select class="select2 select2_clients form-control" name="client_id" >
                    <?php if($client) { ?>
                        <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?> - <?php echo $client['company_taxid']; ?></option>
                    <?php } else { ?>

                        <option value="0"><?= __("Nobody") ?></option>
                    <?php } ?>


                </select>
            </div>



            <div class="form-group">
                <label class=""><?= __("Status") ?></label>
                <select class="select2 form-control" name="status" required>
                    <option value="Draft" <?php if($project['status'] == "Draft") echo "selected"; ?> ><?= __("Draft") ?></option>
                    <option value="In Progress" <?php if($project['status'] == "In Progress") echo "selected"; ?> ><?= __("In Progress") ?></option>
                    <option value="Done" <?php if($project['status'] == "Done") echo "selected"; ?> ><?= __("Done") ?></option>
                </select>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="row" id="customfields">
                <?php foreach ($customfields as $customfield) { ?>
                    <div class="col-md-6">
                        <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], extract_value($customfield['id'],$project['custom_fields_values']), $customfield['description'] ) ?>
                    </div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinput"><?= $project['description']; ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
