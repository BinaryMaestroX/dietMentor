
function showSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'flex';
}

function hideSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'none';
}

let profilepic = document.getElementById("profile-pic");
let inputfile = document.getElementById("input-file");

inputfile.onchange = function () {
    profilepic.src = URL.createObjectURL(inputfile.files[0]);
}

function changeProfile() {
    alert('Change Profile button clicked');
}

function logout(){
    sessionStorage.setItem('username','');
}

$(function(){
    var username = sessionStorage.getItem('username');
    $.ajax({
        type: 'POST',
        url: 'https://dietmentor.000webhostapp.com/Backend/API/Fetch_data.php',
        data: {
            username: username
        },
        dataType: 'json',
        success: function(response) {
            $("#username").val(response.user_id);
            $("#email").val(response.email);
            $("#mobile").val(response.phone);
            $("#dob").val(dob);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
            alert('Error: ' + xhr.responseText); 
        }
    });
});
