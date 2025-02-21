<div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <img src="<?= base_url('filestore/img_cache/'); ?><?= get_image($image['file'], 800, 500); ?>" class="img-fluid">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>
        </div>


</div>
