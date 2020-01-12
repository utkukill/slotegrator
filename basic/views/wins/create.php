<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wins */

$this->title = 'Create Wins';
$this->params['breadcrumbs'][] = ['label' => 'Wins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wins-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
