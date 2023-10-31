<!DOCTYPE html>
<html>
<head>
	<title>Send Invoice</title>
</head>
<body>
	<p>Dear <?= $customer_name; ?>,</p>
	<br/>
	
	<p>Please find the attched pdf for Invoice No. INV-000<?= $id; ?></p>
	<br/>
	
	<p>Feel free to contact us for any query.</p>
	<br/>

	<p>Regards,<br/>
	<?= $owner_name; ?><br/>
	<?= $store_name; ?>.</p>
</body>
</html>