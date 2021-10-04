function MethodsChartShow(methods,totals)
{
	var ctx = document.getElementById('methodChart').getContext('2d');
	var chart = new Chart(ctx, {
		type: 'bar',
		data: 
		{
			labels: methods,
			datasets: [{
				label: 'Request Methods',
				backgroundColor: '#3399FF',
				borderColor: '#3399FF',
				data: totals
			}]
		},
		options: 
		{
			scales: 
			{
				yAxes: [{
					ticks: 
					{
						beginAtZero: true//,
						//stepSize: 50
					}
				}]
			}
		}
	});
}
if ($('#methodChart').length)
{
	$.ajax({
		url: "scripts/reqMethods.php",
		type: "GET",
		dataType: "json",
		success: function(resp)
		{
			var req_methods = resp[0];
			var totals = resp[1];
			MethodsChartShow(req_methods,totals);
		}
	});
}