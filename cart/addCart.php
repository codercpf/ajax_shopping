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

//3、将数据添加进购物车（判断当前用户在购物车中是否已经加入过该商品，若加入过，则自增即可）
		//判断
		$sqlQuery = "select * from shop_cart where productid=? and userid=?";
		$stmtQuery = $pdo->prepare($sqlQuery);
		$stmtQuery->execute(array($productid, $userid));
		
		$data = $stmtQuery->fetch(PDO::FETCH_ASSOC);

		if ($data) {
			//查询结果为真，说明表中存在对应的用户和相同的产品id，执行更新
			$sql = "update shop_cart set num=num+? where userid=? and productid=?";
			$params = array($num, $userid, $productid);			
		}else{
			//结果为空，说明该用户未添加过商品，执行添加操作
			$sql = "insert into shop_cart(productid, userid, num, price, createtime) value(?,?,?,?,?)";
			$params = array($productid, $userid, $num, $price, $createtime);
		}
		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);	

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
