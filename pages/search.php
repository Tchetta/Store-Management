<div class="search-container">
    <label for="searchBar">Search Equipment:</label>
    <input type="text" id="searchBar" placeholder="Type to search...">
    <div id="searchResults" class="results-container"></div>
</div>

<style>
    /* Optional: Styles for search results */
    .results-container { padding-top: 10px; }
    .result-item { padding: 8px; border-bottom: 1px solid #ddd; }
    .result-item h4 { margin: 0; font-size: 1.1em; }
    .result-item p { margin: 0; color: #555; }
</style>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchBar");
    const resultsContainer = document.getElementById("searchResults");

    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();

        if (query.length > 0) {
            fetch(`../includes/search_equipment.inc.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displayResults(data);
                })
                .catch(error => console.error("Error fetching search results:", error));
        } else {
            resultsContainer.innerHTML = "";
        }
    });

    function displayResults(data) {
        resultsContainer.innerHTML = "";

        if (data.length === 0) {
            resultsContainer.innerHTML = "<p>No equipment found.</p>";
            return;
        }

        data.forEach(item => {
            const resultItem = document.createElement("div");
            resultItem.classList.add("result-item");
            resultItem.innerHTML = `
                <h4>${item.model_name}</h4>
                <p>Store: ${item.store_name}</p>
                <p>Category: ${item.category_name}</p>
                <p>Serial Number: ${item.serial_num}</p>
            `;
            resultsContainer.appendChild(resultItem);
        });
    }
});
</script>
