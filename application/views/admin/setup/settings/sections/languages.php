<div class="row">
    <div class="col-md-12">


        <div class="dt-responsive table-responsive">

            <table id="DataTables" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Code') ?></th>
                        <th class="text-right no-sort"><?= __('Actions') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($languages as $language) { ?>
                        <tr>
                            <td><?= $language['id']; ?></td>
                            <td><?= $language['name']; ?></td>
                            <td><?= $language['code']; ?></td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    
                                        <a href="<?= base_url('admin/setup/settings/edit_translation/'.$language['id']) ?>" data-toggle="tooltip" title="<?= __('Manage Translations') ?>" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-language"></i></a>
                                    <?php if($language['id'] != 1) { ?>
                                        <button data-modal="admin/setup/settings/edit_language/<?= $language['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Language') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                        <button data-modal="admin/setup/settings/delete_language/<?= $language['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Language') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
                                    <?php } ?>
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
