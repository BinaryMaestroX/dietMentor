$(function(){
    $("#btnSubmit").on('click',function(e){
        e.preventDefault();
        var username = $("#username").val();
        var password = $("#password").val();
        var dob = $("#dob").val();
        var phone = $("#phone").val();
        var email = $("#email").val();

        $.ajax({
            url: 'https://dietmentor.000webhostapp.com/Backend/API/Register.php',
            type: 'POST',
            data: {
                username: username,
                password: password,  // Corrected here
                dob: dob,
                phone: phone,
                email: email
            },
            success: function(response) {
                if (response.status === "success") {
                    alert("Registration Successful");
                }else if(response.status === "error"){
                    alert(response.message);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    })
});