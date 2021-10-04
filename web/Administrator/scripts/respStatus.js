function statusChartShow(status,totals)
{
	var ctx = document.getElementById('statusChart').getContext('2d');
	var chart = new Chart(ctx, 
	{
		type: 'bar',
		data:
		{
			labels: status,
			datasets: [{
				label: 'Status codes',
				backgroundColor: '#ff4d4d',
				borderColor: '#ff4d4d',
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
		url: "scripts/respStatus.php",
		type: "GET",
		dataType: "json",
		success: function(resp)
		{
			var resp_status = resp[0];
			var status_totals = resp[1];
			statusChartShow(resp_status,status_totals);
		}
	});
}