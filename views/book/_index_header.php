<?php

use yii\helpers\Html;
$this->title = 'Books Collection';

?>
<div class="bg-warning py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome to <?= Html::encode($this->title) ?></h1>
            <p class="lead fw-normal text-dark mb-0">The unlimited book library</p>
            <p class="lead fw-normal text-dark mb-0">Get started by <button class="btn p-0 btn-link" id="search-button">searching for your favorite book(s)</button>
                or <button class="btn p-0 btn-link" id="sort-button">sort books</button></p>

        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#search-div").hide();
        $("#sort-div").hide();
        $("#search-button").click(function () {
            $("#search-div").toggle();

        });
        $("#sort-button").click(function () {
            $("#sort-div").toggle();
        })
    });

</script>