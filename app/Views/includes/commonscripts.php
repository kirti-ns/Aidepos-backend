<script type="text/javascript">
	function xlsxExport(data,heading,fileName,sheetName)
	{
		var ws = XLSX.utils.json_to_sheet(data, { origin: 'A2', skipHeader: true });
	    XLSX.utils.sheet_add_aoa(ws, heading, { origin: 'A1' });
	    var wb = XLSX.utils.book_new();
	    XLSX.utils.book_append_sheet(wb, ws, sheetName);
	    XLSX.writeFile(wb,fileName);
	}
	function csvExport(data,heading,fileName)
	{
		// header row
		// let head = Object.keys(data[0]).join(',') + '\n';
		let head = Object.values(heading).join(',') + '\n';
      	let body = data.map(row => Object.values(row).join(',')).join('\n');

      	var e = document.createElement('a');
      	e.href = 'data:text/csv;charset=utf-8,' + encodeURI(head + body);
      	e.target = '_blank';
      	e.download = fileName;
      	e.click();
	}
	function pdfExport(url)
	{
      	var blob = new Blob([response], {type: 'application/pdf'})
  		var url = URL.createObjectURL(blob);
  		location.assign(url);
	}
</script>