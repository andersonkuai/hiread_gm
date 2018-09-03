<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','作文得分点配置')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','功能管理')?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','作文得分点配置表')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=hi-user/conf-writing"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <td width="20%"><?=\Yii::t('app','等级')?></td>
                                <td>
                                    <input class="form" name="level"  type="text" value="<?php echo empty($row) ? '' : $row['level'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td width="20%"><?=\Yii::t('app','类型')?></td>
                                <td>
                                    <select name="type">
                                        <?php foreach (\Yii::$app->params['writing-type'] as $key => $val) { ?>
                                            <option value="<?=$key?>"><?=$val?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','得分项目')?></td>
                                <td>
                                    <input style="width: 60%" class="form" name="item"  type="text" value="<?php echo empty($row) ? '' : $row['item'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','得分点')?></td>
                                <td>
                                    <input class="form" name="point"  type="text" value="<?php echo empty($row) ? '' : $row['point'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','得分项名称')?></td>
                                <td>
                                    <textarea name="name" rows="5" cols="50"><?php echo empty($row) ? '' : $row['name'];?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','分值')?></td>
                                <td>
                                    <input class="form" name="score"  type="text" value="<?php echo empty($row) ? '' : $row['score'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','权重')?></td>
                                <td>
                                    <input class="form" name="weight"  type="text" value="<?php echo empty($row) ? '0.25' : $row['weight'];?>">
                                </td>
                            </tr>
                        </table>
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
    $(document).ready(function() {
        $('#myForm').ajaxForm({
            dataType:"json",
            success:function(data){
                console.log(data);
                alert(data.msg);
                if(data.code == 1){
                    location.href = location.href ;
                }
            }
        });
    });
</script>