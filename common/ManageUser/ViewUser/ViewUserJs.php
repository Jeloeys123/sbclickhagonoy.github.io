<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
		$("#tblViewUser").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/ManageUser/ViewUser/GetData.php",
                type: "POST",
				data: 
				{
					type: "GETALLACCOUNT"
				}
            },
            columnDefs: 
            [{
                targets: [0,1,2,3,4,5],
                orderable: false
            }]
        });
	});
</script>