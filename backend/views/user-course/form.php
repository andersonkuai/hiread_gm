<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? '添加':'编辑'?>用户课程
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">用户课程管理</a></li>
        <li class="active"><?php echo empty($row) ? '添加':'编辑'?>用户课程</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="javascript:history.back(-1)"><i class="fa fa-arrow-circle-o-left"></i> 返回</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>用户id</label>
                                            <input type="text" class="form-control" name="uid" value="<?=empty($row['uid']) ? '' : $row['uid']?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>课程</label>
                                            <select name="course" class="form-control">
                                                <?php foreach($course as $key=>$val){?>
                                                    <option value="<?=$val['ID']?>">ID：<?=$val['ID']?> Level：<?=$val['HLevel']?>&nbsp;&nbsp;&nbsp; <?=$val['ProdName']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input name="<?= Yii::$app->request->csrfParam;?>" type="hidden" value="<?= Yii::$app->request->getCsrfToken();?>">
                        <button type="submit" class="btn btn-primary">提交</button>
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
                    location.href = location.href ;
                }
            }
        });

        UTILITY.UPLOAD.bind('.uploadBtn');
    });
</script>