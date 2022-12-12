<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#fLogin").submit(function(event) 
        {
            event.preventDefault(); 
            let username = $("#txtUsername").val().trim();
            let password = $("#txtPassword").val().trim();
            
            $.ajax(
			{
				type: "POST",
				url: "modules/Login/Verify.php",
				data: 
				{
					username: username,
					type: "VERIFYUSERNAME"
				},
				success: function(result)
				{
                    if(result == "ExisitingUsername")
                    {
                        $.ajax(
                        {
                            type: "POST",
                            url: "modules/Login/Verify.php",
                            data: 
                            {
                                username: username,
                                password: password,
                                type: "LOGINVERIFY"
                            },
                            success: function(result)
                            {
                                var data = result.split(",");
                                
                                if(data[0] == "AccountBlocked")
                                {
                                    Swal.fire(
                                    {
                                        title: "Account Blocked!",
                                        text: "Your account is temporarily blocked, please contact the administrator!",
                                        icon: "error",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then(function(isConfirm)
                                    {
                                        
                                    });
                                }
                                
                                if(data[0] == "FirstLogin")
                                {
                                    window.location.assign("/Kasangguni/change-password?id="+btoa(data[1]));
                                }
                                
                                if(data[0] == "LoginFailed")
                                {
                                    Swal.fire(
                                    {
                                        title: "There was a problem!",
                                        text: "Please input a valid password! You have "+ data[1] +" login attempt left, otherwise your account will be blocked.",
                                        icon: "error",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then(function(isConfirm)
                                    {
                                        $("#txtPassword").val("");
                                    });
                                }
                                
                                if(data[0] == "LoginSuccess")
                                {
                                    window.location.assign("/Kasangguni/main-page");
                                }
                            }
                        });
                    }
                    
                    if(result == "NotExistingUsername")
                    {
                        Swal.fire(
                        {
                            title: "There was a problem!",
                            text: "Please input a valid username!",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(function(isConfirm)
                        {
                            
                        });
                    }
                }
            });
        });
        
        $("#fChangePassword").submit(function(event) 
        {
            event.preventDefault(); 
            let empcode = $("#txtEmpcode").val().trim();
            let newpassword = $("#txtNewPassword").val().trim();
            $.ajax(
            {
                type: "POST",
                url: "modules/Login/Insert.php",
                data: 
                {
                    empcode: empcode,
                    newpassword: newpassword,
                    type: "CHANGEPASSWORD"
                },
                success: function(result)
                {
                    if(result == "RecordSaved")
                    {
                        const Toast = Swal.mixin(
                        {
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => 
                            {
                                toast.addEventListener("mouseenter", Swal.stopTimer)
                                toast.addEventListener("mouseleave", Swal.resumeTimer)
                            }
                        });
                        
                        Toast.fire(
                        {
                            title: "Success!",
                            text: "Password changed successfully.",
                            icon: "success",
                        }).then(function(isConfirm)
                        {
                            window.location.assign("/Kasangguni/login");
                        });
                    }
                    
                    if(result == "SamePassword")
                    {
                        Swal.fire(
                        {
                            title: "There was a problem!",
                            text: "Your new password cannot be the same as your current password.",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(function(isConfirm)
                        {
                            $("#txtNewPassword").val("");
                        });
                    }
                }
            });
        });
	});
</script>