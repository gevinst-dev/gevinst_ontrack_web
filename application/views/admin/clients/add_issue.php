<div class="modal-content">
    <?= form_open(NULL, 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Priority") ?></label>
                        <select class="select2 form-control" name="priority" required>
                            <option value="Low"><?= __("Low") ?></option>
                            <option value="Normal" selected><?= __("Normal") ?></option>
                            <option value="High"><?= __("High") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="issuetype"><?php _e('Type'); ?></label>
                        <select class="form-control select2-icon w-100" id="issuetype" name="type">
                            <option value="Task" data-icon="fa fa-check-square fa-fw text-primary"> <?= __('Task'); ?></option>
                            <option value="Maintenance" data-icon="fa fa-minus-square fa-fw text-warning"> <?= __('Maintenance'); ?></option>
                            <option value="Bug" data-icon="fa fa-bug fa-fw text-danger"> <?= __('Bug'); ?></option>
                            <option value="Improvement" data-icon="fa fa-external-link-square-alt fa-fw text-info"> <?= __('Improvement'); ?></option>
                            <option value="New Feature" data-icon="fa fa-plus-square fa-fw text-success"> <?= __('New Feature'); ?></option>
                            <option value="Story" data-icon="fa fa-circle fa-fw text-purple"> <?= __('Story'); ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Assign to") ?></label>
                        <select class="select2 form-control" name="assigned_to" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($staff as $item) { ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Due Date") ?></label>
                        <input type="text" class="form-control" name="due_date" id="datepicker">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>
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
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>
