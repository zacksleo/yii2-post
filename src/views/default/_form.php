<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="post-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'imgFile')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'png/*',
            'multiple' => false
        ],
        'pluginOptions' => [
            // 需要预览的文件格式
            'previewFileType' => 'image',
            // 需要展示的图片设置，比如图片的宽度等
            'initialPreview' => [
                $_ENV['APP_HOST'] . 'uploads/' . $model->img,
            ],
            'initialPreviewAsData' => true,
            'showRemove' => true,
            'showPreview' => $model->isNewRecord ? false : true,
            'initialCaption' => $model->img,
            'overwriteInitial' => false,
        ]
    ])->hint('在此上传图片'); ?>
    <?= $form->field($model, 'views')->textInput() ?>
    <?= $form->field($model, 'order')->textInput() ?>
    <?= $form->field($model, 'status')->radioList(['0' => '下线', '1' => '上线']) ?>
    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor', []) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>