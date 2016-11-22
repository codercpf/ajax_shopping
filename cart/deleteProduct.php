<?php 
	// 1、接收参数
	// 2、处理参数
	// 3、完成操作
	// 4、返回结果

	$productid = intval($_POST['productid']);
	$userid = 17;

	try{
		$dsn = "mysql:host=localhost; dbname=imooc";
		$username = "root";
		$passwd = "root";
		$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
		$pdo = new PDO($dsn, $username, $passwd, $options);

		$pdo->query("set names utf8");

		$sql = "delete from shop_cart where productid=? and userid=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($productid, $userid));

		$rows = $stmt->rowCount();

	}catch(PDOException $e){
		echo $e->getMessage();
	}

	if ($rows) {
		$response = array(
			'errno' => 0,
			'errmsg'=> '删除成功！',
			'data'  => true, 
		);
	}else{
		$response = array(
			'errno' => -1,
			'errmsg'=> '删除失败',
			'data'  => false, 
		);
	}

	echo json_encode($response);
