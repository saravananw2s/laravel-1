<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
	$.get("showOrders", function(data, status){
        for (var i = 0 ; i<data.length;i++) {
    		var data=data[i];
    		td = "<tr class='warning'><td>"+data.ID+"</td>"+
    			"<td>"+data.name+"</td>"+
    			"<td>"+data.Items+"</td>"+
    			"<td>"+data.number+"</td>"+
     			"<td>"+data.payment+"</td>"+
     			"<td> <a onclick='stschage("+data.ID+")'>MARKED</a></td></tr>";
     		}
     		document.getElementById("table").innerHTML = td;

    });
</script>
<script type="text/javascript">
	function stschage(id){
		var request = $.ajax({
  url: "stschage",
  type: "POST",
  data: {id : id},
  headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

});

request.done(function(msg) {
  $("#log").html( msg );

});

request.fail(function(jqXHR, textStatus) {
  alert( "Request failed: " + textStatus );

});
	}
</script>
<style type="text/css">
	
	*,
*:before,
*:after{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

html{
	font-size: 16px;
}

body{
	height: 100vh;
	font-family: 'Montserrat', sans-serif;
	background: #2ecc71;
}

.wrapper{
	padding: 2rem;
}

ul{
	list-style: none;
}

.navbar{
	background: #27ae60;
}

.navbar > ul{
	display: flex;
	justify-content: center;
}

.navbar li{
	padding: 0 15px;
	margin: 0 15px;
	position: relative;
}

.navbar a{
	line-height: 2.5;
	color: #fff;
	text-decoration: none;
	display: block;
}

.arrow{
	width: .8rem;
	position: relative;
	top: 3px;
	transform: rotate(0deg);
	transition: all .35s;
}

.submenu{
	position: absolute;
	background: #27ae60;
	left: 0;
	top: 150%;
	min-width: 11rem;
	left: -2.5rem;
	visibility: hidden;
	opacity: 0;
	transform: translateY(-1rem);
	transition: all .35s;
}

.navbar > ul > li:hover .arrow{
	transform: rotate(180deg);
}

.navbar > ul > li:hover .submenu{
	visibility: visible;
	opacity: 1;
	transform: translateY(0);
}

.submenu::before{
	position: absolute;
	content: "";
	width: 100%;
	height: 20px;
	top: -20px;
	left: 0;
	background: transparent;
}

.submenu::after{
	position: absolute;
	content: "";
	width: 0; 
	height: 0; 
	border-left: 10px solid transparent;
	border-right: 10px solid transparent;
	
	border-bottom: 10px solid #27ae60;
	top: -10px;
	left: 50%;
	transform: translateX(-50%);
}

.submenu li:not(:last-child){
	border-bottom: 1px solid #fcfcfc;
}
</style>
</head>
<body>
	
<div class="wrapper">
		<nav class="navbar">
			<ul>
				<li>
					<a href="#">Orders
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 185.344 185.344" class="arrow">
							<path d="M92.672 144.373c-2.752 0-5.493-1.044-7.593-3.138L3.144 59.3c-4.194-4.198-4.194-10.99 0-15.18 4.194-4.198 10.987-4.198 15.18 0l74.347 74.342 74.347-74.34c4.193-4.2 10.986-4.2 15.18 0 4.193 4.193 4.193 10.98 0 15.18l-81.94 81.933c-2.094 2.094-4.84 3.138-7.588 3.138z" fill="#FFF"/>
						</svg>
					</a>
					<div class="submenu">
						<ul>
							<li><a href="#">Sales Report</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href="#">Ventors
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 185.344 185.344" class="arrow">
							<path d="M92.672 144.373c-2.752 0-5.493-1.044-7.593-3.138L3.144 59.3c-4.194-4.198-4.194-10.99 0-15.18 4.194-4.198 10.987-4.198 15.18 0l74.347 74.342 74.347-74.34c4.193-4.2 10.986-4.2 15.18 0 4.193 4.193 4.193 10.98 0 15.18l-81.94 81.933c-2.094 2.094-4.84 3.138-7.588 3.138z" fill="#FFF"/>
						</svg>
					</a>
					<div class="submenu">
						<ul>
							<li><a href="#">Customers</a></li>
							<li><a href="#">Products</a></li>
						</ul>
					</div>
				</li>
				
			</ul>
		</nav>
	</div>
	<table style="width: 100%;" class="table">
  <tr class="info">  	
    <td>ID</td>
    <td>Items</td>
    <td>Address</td>
    <td>Mobile</td>
    <td>price</td>
    <td>Action</td>

  </tr>
 <tbody id="table">
 	
 </tbody>
</table>

</body>