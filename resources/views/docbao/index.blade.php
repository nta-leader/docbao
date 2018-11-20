
<!DOCTYPE html>
<html>
<head>
	<title>ys</title>
	<link rel="stylesheet" type="text/css" href="{{$urlAdmin}}/reset.css">
	<style type="text/css">
		body {
		  background: url({{$urlAdmin}}/ys.jpg) no-repeat center center fixed;
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}
		.header{

		}
		.header h3{
		    color: #f9f6f1;
		    font-size: 21px;
		    padding-top: 20px;
		    padding-bottom: 20px;
		    border-bottom: 4px solid #0c1321;
		    margin-left: 6%;
		    margin-right: 6%;
		}
		.body{
			margin: 20px 6%;
			padding-bottom: 1%;
		}
		.input{
			margin: 22px 10%;
		}
		.input h3{
			color: #f9f6f1;
			font-size: 19px;
			width: 100%; 
			margin-bottom: 10px;	
		}
		.input input{
		    width: 76%;
		    border: none;
		    border-radius: 5px;
		    padding: 2% 12%;
		    font-size: 19px;
		    background: #484652;
		    color: white;
		}
		.input button{
		   	position: relative;
		    left: 71%;
		    padding: 10px;
		    border-radius: 5px;
		    margin-top: 10px;
		    border: none;
		    background: #504750;
		    color: white;
		}
		.footer{
			margin: 20px 6%;
		}

		.login{
			width: 430px;
			margin: 15% auto;
		    border-radius: 5px;
		    background-color: #141c2c;
		    border: 3px solid #112856;
		    opacity: 0.9;
		}
	</style>
</head>
<body>
	<div class="login">
		<form>
			<div class="header">
				<h3>Đăng nhập tài khoản</h3>
			</div>
			<div class="body">
				<div class="input">
					<h3>Tên tài khoản</h3>
					<input type="text" name="username">
				</div>
				<div class="input">
					<h3>Mật khẩu</h3>
					<input type="password" name="password">
				</div>
				<div class="input">
					<button type="submit">Đăng nhập</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
