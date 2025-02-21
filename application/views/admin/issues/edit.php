<div class="modal-content">
    <?= form_open(base_url('admin/issues/edit/'.$issue['id']), 'id="modal-form"'); ?>

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
                        <input type="text" class="form-control" name="name" value="<?= $issue['name'] ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Priority") ?></label>
                        <select class="select2 form-control" name="priority" required>
                            <option value="Low" <?php if($issue['priority'] == "Low") echo "selected"; ?> ><?= __("Low") ?></option>
                            <option value="Normal" <?php if($issue['priority'] == "Normal") echo "selected"; ?> ><?= __("Normal") ?></option>
                            <option value="High" <?php if($issue['priority'] == "High") echo "selected"; ?> ><?= __("High") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="issuetype"><?php _e('Type'); ?></label>
                        <select class="form-control select2-icon w-100" id="issuetype" name="type">
                            <option value="Task" data-icon="fa fa-check-square fa-fw text-primary" <?php if($issue['type'] == "Task") echo "selected"; ?> > <?= __('Task'); ?></option>
                            <option value="Maintenance" data-icon="fa fa-minus-square fa-fw text-warning" <?php if($issue['type'] == "Maintenance") echo "selected"; ?> > <?= __('Maintenance'); ?></option>
                            <option value="Bug" data-icon="fa fa-bug fa-fw text-danger" <?php if($issue['type'] == "Bug") echo "selected"; ?> > <?= __('Bug'); ?></option>
                            <option value="Improvement" data-icon="fa fa-external-link-square-alt fa-fw text-info" <?php if($issue['type'] == "Improvement") echo "selected"; ?> > <?= __('Improvement'); ?></option>
                            <option value="New Feature" data-icon="fa fa-plus-square fa-fw text-success" <?php if($issue['type'] == "New Feature") echo "selected"; ?> > <?= __('New Feature'); ?></option>
                            <option value="Story" data-icon="fa fa-circle fa-fw text-purple" <?php if($issue['type'] == "Story") echo "selected"; ?> > <?= __('Story'); ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Assigned to") ?></label>
                        <select class="select2 form-control" name="assigned_to" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($staff as $item) { ?>
                                <option value="<?= $item['id'] ?>" <?php if($item['id'] == $issue['assigned_to']) echo "selected"; ?> ><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Due Date") ?></label>
                        <input type="text" class="form-control" name="due_date" value="<?= date_display($issue['due_date']) ?>" id="datepicker">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-12">
                    <hr>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Client") ?></label>
                        <select class="select2_clients_none form-control" name="client_id" >
                            <?php if($client) { ?>
                                <option value="<?= $client['id'] ?>" selected><?= $client['name'] ?> (<?= $client['company_id'] ?>)</option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("user") ?></label>
                        <select class="select2_users_none form-control" name="user_id" >
                            <?php if($user) { ?>
                                <option value="<?= $user['id'] ?>" selected><?= $user['name'] ?> <?= $user['email'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Asset") ?></label>
                        <select class="select2_assets_none form-control" name="asset_id" >
                            <?php if($asset) { ?>
                                <option value="<?= $asset['id'] ?>" selected><?= $asset['tag'] ?> <?= $asset['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("License") ?></label>
                        <select class="select2_licenses_none form-control" name="license_id" >
                            <?php if($license) { ?>
                                <option value="<?= $license['id'] ?>" selected><?= $license['tag'] ?> <?= $license['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Project") ?></label>
                        <select class="select2_projects_none form-control" name="project_id" >
                            <?php if($project) { ?>
                                <option value="<?= $project['id'] ?>" selected><?= $project['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

            </div>



            <div class="row" id="customfields">

                <?php foreach ($customfields as $customfield) { ?>
                    <div class="col-md-6">
                        <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], extract_value($customfield['id'],$issue['custom_fields_values']), $customfield['description'] ) ?>
                    </div>
                <?php } ?>

            </div>



            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control" id="tinymceinput"><?= $issue['description'] ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>








        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
