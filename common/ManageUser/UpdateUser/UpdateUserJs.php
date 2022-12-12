<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $(document).on("click", ".isBtnUpdateUser", function()
		{
			let id = $(this).attr("id");
			window.location.assign("/Kasangguni/manage-user-updatedisplay?id="+btoa(id));
		});
        
        $("#tblUpdateUser").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/ManageUser/UpdateUser/GetData.php",
                type: "POST",
				data: 
				{
					type: "GETACTIVEACCOUNT"
				}
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3,4,5,6],
                orderable: false
            }]
        });
        
        $("#fUpdateUser").submit(function(event) 
        {
            event.preventDefault(); 
            let acccode = $("#txtAccountCode").val().trim();
            let brgycode = $("#txtBrgycode").val().trim();
            let empcode = $("#txtEmpcode").val().trim();
            let firstname = $("#txtFirstname").val().trim();
            let middlename = $("#txtMiddlename").val().trim();
            let lastname = $("#txtLastname").val().trim();
            let suffixname = $("#txtSuffixname").val().trim();
            let gender = $("#cboGender").val();
            let email = $("#txtEmail").val().trim();
            let mobile = $("#txtMobileNumber").val().trim();
            let position = $("#cboPosition").val().trim();
            let address = $("#txtAddress").val().trim();
            
            Swal.fire(
            {
                title: "Do you want to update it?",
                text: "Please check all information before submitting!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Update",
                cancelButtonColor: "#d33",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => 
            {
                if (result.isConfirmed)
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: "modules/ManageUser/UpdateUser/Insert.php",
                        data: 
                        {
                            acccode: acccode,
                            brgycode: brgycode,
                            empcode: empcode,
                            firstname: firstname,
                            middlename: middlename,
                            lastname: lastname,
                            suffixname: suffixname,
                            gender: gender,
                            email: email,
                            mobile: mobile,
                            position: position,
                            address: address,
                            type: "UPDATEACCOUNT"
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
                                    text: "User account has been changed successfully.",
                                    icon: "success",
                                }).then(function(isConfirm)
                                {
                                    window.location.assign("/Kasangguni/manage-user-updatemain");
                                });
                            }
                        }
                    });
                }
            });
        });
        
        $(document).on("click", ".isBtnUnblockUser", function()
		{
			let id = $(this).attr("id");
            
            Swal.fire(
            {
                title: "Do you want to unblock this account?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Unblock",
                cancelButtonColor: "#d33",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => 
            {
                if (result.isConfirmed)
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: "modules/ManageUser/UpdateUser/Insert.php",
                        data: 
                        {
                            id: id,
                            type: "UNBLOCKEDACCOUNT"
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
                                    text: "User account has been unblocked successfully. The account is now already active.",
                                    icon: "success",
                                }).then(function(isConfirm)
                                {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
		});
        
        $(document).on("click", ".isBtnResetPassword", function()
		{
			let id = $(this).attr("id");
            
            Swal.fire(
            {
                title: "Do you want to reset this password?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Reset Password",
                cancelButtonColor: "#d33",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => 
            {
                if (result.isConfirmed)
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: "modules/ManageUser/UpdateUser/Insert.php",
                        data: 
                        {
                            id: id,
                            type: "RESETPASSWORD"
                        },
                        success: function(result)
                        {
                            if(result == "RecordBlocked")
                            {
                                Swal.fire(
                                {
                                    title: "Warning!",
                                    text: "The account is blocked. Password reset is not available.",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then(function(isConfirm)
                                {
                                    
                                });
                            }
                            
                            if(result == "RecordResetAlready")
                            {
                                Swal.fire(
                                {
                                    title: "Warning!",
                                    text: "The account has already been reset.",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then(function(isConfirm)
                                {
                                    
                                });
                            }
                            
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
                                    text: "Password has been changed successfully. Please inform the employee to log out his account in order to apply the account reset.",
                                    icon: "success",
                                }).then(function(isConfirm)
                                {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
		});
	});
    
    function isBtnBack()
    {
        window.location.assign("/Kasangguni/manage-user-updatemain");
    }
</script>