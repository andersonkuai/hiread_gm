<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','优惠券')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','优惠券管理')?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','优惠券')?></li>
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
                        <table class="table">
                            <tr>
                                <td width="20%"><?=\Yii::t('app','优惠券名称')?></td>
                                <td>
                                    <input class="form" name="Name"  type="text" value="<?php echo empty($row) ? '' : $row['Name'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','面额（单位：元）')?></td>
                                <td>
                                    <input class="form" name="Price"  type="text" value="<?php echo empty($row) ? '' : $row['Price'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','限额（单位：元）')?></td>
                                <td>
                                    <input class="form" name="MinLimit" type="text" value="<?php echo empty($row['MinLimit']) ? 0 : $row['MinLimit'];?>">
                                    <span style="color: red">* 0为无限额</span>
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','适用范围')?></td>
                                <td>
                                    <select name="CourseId" id="">
                                        <option value="0">课程通用</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>生效方式</td>
                                <td>
                                    <input onclick="switchWay(1)" type="radio" value="1" name="EffectiveWay" <?php if(!empty($row['EffectiveWay']) && $row['EffectiveWay'] == 1){echo 'checked';};?>>设定区间
                                    <input onclick="switchWay(2)" type="radio" value="2" name="EffectiveWay" <?php if(!empty($row['EffectiveWay']) && $row['EffectiveWay'] == 2){echo 'checked';};?>>领取生效
                                </td>
                            </tr>
                            <tr>
                                <td>有效时长</td>
                                <td>
                                    <div id="set_section">
                                        <input type="text" name="EffectiveTime1"
                                               value="<?php
                                                    if(!empty($row) && $row['EffectiveWay'] == 1) echo date('Y-m-d',$row['EffectiveTime1']);
                                               ?>"
                                               onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                        -
                                        <input type="text" name="EffectiveTime2"
                                               value="<?php
                                                    if(!empty($row) && $row['EffectiveWay'] == 1) echo date('Y-m-d',$row['EffectiveTime2']);
                                               ?>"
                                               onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    </div>
                                    <div id="get_coupon" style="display: none">
                                        <input type="text" value="<?php if(!empty($row) && $row['EffectiveWay'] == 2){echo $row['EffectiveDay'];}?>" name="EffectiveDay">天
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>单账号限制</td>
                                <td>
                                    <input type="text" name="SingleLimit" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td>券数</td>
                                <td>
                                    <input type="number" name="Count" value="<?php echo !empty($row['Count'])?$row['Count']:0; ?>"><span style="color: red">* 范围：1-9999</span>
                                </td>
                            </tr>
                        </table>
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
    /**
     * 切换生效方式
     */
    function switchWay(way) {
        if(way == 1){
            $('#set_section').show();
            $('#get_coupon').hide();
        }else{
            $('#get_coupon').show();
            $('#set_section').hide();
        }
    }
    <?php if(!empty($row)){?>
        switchWay(<?php echo $row['EffectiveWay'];?>);
    <?php } ?>
</script>