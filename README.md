# gms
php游戏系统后台

需要aphche服务器
	直接将该项目根目录拷贝到apache服务器下即可

配置目录:config
	配置说明
	menu.php				=>	配置菜单
	helper.html				=>	主页说明
	FileJurisdiction.php	=>	页面权限配置
	DBList.php				=>	后台数据库配置
	CommomConfig.php		=>	通用配置(主页地址、热云地址等)
	
数据库表:
	db/base.sql				=>	数据表创建(内含admin管理员)
		初始用户名:admin
		初始密码:admin

	db/test_data.sql		=>	平台服测试数据
	
//-------------------------------------------------------------------------------------------------------------------------------------
	
安装Apache
	yum install httpd

	防火墙
	systemctl stop iptables
	systemctl stop firewalld
	setenforce 0

	重启
	systemctl restart httpd

	启用.htaccess
	/etc/httpd/conf/httpd.conf
		AllowOverRide All

安装php
	yum-config-manager --enable remi-php70
	yum -y install php php-opcache

	安装依赖
	yum -y install php-mysql php-gd php-ldap php-odbc php-pear php-xml php-xmlrpc php-mbstring php-soap curl curl-devel

安装Mysql
	yum install mysql
	yum install mysql-server(可能失败)
	yum install mysql-devel

	失败处理：
	wget http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm
	rpm -ivh mysql-community-release-el7-5.noarch.rpm
	yum install mysql-community-server

	配置:
	service mysqld restart
	mysql -u root (初始无密码)

	设置密码:
	set password for 'root'@'localhost' =password('password');