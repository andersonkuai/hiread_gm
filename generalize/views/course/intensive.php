<!--泛读-->
<hr>
<div>
    <div class="col-xs-12">
        <table>
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
                        <input class="form" style="width: 40%;" name="FileName[]" type="text" value="<?php echo empty($row) ? '' : $row['Video'];?>">
                        <input class="form" style="width: 10%;" name="FileSize[]" type="text" value="<?php echo empty($row) ? '' : $row['Video'];?>">
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
        </table>
    </div>

    <div class="col-xs-12">
        <h3><?= \Yii::t('app', '课程大纲');?></h3>
        <table width="50%">
            <tr>
                <th style="width: 30%"><?= \Yii::t('app', '大纲名称');?></th>
                <th style="width: 70%"><?= \Yii::t('app', '大纲描述');?></th>
                <th></th>
                <th></th>
            </tr>
            <?php if(!empty($outline)){ ?>
                <?php foreach ($outline as $k=>$v){ ?>
                    <tr>
                        <td><input style="width: 100%" type="text" name="intensive_outline_name[]" value="<?php echo $v->Name;?>"></td>
                        <td><input style="width: 100%" type="text" name="intensive_outline_desc[]" value="<?php echo $v->Desc;?>"></td>
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
                    <td><input style="width: 100%" type="text" name="intensive_outline_name[]" value="课前热身 Warm up"></td>
                    <td><input style="width: 100%" type="text" name="intensive_outline_desc[]" value="课前测"></td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                    </td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                    </td>
                </tr>
                <tr>
                    <td><input style="width: 100%" type="text" name="intensive_outline_name[]" value="第1单元 Unit 1"></td>
                    <td><input style="width: 100%" type="text" name="intensive_outline_desc[]" value=""></td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                    </td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                    </td>
                </tr>
                <tr>
                    <td><input style="width: 100%" type="text" name="intensive_outline_name[]" value="第2单元 Unit 2"></td>
                    <td><input style="width: 100%" type="text" name="intensive_outline_desc[]" value=""></td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                    </td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                    </td>
                </tr>
                <tr>
                    <td><input style="width: 100%" type="text" name="intensive_outline_name[]" value="第3单元 Unit 3"></td>
                    <td><input style="width: 100%" type="text" name="intensive_outline_desc[]" value=""></td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                    </td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                    </td>
                </tr>
                <tr>
                    <td><input style="width: 100%" type="text" name="intensive_outline_name[]" value="第4单元 Unit 4"></td>
                    <td><input style="width: 100%" type="text" name="intensive_outline_desc[]" value=""></td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="addData(this)" class="fa fa-plus"></a>
                    </td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="minuxData(this)" class="fa fa-minus"></a>
                    </td>
                </tr>
                <tr>
                    <td><input style="width: 100%" type="text" name="intensive_outline_name[]" value="结业测试"></td>
                    <td><input style="width: 100%" type="text" name="intensive_outline_desc[]" value="完成课后测试+Free Talk, 提供完整的学习报告给到学生和家长。"></td>
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
    <div class="col-xs-8" tab="<?php if(!empty($unit)) {echo max(array_keys($unit));}else{echo 0;} ?>">
        <h3><?= \Yii::t('app', '课程单元');?></h3>
        <div class="row">
            <div class="col-xs-4"><?= \Yii::t('app', '单元名称');?></div>
            <div class="col-xs-6"><?= \Yii::t('app', '开放时间,(格式：20180808，0：无限制)');?></div>
        </div>
        <?php if(!empty($unit)){ ?>
            <?php foreach ($unit as $key=>$val){?>
                <div class="unit" tab="0">
                    <div class="row" style="border: solid 1px;border-radius:10px;margin-bottom: 5px;margin-top: 20px">
                        <div class="col-xs-4">
                            <input type="text" name="unitName[<?=$key?>]" value="<?php echo $val['Name']?>">
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="openDay[<?=$key?>]" value="<?php echo $val['OpenDay']?>">
                        </div>
                        <div class="col-xs-4">
                            <a href="##" onclick="addUnit(this)" style="margin-right: 1px"><span class="fa fa-plus"></span></a>
                            <a href="##" onclick="minusUnit(this)" style="margin-right: 1px"><span class="fa fa-minus"></span></a>
                            <a href="##" class="btn btn-info btn-xs" onclick="showSubUnit(this)">子单元</a>
                        </div>
                    </div>
                    <div class="row" style="border: solid 1px;padding: 10px;display: none;">
                        <?php if(!empty($val['subUnit'])){?>
                            <?php foreach ($val['subUnit'] as $k=>$v){?>
                                <div class="row col-xs-12">
                                    <div class="col-xs-6"><input type="text" name="subUnitName[<?=$key?>][]" value="<?php echo $v['Name'];?>"></div>
                                    <div class="col-xs-3">
                                        <select class="subUnit" name="subUnitType[<?=$key?>][]" id="">
                                            <?php foreach (\common\enums\subUnit::params('type') as $key_t=>$val_t){ ?>
                                                <option value="<?= $key_t;?>" <?php if($v['Type'] == $key_t){echo 'selected';}?>><?= $val_t;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <a href="##" onclick="addSubUnit(this)" style="margin-right: 1px"><span class="fa fa-plus"></span></a>
                                        <a href="##" onclick="minusSubUnit(this)" style="margin-right: 1px"><span class="fa fa-minus"></span></a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php }else{?>
                            <div class="row col-xs-12">
                                <div class="col-xs-6"><input type="text" name="subUnitName[<?=$key?>][]" value=""></div>
                                <div class="col-xs-3">
                                    <select class="subUnit" name="subUnitType[<?=$key?>][]" id="">
                                        <?php foreach (\common\enums\subUnit::params('type') as $key_t=>$val_t){ ?>
                                            <option value="<?= $key_t;?>"><?= $val_t;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <a href="##" onclick="addSubUnit(this)" style="margin-right: 1px"><span class="fa fa-plus"></span></a>
                                    <a href="##" onclick="minusSubUnit(this)" style="margin-right: 1px"><span class="fa fa-minus"></span></a>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
        <div class="unit" tab="0">
            <div class="row" style="border: solid 1px;border-radius:10px;margin-bottom: 5px;margin-top: 20px">
                <div class="col-xs-4">
                    <input type="text" name="unitName[]" value="">
                </div>
                <div class="col-xs-4">
                    <input type="text" name="openDay[]" value="">
                </div>
                <div class="col-xs-4">
                    <a href="##" onclick="addUnit(this)" style="margin-right: 1px"><span class="fa fa-plus"></span></a>
                    <a href="##" onclick="minusUnit(this)" style="margin-right: 1px"><span class="fa fa-minus"></span></a>
                    <a href="##" class="btn btn-info btn-xs" onclick="showSubUnit(this)">子单元</a>
                </div>
            </div>
            <div class="row" style="border: solid 1px;padding: 10px;display: none;">
                <div class="row col-xs-12">
                    <div class="col-xs-6"><input type="text" name="subUnitName[0][]" value=""></div>
                    <div class="col-xs-3">
                        <select class="subUnit" name="subUnitType[0][]" id="">
                            <?php foreach (\common\enums\subUnit::params('type') as $key_t=>$val_t){ ?>
                                <option value="<?= $key_t;?>"><?= $val_t;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <a href="##" onclick="addSubUnit(this)" style="margin-right: 1px"><span class="fa fa-plus"></span></a>
                        <a href="##" onclick="minusSubUnit(this)" style="margin-right: 1px"><span class="fa fa-minus"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<script>
    //添加子单元
    function addSubUnit(obj) {
        var dom = $(obj).parent().parent();
        var html = '<div class="row col-xs-12">' + dom.html() + '</div>';
        dom.after(html)
    }
    //删除子单元
    function minusSubUnit(obj) {
        var dom = $(obj).parent().parent();
        dom.remove()
    }
    //添加单元
    function addUnit(obj) {
        var dom = $(obj).parent().parent().parent();
//        var idStr = $(obj).parent().parent().parent().parent().children('.unit').last().attr('tab');
        var idStr = $(obj).parent().parent().parent().parent().attr('tab');
        var id = parseInt(idStr) + 1;
        var html = '<div class="unit" tab="'+id+'">' + dom.html() + '</div>';
        //替换name值
        var nameVal = $(obj).parent().parent().next().children('div').children('div').one().children().attr('name');
        var length = parseInt(nameVal.length) - 15;
        var nameKey = nameVal.substr(12,length)
        var grepVal = '\\['+nameKey+'\\]'
        var html1 = html.replace(new RegExp(grepVal,'gm'),'['+id+']');
        //修改tab值
        $(obj).parent().parent().parent().parent().attr('tab',id);
        dom.after(html1)
    }
    //删除单元
    function minusUnit(obj) {
        var dom = $(obj).parent().parent().parent();
        dom.remove()
    }
    //展示子单元
    function showSubUnit(obj) {
        var div = $(obj).parent().parent().next().html()
        $(obj).parent().parent().next().toggle();
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
</script>