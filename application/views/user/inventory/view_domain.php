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
                    <th><?= __("Expiry") ?></th>
                    <td><?= date_display($domain['exp_date']) ?></td>

                </tr>




            </table>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>
           
        </div>

  

</div>
