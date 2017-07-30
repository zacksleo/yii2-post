<?php

use yii\helpers\Html;
use zacksleo\yii2\post\Module;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = Module::t('post', 'Create');
$this->params['breadcrumbs'][] = ['label' => Module::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
