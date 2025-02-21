<div class="row">
    <div class="col-md-12">


        <div class="dt-responsive table-responsive">

            <table id="DataTables" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Rate %') ?></th>
                        <th class="text-right no-sort"><?= __('Actions') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($taxrates as $taxrate) { ?>
                        <tr>
                            <td><?= $taxrate['id']; ?></td>
                            <td><?= $taxrate['name']; ?></td>
                            <td><?= $taxrate['rate']; ?>%</td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <button data-modal="admin/setup/settings/edit_taxrate/<?= $taxrate['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Tax Rate') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                    <button data-modal="admin/setup/settings/delete_taxrate/<?= $taxrate['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Tax Rate') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
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
