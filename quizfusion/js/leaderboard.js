
document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.querySelector("#leaderboardTable tbody");
    const categorySelect = document.getElementById("categoryFilter");

    /*
    |--------------------------------------------------------------------------
    | Load categories
    |--------------------------------------------------------------------------
    */
    fetch("api/leaderboards.php?category=categories")
        .then(res => res.json())
        .then(categories => {
            categories.forEach(cat => {
                const option = document.createElement("option");
                option.value = cat;
                option.textContent = cat.replace(/_/g, " ");
                categorySelect.appendChild(option);
            });
        });

    // Load default leaderboard
    fetchLeaderboard("all");

    categorySelect.addEventListener("change", () => {
        fetchLeaderboard(categorySelect.value);
    });

    /*
    |--------------------------------------------------------------------------
    | Fetch leaderboard data
    |--------------------------------------------------------------------------
    */
    function fetchLeaderboard(category) {
        fetch(`api/leaderboards.php?category=${encodeURIComponent(category)}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    tableBody.innerHTML =
                        `<tr><td colspan="6">${data.error}</td></tr>`;
                    return;
                }
                renderLeaderboard(data);
            })
            .catch(() => {
                tableBody.innerHTML =
                    `<tr><td colspan="6">Error loading leaderboard</td></tr>`;
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Render leaderboard
    |--------------------------------------------------------------------------
    */
    function renderLeaderboard(data) {
        if (!data.length) {
            tableBody.innerHTML =
                `<tr><td colspan="6">No results found</td></tr>`;
            return;
        }

        tableBody.innerHTML = "";
        data.forEach(row => {
            tableBody.innerHTML += `
                <tr>
                    <td>${row.rank}</td>
                    <td>${row.email}</td>
                    <td>${row.category}</td>
                    <td>${row.total_questions}</td>
                    <td>${row.score}</td>
                    <td>${row.taken_on}</td>
                </tr>
            `;
        });
    }
});

