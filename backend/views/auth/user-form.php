<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? '添加':'编辑'?>管理员
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">权限管理</a></li>
        <li class="active"><?php echo empty($row) ? '添加':'编辑'?>管理员</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=auth/user"><i class="fa fa-arrow-circle-o-left"></i> 返回</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>用户名</label>
                                    <input class="form-control" name="username" placeholder="用户名" type="text" value="<?php echo empty($row) ? '' : $row['username'];?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>密码</label>
                                    <input class="form-control" name="password" placeholder="密码" type="text" value="">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>昵称</label>
                                    <input class="form-control" name="nickname" placeholder="昵称" type="text" value="<?php echo empty($row) ? '' : $row['nickname'];?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>真实姓名</label>
                                    <input class="form-control" name="realname" placeholder="真实姓名" type="text" value="<?php echo empty($row) ? '' : $row['realname'];?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>手机号</label>
                                    <input class="form-control" name="mobile" placeholder="手机号" type="text" value="<?php echo empty($row) ? '' : $row['mobile'];?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>最后登陆时间</label>
                                    <input class="form-control" readonly type="text" value="<?php echo empty($row) ? '' : date('Y-m-d H:i:s', $row['login_time']);?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>最后登陆IP</label>
                                    <input class="form-control" readonly type="text" value="<?php echo empty($row) ? '' : $row['login_ip'];?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>创建时间</label>
                                    <input class="form-control" readonly type="text" value="<?php echo empty($row) ? '' : date('Y-m-d H:i:s', $row['created']);?>">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>角色</label>
                                    <div class="checkbox">
                                        <?php
                                        $roles = Yii::$app->authManager->getRoles();
                                        foreach($roles as $role){
                                            $checked = false;
                                            if(!empty($row)){
                                                $assi = Yii::$app->authManager->getAssignment($role->name, $row['id']);
                                                $checked = $assi ? true : $checked;
                                            }
                                        ?>
                                        <label><input type="checkbox" name="roles[]" value="<?php echo $role->name?>" <?php echo $checked?'checked="checked"':''?>>
                                            <?php echo $role->description?></label>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <?php if(!empty($row)){?>
                        <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
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