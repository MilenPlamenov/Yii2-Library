<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\Autocomplete;


/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var yii\widgets\ActiveForm $form */
echo var_dump($_SESSION['cart']);

$this->title = 'Live taking for user: ' . $user->email;
?>

<div class="taken-books-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a(
        'Currently taken books',
        ['currently-taken-books', 'id' => $user->id],
        ['class' => 'btn btn-secondary']
    ); ?>
    <?php $form = ActiveForm::begin(['id' => $user->formName()]); ?>

    <?= $form->field($user, 'book_id')->textInput() ?>

    <?= $form->field($user, 'amount')->textInput() ?>

    <div class="form-group m-2">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success',
            'id' => 'orderBtn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS

$('form#{$user->formName()}').on('beforeSubmit', function(e){
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
    .done(function(result){
        if(result == 1){
            $("#item-count").html(function(index,currentContent) {
            return parseInt(currentContent) + 1;
            });
            $(\$form).trigger("reset");
            $('<h4/>',{
                text: 'Successfully added item to the cart',
                class: 'text-success'
            }).appendTo("#modelContent");

            // if($('#modalReportButton').length){
            //     $.pjax.reload({container:'#grid'}); //requery the main form's grid with the new addition
            //     $(document).find('#modal').modal('hide');
            // }else{
            //     $(document).find('#modalPopup3').modal('hide');
            // }
        }else{
            // $(\$form).trigger("reset");
            // if($('#modalReportButton').length){
            //     $("#message").html(result.message);
            // }
            $('<h4/>',{
                text: 'Make sure that the book ID exist and there are enough books!',
                class: 'text-danger'
            }).appendTo("#modelContent");
        }
        $('h4').delay(3000).fadeOut('slow');

    })
    .fail(function(){
        console.log("server error");
    });

    return false;
});

JS;
$this->registerJs($script);
?>