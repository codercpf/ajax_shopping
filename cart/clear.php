<?php 
	$userid = 17;
	try{
		$dsn = "mysql:host=localhost;dbname=imooc";
		$username = "root";
		$passwd = "root";
		$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
		$pdo = new PDO($dsn, $username, $passwd, $options);

		$pdo->query("set names utf8");

		$sql = "delete from shop_cart where userid=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($userid));

		$rows = $stmt->rowCount();
	}catch(PDOException $e){
		echo $e->getMessage();
	}

	if ($rows) {
		$response = array(
			'errno' => 0,
			'errmsg'=> '购物车已清空',
			'data'	=> true,
		);
	}else{
		$response = array(
			'errno' => -1,
			'errmsg'=> '清空失败',
			'data'	=> false,
		);
	}

	echo json_encode($response);