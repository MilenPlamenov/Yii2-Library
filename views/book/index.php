<?php
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<?php echo $this->render('_index_header'); ?>


<div class="book-index container mt-4">

    <div id="search-div">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?php
        if (isset($_SESSION['selected_user'])) {
            $user = User::find()->where(['id' => $_SESSION['selected_user']])->one()->email;
            echo '<h4>Selected User:'. Html::a($user,
                                                        [Url::toRoute(['user/currently-taken-books',
                                                            'id' => User::find()
                                                                ->where(['id' => $_SESSION['selected_user']])->one()->id])])
                                                                    . '</h4>';
        }
    ?>
    <div id="sort-div">
        <h3>Sort the books base on (title, author or year)</h3>
        <?= LinkSorter::widget([
            'sort' => $dataProvider->sort,
            'attributes' => [
                'title',
                'author',
                'post_year',
            ],
            'options' => ['class' => 'list-group  nav'],
            'linkOptions' => ['class' => 'list-group-item list-group-item-action'],
        ]) ?>
    </div>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_book_item',
        'summary' => '',
    ]) ?>
</div>
