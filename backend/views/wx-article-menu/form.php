<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','微信推荐文章')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','文章列表')?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','微信推荐文章')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=wx-article-menu/index"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','名称')?></label>
                                    <input class="form-control" name="name"  type="text" value="<?php echo empty($row) ? '' : $row['name'];?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','排序')?></label>
                                    <input class="form-control"  name="order"  type="text" value="<?php echo empty($row) ? 0: $row['order'];?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <select class="form" name="theme">
                                        <option value="">选择主题</option>
                                        <?php foreach($theme as $k=>$v){ ?>
                                            <option value="<?=$v['id']?>" <?php if(!empty($row) && $row['theme'] == $v['id']) echo 'selected';?> ><?=$v['theme']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <select class="form" name="is_show">
                                        <option value="1" <?php if(!empty($row) && $row['is_show'] == 1) echo 'selected';?>>显示</option>
                                        <option value="2" <?php if(!empty($row) && $row['is_show'] == 2) echo 'selected';?>>不显示</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php if(!empty($row)) echo $row['id']?>"/>
                        <input name="<?= Yii::$app->request->csrfParam;?>" type="hidden" value="<?= Yii::$app->request->getCsrfToken();?>">
                        <button type="submit" class="btn btn-primary"><?=\Yii::t('app','提交')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<!-- /.content -->
<script type="text/javascript">
    <!--
    $(document).ready(function() {

        $('#myForm').ajaxForm({
            dataType:"json",
            success:function(data){
                alert(data.msg);
                if(data.code == 1){
                    location.href = location.href ;
                }
            }
        });
    });
    -->
</script>