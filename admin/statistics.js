// Function to fetch statistics data using AJAX
function fetchStatistics() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                document.getElementById("totalUsers").textContent = data.totalUsers;
                document.getElementById("totalAdmins").textContent = data.totalAdmins;
                document.getElementById("totalVehicles").textContent = data.totalVehicles;
                document.getElementById("totalLocations").textContent = data.totalLocations;
                document.getElementById("totalBookings").textContent = data.totalBookings;
            } else {
                console.error("Error fetching data");
            }
        }
    };

    xhr.open("GET", "get_statistics.php", true);
    xhr.send();
}

// Call the function to fetch and update statistics
fetchStatistics();
