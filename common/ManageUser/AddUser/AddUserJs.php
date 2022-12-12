<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#fAddUser").submit(function(event) 
        {
            event.preventDefault(); 
            let brgycode = $("#cboBarangay").val();
            let firstname = $("#txtFirstname").val().trim();
            let middlename = $("#txtMiddlename").val().trim();
            let lastname = $("#txtLastname").val().trim();
            let suffixname = $("#txtSuffixname").val().trim();
            let gender = $("#cboGender").val();
            let email = $("#txtEmail").val().trim();
            let mobile = $("#txtMobileNumber").val().trim();
            let position = $("#cboPosition").val();
            let address = $("#txtAddress").val().trim();
            
            Swal.fire(
            {
                title: "Do you want to save it?",
                text: "Please check all information before submitting!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Save",
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
                        url: "modules/ManageUser/AddUser/Verify.php",
                        data: 
                        {
                            brgycode: brgycode,
                            firstname: firstname,
                            lastname: lastname,
                            type: "VERIFYACCOUNT"
                        },
                        success: function(result)
                        {
                            if(result == "RecordDuplicate")
                            {
                                Swal.fire(
                                {
                                    title: "Error!",
                                    text: "The specified record already exists.",
                                    icon: "error",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then(function(isConfirm)
                                {
                                    
                                });
                            }
                            
                            if(result == "RecordNotFound")
                            {
                                
                                $.ajax(
                                {
                                    type: "POST",
                                    url: "modules/ManageUser/AddUser/Insert.php",
                                    data: 
                                    {
                                        brgycode: brgycode,
                                        firstname: firstname,
                                        middlename: middlename,
                                        lastname: lastname,
                                        suffixname: suffixname,
                                        gender: gender,
                                        email: email,
                                        mobile: mobile,
                                        position: position,
                                        address: address,
                                        type: "ADDACCOUNT"
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
                                                text: "New account has been saved successfully.",
                                                icon: "success",
                                            }).then(function(isConfirm)
                                            {
                                                location.reload();
                                            });
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
	});
</script>