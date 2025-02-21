<div class="modal-content">
    <?= form_open(base_url('admin/inventory/credentials/edit/'.$credential['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="row">
                <div class="col-md-4">

                    <div class="form-group">
                        <label class=""><?= __("Client") ?></label>
                        <select class="select2 select2_clients_none form-control" name="client_id" >

                            <?php if($client) { ?>
                                <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>
                            <?php } else { ?>

                                <option value="0"><?= __("- Nobody -") ?></option>
                            <?php } ?>

                        </select>
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label class=""><?= __("Asset") ?></label>
                        <select class="select2 select2_assets_none form-control" name="asset_id" >

                            <?php if($asset) { ?>
                                <option value="<?php echo $asset['id']; ?>"><?php echo $asset['tag']; ?> <?php echo $asset['name']; ?></option>
                            <?php } else { ?>

                                <option value="0"><?= __("Nobody") ?></option>
                            <?php } ?>

                        </select>
                    </div>

                </div>


                <div class="col-md-4">

                    <div class="form-group">
                        <label class=""><?= __("Project") ?></label>
                        <select class="select2 select2_projects_none form-control" name="project_id" >

                            <?php if($project) { ?>
                                <option value="<?php echo $project['id']; ?>"><?php echo $project['name']; ?></option>
                            <?php } else { ?>

                                <option value="0"><?= __("Nobody") ?></option>
                            <?php } ?>

                        </select>
                    </div>

                </div>


            </div>


            <div class="form-group">
                <label class=""><?= __("Type") ?></label>
                <input type="text" class="form-control" name="type" value="<?= $credential['type'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Username") ?></label>
                <input type="text" class="form-control" name="username" value="<?= $credential['username'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Password") ?></label>
                <input type="text" class="form-control" name="pswd">
                <span class="help-block with-errors messages text-danger"></span>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
