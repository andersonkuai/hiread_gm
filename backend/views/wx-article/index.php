<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '微信推荐文章');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','功能管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '微信推荐文章');?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=wx-article/add"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="wx-article/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="title" class="form-control" placeholder="标题"
                                       value="<?=!empty($searchData['title'])?$searchData['title']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select name="menu" class="form-control">
                                    <option value="">所属菜单</option>
                                    <?php foreach($menu as $k=>$v){ ?>
                                        <option <?php if(!empty($searchData) && $searchData['menu'] == $v['id']) echo 'selected';?> value=<?=$v['id']?>><?=$v['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <select name="is_show" class="form-control">
                                    <option value="">是否显示</option>
                                    <option <?php if(!empty($searchData) && $searchData['is_show'] == 1) echo 'selected';?> value=1?>显示</option>
                                    <option <?php if(!empty($searchData) && $searchData['is_show'] == 2) echo 'selected';?> value=2?>不显示</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">查询</button>
                        </form>

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
<!--                            <th style="text-align: center"><input type="checkbox" onclick="UTILITY.CHECK.all(this);"/></th>-->
                            <th>ID</th>
                            <th>所属菜单</th>
                            <th>标题</th>
                            <th>图片</th>
                            <th>简介</th>
                            <th>链接</th>
                            <th>是否显示</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>

                        <?php foreach($users as $user){?>
                            <tr>
                                <td><?php echo $user['id']?></td>
                                <td><?php echo !empty($menu[$user['menu']]['name'])? $menu[$user['menu']]['name'] : '<span style="color:#F00">暂无</span>'?></td>
                                <td><?php echo $user['title']?></td>
                                <td>
                                    <a target="_blank" href="<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_wx_article'].$user['img']; ?>">
                                        <img width="30%" src="<?php if(!empty($user['img'])) echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_wx_article'].$user['img']; ?>" alt="">
                                    </a>
                                </td>
                                <td><textarea><?php echo $user['introduction']?></textarea></td>
                                <td>
                                    <textarea><?=$user['url'];?></textarea>
                                </td>
                                <td><?= $user['is_show'] == 1 ? '是': '否';?></td>
                                <td><?= date('Y-m-d H:i:s',$user['time']);?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="?r=wx-article/edit&id=<?php echo $user['id']?>" target="_Blank"><i class="fa fa-edit">修改</i></a>&nbsp;&nbsp;
                                        <a class="" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=wx-article/del-article&id=<?php echo $user['id']?>');"><i class="fa fa-minus-square"></i> 删除</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $pageHtml;?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">分配邀请码</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="invite-code/allot" id="myForm" role="form">
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="invite_id" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">邀请码</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="invite_code" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">所有者</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="invite_username">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" onclick="allotDo()" class="btn btn-primary">分配</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    //分配邀请码
    function allot(id,inviteCode,userName) {
        $('#invite_id').val(id);
        $('#invite_code').val(inviteCode);
        $('#invite_username').val(userName);
    }
    function allotDo() {
        var id = $('#invite_id').val();
        var username = $('#invite_username').val();
        var postData = {"id":id,"username":username};
        $.post( 'index.php?r=invite-code/allot', postData, function(data){
            if( data.code == 1 ){
                window.location.href = window.location.href;
            }else{
                alert(data.msg);
            }
        }, 'json');
    }
</script>
<!-- /.content -->