$(document).ready(function(){

		// Start Left Side Bar
		$(".sidebarlinks").click(function(){
				$(".sidebarlinks").removeClass("currents");
				$(this).addClass("currents");
		});
		// End Left Side Bar
});

// Start Js Area


// Start Site Setting
const getsitesettings = document.getElementById("sitesettings");
getsitesettings.addEventListener("click",function(){
	document.body.classList.toggle("show-nav");
});
// End Site Setting

// Start Top Sidebar
// start notify & userlogout

// start dropdown
function dropbtn(e){
		console.log(e);

		e.target.parentElement.nextElementSibling.classList.toggle('show');
}
document.getElementById("noticenter").addEventListener("click",function(e){
	e.target.parentElement.nextElementSibling.classList.toggle('show');
});

// end dropdown

// end notify & user logout
// End Top Sidebar

// Start Gauge Area



//  var gaugecus = new JustGage({
// 	id: "gaugecustomers", // the id of the html element
// 	width : 200,
// 	height: 200,
// 	value: 7000000,
// 	min: 0,
// 	max: 9000000,
// 	gaugeWidthScale: 0.6
//  });

 var gaugeemps = new JustGage({
	id: "gaugeemployees", // the id of the html element
	width : 200,
	height: 200,
	value: 80,
	min: 0,
	max: 100,
	gaugeWidthScale: 0.6
 });

 var gaugeinvs = new JustGage({
	id: "gaugeinverters", // the id of the html element
	width : 200,
	height: 200,
	value: 40,
	min: 0,
	max: 50,
	gaugeWidthScale: 0.6
 });


// update the value randomly
// setInterval(() => {
// 	gaugeurs.refresh(Math.random() * 100);
// 	gaugecus.refresh(Math.random() * 100);
// 	gaugeemps.refresh(Math.random() * 100);
// 	gaugeinvs.refresh(Math.random() * 100);
// }, 5000);



// End Guague Area

// 22GG



// End Js Area



// --------------------------------------------------

// let result = Math.min(10,20,5,6,8,2,60,18,7);
// console.log(result);
// let results = Math.max(10,20,5,6,8,2,60,18,7);
// console.log(results);

// Get Min number
// var arrnums = [5,10,15,3,7,8,20,6];
	
// function getminnumber(numbers){
// 	let minnumber = numbers[0];
// 	for(var x=0; x<numbers.length; x++){
// 		// Get Mini Number
// 		if(numbers[x] < minnumber){
// 			minnumber = numbers[x];
// 		}

// 		// Get Mini Number
// 		// if(numbers[x] > minnumber){
// 		// 	minnumber = numbers[x];
// 		// }
// 	}


// 	return minnumber;
// }

// console.log(getminnumber(arrnums));

// var arrnumstwo = [5,10,15,3,7,8,20,6];

// function sortmaxtominnum(numbers){

// 	for(let y=0; y<numbers.length; y++){
// 		// let maxnumber = numbers[0];
// 		// let curidx;

// 		let maxnumber = numbers[y];
// 		let curidx;

// 		// for(let x=0; x<numbers.length; x++){
// 		for(let x=y; x<numbers.length; x++){
// 			// Get Max  Number
// 			if(numbers[x] > maxnumber){
// 				maxnumber = numbers[x];
// 				curidx = x;
// 			}

// 			// Get Min  Number
// 			// if(numbers[x] < maxnumber){
// 			// 	maxnumber = numbers[x];
// 			// 	curidx = x;
// 			// }
// 		}
// 		// return maxnumber; //20

// 		// return [maxnumber,curidx]; //[20,6]

// 		// swap idx6 to idx0
// 		// numbers[curidx] = numbers[0]; //5
// 		// // return [maxnumber,curidx,numbers] // 20 5 [5,10,15,3,7,8,5,6]
// 		// numbers[0] = maxnumber; //20
// 		// return [maxnumber,curidx,numbers]; // 20 5 [20,10,15,3,7,8,5,6]
	
// 		numbers[curidx] = numbers[y];
// 		numbers[y] = maxnumber;
// 	}
// 	return numbers;
	

// }

// console.log(sortmaxtominnum(arrnumstwo));



// ---------------------------------------------
let saledatas = [
	{
		title : "Order Value",
		rank : 80,
		value: "120.8%",
		color : "bg-secondary"
	},
	{
		title : "Total Products",
		rank : 50,
		value: "325.2%",
		color : "bg-success"
	},
	{
		title : "Quantity",
		rank : 70,
		value: "25.60%",
		color : "bg-warning"
	}
];
			
var arrnumstwo = [5,10,15,3,7,8,20,6];

function sortmaxtominnum(numbers){

	for(let y=0; y<numbers.length; y++){
		let maxnumber = numbers[y];
		let curidx;

	
		for(let x=y; x<numbers.length; x++){
			// Get Max  Number
			if(numbers[x] > maxnumber){
				maxnumber = numbers[x];
				curidx = x;
			}

		}

		numbers[curidx] = numbers[y];
		numbers[y] = maxnumber;
	}
	return numbers;
	

}
// console.log(sortmaxtominnum(arrnumstwo));

function showsaledatas(sortdatas){
	let getsalectn = document.getElementById("salecontainer");
	let progress;

	for(let x=0; x<3;x++){
		progress += `
		<div class="mt-2">
			<div class="d-flex justify-content-between">
			<small>Order Value</small>
			<small>120.8%</small>
			</div>
			<div class="progress">
			<div class="progress-bar bg-secondary" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>;
		`;
	}
	

	// getsalectn.innerHTML = progress;
}
showsaledatas();



// Start Footer
	const getyear = document.getElementById("getyear");
	const getfullyear = new Date().getFullYear();
	getyear.textContent = getfullyear;
// End Footer



$(document).ready(function(){
	// Start Lead Chat

	$.ajax({
		url: '/api/leadsdashboard',
		method: 'GET',
		success:function(data){
			// console.log(data)
			const ctx = document.getElementById('leadcharts');
			ctx.height = 250;
			new Chart(ctx, {
				type: 'doughnut',

				data: {
					labels: Object.keys(data.leadsources),
					datasets: [{
						data:  Object.values(data.leadsources),
						backgroundColor: ["green","blue","red"],
						borderWidth:1
					}]
				},
				options: {
					responsive:false
				}
			});

		}
	})
	// End Lead Chat

	// Start Age Chart
	$.ajax({
		url: '/api/studentsdashboard',
		method: 'GET',
		success:function(data){
			// console.log(data)

			// age analysis
			const agectx = document.getElementById('agechart');
			agectx.height = 250;
			new Chart(agectx, {
				type: 'bar',

				data: {
					labels: Object.keys(data.agegroups),
					datasets: [{
						label: 'Age Analysis',
						data:  Object.values(data.agegroups),
						backgroundColor: "steelblue",
						borderWidth:1
					}]
				},
				options: {
					responsive:true,
					scales: {
						y:{
							beginAtZero: true
						}
					}
				}
			});


			// student chart

			$('#studentcount').text(data.totalstudents);
			var gaugeurs = new JustGage({
				id: "studentchart", // the id of the html element
				width : 200,
				height: 200,
				value: data.activestudents,
				min: 0,
				max: data.totalstudents,
				gaugeWidthScale: 0.6
			 });
		}
	})
	// End Age Chart


	// Start Leave Chart
	$.ajax({
		url: '/api/leavesdashboard',
		method: 'GET',
		success:function(data){
			console.log(data);

			const datas = [
				{icon:'fas fa-users',label: "Total Leaves",value:data.totalleaves},
				{icon:'fas fa-check-circle',label: "Approved Leaves",value:data.approved},
				{icon:'fas fa-hourglass-half',label: "Pending Leaves",value:data.pending},
				{icon:'fas fa-times-circle',label: "Rejected Leaves",value:data.rejeted},
		
			];

			let html = '';
			$.each(datas,function(idx,data){
				html += `
				<div class="col-md-3 col-sm-6">
					<div class="card-body">
						<div class="d-flex justify-content-center align-items-center">
							<i class="${data.icon} fa-2x text-primary me-4"></i>
							<div class="text-center">
								<p class="text-dark mb-0">${data.label}</p>
								<h5 class="fw-bold text-dark mb-0">${data.value}</h5>
							</div>
						</div>
					</div>
				</div>
				`;

				$('#leavechart').html(html);
			})

		},
		error:function(){
			$('#leavechart').html('<span class="text-danger">Failed to load leave data.<span>')
		}
	})
	// End Leave Chart

	// Start Earning Area
// google.charts.load('current', {'packages':['corechart']});
// google.charts.setOnLoadCallback(drawChart);

// function drawChart() {
// 	var data = google.visualization.arrayToDataTable([
// 		['Year', 'Sales', 'Expenses'],
// 		['2004',  1000,      400],
// 		['2005',  1170,      460],
// 		['2006',  660,       1120],
// 		['2007',  1030,      540]
// 	]);

// 	var options = {
// 		title: 'Sale Performance',
// 		curveType: 'function',
// 		legend: { position: 'bottom' }
// 	};

// 	var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

// 	chart.draw(data, options);
// }


// End Earning Area


	// Start User Chart
	$.ajax({
		url: '/api/usersdashboard',
		method: 'GET',
		success:function(data){
			// console.log(data)

			$('#usercount').text(data.totalusers);
			var gaugeurs = new JustGage({
				id: "userchart", // the id of the html element
				width : 200,
				height: 200,
				value: data.onlineusers,
				min: 0,
				max: data.totalusers,
				gaugeWidthScale: 0.6
			 });
		},
		error: function(){
			$('#usercount').text("Error loading data");
		}
	})
	
	//  End User Chart
	

});

