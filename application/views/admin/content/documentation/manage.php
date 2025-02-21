<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-book bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">
                    <button data-modal="admin/content/documentation/add_page/<?= $space['id'] ?>" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Page') ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <!-- Page Body start -->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">

                                <div class="card-block tree-view">

                                    <div id="basicTree">
                                        <?php documentation_page_tree($space['id'], 0, $selected_page_id); ?>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-block">

                                    <?php if(empty($selected_page)) { ?>

                                        <div class="alert alert-info background-info">
                                            <strong><?= __('This space is empty!') ?></strong> <br><?= __('Start adding pages to start editing this documentation space.') ?>
                                        </div>

                                    <?php } else { ?>


                                        <?= form_open(base_url('admin/content/documentation/edit_page/'.$selected_page['id']), 'id="modal-form"'); ?>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class=""><?= __("Name") ?></label>
                                                        <input type="text" class="form-control" name="name" value="<?= $selected_page['name'] ?>" required>
                                                        <span class="help-block with-errors messages text-danger"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class=""><?= __("Parent Page") ?></label>
                                                        <select class="select2 form-control" name="parent_id" required>
                                                            <option value="0">[<?= __("ROOT") ?>]</option>
                                                            <?php echo documentation_page_select($space['id'],0,0,$selected_page['parent_id']); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class=""><?= __("Sort Order") ?></label>
                                                        <input type="number" class="form-control" name="sort" step="1" value="0" value="<?= $selected_page['sort'] ?>" required>
                                                        <span class="help-block with-errors messages text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class=""><?= __("Content") ?></label>
                                                <textarea name="content" class="form-control" id="tinymceinput"><?= $selected_page['content'] ?></textarea>
                                                <span class="help-block with-errors messages text-danger"></span>
                                            </div>


                                            <div class="form-group">
                                                <div class="checkbox-fade fade-in-primary">
                                                    <label>
                                                        <input type="hidden" name="status" value="Draft">
                                                        <input type="checkbox" name="status" value="Published" <?php if($selected_page['status'] == "Published") echo "checked"; ?> >
                                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                        <span><?= __("Published") ?></span>
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="checkbox-fade fade-in-primary">
                                                    <label>
                                                        <input type="hidden" name="folder" value="0">
                                                        <input type="checkbox" name="folder" value="1" <?php if($selected_page['folder'] == "1") echo "checked"; ?> >
                                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                        <span><?= __("Folder only") ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="<?= __("Select only if this page has no content and will have subpages.") ?>" ></i></span>
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="text-right">
                                                <button data-modal="admin/content/documentation/delete_page/<?= $selected_page['id'] ?>" type="button" class="btn btn-danger waves-effect waves-light"><?= __("Delete Page") ?></button>

                                                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                                            </div>

                                        <?= form_close(); ?>


                                    <?php } ?>

                                </div>

                            </div>
                        </div>

                    </div>





                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>



