document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.querySelector("#leaderboardTable tbody");
    const categorySelect = document.getElementById("categoryFilter");

    // Fetch all categories to populate the filter
    fetch("api/leaderboards.php?category=all")
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${data.error}</td></tr>`;
                return;
            }

            // Get unique categories
            const categories = [...new Set(data.map(item => item.category))];
            categories.forEach(cat => {
                const option = document.createElement("option");
                option.value = cat;
                option.textContent = cat;
                categorySelect.appendChild(option);
            });

            renderLeaderboard(data);
        })
        .catch(err => {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading leaderboard. Please try again later.</td></tr>`;
            console.error(err);
        });

    // Handle category change
    categorySelect.addEventListener("change", () => {
        const cat = categorySelect.value;
        fetchLeaderboard(cat);
    });

    function fetchLeaderboard(category) {
        const url = category === "all" ? 
                    "api/leaderboards.php?category=all" : 
                    `api/leaderboards.php?category=${encodeURIComponent(category)}`;
        
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${data.error}</td></tr>`;
                    return;
                }
                renderLeaderboard(data);
            })
            .catch(err => {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading leaderboard. Please try again later.</td></tr>`;
                console.error(err);
            });
    }

    function renderLeaderboard(data) {
        if (!data.length) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center">No results found.</td></tr>`;
            return;
        }

        tableBody.innerHTML = "";
        data.forEach((row, index) => {
            const tr = document.createElement("tr");

            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>${row.email}</td>
                <td>${row.category}</td>
                <td>${row.total_questions}</td>
                <td>${row.score}</td>
                <td>${row.taken_on}</td>
            `;

            tableBody.appendChild(tr);
        });
    }
});
