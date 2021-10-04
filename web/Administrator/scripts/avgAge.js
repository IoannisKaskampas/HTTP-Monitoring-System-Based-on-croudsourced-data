function ageChartShow(type,avg)
{
	var ctx = document.getElementById('avgAgeChart').getContext('2d');
	var chart = new Chart(ctx, 
	{
		type: 'bar',
		data:
		{
			labels: type,
			datasets: [{
				label: 'Average age',
				backgroundColor: '#3399FF',
				borderColor: '#3399FF',
				data: avg
			}]
		},
		options: 
		{
			scales: 
			{
				yAxes: [{
					ticks: 
					{
						beginAtZero: true,
					}
				}]
			}
		}
	});
}

if ($('#avgAgeChart').length)
{
	$.ajax({
		url: "scripts/avgAge.php",
		type: "GET",
		dataType: "json",
		success: function(resp)
		{
			var avg_age = resp[0];
			var content_type = resp[1];
			ageChartShow(content_type,avg_age);
		}
	});
}