$(document).ready(function () {
    $("#amount-sort-grid").hide();
    $("#returned-btn").click(function () {
        $("#returned-sort-grid").show();
        $("#amount-sort-grid").hide();
        $("#returned-btn").addClass("active");
        $("#amount-btn").removeClass("active");
    });
    $("#amount-btn").click(function () {
        $("#returned-sort-grid").hide();
        $("#amount-sort-grid").show();
        $("#returned-btn").removeClass("active");
        $("#amount-btn").addClass("active");
    })
});