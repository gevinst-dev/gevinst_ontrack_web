<div class="modal-content">
    <?= form_open_multipart(base_url('admin/content/knowledge_base/edit_category/'.$category['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="form-group">
                <label class=""><?= __("Name") ?></label>
                <input type="text" class="form-control" name="name" value="<?= $category['name'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Description") ?></label>
                <textarea name="description" class="form-control"><?= $category['description'] ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="form-group">
                <label class=""><?= __("Access Level") ?></label>
                <select class="select2 form-control" name="access" required>
                    <option value="Public" <?php if($category['access'] == "Public") echo "selected"; ?> ><?= __("Public (Guests, Users, Staff)") ?></option>
                    <option value="Users" <?php if($category['access'] == "Users") echo "selected"; ?>><?= __("Users (Users, Staff)") ?></option>
                    <option value="Staff" <?php if($category['access'] == "Staff") echo "selected"; ?>><?= __("Staff Only") ?></option>
                </select>
            </div>

            <div class="form-group">
                <label class=""><?= __("Main Image") ?></label>
                <input type="file" class="form-control" name="userfile">
                <span class="help-block with-errors messages text-danger"></span>
                <span class="help-block text-muted"><?= __("Select new image only if you want to replace the current image.") ?></span>
            </div>



            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="status" value="Draft">
                        <input type="checkbox" name="status" value="Published" <?php if($category['status'] == "Published") echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Published") ?></span>
                    </label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Cancel") ?></button>
            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
        </div>

    <?= form_close(); ?>

</div>
