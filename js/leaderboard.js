function getLeaderboard(sortBy) {
    console.log("Fetching leaderboard sorted by:", sortBy);
    $.ajax({
        type: "GET",
        url: "inc/get_leaderboard_db.php?sortBy=" + sortBy, // your PHP script
        dataType: "json",
        success: function (data) {
            // data is an array of leaderboard entries
            console.log(data);

            // clear the table first
            $("#leaderboard-table tbody").empty();

            // loop through each entry and render with Mustache
            $.each(data, function (index, entry) {
                const difficultyMap = {
                    1: "Easy",
                    2: "Average",
                    3: "Tough",
                    4: "Hard",
                    5: "Harder",
                    6: "Extreme",
                };

                entry.rank = index + 1; // add a rank/index to each entry
                entry.difficulty =
                    difficultyMap[String(entry.difficulty)] || entry.difficulty;

                var template = $("#leaderboard-template").html();
                var renderTemplate = Mustache.render(template, {
                    entry: entry,
                });
                $("#leaderboard-table tbody").append(renderTemplate);
            });
        },
        error: function (xhr, status, error) {
            console.error("Failed to fetch leaderboard:", error);
        },
    });
}

$(document).ready(function () {
    // populate leaderboard on page load
    getLeaderboard("attempts");

    $(document).on("change", "#sortByAttempts", function () {
        getLeaderboard("attempts");
    });

    $(document).on("change", "#sortByTime", function () {
        getLeaderboard("maxTime(s)");
    });
});
