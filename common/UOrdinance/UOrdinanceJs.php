<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#tblOrdinance").DataTable(
        {
            "processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/UOrdinance/GetData.php",
                type: "POST",
                data: 
                {
                    type: "SETORDINANCEDATE"
                }
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3,4,5],
                orderable: false
            }]
        });
        
        $(document).on("click", ".isBtnEdit", function()
		{
			let id = $(this).attr("id");
            
            window.location.assign("/Kasangguni/barangay-ordinance-update?id="+btoa(id));
		});
        
        $(document).on("click", ".isBtnDownload", function()
		{
			let id = $(this).attr("id");
            
            window.open("/Kasangguni/barangay-ordinance-download?id="+id);
		});
        
        $("#fCreateOrdinance").submit(function(event) 
        {
            event.preventDefault(); 
            let fd = new FormData();
            let ordinanceyear = $("#txtOrdinanceYear").val().trim();
            let ordinancecode = $("#txtOrdinanceCode").val().trim();
            let ordinancetitle = $("#txtOrdinanceTitle").val().trim();
            let submitteddate = $("#txtSubmitteddate").val();
            let files = $("#file")[0].files;
            let ordinancedescription = $("#txtDescription").val().trim();
            
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
                    fd.append("file",files[0]);
                        
                    $.ajax(
                    {
                        url: "modules/UOrdinance/Upload.php",
                        type: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(result)
                        {
                            if(result != 0)
                            {
                                let fileinput = result.split("/");
                                
                                $.ajax(
                                {
                                    type: "POST",
                                    url: "modules/UOrdinance/Insert.php",
                                    data: 
                                    {
                                        ordinanceyear: ordinanceyear,
                                        ordinancecode: ordinancecode,
                                        ordinancetitle: ordinancetitle,
                                        ordinancedescription: ordinancedescription,
                                        submitteddate: submitteddate,
                                        fileinput: fileinput[3],
                                        type: "CREATEORDINANCE"
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
                                                title: "Success.",
                                                text: "New ordinance has been successfully uploaded.",
                                                icon: "success",
                                            }).then(function(isConfirm)
                                            {
                                                window.location.assign("/Kasangguni/barangay-ordinance-main");
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
        
        $("#fUpdateOrdinance").submit(function(event) 
        {
            event.preventDefault(); 
            let fd = new FormData();
            let ordinancecode = $("#txtOrdinanceCode").val().trim();
            let files = $("#file")[0].files;
            let ordinancedescription = $("#txtDescription").val().trim();
            
            Swal.fire(
            {
                title: "Confirmation?",
                text: "Do you want to save the changes for this ordinance? If you don't save, your changes will be lost.",
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
                    fd.append("file",files[0]);
                        
                    $.ajax(
                    {
                        url: "modules/UOrdinance/Upload.php",
                        type: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(result)
                        {
                            if(result != 0)
                            {
                                let fileinput = result.split("/");
                                
                                $.ajax(
                                {
                                    type: "POST",
                                    url: "modules/UOrdinance/Insert.php",
                                    data: 
                                    {
                                        ordinancecode: ordinancecode,
                                        ordinancedescription: ordinancedescription,
                                        fileinput: fileinput[3],
                                        type: "UPDATEORDINANCE"
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
                                                title: "Success.",
                                                text: "Ordinance record has been successfully changed.",
                                                icon: "success",
                                            }).then(function(isConfirm)
                                            {
                                                window.location.assign("/Kasangguni/barangay-ordinance-main");
                                            });
                                        }
                                    }
                                });
                            }
                            else
                            {
                                $.ajax(
                                {
                                    type: "POST",
                                    url: "modules/UOrdinance/Insert.php",
                                    data: 
                                    {
                                        ordinancecode: ordinancecode,
                                        ordinancedescription: ordinancedescription,
                                        fileinput: "",
                                        type: "UPDATEORDINANCE"
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
                                                title: "Success.",
                                                text: "Ordinance record has been successfully changed.",
                                                icon: "success",
                                            }).then(function(isConfirm)
                                            {
                                                window.location.assign("/Kasangguni/barangay-ordinance-main");
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
    
    function isBtnUpload()
    {
        window.location.assign("/Kasangguni/barangay-ordinance-create");
    }
    
    function showOrdinanceNumber()
    {
        $.ajax(
        {
            type: "POST",
            url: "modules/UOrdinance/Verify.php",
            data: 
            {
                type: "SETORDINANCENUMBER"
            },
            dataType: "JSON",
            success: function(result)
            {
                for(let num in result)
				{
                    $("#txtOrdinanceYear").val(result[num].ORDINANCEYEAR);
                    $("#txtOrdinanceCode").val(result[num].ORDINANCENUMBER.toUpperCase());
                    $("#txtOrdinanceTitle").val(result[num].ORDINANCETITLE);
                }
            }
        });
    }
    
    function showOrdinance()
    {
        let ordinancecode = $("#txtOrdinanceCode").val().trim();
        
        $.ajax(
        {
            type: "POST",
            url: "modules/UOrdinance/Verify.php",
            data: 
            {
                ordinancecode: ordinancecode,
                type: "GETUPDATEORDINANCEINFO"
            },
            dataType: "JSON",
            success: function(result)
            {
                let submitteddate = "";
                
                for(let num in result)
                {
                    submitteddate = new Date(result[num].SUBMITTEDDATE);
                    $("#txtOrdinanceTitle").val(result[num].TITLE);
                    $("#txtSubmitteddate").val(((submitteddate.getMonth() > 8) ? (submitteddate.getMonth() + 1) : ('0' + (submitteddate.getMonth() + 1))) + '/' + ((submitteddate.getDate() > 9) ? submitteddate.getDate() : ('0' + submitteddate.getDate())) + '/' + submitteddate.getFullYear());
                    $("#txtDescription").val(result[num].DESCRIPTION);
                }
            }
        });
    }
    
    function isBtnBack()
    {
        window.location.assign("/Kasangguni/barangay-ordinance-main");
    }
</script>