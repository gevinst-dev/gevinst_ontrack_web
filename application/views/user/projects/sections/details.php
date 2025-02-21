<div class="row">
    <div class="col-md-8">
        <div class="card">

      
                <div class="modal-body">


                    <h5><?= __("Name") ?></h5>
                    <?= $project['name']; ?>

                    <hr>

                    <h5><?= __("Status") ?></h5>
                    <?= __($project['status']); ?>

                    <hr>

                
                    <?php foreach ($customfields as $customfield) { ?>
                        <h5><?= $customfield['name']; ?></h5>
                        <?= extract_value($customfield['id'],$project['custom_fields_values']); ?>

                        <hr>
                            
                    <?php } ?>
                

                    <h5><?= __("Description") ?></h5>
                    <?= purify($project['description']); ?>

            


                </div>
         

            
        </div>
    </div>

    <div class="col-md-4">





        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Comments') ?></h5>
                <div class="card-header-right">




                </div>
            </div>
            <div class="card-body">
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
                                        <span class="lead"><?= $this->staff->get_name($comment['added_by']); ?> <span class="text-muted t-size-12"><?= datetime_display($comment['created_at']); ?></span></span>
                                    
                                    </div>
                                    <p class="m-t-15 m-b-0"><?= nl2br($comment['comment']); ?></p>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
        </div>



        <div class="card table-card">
            <div class="card-header">
                <h5><?= __('Files') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                        <button data-modal="projects/upload_file/<?= $project['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
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
                                        <td><a href="<?= base_url('projects/download_file/'.$file['id']) ?>"><?= $file['file']; ?></a></td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('projects/download_file/'.$file['id']) ?>" data-toggle="tooltip" title="<?= __('Download File') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-download"></i></a>
                                                
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
                <h5><?= __('Credentials') ?></h5>
                <div class="card-header-right">

                    <div class="btn-group" role="group" >

                
                    </div>

                </div>
            </div>
            <div class="card-body">
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

                                                <button data-modal="inventory/view_credential/<?= $credential['id']; ?>" data-toggle="tooltip" title="<?= __('View Credential') ?>" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>
                                               
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
