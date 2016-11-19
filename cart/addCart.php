<?php 
/*
* 加入购物车操作
*/

//1、接收传递过来的post参数
	$productid = intval($_POST['productid']);
	$num = intval($_POST['num']);
//2、准备要添加的购物车数据
	session_start();
	// $userid = $_SESSION['memberid'];
	$userid = 17;
	//根据productid查询相应产品的price
	try{
		$dsn = "mysql:host=localhost;dbname=imooc";
		$username = "root";
		$passwd = "root";
		$option = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
		$pdo = new PDO($dsn, $username, $passwd, $option);

		$pdo->query("set names utf8");

		$sql = "select price from shop_product where id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($productid));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$price = $data['price'];
		$createtime = time();

//3、将数据添加进购物车
		$sql = "insert into shop_cart(productid, userid, num, price, createtime) value(?,?,?,?,?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($productid, $userid, $num, $price, $createtime));

		$rows = $stmt->rowCount();
	}catch(PDOException $e){
		echo $e->getMessage();
	}

//4、返回添加结果
	if($rows){
		$response = array(
			'errno'  => 0,
			'errmsg' => '添加成功',
			'data'	 => true, 
		);
	}else{
		$response = array(
			'errno'  => -1,
			'errmsg' => '添加失败',
			'data'   => false,
		);
	}

	echo json_encode($response);
