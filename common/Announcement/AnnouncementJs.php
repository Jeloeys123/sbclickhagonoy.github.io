<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#cboBarangay").select2(
        {
            tags: true,
            tokenSeparators: [',', ' ']
        });
        
        $("#tblAnnouncement").DataTable(
        {
            "processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/Announcement/GetData.php",
                type: "POST",
                data: 
                {
                    type: "SETANNOUNCEMENTDATA"
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
            
            window.location.assign("/Kasangguni/announcement-update?id="+btoa(id));
        });
        
        $(document).on("click", ".isBtnDelete", function()
		{
			let id = $(this).attr("id");
            
            Swal.fire(
            {
                title: "Delete?",
                text: "Are you sure want to delete this announcement? You won't be able to vert this!",
                input: "textarea",
				inputPlaceholder: "Type your reasons here...",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete",
                cancelButtonColor: "#d33",
                allowOutsideClick: false,
                allowEscapeKey: false,
                preConfirm: (reason) => 
				{
					if (!reason) 
					{
						Swal.showValidationMessage("Please input your reasons. Thank you!");
					}
				}
            }).then((result) => 
            {
                if (result.isConfirmed)
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: "modules/Announcement/Insert.php",
                        data: 
                        {
                            announcementcode: id,
                            reason: result.value,
                            type: "DELETEANNOUNCEMENT"
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
                                    title: "Success.",
                                    text: "Announcement record has been successfully deleted.",
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
        
        $(document).on("click", ".isBtnDownload", function()
		{
			let id = $(this).attr("id");
            
            window.open("/Kasangguni/announcement-download?id="+id);
		});
        
        $("#fCreateAnnouncement").submit(function(event) 
        {
            event.preventDefault(); 
            let fd = new FormData();
            let barangay =  $("#cboBarangay").select2("data");
            let files = $("#file")[0].files;
            let title = $("#txtTitle").val().trim();
            let startdate = $("#txtStartdate").val();
            let enddate = $("#txtEnddate").val();
            let content = $("#txtContent").val().trim();
            let id = [];
            
            for (let i = 0; i <= barangay.length-1; i++)
            {
                id[i] = barangay[i].id;
            }
            
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
                    if(startdate >= enddate)
                    {
                        Swal.fire(
                        {
                            title: "Error!",
                            text: "\"To Date\" cannot be smaller than \"From Date\".",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(function(isConfirm)
                        {
                            
                        });
                    }
                    else
                    {
                        fd.append("file",files[0]);
                        
                        $.ajax(
                        {
                            url: "modules/Announcement/Upload.php",
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
                                        url: "modules/Announcement/Insert.php",
                                        data: 
                                        {
                                            id: id,
                                            title: title,
                                            startdate: startdate,
                                            enddate: enddate,
                                            content: content,
                                            fileinput: fileinput[3],
                                            type: "CREATEANNOUNCEMENT"
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
                                                    text: "New announcement has been successfully saved.",
                                                    icon: "success",
                                                }).then(function(isConfirm)
                                                {
                                                    window.location.assign("/Kasangguni/announcement-main");
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
                                        url: "modules/Announcement/Insert.php",
                                        data: 
                                        {
                                            id: id,
                                            title: title,
                                            startdate: startdate,
                                            enddate: enddate,
                                            content: content,
                                            fileinput: "",
                                            type: "CREATEANNOUNCEMENT"
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
                                                    text: "New announcement has been successfully saved.",
                                                    icon: "success",
                                                }).then(function(isConfirm)
                                                {
                                                    window.location.assign("/Kasangguni/announcement-main");
                                                });
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        });
        
        $("#fUpdateAnnouncement").submit(function(event) 
        {
            event.preventDefault(); 
            let fd = new FormData();
            let announcementcode = $("#txtAnnouncementcode").val().trim();
            let barangay =  $("#cboBarangay").select2("data");
            let files = $("#file")[0].files;
            let title = $("#txtTitle").val().trim();
            let startdate = $("#txtStartdate").val();
            let enddate = $("#txtEnddate").val();
            let content = $("#txtContent").val().trim();
            let id = [];
            
            for (let i = 0; i <= barangay.length-1; i++)
            {
                id[i] = barangay[i].id;
            }
            
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
                    if(startdate >= enddate)
                    {
                        Swal.fire(
                        {
                            title: "Error!",
                            text: "\"To Date\" cannot be smaller than \"From Date\".",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(function(isConfirm)
                        {
                            
                        });
                    }
                    else
                    {
                        fd.append("file",files[0]);
                        
                        $.ajax(
                        {
                            url: "modules/Announcement/Upload.php",
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
                                        url: "modules/Announcement/Insert.php",
                                        data: 
                                        {
                                            announcementcode: announcementcode,
                                            id: id,
                                            title: title,
                                            startdate: startdate,
                                            enddate: enddate,
                                            content: content,
                                            fileinput: fileinput[3],
                                            type: "UPDATEANNOUNCEMENT"
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
                                                    text: "Announcement record has been successfully changed.",
                                                    icon: "success",
                                                }).then(function(isConfirm)
                                                {
                                                    window.location.assign("/Kasangguni/announcement-main");
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
                                        url: "modules/Announcement/Insert.php",
                                        data: 
                                        {
                                            announcementcode: announcementcode,
                                            id: id,
                                            title: title,
                                            startdate: startdate,
                                            enddate: enddate,
                                            content: content,
                                            fileinput: "",
                                            type: "UPDATEANNOUNCEMENT"
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
                                                    text: "Announcement record has been successfully changed.",
                                                    icon: "success",
                                                }).then(function(isConfirm)
                                                {
                                                    window.location.assign("/Kasangguni/announcement-main");
                                                });
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        });
	});
    
    function showAnnouncement()
    {
        let announcementcode = $("#txtAnnouncementcode").val().trim();
        
        $.ajax(
        {
            type: "POST",
            url: "modules/Announcement/Verify.php",
            data: 
            {
                announcementcode: announcementcode,
                type: "GETUPDATEANNOUNCEMENTINFO"
            },
            dataType: "JSON",
            success: function(result)
            {
                let barangay = [];
                let startdate = "";
                let enddate = "";
                
                for(let num in result)
                {
                    barangay.push(result[num].BARANGAY);
                    startdate = new Date(result[num].STARTDATE);
                    enddate = new Date(result[num].ENDDATE);
                    $("#txtTitle").val(result[num].TITLE);
                    $("#txtStartdate").val(((startdate.getMonth() > 8) ? (startdate.getMonth() + 1) : ('0' + (startdate.getMonth() + 1))) + '/' + ((startdate.getDate() > 9) ? startdate.getDate() : ('0' + startdate.getDate())) + '/' + startdate.getFullYear());
                    $("#txtEnddate").val(((enddate.getMonth() > 8) ? (enddate.getMonth() + 1) : ('0' + (enddate.getMonth() + 1))) + '/' + ((enddate.getDate() > 9) ? enddate.getDate() : ('0' + enddate.getDate())) + '/' + enddate.getFullYear());
                    $("#txtContent").val(result[num].CONTENT);
                }
                
                $("#cboBarangay").val(barangay).trigger("change");
            }
        });
    }
    
    function isBtnCreate()
    {
        window.location.assign("/Kasangguni/announcement-create");
    }
    
    function isBtnBack()
    {
        window.location.assign("/Kasangguni/announcement-main");
    }
</script>