<!--<script type="text/javascript" src="/assets/upload/jquery.form.js"></script>-->
<!--<!-- Content Header (Page header) -->-->
<!--<section class="content-header">-->
<!--    <h1>-->
<!--        --><?//= \Yii::t('app', '课程结构');?>
<!--        <small></small>-->
<!--    </h1>-->
<!--    <ol class="breadcrumb">-->
<!--        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> --><?//= \Yii::t('app', '主页');?><!--</a></li>-->
<!--        <li><a href="#">--><?//= \Yii::t('app', '课程管理');?><!--</a></li>-->
<!--        <li><a href="#">--><?//= \Yii::t('app', '课程列表');?><!--</a></li>-->
<!--        <li class="active">--><?//= \Yii::t('app', '课程结构');?><!--</li>-->
<!--    </ol>-->
<!--</section>-->
<!---->
<!--<!-- Main content -->-->
<!--<section class="content">-->
<!---->
<!--    <div class="row">-->
<!--        <div class="col-xs-12">-->
<!--            <div class="box box-primary">-->
<!--                <div class="box-header with-border">-->
<!--                    <div class="btn-group btn-group-sm" role="group">-->
<!--                        <a class="btn btn-default" href="?r=course/index"><i class="fa fa-arrow-circle-o-left"></i> --><?//= \Yii::t('app', '返回');?><!--</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <!-- /.box-header -->-->
<!--                <!-- form start -->-->
<!--                <form role="form" id="myForm" action="" method="post" enctype="multipart/form-data">-->
<!--                    <div class="box-body">-->
<!--                        <select name="read_type" id="read_type">-->
<!--                            <option value="extensive">--><?//= \Yii::t('app', '泛读');?><!--</option>-->
<!--                            <option value="intensive">--><?//= \Yii::t('app', '精读');?><!--</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="box-body">-->
<!--                        <div class="row">-->
<!--                            <div class="col-xs-12">-->
<!--                                <div id="extensive_id" class="row">-->
<!--                                    --><?php //require_once('extensive.php') ?>
<!--                                </div>-->
<!--                                <div style="display: none" id="intensive_id" class="row">-->
<!--                                    --><?php //require_once('intensive.php') ?>
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <!-- /.box-body -->-->
<!--                    <div class="box-footer">-->
<!--                        --><?php //if(!empty($course)){?>
<!--                            <input type="hidden" name="id" value="--><?php //echo $course['ID']?><!--"/>-->
<!--                        --><?php //}?>
<!--                        <input name="--><?//= Yii::$app->request->csrfParam;?><!--" type="hidden" value="--><?//= Yii::$app->request->getCsrfToken();?><!--">-->
<!--                        <button type="submit" class="btn btn-primary">提交</button>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<!-- /.content -->
<script type="text/javascript">
    //根据选择泛读与否展示选项卡
//    read_type = $('#read_type').val()
//    $('#read_type').change(function () {
//        read_type = $('#read_type').val()
//        if (read_type == 'intensive'){
//            $('#intensive_id').css('display','block')
//            $('#extensive_id').css('display','none')
//        }else{
//            $('#intensive_id').css('display','none')
//            $('#extensive_id').css('display','block')
//        }
//    })
//    <?php //if(!empty($extensive)){ ?>
//        $('#read_type').val('extensive')
//    <?php //}else{ ?>
//        $('#read_type').val('intensive')
//    <?php //}?>
//    $("#read_type").trigger("change")//自动触发change事件

    //上传图片
//    function uploadImg(action) {
//        var fileDom = $('#'+action+'_pic');
//        var btn = $('#'+action+'_btn')
//        var url = "index.php?r=course/uploadimg&action="+action
//        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
//        fileDom.parent().ajaxSubmit({
//            dataType:  'json',
//            beforeSend: function() {
//                var percentVal = '0%';
//                btn.addClass('disabled').text("上传中...");
//            },
//            uploadProgress: function(event, position, total, percentComplete) {
//                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
//            },
//            success: function(data) {
//                console.log(data);
//                if(data.code == 1){
//                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
//                    $("input[name="+action+"]").val(data.pic)
//                }
//                fileDom.unwrap();
//            },
//            error:function(xhr){
//                alert('上传失败');
//                fileDom.unwrap();
//            }
//        });
//    }
    //查看图片
//    function viewImg(action,obj = false) {
//        //获取图片名称
//        var imgName = $("input[name="+action+"]").val()
//        if(obj != false){
//            var imgName = $(obj).parent().children(0).val()
//        }
//        var key = 'view_'+action;
//        //获取查看目录
//        var href = '';
//        switch(action)
//        {
//            case 'CoverImg'://课程封面图片
//                href = '<?php //echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_CoverImg']; ?>//' + imgName
//                break;
//            case 'DetailImg'://课程简介图片
//                href = '<?php //echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_DetailImg']; ?>//' + imgName
//                break;
//            case 'Poster'://泛读封面图片
//                href = '<?php //echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_cover_img']; ?>//' + imgName
//                break;
//            case 'Author'://作者头像
//                href = '<?php //echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_Author']; ?>//' + imgName
//                break;
//            default:
//                href = '';
//                break;
//        }
//        window.open(href);
//    }

//    $(document).ready(function() {
//        $('#myForm').ajaxForm({
//            dataType:"json",
//            success:function(data){
//                console.log(data);
//                alert(data.msg);
//                if(data.code == 1){
//                    window.location.href="index.php?r=course/index";
//                }
//            }
//        });
//    });

</script>