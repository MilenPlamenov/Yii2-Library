<?php

/** @var $key */
/** @var $value */

use app\models\Book;
use yii\helpers\Html;
?>
            <p class="card-text" id="amount">
                Amount: <?= $value['amount'] ?>
            </p>
            <div id="btns" style="text-align: right;">
                <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                            </svg>',
                    ['user/add-amount', 'item_id' => $key], ['data' => ['method' => 'post', 'pjax' => '1']]); ?>

                <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                            </svg>',
                    ['user/remove-amount', 'item_id' => $key], ['data' => [
                        'method' => 'post',
                        'pjax' => '1',
                    ]]); ?>

                <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3-fill trash" viewBox="0 0 16 16">
                              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                            </svg>',
                    ['user/remove-from-cart', 'item_id' => $key], ['data' => [
                        'method' => 'post',
                        'pjax' => '1',
                    ]]); ?>
            </div>

<script>
    $(document).ready(function(){
        $(".trash").click(function (event) {
            $(this).removeClass("trash");
            $(this).parent().parent().parent().parent().parent().parent().hide();
            if (!$(this).parent().parent().parent().parent().parent().parent().siblings().length) {
                $("#proceed-btn").hide();
                $(document.createElement('h2')).html("Empty cart").appendTo(".container");
            }
        });
    });
</script>