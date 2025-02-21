<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="fas fa-life-ring bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= html_escape($title); ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <form method="get" accept-charset="utf-8" action="<?= base_url('knowledge_base/search'); ?>">

                    <div class="row">
                        <div class="col-xs-11">
                            
                            <input type="text" class="form-control" name="query" value="<?= $_GET['query'] ?>" placeholder="<?= __('Search...') ?>">
                    
                        </div>
                        <div class="col-xs-1">
                            <button type="submit" class="btn btn-primary m-l-10"><i class="fas fa-search"></i></button>
                        </div>


                    </div>

                </form>

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

                        


                        <div class="col-md-12">



                        <div class="card">

                            <div class="card-header">
                                <h5><?= __('Articles') ?></h5>
                            </div>

                            <div class="card-block">


                                <?php if(empty($articles)) { ?>
                                    <p class="alert alert-warning"><?= __('No articles have been found.') ?><p>
                                <?php } ?>

                                <div class="row">
                                    <?php foreach($articles as $article) { ?>

                                        

                                        <div class="col-md-6">
                                            <div class="card list-view-media">
                                                <div class="card-block">
                                                    <div class="media">
                                                        
                                                        <div class="media-body">

                                                            <div class="col-xs-12">
                                                                <a href="<?= base_url('knowledge_base/article/'.$article['id']); ?>">
                                                                    <h6 class="d-inline-block"><?= html_escape($article['name']) ?></h6>
                                                                </a>
                                                            </div>

                                                            <div class="m-b-15">
                                                                <a class="f-13 text-muted" href="<?= base_url('knowledge_base/category/'.$article['category_id']); ?>"><?= get_kb_category_name($article['category_id']); ?></a>
                                                            </div>

                                                            <p>
                                                                <?= text_excerpt(strip_tags($article['content']), 170) ?>
                                                                <a href="<?= base_url('knowledge_base/article/'.$article['id']); ?>"><?= __("Read") ?> <i class="far fa-arrow-alt-circle-right"></i></a>
                                                            </p>

                                                        

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>

    <!-- Page Body end -->

</div>




