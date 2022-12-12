<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#tblDemographicData").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/DemographicProfile/GetData.php",
                type: "POST",
				data: 
				{
					type: "SETDEMOGRAPHICDATA"
				}
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3,4],
                orderable: false
            }]
        });
        
        $(document).on("click", ".isBtnEdit", function()
		{
			let id = $(this).attr("id");
            
            window.location.assign("/Kasangguni/demographic-profile-update?id="+btoa(id));
		});
        
        $(document).on("click", ".isBtnDelete", function()
		{
			let id = $(this).attr("id");
            
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
                        url: "modules/DemographicProfile/Insert.php",
                        data: 
                        {
                            censusyear: id,
                            type: "DELETEDEMOGRPAHIC"
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
                                    text: "Demographic record for the year "+ id +" has been successfully deleted.",
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
        
        $("#tblUpdateDemographicData").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/DemographicProfile/GetData.php",
                type: "POST",
				data: 
				{
					type: "SETUPDATEDDEMOGRAPHICDATA"
				}
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3],
                orderable: false
            }]
        });
        
        $("#fCreateDemographicData").submit(function(event) 
        {
            event.preventDefault(); 
            let censusyear = $("#cboYear").val();
            let housepopulation = $("#txtHousePopulation").val().trim();
            let noofhouseholds = $("#txtNumberHouseholds").val().trim();
            let avghousehold = $("#txtAverageHousehold").val().trim();
            
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
                        url: "modules/DemographicProfile/Verify.php",
                        data: 
                        {
                            censusyear: censusyear,
                            type: "VERIFYDEMOGRAPHICDATA"
                        },
                        success: function(result)
                        {
                            if(result == "RecordDuplicate")
                            {
                                Swal.fire(
                                {
                                    title: "Error!",
                                    text: "You're creating a duplicate record. We recommend you to use an existing record instead. Thank you!",
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
                                    url: "modules/DemographicProfile/Insert.php",
                                    data: 
                                    {
                                        censusyear: censusyear,
                                        housepopulation: housepopulation,
                                        noofhouseholds: noofhouseholds,
                                        avghousehold: avghousehold,
                                        type: "CREATEDEMOGRAPHIC"
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
                                                text: "New demographic data has been successfully saved.",
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
        
        $("#fUpdateDemographicData").submit(function(event) 
        {
            event.preventDefault(); 
            let censusyear = $("#txtCensusYear").val().trim();
            let housepopulation = $("#txtHousePopulation").val().trim();
            let noofhouseholds = $("#txtNumberHouseholds").val().trim();
            let avghousehold = $("#txtAverageHousehold").val().trim();
            
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
                        url: "modules/DemographicProfile/Insert.php",
                        data: 
                        {
                            censusyear: censusyear,
                            housepopulation: housepopulation,
                            noofhouseholds: noofhouseholds,
                            avghousehold: avghousehold,
                            type: "UPDATEDEMOGRAPHIC"
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
                                    text: "Demographic record has been successfully changed.",
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
    
    function isBtnDownload()
    {
        window.open("/Kasangguni/demographic-profile-download?type=pdf");
    }
    
    function isOnkeyupHousePopulation(housepopulation)
    {
        let noofhouseholds = $("#txtNumberHouseholds").val();
        let avghousehold = 0.00;
        
        if(housepopulation == "" || housepopulation <= 0)
        {
            housepopulation = 0;
        }
        
        avghousehold = parseFloat(housepopulation) / parseFloat(noofhouseholds);
        
        if(avghousehold == "Infinity")
        {
            $("#txtAverageHousehold").val("0.00");
        }
        else
        {
            $("#txtAverageHousehold").val(avghousehold.toFixed(2));
        }
    }
    
    function isOnkeyupNumberHouseholds(noofhouseholds)
    {
        let housepopulation = $("#txtHousePopulation").val();
        let avghousehold = 0.00;
        
        if(noofhouseholds == "" || noofhouseholds <= 0)
        {
            noofhouseholds = 0;
        }
        
        avghousehold = parseFloat(housepopulation) / parseFloat(noofhouseholds);
        
        if(avghousehold == "Infinity")
        {
            $("#txtAverageHousehold").val("0.00");
        }
        else
        {
            $("#txtAverageHousehold").val(avghousehold.toFixed(2));
        }
    }
    
    function isBtnBack()
    {
        window.location.assign("/Kasangguni/demographic-profile-main");
    }
</script>