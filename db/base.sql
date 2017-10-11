create table if not exists user_list
(
	`uid` int primary key not null auto_increment comment '角色id', 
	`jurisdiction` int comment '权限',
	`username` varchar(64)  comment '名称',
	`password` varchar(64) comment '密码'
) engine = myisam default charset=utf8 comment='角色表';

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