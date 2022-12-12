<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#tblPendingOrdinance").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/AOrdinance/Pending/GetData.php",
                type: "POST",
				data: 
				{
					type: "GETALLPENDINGORDINANCE"
				}
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3,4,5],
                orderable: false
            }]
        });
        
        $(document).on("click", ".isBtnApproved", function()
		{
			let id = $(this).attr("id").split(",");
            let brgycode = id[0];
            let ordinancecode = id[1];
            
            Swal.fire(
            {
                title: "Approve Ordinance?",
                text: "Are you sure do you want to approve this ordinance?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Approve",
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
                        url: "modules/AOrdinance/Pending/Insert.php",
                        data: 
                        {
                            brgycode: brgycode,
                            ordinancecode: ordinancecode,
                            type: "APPROVEDORDINANCEINFO"
                        },
                        success: function(result)
                        {
                            console.log(result);
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
                                    text: "Ordinance has been approved successfully.",
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
        
        $(document).on("click", ".isBtnRevision", function()
		{
			let id = $(this).attr("id").split(",");
            let brgycode = id[0];
            let ordinancecode = id[1];
            
            Swal.fire(
            {
                title: "Revise Ordinance?",
                text: "Are you sure do you want to revise this ordinance?",
                input: "textarea",
				inputPlaceholder: "Type your reasons here...",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm",
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
                        url: "modules/AOrdinance/Pending/Insert.php",
                        data: 
                        {
                            brgycode: brgycode,
                            ordinancecode: ordinancecode,
                            reason: result.value,
                            type: "REVISEDORDINANCEINFO"
                        },
                        success: function(result)
                        {
                            console.log(result);
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
                                    text: "The ordinance was successfully returned to the barangay to do the remarks.",
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
        
        $(document).on("click", ".isBtnRejected", function()
		{
			let id = $(this).attr("id").split(",");
            let brgycode = id[0];
            let ordinancecode = id[1];
            
            Swal.fire(
            {
                title: "Disapprove Ordinance?",
                text: "Are you sure do you want to disapprove this ordinance?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Disapprove",
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
                        url: "modules/AOrdinance/Pending/Insert.php",
                        data: 
                        {
                            brgycode: brgycode,
                            ordinancecode: ordinancecode,
                            type: "REJECTEDORDINANCEINFO"
                        },
                        success: function(result)
                        {
                            console.log(result);
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
                                    text: "Ordinance has been disapproved.",
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