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
                    <th><?= __("Type") ?></th>
                    <td><?= $credential['type'] ?></td>

                </tr>

                <tr>
                    <th><?= __("Username") ?></th>
                    <td><?= $credential['username'] ?></td>

                </tr>

                <tr>
                    <th><?= __("Password") ?></th>
                    <td><?= $this->encryption->decrypt($credential['pswd']) ?></td>

                </tr>


                <tr>
                    <th><?= __("Asset") ?></th>
                    <td><?= $asset['tag'] ?> - <?= $asset['name'] ?></td>

                </tr>

                <tr>
                    <th><?= __("Project") ?></th>
                    <td><?= get_project_name($credential['project_id']) ?></td>

                </tr>



            </table>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>

        </div>



</div>
