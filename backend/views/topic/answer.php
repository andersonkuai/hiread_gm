<?php if(!empty($answer)){ ?>
    <?php foreach ($answer as $k_answer=>$v_answer){ ?>
        <ul style="margin-top: 10px;background-color: burlywood;">
            <li>
                <?= \Yii::t('app', '答案描述');?>：<input name="answerName[]" type="text" value="<?=htmlspecialchars($v_answer->Name);?>" />
            </li>
            <li>
                <?= \Yii::t('app', '图片');?>：
                <input class="form" name="answerImage[]" type="text" value="<?=$v_answer->Image;?>">
                <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_answer_image',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_image',this)"><?= \Yii::t('app', '查看');?></a>
            </li>
            <li>
                <?= \Yii::t('app', '是否显示该选项');?>：
                <select name="answerShow[]" id="">
                    <option value="1" <?php if($v_answer->Show == '1') echo 'selected';?>><?= \Yii::t('app', '显示');?></option>
                    <option value="0" <?php if($v_answer->Show == '0') echo 'selected';?>><?= \Yii::t('app', '不显示');?></option>
                </select>
            </li>
            <li>
                <?= \Yii::t('app', '配对文字1');?>：<input name="answerPair1Text[]" type="text" value="<?=htmlspecialchars($v_answer->Pair1Text)?>">
            </li>
            <li>
                <?= \Yii::t('app', '配对图片1');?>：
                <input class="form" name="answerPair1Img[]" type="text" value="<?=$v_answer->Pair1Img;?>">
                <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_answer_Pair1Img',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Img',this)"><?= \Yii::t('app', '查看');?></a>
            </li>
            <li>
                <?= \Yii::t('app', '配对音频1');?>：
                <input class="form" name="answerPair1Audio[]" type="text" value="<?=$v_answer->Pair1Audio;?>">
                <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_answer_Pair1Audio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Audio',this)"><?= \Yii::t('app', '查看');?></a>
            </li>

            <li>
                <?= \Yii::t('app', '配对文字2');?>：<input name="answerPair2Text[]" type="text" value="<?=htmlspecialchars($v_answer->Pair2Text)?>">
            </li>
            <li>
                <?= \Yii::t('app', '配对图片2');?>：
                <input class="form" name="answerPair2Img[]" type="text" value="<?=$v_answer->Pair2Img ?>" >
                <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_answer_Pair1Img',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Img',this)"><?= \Yii::t('app', '查看');?></a>
            </li>
            <li>
                <?= \Yii::t('app', '配对音频2');?>：
                <input class="form" name="answerPair2Audio[]" type="text" value="<?=$v_answer->Pair2Audio?>" >
                <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_answer_Pair1Audio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
                <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Audio',this)"><?= \Yii::t('app', '查看');?></a>
            </li>
            <li>
                <?= \Yii::t('app', '标为正确答案');?>：
                <select name="isTrue[]" id="">
                    <option value="1" <?php if(in_array($v_answer->ID,explode('|',$question['Correct']))) echo 'selected'; ?>>是</option>
                    <option value="0" <?php if(!in_array($v_answer->ID,explode('|',$question['Correct']))) echo 'selected'; ?>>否</option>
                </select>
                <a onclick="addAnswer(this)" class="fa fa-plus"></a>
                <a onclick="minusAnswer(this)" class="fa fa-minus"></a>
            </li>
        </ul>
    <?php }?>
<?php }else{ ?>
    <ul style="margin-top: 10px;background-color: burlywood;">
        <li>
            <?= \Yii::t('app', '答案描述');?>：<input name="answerName[]" type="text" />
        </li>
        <li>
            <?= \Yii::t('app', '图片');?>：
            <input class="form" name="answerImage[]" type="text" value="<?php echo empty($val) ? '' : '';?>">
            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_answer_image',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_image',this)"><?= \Yii::t('app', '查看');?></a>
        </li>
        <li>
            <?= \Yii::t('app', '是否显示该选项');?>：
            <select name="answerShow[]" id="">
                <option value="1"><?= \Yii::t('app', '显示');?></option>
                <option value="0"><?= \Yii::t('app', '不显示');?></option>
            </select>
        </li>
        <li>
            <?= \Yii::t('app', '配对文字1');?>：<input name="answerPair1Text[]" type="text">
        </li>
        <li>
            <?= \Yii::t('app', '配对图片1');?>：
            <input class="form" name="answerPair1Img[]" type="text" value="<?php echo empty($val) ? '' : '';?>">
            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_answer_Pair1Img',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Img',this)"><?= \Yii::t('app', '查看');?></a>
        </li>
        <li>
            <?= \Yii::t('app', '配对音频1');?>：
            <input class="form" name="answerPair1Audio[]" type="text" value="<?php echo empty($val) ? '' : '';?>">
            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_answer_Pair1Audio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Audio',this)"><?= \Yii::t('app', '查看');?></a>
        </li>

        <li>
            <?= \Yii::t('app', '配对文字2');?>：<input name="answerPair2Text[]" type="text">
        </li>
        <li>
            <?= \Yii::t('app', '配对图片2');?>：
            <input class="form" name="answerPair2Img[]" type="text" value="<?php echo empty($val) ? '' : '';?>">
            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadImg('extensive_answer_Pair1Img',this)" accept="image/*" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Img',this)"><?= \Yii::t('app', '查看');?></a>
        </li>
        <li>
            <?= \Yii::t('app', '配对音频2');?>：
            <input class="form" name="answerPair2Audio[]" type="text" value="<?php echo empty($val) ? '' : '';?>">
            <span  id="questionPicTr">
                <input style="display: inline-block" class="fileupload" type="file" name="questionPic" id="CoverImg_pic" onchange="uploadFile('extensive_answer_Pair1Audio',this)" />
                <span class="btn-upload" id="CoverImg_btn"></span>
            </span>&nbsp;&nbsp;
            <a class="btn btn-sm btn-primary" href="##" onclick="viewFile('extensive_answer_Pair1Audio',this)"><?= \Yii::t('app', '查看');?></a>
        </li>
        <li>
            <?= \Yii::t('app', '标为正确答案');?>：
            <select name="isTrue[]" id="">
                <option value="1">是</option>
                <option value="0" selected>否</option>
            </select>
            <a onclick="addAnswer(this)" class="fa fa-plus"></a>
            <a onclick="minusAnswer(this)" class="fa fa-minus"></a>
        </li>
    </ul>
<?php } ?>

<script>
    function addAnswer(obj) {
        //获取当前table元素
        var tr = $(obj).parent().parent()
        //获取tab值
        var tab = $(obj).parent().parent().parent().parent().parent().parent().attr('tab')
        //获取html标签
        var str = tr.html();
        var html = '<ul style="margin-top: 20px;background-color: burlywood">' + str + '</ul>';
        tr.after(html)
    }
    function minusAnswer(obj) {
        //获取当前tr元素
        var tr = $(obj).parent().parent()
        tr.remove();
    }
</script>

