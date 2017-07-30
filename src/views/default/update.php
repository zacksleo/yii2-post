<?php

use yii\helpers\Html;
use zacksleo\yii2\post\Module;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = Yii::t('yii', 'Update');
$this->params['breadcrumbs'][] = ['label' => Module::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
