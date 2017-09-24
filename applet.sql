CREATE DATABASE applet;


小程序管理员表
rid 标识小程序ID
lgmail 小程序登录邮箱
pwd 小程序登录密码
phone 小程序联系电话
appname 小程序名称
appID 小程序AppID

CREATE TABLE tenant(
	rid int unsigned not null AUTO_INCREMENT PRIMARY KEY,
	lgmail varchar(30) not null,
	pwd char(40) not null,
	phone char(11) not null,
	appname varchar(40) not null,
	appID char(18) not null
)


首页轮播图表
swpingID 轮播图ID
rid 标识小程序ID
image 轮播图的路径
CREATE TABLE swpimg(
	swpimgID int unsigned not null AUTO_INCREMENT PRIMARY KEY,
	rid int unsigned not null,
	image varchar(100) not null
)

分类表
catalogID 分类ID
rid 标识小程序ID
catname 分类名
image 分类图片的路径
CREATE TABLE catalog(
	catalogID int unsigned not null AUTO_INCREMENT PRIMARY KEY,
	rid int unsigned not null,
	catname varchar(40) not null,
	image varchar(100) not null
)


商品表
goodsID 商品ID
rid 标识小程序ID
catalogID   分类ID
gdname 商品名称
sprice 商品原价
price 商品现价
gdswpimg 商品轮播图
detailsimg  商品详情图
gdnumber  商品数量
unitname  商品单位名

CREATE TABLE goods(
	goodsID int unsigned not null AUTO_INCREMENT PRIMARY KEY,
	rid int unsigned not null,
	catalogID int unsigned not null,
	gdname varchar(50) not null,
	sprice decimal(8,2), 
	price decimal(8,2) not null,
	gdswpimg varchar(120) not null,
	detailsimg varchar(120) not null,
	gdnumber SMALLINT unsigned not null,
	unitname varchar(20) not null
)

INSERT INTO goods VALUES(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),
(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),
(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),
(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),
(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),
(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),
(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),
(null,1,2,'苹果',5.5,2.5,'test1.png','test2.png',40,'个'),



INSERT INTO swpimg VALUES(null,"1","test1.jpg"),
(null,"1","test2.jpg"),
(null,"1","test3.jpg"),
(null,"1","test4.jpg");