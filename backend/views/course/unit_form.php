<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($unit) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','单元')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','课程结构')?></a></li>
        <li class="active"><?php echo empty($unit) ? \Yii::t('app','添加'):\Yii::t('app','编辑')?> <?=\Yii::t('app','单元')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=course/structure&id=<?php echo $_GET['courseId'];?>"><i class="fa fa-arrow-circle-o-left"></i> <?=\Yii::t('app','返回')?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-8">
                                <table style="margin-bottom: 30px">
                                    <tr>
                                        <td><?= \Yii::t('app', '单元名称');?>：</td>
                                        <td>
                                            <input class="form" name="Name" type="text" value="<?php echo empty($unit) ? '' : $unit['Name'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '开放时间');?>：</td>
                                        <td>
                                            <input class="form" name="OpenDay" type="text" value="<?php echo empty($unit['OpenDay']) ? 0 : date('Ymd',$unit['OpenDay']);?>"> 格式：20180129，0:没有限制
                                        </td>
                                    </tr>
                                    <?php if(empty($unit)){?>
                                        <tr>
                                            <td style="color: red"><b><?= \Yii::t('app', '子单元');?>：</b></td>
                                        </tr>
                                        <tr>
                                            <td><?= \Yii::t('app', '子单元类型');?>：
                                            </td>
                                            <td>
                                                <select class="subUnit" name="subUnitType[]" id="">
                                                    <?php foreach (\common\enums\subUnit::params('type') as $key_t=>$val_t){ ?>
                                                        <option value="<?= $key_t;?>"><?= $val_t;?></option>
                                                    <?php }?>
                                                </select>&nbsp;&nbsp;
                                                <?= \Yii::t('app', '子单元名称');?>：
                                                <input type="text" name="subUnitName[]" value="">
                                            </td>
                                            <td>
                                                <a href="##" onclick="addSubUnit(this)" style="margin-right: 1px"><span class="fa fa-plus"></span></a>
                                                <a href="##" onclick="minusSubUnit(this)" style="margin-right: 1px"><span class="fa fa-minus"></span></a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <?php if(!empty($unit)){?>
                            <input type="hidden" name="unitId" value="<?php echo $unit['ID']?>"/>
                        <?php }?>
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
                alert(data.msg);
                if(data.code == 1){
                    location.reload();
                }
            }
        });
    });
    //添加子单元
    function addSubUnit(obj) {
        var dom = $(obj).parent().parent();
        var html = '<tr>' + dom.html() + '</tr>';
        dom.after(html)
    }
    //删除子单元
    function minusSubUnit(obj) {
        var dom = $(obj).parent().parent();
        dom.remove()
    }
</script>
