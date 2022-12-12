<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#tblBarangayOfficials").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/BarangayOfficials/GetData.php",
                type: "POST",
				data: 
				{
					type: "GETBARANGAYOFFICIALS"
				}
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3,4],
                orderable: false
            }]
        });
        
        $(document).on("click", ".isBtnUpdate", function()
		{
			let id = $(this).attr("id").split(",");
            let fname = id[0];
            let lname = id[1];
            let poscode = id[2];
            
            window.location.assign("/Kasangguni/barangay-officials-update?fname="+btoa(fname)+"&lname="+btoa(lname)+"&posid="+btoa(poscode));
		});
        
        $(document).on("click", ".isBtnDelete", function()
		{
			let id = $(this).attr("id").split(",");
            let fname = id[0];
            let lname = id[1];
            let poscode = id[2];
            
            Swal.fire(
            {
                title: "Delete?",
                text: "Are you sure want to delete this announcement? You won't be able to vert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete",
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
                        url: "modules/BarangayOfficials/Insert.php",
                        data: 
                        {
                            fname: fname,
                            lname: lname,
                            poscode: poscode,
                            type: "DELETEBARANGAYOFFICIAL"
                        },
                        success: function(result)
                        {
                            if(result == "RecordDeleted")
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
                                    text: "Barangay Official record has been successfully deleted.",
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
        
        $("#fCreateBarangayOfficials").submit(function(event) 
        {
            event.preventDefault(); 
            let firstname = $("#txtFirstname").val().trim();
            let middlename = $("#txtMiddlename").val().trim();
            let lastname = $("#txtLastname").val().trim();
            let suffixname = $("#txtSuffixname").val().trim();
            let position = $("#cboPosition").val();
            let email = $("#txtEmail").val().trim();
            let mobile = $("#txtMobileNumber").val().trim();
            
            Swal.fire(
            {
                title: "Confirmation?",
                text: "Do you want to save it? Please check information before submitting.",
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
                        url: "modules/BarangayOfficials/Verify.php",
                        data: 
                        {
                            firstname: firstname,
                            lastname: lastname,
                            type: "VERIFYBARANGAYOFFICIALDATA"
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
                                    url: "modules/BarangayOfficials/Insert.php",
                                    data: 
                                    {
                                        firstname: firstname,
                                        middlename: middlename,
                                        lastname: lastname,
                                        suffixname: suffixname,
                                        position: position,
                                        email: email,
                                        mobile: mobile,
                                        type: "CREATEBARANGAYOFFICIAL"
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
                                                text: "New barangay official data has been successfully saved.",
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
        
        $("#fUpdateBarangayOfficials").submit(function(event) 
        {
            event.preventDefault(); 
            let fname = $("#txtFirstnameVal").val().trim();
            let lname = $("#txtLastnameVal").val().trim();
            let poscode = $("#txtPositionVal").val().trim();
            let firstname = $("#txtFirstname").val().trim();
            let middlename = $("#txtMiddlename").val().trim();
            let lastname = $("#txtLastname").val().trim();
            let suffixname = $("#txtSuffixname").val().trim();
            let email = $("#txtEmail").val().trim();
            let mobile = $("#txtMobileNumber").val().trim();
            
            Swal.fire(
            {
                title: "Confirmation?",
                text: "Do you want to save the changes for this announcement? If you don't save, your changes will be lost.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
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
                        url: "modules/BarangayOfficials/Insert.php",
                        data: 
                        {
                            fname: fname,
                            lname: lname,
                            poscode: poscode,
                            firstname: firstname,
                            middlename: middlename,
                            lastname: lastname,
                            suffixname: suffixname,
                            email: email,
                            mobile: mobile,
                            type: "UPDATEBARANGAYOFFICIAL"
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
                                    text: "Record of "+ firstname + " " + lastname + " has been successfully changed.",
                                    icon: "success",
                                }).then(function(isConfirm)
                                {
                                    window.location.assign("/Kasangguni/barangay-officials-main");
                                });
                            }
                        }
                    });
                }
            });
        });
	});
    
    function isBtnDownload()
    {
        window.open("/Kasangguni/barangay-officials-download?type=pdf");
    }
    
    function isBtnBack()
    {
        window.location.assign("/Kasangguni/barangay-officials-main");
    }
</script>