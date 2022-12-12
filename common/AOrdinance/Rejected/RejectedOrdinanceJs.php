<?php include $_SERVER["DOCUMENT_ROOT"]."/Kasangguni/common/paths.php"; ?>
<script type = "text/javascript">
    $(document).ready(function()
	{
        $("#tblRejectedOrdinance").DataTable(
        {
			"processing": true,
            "serverSide": true,
            "ajax":
            {
                url: "modules/AOrdinance/Rejected/GetData.php",
                type: "POST",
				data: 
				{
					type: "GETALLREJECTEDORDINANCE"
				}
            },
            destroy: true,
            columnDefs: 
            [{
                targets: [0,1,2,3,4,5],
                orderable: false
            }]
        });
	});
</script>