<!--泛读-->
<hr>
<div>

    <div class="col-xs-8">
        <?php if(!empty($extensive)){ ?>
            <?php foreach($extensive as $k=>$v){ ?>
                <table style="margin-bottom: 30px">
                    <tr>
                        <td><?= \Yii::t('app', '泛读标题');?>：</td>
                        <td>
                            <input class="form" name="extensiveTitle[]" type="text" value="<?php echo $v->Title;?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '视频');?>：</td>
                        <td>
                            <input class="form" name="extensiveVideo[]" type="text" value="<?php echo $v->Video;?>">
                            <span  id="VideoTr">
                            <input style="display: inline-block" class="fileupload" type="file" name="VideoSource" id="VideoSource" onchange="uploadExtensiveVideo(this)" />
                            <span class="btn-upload"></span>
                        </span>&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '视频封面');?>：</td>
                        <td>
                            <input class="form" name="extensivePoster[]" type="text" value="<?php echo $v->Poster;?>">
                            <span  id="PosterPicTr">
                        <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="Poster_pic" onchange="uploadExtensiveVideoImg(this)" accept="image/*" />
                        <span class="btn-upload" id="Poster_btn"></span>
                    </span>&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary" href="##" onclick="viewImg('Poster',this)"><?= \Yii::t('app', '查看');?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><?= \Yii::t('app', '开放日期');?>：</td>
                        <td>
                            <input class="form" name="extensiveOpenDay[]" type="text" value="<?php echo empty($v->OpenDay) ? 0 : date('Ymd',$v->OpenDay) ;?>"> 格式：20180129，0:没有限制
                        </td>
                        <td>
                            <a href="##" style="margin: 8px" onclick="addExtensive(this)" class="fa fa-plus"></a>
                            <a href="##" style="margin: 8px" onclick="minuxExtensive(this)" class="fa fa-minus"></a>
                        </td>
                    </tr>
                </table>
            <?php }?>
        <?php }else{ ?>
            <table style="margin-bottom: 30px">
                <tr>
                    <td><?= \Yii::t('app', '泛读标题');?>：</td>
                    <td>
                        <input class="form" name="extensiveTitle[]" type="text" value="<?php echo empty($row) ? '' : $row['username'];?>">
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '视频');?>：</td>
                    <td>
                        <input class="form" name="extensiveVideo[]" type="text" value="<?php echo empty($row) ? '' : $row['Video'];?>">
                        <span  id="VideoTr">
                        <input style="display: inline-block" class="fileupload" type="file" name="VideoSource" id="VideoSource" onchange="uploadExtensiveVideo(this)" />
                        <span class="btn-upload"></span>
                    </span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '视频封面');?>：</td>
                    <td>
                        <input class="form" name="extensivePoster[]" type="text" value="<?php echo empty($row) ? '' : $row['Poster'];?>">
                        <span  id="PosterPicTr">
                        <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="Poster_pic" onchange="uploadExtensiveVideoImg(this)" accept="image/*" />
                        <span class="btn-upload" id="Poster_btn"></span>
                    </span>&nbsp;&nbsp;
                        <a class="btn btn-sm btn-primary" href="##" onclick="viewImg('Poster',this)"><?= \Yii::t('app', '查看');?></a>
                    </td>
                </tr>
                <tr>
                    <td><?= \Yii::t('app', '开放日期');?>：</td>
                    <td>
                        <input class="form" name="extensiveOpenDay[]" type="text" value="<?php echo empty($row) ? date('Ymd') : $row['username'];?>"> 格式：20180129，0:没有限制
                    </td>
                    <td>
                        <a href="##" style="margin: 8px" onclick="addExtensive(this)" class="fa fa-plus"></a>
                        <a href="##" style="margin: 8px" onclick="minuxExtensive(this)" class="fa fa-minus"></a>
                    </td>
                </tr>
            </table>
        <?php } ?>
    </div>
</div>

<script>
    function addExtensive(obj) {
        //获取当前table元素
        var tr = $(obj).parent().parent().parent().parent()
        console.log(tr.html());
        var html = '<table style="margin-bottom: 30px">' + tr.html() + '</table>';
        tr.after(html)
    }
    function minuxExtensive(obj) {
        //获取当前tr元素
        var tr = $(obj).parent().parent().parent().parent()
        tr.remove();
    }

    //上传视频
    function uploadExtensiveVideo(obj) {
        var fileDom = $(obj);
        var btn = fileDom.next();
        fileDom.wrap('<form action="index.php?r=course/uploadvideo&read_type=extensive" method="post" enctype="multipart/form-data"></form>');
        $(obj).parent().parent().find('form').ajaxSubmit({
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
                    $(obj).parent().parent().prev().val(data.pic)
                }else{
                    alert('上传失败');
                }
                fileDom.unwrap();
            },
            error:function(xhr){
                alert('上传失败');
                fileDom.unwrap();
            }
        });
    }
    //上传图片
    function uploadExtensiveVideoImg(obj) {
        var action = 'Poster';
        var fileDom = $(obj);
        var btn = fileDom.next();
        var url = "index.php?r=course/uploadimg&action="+action
        fileDom.wrap('<form action="'+url+'" method="post" enctype="multipart/form-data"></form>');
        $(obj).parent().parent().find('form').ajaxSubmit({
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
                    $(obj).parent().parent().prev().val(data.pic)
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