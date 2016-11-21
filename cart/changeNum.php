<?php 
//完成对购物车数据表的更新操作
/*
	1、接受参数
	2、处理参数
	3、完成更新操作
	
*/
	$num = intval($_POST['num']);
	$productid = intval($_POST['productid']);
/*
	session_start();
	$userid = $_SESSION['memberid'];
*/
	$userid = 17;
	try{
		$dsn = "mysql:host=localhost; dbname=imooc";
		$username = "root";
		$passwd = "root";
		$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
		$pdo = new PDO($dsn, $username, $passwd, $options);

		$pdo->query("set names utf8");

		$sql = "update shop_cart set num=? where productid=? and userid=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($num, $productid, $userid));

		$rows = $stmt->rowCount();

	}catch (PDOException $e){
		echo $e->getMessage();
	}

//4、返回结果
	if ($rows) {
		$response = array(
			'errno' => 0,
			'errmsg'=> '更新成功！',
			'data'  => true,
		);
	}else{
		$response = array(
			'errno' => -1,
			'errmsg'=> '更新失败',
			'data'  => false,			
		);
	}

	echo json_encode($response);	

