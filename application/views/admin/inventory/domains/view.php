<div class="modal-content">
    
        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

      
            <table class="table table-striped table-simple">
                <tr>
                    <th><?= __("Domain") ?></th>
                    <td><?= $domain['domain'] ?></td>
                </tr>

                <tr>
                    <th><?= __("Client") ?></th>
                    <td><?= get_client_name($domain['client_id']) ?></td>
                </tr>

                <tr>
                    <th><?= __("Notify") ?></th>
                    <td>
                        <?php foreach($staff as $item) { ?>
                            <?php if(in_array($item['id'], $selected_notify)) echo $item['name'] . " "; ?>  
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <th><?= __("Expiry") ?></th>
                    <td><?= date_display($domain['exp_date']) ?></td>

                </tr>

                <tr>
                    <th><?= __("Notifications") ?></th>
                    <td>

                        <?php if($domain['notify_30'] == "1") { ?><?= __("Notify staff 30 days before") ?><br><?php } ?>
                        <?php if($domain['notify_14'] == "1") { ?><?= __("Notify staff 14 days before") ?><br><?php } ?>
                        <?php if($domain['notify_7'] == "1") { ?><?= __("Notify staff 7 days before") ?><br><?php } ?>
                        <?php if($domain['notify_3'] == "1") { ?><?= __("Notify staff 3 days before") ?><br><?php } ?>
                        <?php if($domain['notify_0'] == "1") { ?><?= __("Notify staff on expiry") ?><br><?php } ?>
                        <?php if($domain['notify_client'] == "1") { ?><?= __("Notify the client too") ?><br><?php } ?>

                    </td>

                </tr>



            </table>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>
           
        </div>

  

</div>
