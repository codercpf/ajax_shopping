<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ajax在购物车中的应用</title>
	<link rel="stylesheet" type="text/css" href="/resource/style.css">
	<script src="/resource/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>
	<div id="toolbar">
		<div class="heaTop w">
			<a href="javascript:void(0)" onclick="AddFavorite('我的网站',location.href)" class="heaTopFav" title="">收藏本站</a>
		</div>
	</div>
	<div id="head">
		<div class="hd">
			<p class="heaLogo f_1">
				<a>
					<img src="/resource/logo.gif" alt="">
				</a>
			</p>
		</div>
	</div>

	<div class="block table">
		<div class="flowBox">
			<h6><span>商品列表</span></h6>
			<form id="formCart" name="formCart" method="post" action="http://localhost/upload/flow.php">
	            <table width="99%" align="center" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
		            <tbody>
						<tr>
				            <th bgcolor="#ffffff">商品名称</th>
				            <th bgcolor="#ffffff">市场价</th>
				            <th bgcolor="#ffffff">本店价</th>
				            <th bgcolor="#ffffff">购买数量</th>
				            <th bgcolor="#ffffff">小计</th>
				            <th bgcolor="#ffffff">操作</th>
			            </tr>      
<?php 
	try{
		$dsn = "mysql:host=localhost; dbname=imooc";
		$username = "root";
		$passwd = "root";
		$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
		$pdo = new PDO($dsn, $username, $passwd, $options);

		$pdo->query("set names utf8");
		$sql = "select p.id, p.title, p.cover, p.originalprice, p.price, c.num from 
				shop_product p right join shop_cart c on p.id=c.productid where c.userid = ?";
		$stmt = $pdo->prepare($sql);
/*
		session_start();
		$userid = $_SESSION['memberid'];
*/
		$userid = 17;
		$stmt->execute(array($userid));	
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*
		echo "<pre>";
		print_r($data);
		echo "<pre>";
		exit;
*/
	}catch(PDOException $e){
		echo $e->getMessage();
	}	
?>

<?php
	$total = 0; 
	foreach ($data as $item) {
 ?>
            			<tr id="<?php echo $item['id']; ?>" class="products">
				            <td bgcolor="#ffffff" align="center" style="width:300px;">
								<a href="product.php?id=<?php echo $item['id']; ?>" target="_blank">
									<img style="width:80px; height:80px;" src="<?php echo $item['cover']; ?>" border="0" title="">
								</a><br>
								<a href="product.php?id=<?php echo $item['id']; ?>" target="_blank" class="f6">
									<?php echo $item['title']; ?>									
								</a>
				            </td>
				            <td align="center" bgcolor="#ffffff">￥<?php echo $item['originalprice'] ;?>元</td>
				            <td align="center" bgcolor="#ffffff">￥<span id="p-<?php echo $item['id']; ?>"><?php echo $item['price']; ?></span>元</td>
				            <td align="center" bgcolor="#ffffff">
				              	<input type="text" name="goods_number" value="<?php echo $item['num']; ?>" size="4" class="inputBg" style="text-align:center " 
				              	   	   onblur="changeNum(<?php echo $item['id'];?>, this.value)" id="num-<?php echo $item['id']; ?>" >
				            </td>
				            <td align="center" bgcolor="#ffffff">￥<span id="total-<?php echo $item['id']; ?>"><?php echo $item['num'] * $item['price']; ?></span>元</td>
				            <td align="center" bgcolor="#ffffff">
				              	<a href="javascript:delPro();" class="f6">删除</a>
				            </td>
				        </tr>
<?php
	$total += $item['num'] * $item['price'];
	}
 ?>
					</tbody>
				</table>

		<script type="text/javascript">
		//ajax传值实时显示的脚本
			function changeNum(productid, num){
				//通过ajax将对应商品的数量进行修改操作，修改shop_cart数据表
				var url = "changeNum.php";
				var data = {'productid':productid,'num':num};
				$.post(url, data, function(response){
					if (response.errno == 0) {
						var price = $("#num-" + productid).val() * $("#p-" + productid).html();
						$("#total-" + productid).html(price);
						//更新总价格

					};
				}, "json");
			}

		</script>

	          	<table width="99%" align="center" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
		            <tbody>
			            <tr>
				            <td bgcolor="#ffffff">
				            购物金额小计 ￥<span id="total_p"><?php echo $total;?></span>元             
				            </td>
				            <td align="right" bgcolor="#ffffff">
				              	<input type="button" value="清空购物车" class="bnt_blue_1" onclick="clearCart()">
				            </td>
			            </tr>
		          	</tbody>
	          	</table>
          		<input type="hidden" name="step" value="update_cart">
        	</form>

	        <table width="99%" align="center" border="0" cellpadding="5" cellspacing="0" bgcolor="#dddddd">
		        <tbody>
		          	<tr>
		            	<td bgcolor="#ffffff">
		            		<a href="">
		            			<img src="/resource/continue.gif" alt="continue">
		            		</a>
		            	</td>
		            	<td bgcolor="#ffffff" align="right">
		            		<a href="">
		            			<img src="/resource/checkout.gif" alt="checkout">
		            		</a>
		            	</td>
		          	</tr>
		        </tbody>
	        </table>
		</div>
	</div>


	
</body>
</html>