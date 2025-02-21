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

                <?php if(isset($_GET['client_id'])) { ?>
                    <input type="hidden" name="client_id" value="<?= $_GET['client_id'] ?>">
                <?php } else { ?>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label class=""><?= __("Client") ?></label>
                            <select class="select2 select2_clients_none form-control" name="client_id" >
                                <option value="0"><?= __("- Nobody -") ?></option>

                            </select>
                        </div>

                    </div>
                <?php } ?>


                <?php if(isset($_GET['asset_id'])) { ?>
                    <input type="hidden" name="asset_id" value="<?= $_GET['asset_id'] ?>">
                <?php } else { ?>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label class=""><?= __("Asset") ?></label>
                            <select class="select2 select2_assets_none form-control" name="asset_id" >
                                <option value="0"><?= __("- None -") ?></option>

                            </select>
                        </div>

                    </div>
                <?php } ?>


                <div class="col-md-4">

                    <div class="form-group">
                        <label class=""><?= __("Project") ?></label>
                        <select class="select2 select2_projects_none form-control" name="project_id" >
                            <option value="0"><?= __("- None -") ?></option>

                        </select>
                    </div>

                </div>


            </div>


            <div class="form-group">
                <label class=""><?= __("Type") ?></label>
                <input type="text" class="form-control" name="type" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Username") ?></label>
                <input type="text" class="form-control" name="username" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Password") ?></label>
                <input type="text" class="form-control" name="pswd" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add") ?></button>
        </div>

    <?= form_close(); ?>

</div>
