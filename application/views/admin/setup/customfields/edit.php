<div class="modal-content">
    <?= form_open(base_url('admin/setup/customfields/edit/'.$customfield['id']), 'id="modal-form"'); ?>

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
                        <label class=""><?= __("For") ?></label>
                        <select class="select2 form-control" name="for" required>
                            <option value=""><?= __("- Please select -") ?></option>

                            <option value="Assets" <?php if($customfield['for'] == "Assets") echo "selected"; ?> ><?= __("Assets") ?></option>
                            <option value="Licenses" <?php if($customfield['for'] == "Licenses") echo "selected"; ?> ><?= __("Licenses") ?></option>
                            <option value="Projects" <?php if($customfield['for'] == "Projects") echo "selected"; ?> ><?= __("Projects") ?></option>

                            <option value="Tickets" <?php if($customfield['for'] == "Tickets") echo "selected"; ?> ><?= __("Tickets") ?></option>
                            <option value="Issues" <?php if($customfield['for'] == "Issues") echo "selected"; ?> ><?= __("Issues") ?></option>

                            <option value="Clients" <?php if($customfield['for'] == "Clients") echo "selected"; ?> ><?= __("Clients") ?></option>

                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Type") ?></label>
                        <select class="select2 form-control" name="type" required>
                            <option value=""><?= __("- Please select -") ?></option>

                            <option value="Text Box" <?php if($customfield['type'] == "Text Box") echo "selected"; ?> ><?= __("Text Box") ?></option>
                            <option value="Text Area" <?php if($customfield['type'] == "Text Area") echo "selected"; ?> ><?= __("Text Area") ?></option>
                            <option value="Dropdown" <?php if($customfield['type'] == "Dropdown") echo "selected"; ?> ><?= __("Dropdown") ?></option>
                        </select>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Name") ?></label>
                        <input type="text" class="form-control" name="name" value="<?= $customfield['name'] ?>" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <input type="text" class="form-control" name="description" value="<?= $customfield['description'] ?>" >
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class=""><?= __("Options") ?></label>
                        <input type="text" class="form-control" name="options" value="<?= $customfield['options'] ?>" >
                        <span class="help-block with-errors messages text-muted"><?= __("For Dropdowns Only - Comma Seperated List") ?></span>
                    </div>
                </div>



                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="hidden" name="required" value="0">
                                <input type="checkbox" name="required" value="1" <?php if($customfield['required'] == "1") echo "checked"; ?> >
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span><?= __("Required") ?></span>
                            </label>
                        </div>
                    </div>
                </div>












            </div>




        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
