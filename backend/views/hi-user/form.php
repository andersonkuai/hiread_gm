<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? '添加':'编辑'?>用户
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">用户管理</a></li>
        <li class="active"><?php echo empty($row) ? '添加':'编辑'?>用户</li>
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
                                            <label>注册账号</label>
                                            <div class="form-control">
                                                <?=$row['user_name']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>注册时间</label>
                                            <div class="form-control">
                                                <?=date('Y-m-d H:i:s',$row['RegTime'])?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>用户id</label>
                                            <div class="form-control">
                                                <?=$row['Uid']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>孩子昵称</label>
                                            <div class="form-control">
                                                <?=$row['EnName']?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>孩子年龄</label>
                                            <input type="text" class="form-control" name="age" value="<?=empty($row['birth']) ? '' : ceil((time()-$row['birth'])/(24*3600*365))?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>学校类型</label>
                                            <select name="school_type" class="form-control">
                                                <option value='0'>暂无</option>
                                                <?php foreach(\Yii::$app->params['school_type'] as $key=>$val){?>
                                                    <option <?php if(!empty($row['school_type']) && $row['school_type'] == $key) echo 'selected';?> value="<?=$key?>"><?=$val?></option>
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
                        <?php if(!empty($row)){?>
                            <input type="hidden" name="id" value="<?php echo $row['Uid']?>"/>
                        <?php }?>
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