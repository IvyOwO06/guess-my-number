function getLeaderboard() {
    $.ajax({
        type: "GET",
        url: "inc/get_leaderboard_db.php", // your PHP script
        dataType: "json",
        success: function (data) {
            // data is an array of leaderboard entries
            console.log(data);

            // clear the table first
            $("#leaderboard-table tbody").empty();

            // loop through each entry and render with Mustache
            $.each(data, function (index, entry) {
                var template = $("#leaderboard-template").html();
                var renderTemplate = Mustache.render(template, { entry: entry });
                $("#leaderboard-table tbody").append(renderTemplate);
            });
        },
        error: function (xhr, status, error) {
            console.error("Failed to fetch leaderboard:", error);
        }
    });
}

$(document).ready(function () {
    // populate leaderboard on page load
    getLeaderboard();
});