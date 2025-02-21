<div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">



            <ul class="nav nav-tabs  tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#main" role="tab"><?= __('Main Details') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#user" role="tab"><?= __('User') ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#credentials" role="tab"><?= __('Credentials') ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#licenses" role="tab"><?= __('Assigned Licenses') ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#files" role="tab"><?= __('Files') ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#comments" role="tab"><?= __('Comments') ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#notes" role="tab"><?= __('Notes') ?></a>
                </li>

            </ul>

            <div class="tab-content tabs card-block">
                <div class="tab-pane active" id="main" role="tabpanel">
                    <div class="row">
                        <div class="col-md-8 m-10">


                            <table class="table table-striped table-simple">

                                <tr>
                                    <th><?= __("Name"); ?></th>
                                    <td><?= $asset['name']; ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Tag"); ?></th>
                                    <td><?= $asset['tag']; ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Category"); ?></th>
                                    <td><?= get_asset_category_name($asset['category_id']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Status"); ?></th>
                                    <td><?= get_status_name($asset['status_id']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Client"); ?></th>
                                    <td><?= get_client_name($asset['client_id']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("User"); ?></th>
                                    <td>
                                        <?php if(empty($user)) { ?>
                                            <?= __('None'); ?>
                                        <?php } else { ?>
                                            <?= $user['name'] ?>
                                        <?php } ?>

                                    </td>
                                </tr>


                                <tr>
                                    <th><?= __("Location"); ?></th>
                                    <td><?= get_location_name($asset['location_id']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Supplier"); ?></th>
                                    <td><?= get_supplier_name($asset['supplier_id']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Manufacturer"); ?></th>
                                    <td><?= get_manufacturer_name($asset['manufacturer_id']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Model"); ?></th>
                                    <td><?= get_model_name($asset['model_id']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Purchase Date"); ?></th>
                                    <td><?= date_display($asset['purchase_date']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Warranty Expiration"); ?></th>
                                    <td><?= date_display($asset['warranty_end']); ?></td>
                                </tr>

                                <tr>
                                    <th><?= __("Serial Number"); ?></th>
                                    <td><?= $asset['serial_number']; ?></td>
                                </tr>




                                <?php foreach ($customfields as $customfield) { ?>


                                    <tr>
                                        <th><?= __($customfield['name']); ?></th>
                                        <td><?= extract_value($customfield['id'],$asset['custom_fields_values']); ?></td>
                                    </tr>



                                <?php } ?>



                            </table>


                        </div>

                        <div class="col-md-3 m-10">
                            <?php if($asset['main_image'] != "") { ?>
                                <img src="<?= base_url('filestore/img_cache/'); ?><?= get_image($asset['main_image'], 500, 300); ?>" class="img-fluid">
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="user" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12 m-10">
                            <?php if(!empty($user)) { ?>

                                <table class="table table-striped table-simple">

                                    <tr>
                                        <th><?= __("Name"); ?></th>
                                        <td><?= $user['name']; ?></td>
                                    </tr>

                                    <tr>
                                        <th><?= __("Designation"); ?></th>
                                        <td><?= $user['designation']; ?></td>
                                    </tr>

                                    <tr>
                                        <th><?= __("Email"); ?></th>
                                        <td><?= $user['email']; ?></td>
                                    </tr>

                                    <tr>
                                        <th><?= __("Client"); ?></th>
                                        <td><?= get_client_name($user['client_id']); ?></td>
                                    </tr>





                                </table>
                            <?php } else { ?>

                                <p><?= __('No user is currently assigned.') ?></p>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="credentials" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12 m-10">
                            <?php if(empty($credentials)) { ?>
                                <?= __('No credentials have been added.') ?>
                            <?php } else { ?>
                                <div class="table-responsive">
                                    <table class="table  table-hover m-b-0 ">
                                        <thead>
                                            <tr>
                                                <th><?= __('Type') ?></th>
                                                <th><?= __('Username') ?></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($credentials as $credential) { ?>
                                                <tr>
                                                    <td><?= $credential['type']; ?></td>
                                                    <td><?= $credential['username']; ?></td>

                                                    <td class="text-right">
                                                        <div class="btn-group" role="group">

                                                            <button data-modal="admin/inventory/credentials/view/<?= $credential['id']; ?>" data-toggle="tooltip" title="<?= __('View Credential') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>

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

                <div class="tab-pane" id="licenses" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12 m-10">
                            <?php if(empty($assigned_licenses)) { ?>
                                <?= __('No licenses have been assigned.') ?>
                            <?php } else { ?>
                                <div class="table-responsive">
                                    <table class="table  table-hover m-b-0 ">
                                        <thead>
                                            <tr>
                                                <th><?= __('License Tag') ?></th>
                                                <th><?= __('License Name') ?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($assigned_licenses as $assigned_license) { ?>
                                                <?php
                                                    $license = $this->license->get($assigned_license['license_id']);
                                                ?>
                                                <tr>
                                                    <td><?= $license['tag']; ?></td>
                                                    <td><?= $license['name']; ?></td>


                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="files" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12 m-10">
                            <?php if(empty($files)) { ?>
                                <?= __('No files have been uploaded.') ?>
                            <?php } else { ?>
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0 without-header">
                                        <tbody>
                                            <?php foreach($files as $file) { ?>
                                                <tr>
                                                    <td><a href="<?= base_url('admin/inventory/assets/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                                    <td class="text-right">
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= base_url('admin/inventory/assets/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>

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

                <div class="tab-pane" id="comments" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12 m-10">
                            <?php if(empty($comments)) { ?>
                                <?= __('No comments have been added.') ?>
                            <?php } else { ?>
                                <div class="review-block">
                                    <?php foreach($comments as $comment) { ?>
                                        <div class="row m-b-10">
                                            <div class="col-sm-auto p-r-0">
                                                <img src="<?= gravatar($this->staff->get_email($comment['added_by']), 50); ?>" alt="user image" class="img-radius profile-img cust-img m-b-15">
                                            </div>
                                            <div class="col">
                                                <div class="m-b-15">
                                                    <span class="lead"><?= $this->staff->get_name($comment['added_by']); ?> <span class="text-muted f-size-12"><?= datetime_display($comment['created_at']); ?></span></span>

                                                </div>
                                                <p class="m-t-15 m-b-0"><?= nl2br($comment['comment']); ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="notes" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12 m-10">
                            <?= $asset['notes']; ?>
                        </div>
                    </div>

                </div>


            </div>




        </div>
        <div class="modal-footer">
            <a href="<?= base_url('admin/inventory/assets/details/'.$asset['id']) ?>" class="btn btn-inverse waves-effect" ><?= __("Manage") ?></a>
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>

        </div>


</div>
