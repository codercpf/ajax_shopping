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
				<a >
					<img src="/resource/logo.gif" alt=""></a>
			</p>
		</div>
	</div>
<?php
//PDO方式，根据url中的ID，获取商品信息，填充页面
	try{
		$dsn = "mysql:host = localhost;dbname=imooc";
		$username = "root";
		$password = "root";
		$pdo = new PDO($dsn, $username, $password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

		$pdo->query("set names utf8");

		$sql = "select * from shop_product where id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($_GET['id']));

		$data = $stmt->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		echo $e->getMessage();
	}
/*
	echo "<pre>";
	print_r($data);
	echo "<pre>";
	exit;
*/
?>	

	<div class="block">
		<div class="AreaR" style="background: #eee;display: block">
			<div id="goodsInfo" class="clearfix">
				<div class="imgInfo">
					<a href="" id="zoom1" class="MagicZoom MagicThumb" title="" style="position: relative; display: block; outline: 0px; text-decoration: none; width: 360px;">
						<img src="<?php echo $data['cover']; ?>" alt="" width="360px;" height="360px" id="sim625470">
						<div id="bc625470" class="MagicZoomBigImageCont" style="width: 200px; height: 269px; overflow: hidden; z-index: 100; visibility: visible; position: absolute; top: -10000px; left: 377px; display: block;">							
							<div style="overflow: hidden;">
								<img src="<?php echo $data['cover']; ?>" style="position: relative; border-width: 0px; padding: 0px; left: 0px; top: -0.694444px; display: block; visibility: visible;">
							</div>
						</div>
					</a>
					<div class="blank5"></div>
					<div style="text-align:center; position:relative; width:100%;">
			          	<a href="javascript:;">
			            	<img style="position: absolute; left:0;" alt="prev" src="/resource/up.gif">
			            </a>
			          	<a href="javascript:;" onclick="">
			            	<img alt="zoom" src="/resource/zoom.gif">
			            </a>
			        </div>

			        <div class="blank"></div>

			        <div class="picture" id="imglist">
			          	<img src="<?php echo $data['cover']; ?>" alt="<?php echo $data['title']; ?>" class="onbg">
			      	</div>
				</div>

				<div class="textInfo">
					<form action="" method="post" name="" id="">
				        <h1 class="clearfix">
				        	<?php echo $data['title']; ?>			        	
				        </h1>

				        <ul class="ul2 clearfix">
				          	<li class="clearfix" style="width:100%">
				            	<dd> <strong>本店售价：</strong>
					              	<font class="shop" id="ECS_SHOPPRICE">￥<?php echo $data['price']; ?>元</font>
					              	<font class="market">￥<?php echo $data['originalprice']; ?>元</font>
				            	</dd>
				          	</li>

				          	<li class="clearfix">
				            	<dd> <strong>商品货号：</strong>IMOOC-<?php echo $data['id']; ?></dd>
				          	</li>

				          	<li class="clearfix">
				            	<dd><strong>商品库存：</strong><?php echo $data['inventory']; ?>台</dd>
				          	</li>

				          	<li class="clearfix">
				            	<dd>
				            		<strong>上架时间：</strong>
				            		<?php echo date('Y-m-d H:i:s', $data['createtime']); ?>
				            	</dd>
				          	</li>
				          	<li class="clearfix">
				            	<dd><strong>商品点击数：</strong>9</dd>
				          	</li>
				        </ul>

				        <ul class="bnt_ul">
				          	<li class="padd loop">
					            <strong>颜色：</strong>
					            <input type="radio" name="spec_185" value="231" id="spec_value_231" checked="" onclick="changePrice()">白色 [￥<?php echo $data['price']; ?>元]
					          	<input type="hidden" name="spec_list" value="0">
				          	</li>
					        <li class="clearfix">
					          	<dd>
					            	<strong>购买数量：</strong>
					            	<input name="number" type="text" id="number" value="1" size="4" onblur="" style="border:1px solid #ccc; ">
					            	<strong>商品总价：</strong>
					            	<font id="" class="f1">￥<?php echo $data['price']; ?>元</font>
					          	</dd>
					        </li>

					        <li class="padd">
					          	<a href="javascript:addCart(<?php echo $data['id']; ?>);">
					            	<img src="/resource/goumai2.gif">
					            </a>
					        </li>
				      	</ul>
				    </form>
					
				</div>

			</div>

		</div>
	</div>
	
	<script type="text/javascript">
//加入购物车脚本
		function addCart(productId){
			//ajax请求php脚本，完成数据添加到 shop_cart
			var url = "addCart.php";
			var data= {"productid":productId, "num":parseInt($("#number").val())};
			$.post(url, data, function(response){
				if (response.errno == 0) {
					alert("加入购物车成功！");
				}else{
					alert("加入购物车失败！");
				};
			}, "json");
		}
	</script>

	<script type="text/javascript">var process_requrest="正在处理您的请求……"</script>
	<script type="text/javascript">
		//收藏本站
		function AddFavorite(title, url){
			try{
				window.external.addFavorite(url, title);
			}catch(e){
				try{
					window.sidebar.addPanel(title, url, "");
				}catch(e){
					alert("浏览器无法完成此操作。\n\n加入收藏夹失败，请使用Ctrl+D 进行添加");
				}
			}
		}
	</script>
</body>
</html>