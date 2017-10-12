create table if not exists user_list
(
	`uid` int primary key not null auto_increment comment '角色id', 
	`jurisdiction` int comment '权限',
	`username` varchar(64)  comment '名称',
	`password` varchar(64) comment '密码'
) engine = myisam default charset=utf8 comment='角色表';

#管理员账号(admin ,admin)
insert into user_list(jurisdiction, username, password) value(0, 'admin', '04bac4668ac0a8dc5a6529f7b09e4828');

create table if not exists option_record
(
	`id` int primary key not null auto_increment comment '索引id', 
	`username` varchar(64)  comment '名称',
	`option` varchar(128) comment '操作信息',
	`optionserver` varchar(64) comment '操作服',
	`player` varchar(2048) comment '玩家',
	`time` varchar(64) comment '时间'
) engine = myisam default charset=utf8 comment='操作记录表';

create table if not exists server_info
(
	`id` int primary key not null auto_increment comment '索引id', 
	`addrs` varchar(64)  comment '数据库地址',
	`duser` varchar(64) comment '数据库用户名',
	`dpassword` varchar(64) comment '数据库密码',
	`datasource` varchar(64) comment '数据源',
	`platname` varchar(64) comment '平台名',
	`servername` varchar(64) comment '服名',
	`serverid` int comment '服id(worldid)'
) engine = myisam default charset=utf8 comment='服信息表';
