<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#tblActivityLog").DataTable(
        {
            "processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/ActivityLog/GetData.php",
                type: "POST",
                data: 
                {
                    type: "SETACTIVITYLOGDATA"
                }
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3,4],
                orderable: false
            }]
        });
        
        $(document).on("click", ".isBtnDownload", function()
		{
			let id = $(this).attr("id");
            
            window.open("/Kasangguni/activity-log-download?id="+id);
		});
	});
</script>