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

                <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>',
                    ['user/remove-from-cart', 'item_id' => $key], ['data' => [
                        'method' => 'post',
                        'pjax' => '1',
                    ], 'id' => 'trash-button-'. $key]); ?>
            </div>

<script>
    $(document).ready(function(){
        $("[id^=trash-button]").click(function (event) {
            console.log(event.target)
            console.log(this)
            $(this).parent().parent().parent().parent().parent().hide();
            if (!$(this).parent().parent().parent().parent().parent().siblings('.card-group')) {
                $("#proceed-btn").hide();
                $(document.createElement('h2')).html("Empty cart").appendTo(".container");
            }
        });
    });
</script>

<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $(".trash").click(function (event) {-->
<!--            $(this).removeClass("trash");-->
<!--            $(this).parent().parent().parent().parent().parent().parent().hide();-->
<!--            if (!$(this).parent().parent().parent().parent().parent().parent().siblings().length) {-->
<!--                $("#proceed-btn").hide();-->
<!--                $(document.createElement('h2')).html("Empty cart").appendTo(".container");-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->