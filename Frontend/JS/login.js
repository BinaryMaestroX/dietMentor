$(function(){
    
    $("#btnSubmit").on('click',function(e){
        e.preventDefault();
        var username = $("#username").val();
        var password = $("#password").val();
        $.ajax({
            url: 'https://dietmentor.000webhostapp.com/Backend/API/Login.php',
            type: 'POST',
            data: {
                username: username,
                password: password,  // Corrected here
                userrole: 'N',
            },
            success: function(response) {
                if (response.status === "success") {
                    alert("Login Successful");
                    sessionStorage.setItem("username", username);
                    window.location.href = 'Profile.html'
                }else if(response.status === "error"){
                    alert('Not Found');
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
        
    })

})