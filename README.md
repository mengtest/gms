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