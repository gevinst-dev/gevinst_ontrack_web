<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-ticket-alt bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
              
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

                        <div class="col-xl-8 col-md-12">
                            <div class="card comp-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        
                                        <div class="col">
                                            <h3 class="f-w-700 text-c-blue">#<?= $ticket['ticket']; ?></h3>
                                            <h3 class="f-w-700"><?= $ticket['subject']; ?></h3>
                                            <br>
                                            <p class="m-b-0">
                                               
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            <?php if($ticket['priority'] == "Low") { ?>
                                                <i class="fas fa-flag bg-c-green" data-toggle="tooltip" title="<?= __('Low priority') ?>"></i>
                                            <?php } else if($ticket['priority'] == "Normal") { ?>
                                                <i class="fas fa-flag bg-c-blue" data-toggle="tooltip" title="<?= __('Normal priority') ?>"></i>
                                            <?php } else { ?>
                                                <i class="fas fa-flag bg-c-red" data-toggle="tooltip" title="<?= __('High priority') ?>"></i>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>







                            <?php if(empty($replies)) { ?>

                                <p class="alert alert-info"><?= __('No replies have been added.') ?></p>

                            <?php } else { ?>
                                <?php foreach($replies as $reply) { ?>
                                    <div class="card table-card">
                                        <div class="card-header">

                                            <?php if($reply['staff_id'] == "0") { ?>
                                                <img src="<?= gravatar($ticket['email'], 24); ?>" alt="user image" class="img-radius profile-img cust-img ">&nbsp;&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <img src="<?= gravatar($this->staff->get_email($reply['staff_id']), 24); ?>" alt="user image" class="img-radius profile-img cust-img ">&nbsp;&nbsp;&nbsp;
                                            <?php } ?>



                                            <h5>
                                                <?php if($reply['staff_id'] == "0") { ?>
                                                    <?= $ticket['email']; ?>
                                                <?php } else { ?>
                                                    <?= $this->staff->get_name($reply['staff_id']); ?>
                                                <?php } ?>
                                            </h5>
                                            <div class="card-header-right">
                                                <span class="text-muted t-size-12"><?= datetime_display($reply['created_at']); ?></span>
                                            </div>
                                        </div>


                                        <div class="card-body">

                                            <div class="ticket-reply-overflow">
                                                <?= purify($reply['message']); ?>
                                            </div>

                                            <br>

                                            <?php $files = $this->ticket->get_reply_files($reply['id']); ?>

                                            <?php if(!empty($files)) { ?>
                                                <ul>
                                                    <?php foreach($files as $file) { ?>
                                                        <li><a href="<?= base_url('tickets/download_reply_file/'.$file['id']) ?>"><i class="fas fa-fw fa-file"></i><?= $file['name']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>





                            <div class="card table-card">
                                <div class="card-header">
                                    <h5><?= __('Add Reply') ?></h5>

                                    <div class="card-header-right">

                                        <div class="btn-group" role="group" >

                                        

                                        </div>

                                    </div>


                                </div>
                                <div class="card-body">
                                    <?= form_open_multipart(base_url('tickets/add_reply/'.$ticket['id']), 'id="modal-form"'); ?>

                                    <div class="form-group">
                                        <textarea name="message" rows="6" class="form-control" id="tinymceinput" ></textarea>
                                        <span class="help-block with-errors messages text-danger"></span>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class=""><?= __("Attach Files") ?></label>
                                                <input type="file" class="form-control" name="userfiles[]" multiple>
                                                <span class="help-block with-errors messages text-danger"></span>
                                            </div>
                                        </div>

                                  

                                        <div class="col-md-4">
                                            <div class="text-right">
                                                <br>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Reply") ?></button>
                                            </div>
                                        </div>
                                    </div>

                                    <?= form_close(); ?>
                                </div>
                            </div>

                          

                        </div>


                        <div class="col-xl-4 col-md-12">


                            <div class="card table-card">
                                <div class="card-header">
                                    <h5><?= __('Ticket Details') ?></h5>

                                </div>
                                <div class="card-body p-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-simple">
                                            <tbody>
                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Ticket #') ?><br>
                                                        <?= $ticket['ticket']; ?>
                                                    </td>
                                           
                                                </tr>
                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Subject') ?><br>
                                                        <?= $ticket['subject']; ?>
                                                    </td>
                                                  
                                                </tr>
                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Status') ?><br>
                                                        <?php if($ticket['status'] == 'Open') { ?>
                                                            <span class="label label-primary"><?= __('Open') ?></span>
                                                        <?php } ?>

                                                        <?php if($ticket['status'] == 'In Progress') { ?>
                                                            <span class="label label-warning"><?= __('In Progres') ?></span>
                                                        <?php } ?>

                                                        <?php if($ticket['status'] == 'Answered') { ?>
                                                            <span class="label label-success"><?= __('Answered') ?></span>
                                                        <?php } ?>

                                                        <?php if($ticket['status'] == 'Reopened') { ?>
                                                            <span class="label label-danger"><?= __('Reopened') ?></span>
                                                        <?php } ?>

                                                        <?php if($ticket['status'] == 'Closed') { ?>
                                                            <span class="label label-default"><?= __('Closed') ?></span>
                                                        <?php } ?>
                                                    </td>
                                               
                                                </tr>
                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Priority') ?><br>
                                                        <?php if($ticket['priority'] == 'Low') { ?>
                                                            <span class="label label-inverse-success"><?= __('Low') ?></span>
                                                        <?php } else if($ticket['priority'] == 'Normal') { ?>
                                                            <span class="label label-inverse-primary"><?= __('Normal') ?></span>
                                                        <?php } else { ?>
                                                            <span class="label label-inverse-danger"><?= __('High') ?></span>
                                                        <?php } ?>
                                                    </td>
                                           
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Email') ?><br>
                                                        <?= $ticket['email']; ?>
                                                    </td>
                                          
                                                </tr>




                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Asset') ?><br>
                                                        <?= get_asset_name($ticket['asset_id']); ?>
                                                    </td>
                                                    
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('License') ?><br>
                                                        <?= get_license_name($ticket['license_id']); ?>
                                                    </td>
                                                   
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Project') ?><br>
                                                        <?= get_project_name($ticket['project_id']); ?>
                                                    </td>
                                              
                                                </tr>


                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Created At') ?><br>
                                                        <?= datetime_display($ticket['created_at']); ?>
                                                    </td>
                                               
                                                </tr>

                                                <tr>
                                                    <td class="text-right">
                                                        <?= __('Last Updated') ?><br>
                                                        <?= datetime_display($ticket['updated_at']); ?>
                                                    </td>
                                              
                                                </tr>


                                                <?php foreach ($customfields as $customfield) { ?>


                                                    <tr>
                                                        <td class="text-right">
                                                            <?= __($customfield['name']); ?><br>
                                                            <?= extract_value($customfield['id'],$ticket['custom_fields_values']); ?>
                                                        </td>
                                                   
                                                    </tr>



                                                <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
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
