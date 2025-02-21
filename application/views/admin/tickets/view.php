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
                <div class="text-right">
                    <?php if(has_permission('tickets-add')) { ?>
                        <button data-modal="admin/tickets/add" class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Ticket') ?></button>
                    <?php } ?>
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

                        <div class="col-xl-8 col-md-12">
                            <div class="card comp-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="f-w-700 text-c-blue">#<?= $ticket['ticket']; ?></h3>
                                            <h3 class="f-w-700"><?= $ticket['subject']; ?></h3>
                                            <br>
                                            <p class="m-b-0">

                                                <?php if(has_permission('tickets-edit')) { ?>
                                                    <?php if($ticket['status'] == 'Closed') { ?>
                                                        <button data-modal="admin/tickets/reopen/<?= $ticket['id']; ?>" class="btn btn-sm btn-warning waves-effect waves-light" data-toggle="tooltip" title="<?= __('Reopen Ticket') ?>"><?= __('Reopen') ?></button>
                                                    <?php } else { ?>
                                                        <button data-modal="admin/tickets/close/<?= $ticket['id']; ?>" class="btn btn-sm btn-default waves-effect waves-light" data-toggle="tooltip" title="<?= __('Close Ticket') ?>"><?= __('Close') ?></button>
                                                    <?php } ?>

                                                    <button data-modal="admin/tickets/assign/<?= $ticket['id']; ?>" class="btn btn-sm btn-inverse waves-effect waves-light" data-toggle="tooltip" title="<?= __('Assign/Reassign') ?>">
                                                        <?php if($ticket['assigned_to'] == 0) { ?>
                                                            <?= __('Assign') ?>
                                                        <?php } else { ?>
                                                            <?= __('Reassign') ?>
                                                        <?php } ?>
                                                    </button>
                                                    <button data-modal="admin/tickets/edit/<?= $ticket['id']; ?>" class="btn btn-sm btn-success waves-effect waves-light"><?= __('Edit') ?></button>
                                                <?php } ?>

                                                <?php if(has_permission('tickets-delete')) { ?>
                                                    <button data-modal="admin/tickets/delete/<?= $ticket['id']; ?>" class="btn btn-sm btn-danger waves-effect waves-light"><?= __('Delete') ?></button>
                                                <?php } ?>
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


                            <div class="card table-card">
                                <div class="card-header">
                                    <h5><?= __('Add Reply') ?></h5>

                                    <div class="card-header-right reply-card-header">


                                            <div class="form-group">
                                                <select class="select2 form-control" name="predefined_reply_id" id="predefined_reply" required>
                                                    <option value=""  ><?= __("-- Insert predefined reply --") ?></option>

                                                    <?php foreach($predefined_replies as $item) { ?>
                                                        <option value="<?= $item['id'] ?>"  ><?= $item['name'] ?></option>
                                                    <?php } ?>
                                                   
                                                </select>
                                                <span class="help-block with-errors messages text-danger"></span>
                                            </div>

                                            <script>

                                             

                                                $('#predefined_reply').on('select2:select', function (e) {
                                                    var id = e.params.data.id;

                                                    var url = "<?= base_url('admin/json/predefined_reply_content/') ?>"+id;

                                                    $.ajax({
                                                        url: "<?= base_url('admin/json/predefined_reply_content/') ?>"+id,
                                                        success: function(data){ 
                                                  
                                                            tinymce.activeEditor.execCommand('mceInsertContent', false, data);
                                                        },
                                                        error: function(){
                                                            alert("There was an error.");
                                                        }
                                                    });

                                                });
                                            </script>
                                    </div>


                                </div>
                                <div class="card-body">
                                    <?= form_open_multipart(base_url('admin/tickets/add_reply/'.$ticket['id']), 'id="modal-form"'); ?>

                                    <div class="form-group">
                                        <textarea name="message" rows="6" class="form-control" id="tinymceinput"></textarea>
                                        <span class="help-block with-errors messages text-danger"></span>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=""><?= __("Attach Files") ?></label>
                                                <input type="file" class="form-control" name="userfiles[]" multiple>
                                                <span class="help-block with-errors messages text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=""><?= __("New Status") ?></label>
                                                <select class="select2 form-control" name="status" required>
                                                    <option value="Open"  ><?= __("Open") ?></option>
                                                    <option value="Reopened"  ><?= __("Reopened") ?></option>
                                                    <option value="In Progress"  ><?= __("In Progress") ?></option>
                                                    <option value="Answered" selected ><?= __("Answered") ?></option>
                                                    <option value="Closed"  ><?= __("Closed") ?></option>
                                                </select>
                                                <span class="help-block with-errors messages text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="text-right">
                                                <br>
                                                <?php if(has_permission('tickets-edit')) { ?>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Add Reply") ?></button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?= form_close(); ?>
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
                                                <span class="text-muted f-size-12"><?= datetime_display($reply['created_at']); ?></span>
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
                                                        <li><a href="<?= base_url('admin/tickets/download_reply_file/'.$file['id']) ?>"><i class="fas fa-fw fa-file"></i><?= $file['name']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>


                            <div class="card table-card">
                                <div class="card-header">
                                    <h5><?= __('Notes') ?></h5>
                                </div>
                                <div class="card-body">
                                    <?= form_open(base_url('admin/tickets/edit_notes/'.$ticket['id']), 'id="modal-form"'); ?>

                                        <div class="form-group">
                                            <textarea name="notes" rows="6" class="form-control" id="tinymceinput" required><?= $ticket['notes']; ?></textarea>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>

                                        <div class="text-right">
                                            <?php if(has_permission('tickets-edit')) { ?>
                                            <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save") ?></button>
                                            <?php } ?>
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
                                                    <td><?= __('Ticket #') ?></td>
                                                    <td class="text-right"><?= $ticket['ticket']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= __('Ticket Name') ?></td>
                                                    <td class="text-right"><?= $ticket['subject']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= __('Status') ?></td>
                                                    <td class="text-right">
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
                                                    <td><?= __('Priority') ?></td>
                                                    <td class="text-right">
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
                                                    <td><?= __('Email') ?></td>
                                                    <td class="text-right"><?= $ticket['email']; ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?= __('Added by') ?></td>
                                                    <td class="text-right">
                                                        <?php if($user) { ?>
                                                            <?= $user['name'] ?>
                                                        <?php } else { ?>
                                                            <span class="text-muted"><?= __('Nobody') ?></span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><?= __('Assigned to') ?></td>
                                                    <td class="text-right">
                                                        <?php if($assigned_to) { ?>
                                                            <?= $assigned_to['name'] ?>
                                                        <?php } else { ?>
                                                            <span class="text-muted"><?= __('Nobody') ?></span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td><?= __('Client') ?></td>
                                                    <td class="text-right"><?= get_client_name($ticket['client_id']); ?></td>
                                                </tr>


                                                <tr>
                                                    <td><?= __('Asset') ?></td>
                                                    <td class="text-right"><?= get_asset_name($ticket['asset_id']); ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?= __('License') ?></td>
                                                    <td class="text-right"><?= get_license_name($ticket['license_id']); ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?= __('Project') ?></td>
                                                    <td class="text-right"><?= get_project_name($ticket['project_id']); ?></td>
                                                </tr>


                                                <tr>
                                                    <td><?= __('Created At') ?></td>
                                                    <td class="text-right"><?= datetime_display($ticket['created_at']); ?></td>
                                                </tr>

                                                <tr>
                                                    <td><?= __('Last Updated') ?></td>
                                                    <td class="text-right"><?= datetime_display($ticket['updated_at']); ?></td>
                                                </tr>


                                                <?php foreach ($customfields as $customfield) { ?>


                                                    <tr>
                                                        <td><?= __($customfield['name']); ?></td>
                                                        <td class="text-right"><?= extract_value($customfield['id'],$ticket['custom_fields_values']); ?></td>
                                                    </tr>



                                                <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="card table-card">
                                <div class="card-header">
                                    <h5><?= __('Comments') ?></h5>
                                    <div class="card-header-right">

                                        <div class="btn-group" role="group" >

                                            <?php if(has_permission('tickets-edit')) { ?>
                                            <button data-modal="admin/tickets/add_comment/<?= $ticket['id']; ?>" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark">
                                                <?= __('Add Comment') ?>
                                            </button>
                                            <?php } ?>

                                        </div>



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
                                                            <span class="lead"><?= $this->staff->get_name($comment['added_by']); ?> <span class="text-muted f-size-12"><?= datetime_display($comment['created_at']); ?></span></span>
                                                            <div class="float-right">

                                                                <?php if(has_permission('tickets-edit')) { ?>
                                                                <a href="#" data-modal="admin/tickets/edit_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Comment') ?>"><i class="far fa-fw fa-edit"></i></a>
                                                                <?php } ?>
                                                                
                                                                <?php if(has_permission('tickets-delete')) { ?>
                                                                <a href="#" data-modal="admin/tickets/delete_comment/<?= $comment['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Comment') ?>"><i class="fas fa-fw fa-trash"></i></a>
                                                                <?php } ?>
                                                            </div>
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

                    </div>





                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>
