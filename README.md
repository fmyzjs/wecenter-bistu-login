#WeCenter Bistu Login Beta#

Base on WeCenter 2.5.16

0.unzip /root/to/wecenter/

1.import aws_users_bistu.sql

2.exec:

```sql
INSERT INTO `we`.`aws_system_setting` (`id`, `varname`, `value`) VALUES (NULL, 'bistu_akey', 's:0:"";');
INSERT INTO `we`.`aws_system_setting` (`id`, `varname`, `value`) VALUES (NULL, 'bistu_skey', 's:0:"";');
INSERT INTO `we`.`aws_system_setting` (`id`, `varname`, `value`) VALUES (NULL, 'bistu_oauth_enabled', 's:1:"N";');
```

Thanks to Weibo Php SDK 