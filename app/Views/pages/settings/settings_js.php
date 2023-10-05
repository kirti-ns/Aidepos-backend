<script type="text/javascript">
	function setCurrData(val) {
		var currency = '<?php echo isset($data['currency_master_data'])?$data['currency_master_data']:""; ?>';
	    var data = JSON.parse(currency);

	    var getCurrData = data[val];
	    $("#currency_symbol").val(getCurrData.currency_symbol);
	    $("#currency_name").val(getCurrData.currency_name);
	    $("#format").val(getCurrData.currency_format);
	    $("#format").attr("data-val",getCurrData.currency_format);
	    $("#decimal_places").val("2")
	}

	$(document).on('change','#currency_code',function() {
		var val = $(this).val();
		setCurrData(val);
	});

	$(document).on('change','#decimal_places',function(){
		var num = Number($("#format").attr('data-val'));
		var decimal = Number($(this).val());

		const options = { 
		  minimumFractionDigits: decimal,
		  maximumFractionDigits: decimal 
		};
		const formatted = num.toLocaleString('en', options);
		$("#format").val(formatted)
	});

  	$('#currency_code').select2();
</script>