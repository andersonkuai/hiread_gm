<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app','生成'):\Yii::t('app','编辑')?> <?=\Yii::t('app','订单')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','功能管理')?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app','生成'):\Yii::t('app','编辑')?> <?=\Yii::t('app','订单')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="##" onClick="javascript :history.back(-1);"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <td width="20%"><?=\Yii::t('app','注册用户手机号')?></td>
                                <td>
                                    <input class="form" name="UserName"  type="text" value="<?php echo empty($row) ? '' : $row['Name'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td width="20%"><?=\Yii::t('app','孩子英文名')?></td>
                                <td>
                                    <input class="form" name="EnName"  type="text" value="<?php echo empty($row) ? '' : $row['Name'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','课程')?></td>
                                <td>
                                    <select name="Course" id="Course" onchange="getCourse()">
                                        <?php if(!empty($course)){ ?>
                                            <?php foreach ($course as $v) {?>
                                                <option value="<?=$v['ID']?>">Lv:<?=$v['HLevel'];?> &nbsp;<?=$v['ProdName'];?></option>
                                            <?php }?>
                                        <?php }?>
                                    </select>
                                    <select name="entity" id="entity" onchange="changeEntity()">
                                        <option value="0">没有实体书</option>
                                        <option value="1">有实体书</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','原价')?></td>
                                <td id="Price"></td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','现价')?></td>
                                <td id="DiscountPrice"></td>
                            </tr>
                            <tr>
                                <td><?=\Yii::t('app','优惠券')?></td>
                                <td>
                                    <input class="form" name="coupon"  type="text" value="0">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?php if(!empty($row)) echo $row['ID']?>"/>
                        <input name="<?= Yii::$app->request->csrfParam;?>" type="hidden" value="<?= Yii::$app->request->getCsrfToken();?>">
                        <button type="submit" class="btn btn-primary"><?=\Yii::t('app','生成')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<input type="hidden" name="entity_price" value="0" id="entity_price">
<!-- /.content -->
<script type="text/javascript">
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

    function getCourse() {
        var courseId = $('#Course').val();
        //获取课程信息
        $.ajax({
            type:'GET',
            url : '<?= Yii::$app->urlManager->createUrl('order/get-course')?>&id='+courseId,
            dataType:'json',
            success:function(data){
                if(data.code == 1){
                    $('#Price').html(data.data.Price);
                    $('#DiscountPrice').html(data.data.DiscountPrice);
                    $('#entity_price').val(data.data.entity_price);
                    $('#entity').val('0');
                }
            }
        });
    }
    getCourse();
    function changeEntity()
    {
        var entity = $('#entity').val();
        var entityPrice = parseFloat($('#entity_price').val());
        var price = parseFloat($('#Price').html());
        var discountPrice = parseFloat($('#DiscountPrice').html());
        if(entity == 1){
            $('#Price').html(price + entityPrice);
            $('#DiscountPrice').html(discountPrice + entityPrice);
        }else{
            $('#Price').html(price - entityPrice);
            $('#DiscountPrice').html(discountPrice - entityPrice);
        }
    }
</script>