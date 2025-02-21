<div class="modal-content">
    <?= form_open(base_url('admin/content/documentation/add_page/'.$space['id']), 'id="modal-form"'); ?>

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


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Parent Page") ?></label>
                        <select class="select2 form-control" name="parent_id" required>
                            <option value="0">[<?= __("ROOT") ?>]</option>
                            <?php echo documentation_page_select($space['id'],0,0,'none'); ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class=""><?= __("Sort Order") ?></label>
                        <input type="number" class="form-control" name="sort" step="1" value="0" required>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="status" value="Draft">
                        <input type="checkbox" name="status" value="Published" checked>
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Published") ?></span>
                    </label>
                </div>
            </div>


            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="folder" value="0">
                        <input type="checkbox" name="folder" value="1">
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Folder only") ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="<?= __("Select only if this page has no content and will have subpages.") ?>" ></i></span>
                    </label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Page") ?></button>
        </div>

    <?= form_close(); ?>

</div>
