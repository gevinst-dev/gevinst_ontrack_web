<div class="modal-content">
    <?= form_open(base_url('admin/tickets/edit/'.$ticket['id']), 'id="modal-form"'); ?>

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
                        <label class=""><?= __("Subject") ?></label>
                        <input type="text" class="form-control" name="subject" value="<?= $ticket['subject']; ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Priority") ?></label>
                        <select class="select2 form-control" name="priority" required>
                            <option value="Low" <?php if($ticket['priority'] == "Low") echo 'selected'; ?> ><?= __("Low") ?></option>
                            <option value="Normal" <?php if($ticket['priority'] == "Normal") echo 'selected'; ?> ><?= __("Normal") ?></option>
                            <option value="High" <?php if($ticket['priority'] == "High") echo 'selected'; ?> ><?= __("High") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=""><?= __("Status") ?></label>
                        <select class="select2 form-control" name="status" required>
                            <option value="Open" <?php if($ticket['status'] == "Open") echo 'selected'; ?> ><?= __("Open") ?></option>
                            <option value="Reopened" <?php if($ticket['status'] == "Reopened") echo 'selected'; ?> ><?= __("Reopened") ?></option>
                            <option value="In Progress" <?php if($ticket['status'] == "In Progress") echo 'selected'; ?> ><?= __("In Progress") ?></option>
                            <option value="Answered" <?php if($ticket['status'] == "Answered") echo 'selected'; ?> ><?= __("Answered") ?></option>
                            <option value="Closed" <?php if($ticket['status'] == "Closed") echo 'selected'; ?> ><?= __("Closed") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("User") ?></label>
                        <select class="select2 form-control" name="user_id" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($users as $user) { ?>
                                <option value="<?= $user['id'] ?>" <?php if($ticket['user_id'] == $user['id']) echo 'selected'; ?> ><?= $user['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Email Address") ?></label>
                        <input type="email" class="form-control" name="email" value="<?= $ticket['email']; ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class=""><?= __("Assigned to") ?></label>
                        <select class="select2 form-control" name="assigned_to" required>
                            <option value="0"><?= __("Nobody") ?></option>
                            <?php foreach($staff as $item) { ?>
                                <option value="<?= $item['id'] ?>" <?php if($ticket['assigned_to'] == $item['id']) echo 'selected'; ?> ><?= $item['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("CC Recipients") ?></label>
                        <input type="text" class="form-control" name="cc" value="<?= $ticket['cc']; ?>">
                        <span class="help-block with-errors messages text-danger"></span>
                        <span class="help-block text-muted"><?= __("Comma separated") ?></span>
                    </div>
                </div>





                <div class="col-md-12">
                    <hr>
                </div>

                <div class="col-md-3">
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

                <div class="col-md-3">
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

                <div class="col-md-3">
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

                <div class="col-md-3">
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
                            <?= render_customfield($customfield['id'],$customfield['type'],$customfield['name'],$customfield['required'],$customfield['options'], extract_value($customfield['id'],$ticket['custom_fields_values']), $customfield['description'] ) ?>
                        </div>
                    <?php } ?>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
