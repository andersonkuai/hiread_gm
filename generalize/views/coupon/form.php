<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','代金券')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','代金券管理')?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','代金券')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=coupon/index"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','代金券名称')?></label>
                                    <input class="form-control" name="Name"  type="text" value="<?php echo empty($row) ? '' : $row['Name'];?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','代金券类型')?></label>
                                    <select class="form-control" name="Type" id="">
                                        <?php
                                        foreach (\common\enums\Coupon::pfvalues('COUPON_TYPE') as $key => $obj){
                                            $selected = isset($row['Type']) && $row['Type'] == $obj->getValue()
                                                ? 'selected="selected"':'';
                                            echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Coupon::labels()[$key].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','代金券面值（单位：元）')?></label>
                                    <input class="form-control" name="Price"  type="text" value="<?php echo empty($row) ? '' : $row['Price'];?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label><?=\Yii::t('app','代金券有效期（单位：天）')?></label>
                                    <input class="form-control" name="Expire" type="text" value="<?php echo empty($row) ? '' : $row['Expire']/(24*3600);?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php if(!empty($row)) echo $row['ID']?>"/>
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