create table if not exists user_list
(
	`uid` int primary key not null auto_increment comment '��ɫid', 
	`jurisdiction` int comment 'Ȩ��',
	`username` varchar(64)  comment '����',
	`password` varchar(64) comment '����'
) engine = myisam default charset=utf8 comment='��ɫ��';

insert into user_list(jurisdiction, username, password) value(0, 'admin', '291760f98414679e3fd3f9051b19b6f7');

create table if not exists option_record
(
	`id` int primary key not null auto_increment comment '����id', 
	`username` varchar(64)  comment '����',
	`option` varchar(128) comment '������Ϣ',
	`optionserver` varchar(64) comment '������',
	`player` varchar(2048) comment '���',
	`time` varchar(64) comment 'ʱ��'
) engine = myisam default charset=utf8 comment='������¼��';