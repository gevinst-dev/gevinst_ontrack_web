<div class="row">
    <div class="col-md-12">


        <div class="dt-responsive table-responsive">

            <table id="DataTables" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Subject') ?></th>
                        <th class="text-right no-sort"><?= __('Actions') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($templates as $template) { ?>
                        <tr>
                            <td><?= $template['id']; ?></td>
                            <td><?= $template['name']; ?></td>
                            <td><?= $template['subject']; ?></td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <button data-modal="admin/setup/settings/edit_email_template/<?= $template['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Email Template') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>






    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {

        $('#DataTables').DataTable({
            "processing": true,
            "stateSave": true,
            "fixedHeader": true,
        });

    });
</script>
