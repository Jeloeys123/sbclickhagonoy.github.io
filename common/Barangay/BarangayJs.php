<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
		$("#tblManageBarangay").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/Barangay/GetData.php",
                type: "POST",
				data: 
				{
					type: "SETBARANGAYDATA"
				}
            },
            columnDefs: 
            [{
                targets: [0,1,2,3],
                orderable: false
            }]
        });
	});
    
    function isBtnDownload()
    {
        window.open("/Kasangguni/manage-barangay-download?type=pdf");
    }
</script>