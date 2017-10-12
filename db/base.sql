create table if not exists user_list
(
	`uid` int primary key not null auto_increment comment '��ɫid', 
	`jurisdiction` int comment 'Ȩ��',
	`username` varchar(64)  comment '����',
	`password` varchar(64) comment '����'
) engine = myisam default charset=utf8 comment='��ɫ��';

#����Ա�˺�(admin ,admin)
insert into user_list(jurisdiction, username, password) value(0, 'admin', '04bac4668ac0a8dc5a6529f7b09e4828');

create table if not exists option_record
(
	`id` int primary key not null auto_increment comment '����id', 
	`username` varchar(64)  comment '����',
	`option` varchar(128) comment '������Ϣ',
	`optionserver` varchar(64) comment '������',
	`player` varchar(2048) comment '���',
	`time` varchar(64) comment 'ʱ��'
) engine = myisam default charset=utf8 comment='������¼��';

create table if not exists server_info
(
	`id` int primary key not null auto_increment comment '����id', 
	`addrs` varchar(64)  comment '���ݿ��ַ',
	`duser` varchar(64) comment '���ݿ��û���',
	`dpassword` varchar(64) comment '���ݿ�����',
	`datasource` varchar(64) comment '����Դ',
	`platname` varchar(64) comment 'ƽ̨��',
	`servername` varchar(64) comment '����',
	`serverid` int comment '��id(worldid)'
) engine = myisam default charset=utf8 comment='����Ϣ��';
