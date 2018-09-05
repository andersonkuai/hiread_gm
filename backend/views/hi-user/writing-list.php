<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '用户作文列表');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','用户管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '用户作文列表');?></li>
    </ol>
</section>
<style type="text/css">
    a:link {
        color:#3C3C3C;
        text-decoration:none;
    }
    a:visited {
        color:#0000FF;
        text-decoration:none;
    }
    a:hover {
        color:#FF00FF;
        text-decoration:none;
    }
    a:active {
        color:#D200D2;
        text-decoration:none;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <!-- <a class="btn btn-primary" href="?r=hi-user/add-writing"><i class="fa fa-plus"></i>添加</a> -->
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="hi-user/writing">
                            <div class="form-group form-group-sm">
                                <input type="text" name="Uid" class="form-control" placeholder="用户id"
                                       value="<?=!empty($searchData['Uid'])?$searchData['Uid']:''?>">
                            </div>
                            <select class="form-group" name="state">
                                <option value=""><?= \Yii::t('app', '状态');?></option>
                                <?php foreach (\Yii::$app->params['writing-state'] as $key => $val): ?>
                                    <option <?php if($searchData['state'] == $key) echo 'selected';?> value="<?=$key?>"><?=$val?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Score" class="form-control" placeholder="得分"
                                       value="<?=isset($searchData['Score'])?$searchData['Score']:''?>">
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
                            <th>Uid</th>
                            <th><?= \Yii::t('app','用户')?></th>
                            <th><?= \Yii::t('app','课程')?></th>
                            <th><?= \Yii::t('app','题目')?></th>
                            <th><?= \Yii::t('app','状态')?></th>
                            <th><?= \Yii::t('app','得分')?></th>
                            <th><?= \Yii::t('app','操作')?></th>
                        </tr>
                        <?php foreach($list as $user){?>
                            <tr>
                                <td><?php echo $user['Uid']?></td>
                                <td><?php echo $user['EnName']?></td>
                                <td><?php echo $user['ProdName']?></td>
                                <td><?php echo $user['PreviewIntro']?></td>
                                <td><?php echo \Yii::$app->params['writing-state'][$user['state']]?></td>
                                <td><?php echo $user['Score']?></td>
                                <td>
                                    <a class="btn btn-sm" href="?r=hi-user/modify-writing&id=<?php echo $user['ID']?>&uid=<?=$user['Uid']?>">批改</a>
                                    &nbsp;&nbsp;
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
<!-- /.content -->
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">增加/扣除金币</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="invite-code/allot" id="myForm" role="form">
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">用户ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="gold_uid" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">账号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="gold_username" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">现有金币</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="gold_gold">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">增加</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="gold_add" value="0" type="number">
                        </div>
                        <label for="lastname" class="col-sm-2 control-label">金币</label>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">扣除</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="gold_minus" value="0">
                        </div>
                        <label for="lastname" class="col-sm-2 control-label">金币</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" onclick="updateGold()" class="btn btn-primary">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    function markBackGround(obj) {
        $('tr').css('background-color', '#ffffff')
        $(obj).parent().parent().parent().css('background-color', '#C6E746')
    }
    /**
     * 查询金币信息
     */
    function queryGold(uid) {
        if(uid == undefined){
            return
        }
        var postData = {"uid":uid};
        $.post( 'index.php?r=hi-user/query-gold', postData, function(data){
            if( data.code == 1 ){
                $('#gold_uid').val(data.data.Uid);
                $('#gold_username').val(data.data.UserName);
                $('#gold_gold').val(data.data.Gold);
                //改变列表里的值
                $('#gold_'+uid).html(data.data.Gold);
            }else{
                return
            }
        }, 'json');
    }
    /**
     * 修改金币数量
     */
    function updateGold() {
        var uid = $('#gold_uid').val();
        var addGold = $('#gold_add').val();
        var minusGold = $('#gold_minus').val();
        var postData = {"uid":uid,'add_gold':addGold,'minus_gold':minusGold};
        $.post( 'index.php?r=hi-user/update-gold', postData, function(data){
            console.log(data);
            if( data.code == 1 ){
                queryGold(uid);
            }else{
                return
            }
        }, 'json');
    }
</script>