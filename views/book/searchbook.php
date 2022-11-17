<?php

use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Search Books';

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php

echo $this->render('_search', ['model' => $searchModel]);
?>