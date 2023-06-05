function createdd() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Database and table created successfully");
        }
    };
    xhr.open("POST", "create_db.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("createdb=1");
}
function createdb(){
    createdd();
    hideElement("dosageDetails");
    hideElement("removeCenterForm");
    hideElement("addCenterForm");
}
function createss() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Slot table created successfully");
        }
    };
    xhr.open("POST", "create_slot.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("createss=1");
}

function addv(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Inserted");
        }
    };
    xhr.open("POST", "addvac.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("addCenter=1");

}
function showAddCenterForm() {
    hideElement("dosageDetails");
    hideElement("removeCenterForm");
    showElement("addCenterForm");

}
function getDosageDetails() {
    hideElement("addCenterForm");
    hideElement("removeCenterForm");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'admin.php?getDosageDetails=true', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var dosageData = JSON.parse(xhr.responseText);
            var dosageTable = document.getElementById("dosageTable");
            dosageTable.innerHTML = "<tr><th>Center Name</th><th>Total Dosage 1</th><th>Total Dosage 2</th></tr>";
            for (var i = 0; i < dosageData.length; i++) {
                var dosage = dosageData[i];
                var row = "<tr><td>" + dosage.cname + "</td><td>" + dosage.totalDosage1 + "</td><td>" + dosage.totalDosage2 + "</td></tr>";
                dosageTable.innerHTML += row;
            }
            showElement("dosageDetails");
        }
    };
    xhr.send();
}
function showRemoveCenterForm() {
    hideElement("addCenterForm");
    hideElement("dosageDetails");
    showElement("removeCenterForm");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_centers.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var centersData = JSON.parse(xhr.responseText);
            var centerSelect = document.getElementById("centerSelect");
            centerSelect.innerHTML = "<option value=''>Select Center</option>";
            for (var i = 0; i < centersData.length; i++) {
                var center = centersData[i];
                var option = document.createElement("option");
                option.value = center.centerId;
                option.textContent = center.centerName;
                centerSelect.appendChild(option);
            }

            showElement("removeCenterForm");
        }
    };
    xhr.send();
}
function logout() {
    window.location.href = "admin_login.html";
}
function showElement(elementId) {
    var element = document.getElementById(elementId);
    if (element) {
        element.classList.remove("hidden");
    }
}
function hideElement(elementId) {
    var element = document.getElementById(elementId);
    if (element) {
        element.classList.add("hidden");
    }
}
