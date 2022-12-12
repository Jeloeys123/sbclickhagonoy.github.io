<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
		$(document).on("click", ".isBtnBarangay", function()
		{
			let id = $(this).attr("id");
            
            window.location.assign("/Kasangguni/main-profile?id="+btoa(id));
		});
        
        $(document).on("click", ".isBtnNotif", function()
		{
			let id = $(this).attr("id");
            
            $.ajax(
            {
                type: "POST",
                url: "modules/Main/Insert.php",
                data: 
                {
                    id: id,
                    type: "UPDATENOTIFICATION"
                },
                success: function(result)
                {
                    let data = result.split(",");
                    
                    if(data[0] == "A")
                    {
                        window.location.assign("/Kasangguni/announcement-display?id="+btoa(data[1]));
                    }
                }
            });
		});
        
        <?php
            if(isset($brgycode))
            {
        ?>
                $("#tblBarangayOfficials").DataTable(
                {
                    "processing": true,
                    "serverSide": true,
					dom: "rti",
                    "ajax":
                    {
                        url: "modules/Main/GetData.php?id=<?php echo $brgycode ?>",
                        type: "POST",
                        data: 
                        {
                            type: "SETBARANGAYOFFICIALDATA"
                        }
                    },
                    destroy: true,
                    columnDefs: 
                    [{
                        targets: [0,1,],
                        orderable: false
                    }]
                });
                
                $("#tblDemographicData").DataTable(
                {
                    "processing": true,
                    "serverSide": true,
                    "ajax":
                    {
                        url: "modules/Main/GetData.php?id=<?php echo $brgycode ?>",
                        type: "POST",
                        data: 
                        {
                            type: "GETDEMOGRAPHICDATA"
                        }
                    },
                    destroy: true,
                    columnDefs: 
                    [{
                        targets: [0,1,2,3],
                        orderable: false
                    }]
                });
        <?php
            }
        ?>
	});
    
    <?php
        if(isset($brgycode))
        {
    ?>
            function showGraph()
            {
                $.ajax(
                {
                    type: "POST",
                    url: "modules/Main/Verify.php?id=<?php echo $brgycode ?>",
                    data: 
                    {
                        type: "SHOWGRAPH"
                    },
                    success: function(result)
                    {
                        let x = JSON.parse(result);
                        for(let num in x)
                        {
                            let demographchart = $("#chartHousehold");
                            let demographic = new Chart(demographchart, 
                            {
                                type: "bar",
                                data: 
                                {
                                    labels: x[num].HOUSEHOLDPOPULATIONYEAR,
                                    datasets: 
                                    [{
                                        label: "Household Population",
                                        backgroundColor: "#4e73df",
                                        hoverBackgroundColor: "#2e59d9",
                                        borderColor: "#4e73df",
                                        data: x[num].HOUSEHOLDPOPULATIONDATA
                                    },
                                    {
                                        label: "Number of Households",
                                        backgroundColor: "#70df4e",
                                        hoverBackgroundColor: "#72d92e",
                                        borderColor: "#70df4e",
                                        data: x[num].NUMOFHOUSEHOLDDATA,
                                    }],
                                },
                                options: 
                                {
                                    maintainAspectRatio: false,
                                    layout: 
                                    {
                                        padding: 
                                        {
                                            left: 10,
                                            right: 25,
                                            top: 25,
                                            bottom: 0
                                        }
                                    },
                                    scales: 
                                    {
                                        dataset: 
                                        [{
                                            time: 
                                            {
                                                unit: "year"
                                            },
                                            gridLines: 
                                            {
                                                display: false,
                                                drawBorder: false
                                            },
                                            ticks: 
                                            {
                                                maxTicksLimit: 12
                                            },
                                            maxBarThickness: 25,
                                        }],
                                        yAxes: 
                                        [{
                                            ticks: 
                                            {
                                                min: 0,
                                                maxTicksLimit: 10,
                                                padding: 5
                                            },
                                            gridLines: 
                                            {
                                                color: "rgb(234, 236, 244)",
                                                zeroLineColor: "rgb(234, 236, 244)",
                                                drawBorder: false,
                                                borderDash: [2],
                                                zeroLineBorderDash: [2]
                                            }
                                        }],
                                    },
                                    legend: 
                                    {
                                        position: "top",
                                        labels: 
                                        {
                                            padding: 10,
                                            boxWidth: 15
                                        }
                                    },
                                    tooltips: 
                                    {
                                        titleMarginBottom: 10,
                                        titleFontColor: '#6e707e',
                                        titleFontSize: 14,
                                        backgroundColor: "rgb(255,255,255)",
                                        bodyFontColor: "#858796",
                                        borderColor: '#dddfeb',
                                        borderWidth: 1,
                                        xPadding: 15,
                                        yPadding: 15,
                                        displayColors: false,
                                        caretPadding: 10,
                                        callbacks: 
                                        {
                                            label: function(tooltipItem, chart) 
                                            {
                                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || "";
                                                return datasetLabel + ": " + tooltipItem.yLabel;
                                            }
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            }
    <?php
        }
    ?>
</script>