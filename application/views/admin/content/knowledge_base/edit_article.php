<div class="modal-content">
    <?= form_open_multipart(base_url('admin/content/knowledge_base/edit_article/'.$article['id']), 'id="modal-form"'); ?>

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <div class="form-group">
                <label class=""><?= __("Name") ?></label>
                <input type="text" class="form-control" name="name" value="<?= $article['name'] ?>" required>
                <span class="help-block with-errors messages text-danger"></span>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class=""><?= __("Access Level") ?></label>
                        <select class="select2 form-control" name="access" required>
                            <option value="Public" <?php if($article['access'] == "Public") echo "selected"; ?> ><?= __("Public (Guests, Users, Staff)") ?></option>
                            <option value="Users" <?php if($article['access'] == "Users") echo "selected"; ?>><?= __("Users (Users, Staff)") ?></option>
                            <option value="Staff" <?php if($article['access'] == "Staff") echo "selected"; ?>><?= __("Staff Only") ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class=""><?= __("Category") ?></label>
                        <select class="select2 form-control" name="category_id" required>
                            <?php foreach($categories as $category) { ?>
                                <option value="<?= $category['id'] ?>" <?php if($category['id'] == $article['category_id']) echo "selected"; ?> ><?= $category['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class=""><?= __("Content") ?></label>
                <textarea name="content" class="form-control" id="tinymceinput"><?= $article['content'] ?></textarea>
                <span class="help-block with-errors messages text-danger"></span>
            </div>


            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="status" value="Draft">
                        <input type="checkbox" name="status" value="Published" <?php if($article['status'] == "Published") echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Published") ?></span>
                    </label>
                </div>
            </div>


            <div class="form-group">
                <div class="checkbox-fade fade-in-primary">
                    <label>
                        <input type="hidden" name="featured" value="0">
                        <input type="checkbox" name="featured" value="1" <?php if($article['featured'] == "1") echo "checked"; ?> >
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span><?= __("Featured") ?></span>
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
