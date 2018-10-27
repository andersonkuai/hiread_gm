<script type="text/javascript" src="/assets/upload/jquery.form.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo empty($row) ? \Yii::t('app', '添加') :\Yii::t('app', '编辑')?><?= \Yii::t('app', '课程');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app', '主页');?></a></li>
        <li><a href="#"><?= \Yii::t('app', '课程管理');?></a></li>
        <li class="active"><?php echo empty($row) ? \Yii::t('app', '添加') :\Yii::t('app', '编辑')?><?= \Yii::t('app', '课程');?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=course/index"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="myForm" action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <table>
                                    <tr>
                                        <td><?= \Yii::t('app', '课程名称');?>：</td>
                                        <td>
                                            <input class="form" name="ProdName"  type="text" value="<?php echo empty($row) ? '' : htmlspecialchars($row['ProdName']);?>">&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?= \Yii::t('app', '课程开放时间');?>：
                                            <input class="form" style="width: 20%" name="OpenDay"  type="text" value="<?php echo empty($row['OpenDay']) ? 0 : date('Y-m-d H:i:s',$row['OpenDay']);?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                                            <span style="color: red">0或空:无时间随时开放</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '书名');?>：</td>
                                        <td>
                                            <input class="form" name="Name"  type="text" value="<?php echo empty($row) ? '' : htmlspecialchars($row['Name']);?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '课程封面');?>：</td>
                                        <td>
                                            <input class="form" name="CoverImg" type="text" value="<?php echo empty($row) ? '' : $row['CoverImg'];?>">
                                            （<?= \Yii::t('app', '尺寸');?>：324*360）
                                            <span  id="questionPicTr">
                                                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('CoverImg')" accept="image/*" />
                                                <span class="btn-upload" id="CoverImg_btn"></span>
                                            </span>&nbsp;&nbsp;
                                            <a class="btn btn-sm btn-primary" href="##" onclick="viewImg('CoverImg')"><?= \Yii::t('app', '查看');?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '简介图片');?>：</td>
                                        <td>
                                            <input class="form" name="DetailImg" type="text" value="<?php echo empty($row['DetailImg']) ? '' : $row['DetailImg'];?>">
                                            （<?= \Yii::t('app', '尺寸');?>：000*000）
                                            <span  id="questionPicTr">
                                                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="DetailImg_pic" onchange="uploadImg('DetailImg')" accept="image/*" />
                                                <span class="btn-upload" id="DetailImg_btn"></span>
                                            </span>&nbsp;&nbsp;
                                            <a class="btn btn-sm btn-primary" href="##" onclick="viewImg('DetailImg')"><?= \Yii::t('app', '查看');?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '作者头像');?>：</td>
                                        <td>
                                            <input class="form" name="Author" type="text" value="<?php echo empty($row) ? '' : $row['Author'];?>">
                                            （<?= \Yii::t('app', '尺寸');?>：000*000）
                                            <span  id="questionPicTr">
                                                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="Author_pic" onchange="uploadImg('Author')" accept="image/*" />
                                                <span class="btn-upload" id="Author_btn"></span>
                                            </span>&nbsp;&nbsp;
                                            <a class="btn btn-sm btn-primary" href="##" onclick="viewImg('Author')"><?= \Yii::t('app', '查看');?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '难度等级');?>：</td>
                                        <td>
                                            <select name="Level" class="">
                                                <?php for ($i = 0;$i <= 12;$i++){?>
                                                    <option value="<?php echo $i;?>" <?php if(!empty($row) && $row['Level'] == $i){echo 'selected';} ?>><?php echo $i;?></option>
                                                <?php }?>
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?= \Yii::t('app', '适龄范围');?>：
                                            <select name="MinAge" class="">
                                                <?php for ($i = 4;$i <= 15;$i++){?>
                                                    <option value="<?php echo $i;?>" <?php if(!empty($row) && $row['MinAge'] == $i){echo 'selected';} ?>  ><?php echo $i;?><?= \Yii::t('app', '岁');?></option>
                                                <?php }?>
                                            </select>-
                                            <select name="MaxAge" class="">
                                                <?php for ($i = 15;$i >= 4;$i--){?>
                                                    <option value="<?php echo $i;?>" <?php if(!empty($row) && $row['MaxAge'] == $i){echo 'selected';} ?> ><?php echo $i;?><?= \Yii::t('app', '岁');?></option>
                                                <?php }?>
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?= \Yii::t('app', '课程类别');?>：
                                            <select name="Category" class="">
                                                <?php foreach($category as $val){?>
                                                    <option value="<?php echo $val->ID;?>" <?php if(!empty($row) && $row['Category'] == $val->ID){echo 'selected';} ?> ><?php echo $val->Name;?></option>
                                                <?php }?>
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?= \Yii::t('app', '有效期');?>：
                                            <input class="form" style="width: 30px" name="Expire" type="text" value="<?php echo empty($row) ? '6' : $row['Expire'];?>">个月
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '定价');?>：</td>
                                        <td>
                                            <input class="form" name="Price" style="width:10%" type="text" value="<?php echo empty($row) ? '0' : $row['Price'];?>">&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?= \Yii::t('app', '售价');?>：
                                            <input class="form" name="DiscountPrice" style="width:10%" type="text" value="<?php echo empty($row) ? '0' : $row['DiscountPrice'];?>">&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?= \Yii::t('app', '试听价');?>：
                                            <input class="form" name="TryPrice" style="width:10%" type="text" value="<?php echo empty($row) ? '0' : $row['TryPrice'];?>">&nbsp;&nbsp;&nbsp;
                                            <?= \Yii::t('app', '课时数');?>：
                                            <input class="form" name="CourseTime" style="width:10%" type="text" value="<?php echo empty($row) ? '0' : $row['CourseTime'];?>">&nbsp;&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '蓝思指数');?>：</td>
                                        <td>
                                            <input style="width: 10%" class="form" name="Lexile"  type="text" value="<?php echo empty($row) ? '' : $row['Lexile'];?>">&nbsp;&nbsp;
                                            <?= \Yii::t('app', 'ATOS值');?>：
                                            <input style="width: 10%" class="form" name="Atos"  type="text" value="<?php echo empty($row) ? '' : $row['Atos'];?>">&nbsp;&nbsp;
                                            <?= \Yii::t('app', '字数');?>：
                                            <input style="width: 10%" class="form" name="WordsCount"  type="text" value="<?php echo empty($row) ? 0 : $row['WordsCount'];?>">&nbsp;&nbsp;
                                            <?= \Yii::t('app', '重点单词');?>：
                                            <input style="width: 10%" class="form" name="ImportWords"  type="text" value="<?php echo empty($row) ? '' : $row['ImportWords'];?>">&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '单元数量');?>：</td>
                                        <td>
                                            <input style="width: 10%" class="form" name="UnitCount"  type="text" value="<?php echo empty($row) ? 0 : $row['UnitCount'];?>">&nbsp;&nbsp;
                                            <?= \Yii::t('app', '子单元数量');?>：
                                            <input style="width: 10%" class="form" name="SUnitCount"  type="text" value="<?php echo empty($row) ? 0 : $row['SUnitCount'];?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '课程描述');?>：</td>
                                        <td>
                                            <textarea name="Desc" id="" cols="80" rows="6"><?php echo empty($row) ? 0 : $row['Desc'];?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '学习中心描述');?>：</td>
                                        <td>
                                            <textarea name="Description" id="" cols="80" rows="6"><?php echo empty($row) ? 0 : $row['Description'];?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '推荐理由');?>：</td>
                                        <td>
                                            <textarea name="Suggest" id="" cols="80" rows="6"><?php echo empty($row) ? 0 : $row['Suggest'];?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '关于作者');?>：</td>
                                        <td>
                                            <textarea name="AuthorAbout" id="" cols="80" rows="6"><?php echo empty($row) ? 0 : $row['AuthorAbout'];?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '课程收获');?>：</td>
                                        <td>
                                            <textarea name="Harvest" id="" cols="80" rows="6"><?php echo empty($row) ? 0 : $row['Harvest'];?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= \Yii::t('app', '关键阅读技巧');?>：</td>
                                        <td>
                                            <textarea name="Tech" id="" cols="80" rows="6"><?php echo empty($row) ? 0 : $row['Tech'];?></textarea>
                                        </td>
                                    </tr>
                                    <?php if(!empty($package)){ ?>
                                        <?php foreach ($package as $k=>$v){ ?>
                                            <tr>
                                                <td><?= \Yii::t('app', '课程包');?>：</td>
                                                <td>
                                                    <input class="form" style="width: 40%;" name="FileName[]" type="text" value="<?php echo $v->FileName;?>">
                                                    <input class="form" style="width: 10%;" name="FileSize[]" type="text" value="<?php echo $v->FileSize;?>">
                                                    <span  id="">
                                                        <input style="display: inline-block" class="fileupload" type="file" name="package" id="package" onchange="uploadFile(this)" />
                                                        <span class="btn-upload"></span>
                                                    </span>&nbsp;&nbsp;
                                                </td>
                                                <td>
                                                    <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                                                </td>
                                                <td>
                                                    <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <tr>
                                            <td><?= \Yii::t('app', '课程包');?>：</td>
                                            <td>
                                                <input class="form" style="width: 40%;" name="FileName[]" type="text" value="">
                                                <input class="form" style="width: 10%;" name="FileSize[]" type="text" value="">
                                                <span  id="">
                                                    <input style="display: inline-block" class="fileupload" type="file" name="package" id="package" onchange="uploadFile(this)" />
                                                    <span class="btn-upload"></span>
                                                </span>&nbsp;&nbsp;
                                            </td>
                                            <td>
                                                <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                                            </td>
                                            <td>
                                                <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if(!empty($outline)){ ?>
                                        <?php foreach ($outline as $k=>$v){ ?>
                                            <tr>
                                                <td><?= \Yii::t('app', '课程大纲');?>：</td>
                                                <td>
                                                    <input type="text" name="intensive_outline_name[]" value="<?php echo $v->Name;?>">&nbsp;
                                                    <?= \Yii::t('app', '大纲描述');?>：
                                                    <input type="text" style="width: 40%" name="intensive_outline_desc[]" value="<?php echo htmlspecialchars($v->Desc);?>">
                                                </td>
                                                <td>
                                                    <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                                                </td>
                                                <td>
                                                    <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <tr>
                                            <td><?= \Yii::t('app', '课程大纲');?>：</td>
                                            <td>
                                                <input type="text" name="intensive_outline_name[]" value="">&nbsp;
                                                <?= \Yii::t('app', '大纲描述');?>：
                                                <input type="text" style="width: 40%" name="intensive_outline_desc[]" value="">
                                            </td>
                                            <td>
                                                <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                                            </td>
                                            <td>
                                                <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <?php if(!empty($row)){?>
                            <input type="hidden" name="ID" value="<?php echo $row['ID']?>"/>
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
    /**
     * 上传课程包
     */
    function uploadFile(obj) {
        var fileDom = $(obj);
        var btn = fileDom.next()
        var url = "index.php?r=course/upload-package"
        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
        fileDom.parent().ajaxSubmit({
            dataType:  'json',
            beforeSend: function() {
                var percentVal = '0%';
                btn.addClass('disabled').text("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
            },
            success: function(data) {
                if(data.code == 1){
                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
                    var fileName = fileDom.parent().parent().parent().children().get(0);
                    var fileSize = fileDom.parent().parent().parent().children().get(1);
                    $(fileName).val(data.pic)
                    $(fileSize).val(data.size)
                }
                fileDom.unwrap();
            },
            error:function(xhr){
                alert('上传失败');
                fileDom.unwrap();
            }
        });
    }
    function addData(obj) {
        //获取当前tr元素
        var tr = $(obj).parent().parent()
        var html = '<tr>' + tr.html() + '</tr>';
        tr.after(html)
    }
    function minuxData(obj) {
        //获取当前tr元素
        var tr = $(obj).parent().parent()
        tr.remove();
    }

    //上传图片
    function uploadImg(action) {
        var fileDom = $('#'+action+'_pic');
        var btn = $('#'+action+'_btn')
        var url = "index.php?r=course/uploadimg&action="+action
        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
        fileDom.parent().ajaxSubmit({
            dataType:  'json',
            beforeSend: function() {
                var percentVal = '0%';
                btn.addClass('disabled').text("上传中...");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                btn.addClass('disabled').text("上传中..."+percentComplete + '%');
            },
            success: function(data) {
                console.log(data);
                if(data.code == 1){
                    btn.addClass('disabled').html("<span style='color: #00aa00'>上传成功</span>");
                    $("input[name="+action+"]").val(data.pic)
                }
                fileDom.unwrap();
            },
            error:function(xhr){
                alert('上传失败');
                fileDom.unwrap();
            }
        });
    }
    //查看图片
    function viewImg(action) {
        //获取图片名称
        var imgName = $("input[name="+action+"]").val()
        var key = 'view_'+action;
        //获取查看目录
        var href = '';
        switch(action)
        {
            case 'CoverImg'://课程封面图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_CoverImg']; ?>' + imgName
                break;
            case 'DetailImg'://课程简介图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_DetailImg']; ?>' + imgName
                break;
            case 'Poster'://泛读封面图片
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_extensive_cover_img']; ?>' + imgName
                break;
            case 'Author'://作者头像
                href = '<?php echo \Yii::$app->params['static_hiread'].\Yii::$app->params['view_Author']; ?>' + imgName
                break;
            default:
                href = '';
                break;
        }
        window.open(href);
    }

    $(document).ready(function() {
        $('#myForm').ajaxForm({
            dataType:"json",
            success:function(data){
                console.log(data);
                alert(data.msg);
                if(data.code == 1){
                    window.location.href="index.php?r=course/index";
                }
            }
        });
    });

</script>