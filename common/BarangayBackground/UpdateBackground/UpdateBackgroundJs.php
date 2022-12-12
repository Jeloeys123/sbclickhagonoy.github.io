<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#btnUpload").click(function()
		{
            let fd = new FormData();
			let files = $("#file")[0].files;
            
            if(files.length > 0 )
            {
                fd.append("file",files[0]);
                
                $.ajax(
                {
                    url: "modules/BarangayBackground/UpdateBackground/Upload.php",
                    type: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(result)
                    {
                        if(result != 0)
                        {
                            let uploadfile = result.split("/");
                            $("#txtBarangayProfile").attr("src",result); 
                            $(".preview img").show();
                            $("#txtBarangayPicture").val(uploadfile[3]); 
                        }
                        else
                        {
                            Swal.fire(
                            {
                                title: "There was a problem!",
                                text: "File not uploaded.",
                                icon: "error",
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(function(isConfirm)
                            {
                                
                            });
                        }
                    },
                });
            }
            else
            {
                Swal.fire(
                {
                    title: "There was a problem!",
                    text: "Please select a file.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(function(isConfirm)
                {
                    
                });
            }
		});
        
        $("#fBarangayBackground").submit(function(event) 
        {
            event.preventDefault(); 
            let brgycode = $("#txtBarangaycode").val().trim();
            let profile = $("#txtBarangayPicture").val().trim();
            let email = $("#txtEmail").val().trim();
            let mobile = $("#txtMobileNumber").val().trim();
            let telephone = $("#txtTelephoneNumber").val().trim();
            let facebook = $("#txtFacebook").val().trim();
            let bio = $("#txtBarangayBackground").val().trim();
            
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
                        url: "modules/BarangayBackground/UpdateBackground/Insert.php",
                        data: 
                        {
                            brgycode: brgycode,
                            profile: profile,
                            email: email,
                            mobile: mobile,
                            telephone: telephone,
                            facebook: facebook,
                            bio: bio,
                            type: "UPDATEBARANGAYPROFILE"
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
                                    text: "Barangay record has been changed successfully.",
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
</script>