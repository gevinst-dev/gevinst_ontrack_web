<div class="row">
    <div class="col-md-8">
        <div class="card">


            <?= form_open_multipart(base_url('admin/sales/items/edit/'.$item['id']), 'data-toggle="validator"'); ?>
                <div class="card-block">



                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class=""><?= __("Name") ?></label>
                                <input type="text" class="form-control" name="name" value="<?= $item['name']; ?>" required>
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Type") ?></label>
                                <select class="select2 form-control" name="type" required>
                                    <option value="Service" <?php if($item['type'] == "Service") echo "selected"; ?> ><?= __("Service") ?></option>
                                    <option value="Product" <?php if($item['type'] == "Product") echo "selected"; ?> ><?= __("Product") ?></option>

                                </select>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("SKU") ?></label>
                                <input type="text" class="form-control" name="sku" value="<?= $item['sku']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Net Price") ?></label>
                                <input type="number" class="form-control" name="price" required step="any" value="<?= $item['price']; ?>">
                                <span class="help-block with-errors messages text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class=""><?= __("Tax Rate") ?></label>
                                <select class="select2 form-control" name="taxrate" required>
                                    <?php foreach($taxrates as $taxrate) { ?>
                                        <option value="<?= $taxrate['rate']; ?>" <?php if($item['taxrate'] == $taxrate['rate']) echo "selected"; ?> ><?=$taxrate['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>






                    </div>

                    <div class="form-group">
                        <label class=""><?= __("Description") ?></label>
                        <textarea name="description" class="form-control" id="tinymceinput"><?= $item['description']; ?></textarea>
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>



                    <div class="form-group">
                        <label class=""><?= __("Main Image") ?></label>
                        <input type="file" class="form-control" name="userfile">
                        <span class="help-block with-errors messages text-danger"></span>
                    </div>

                    <div class="alert alert-info">
                        <?= __("Select file only if you want to replace the current image.") ?>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
                </div>

            <?= form_close(); ?>
        </div>
    </div>

    <div class="col-md-4">

        <?php if($item['main_image'] != "") { ?>
            <div class="card table-card">
                <div class="card-header">
                    <h5><?= __('Main Image') ?></h5>
                </div>
                <div class="card-body">
                    <img src="<?= base_url('filestore/img_cache/'); ?><?= get_image($item['main_image'], 500, 300); ?>" class="img-fluid">
                </div>
            </div>
        <?php } ?>


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Additional Images') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <button data-modal="admin/sales/items/upload_image/<?= $item['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Upload Image') ?>
                        </button>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <?php if(empty($images)) { ?>
                    <?= __('No images have been uploaded.') ?>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0 without-header">
                            <tbody>
                                <?php foreach($images as $image) { ?>
                                    <tr>
                                        <td><a href="<?= base_url('admin/sales/items/download_image/'.$image['id']) ?>"><?= $image['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <button data-modal="admin/sales/items/view_image/<?= $image['id']; ?>" data-toggle="tooltip" title="<?= __('View Image') ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>
                                                <a href="<?= base_url('admin/sales/items/download_image/'.$image['id']) ?>" data-toggle="tooltip" title="<?= __('Download Image') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                <button data-modal="admin/sales/items/delete_image/<?= $image['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Image') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Files') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <button data-modal="admin/sales/items/upload_file/<?= $item['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                            <?= __('Upload File') ?>
                        </button>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <?php if(empty($files)) { ?>
                    <?= __('No files have been uploaded.') ?>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0 without-header">
                            <tbody>
                                <?php foreach($files as $file) { ?>
                                    <tr>
                                        <td><a href="<?= base_url('admin/sales/items/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/sales/items/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                <button data-modal="admin/sales/items/delete_file/<?= $file['id']; ?>" data-toggle="tooltip" title="<?= __('Delete File') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>


    </div>


</div>
