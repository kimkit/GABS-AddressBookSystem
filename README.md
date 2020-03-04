# GABS-AddressBookSystem
[![Build Status](https://travis-ci.org/manier13579/GABS-AddressBookSystem.svg?branch=master)](https://travis-ci.org/manier13579/GABS-AddressBookSystem)
[![Coverage Status](https://coveralls.io/repos/github/manier13579/GABS-AddressBookSystem/badge.svg?branch=master)](https://coveralls.io/github/manier13579/GABS-AddressBookSystem?branch=master)
[![BCH compliance](https://bettercodehub.com/edge/badge/manier13579/GABS-AddressBookSystem?branch=master)](https://bettercodehub.com/)
[![StyleCI](https://github.styleci.io/repos/136253474/shield?branch=master)](https://github.styleci.io/repos/136253474)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fmanier13579%2FGABS-AddressBookSystem.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fmanier13579%2FGABS-AddressBookSystem?ref=badge_shield)
=======

* 基于web的通讯录系统，适用于企业或者个人使用。
* 目的在于快速获取联系人信息，或通过信息快速查找联系人、与他人共享联系人等。
* 这个项目我本人一直在使用，同时也在当前公司部署，分享给公司员工使用，会一直更新。
* 如果您有什么建议，或是有意向合作，欢迎联系我。

|Author|Bing Zhe|
|---|---
|E-mail|9061@163.com

****

## 项目预览
#### 首页预览
![首页预览1](https://github.com/manier13579/GABS-AddressBookSystem/raw/master/src/images/readme1.png)  
![首页预览2](https://github.com/manier13579/GABS-AddressBookSystem/raw/master/src/images/readme2.png)  
#### 普通用户后台预览
![普通用户后台预览1](https://github.com/manier13579/GABS-AddressBookSystem/raw/master/src/images/readme3.png)  
![普通用户后台预览2](https://github.com/manier13579/GABS-AddressBookSystem/raw/master/src/images/readme4.png)  
#### 管理员用户后台预览
![管理员用户后台预览](https://github.com/manier13579/GABS-AddressBookSystem/raw/master/src/images/readme5.png)  
## 项目特色
* 简单易部署，只需要最基础的WAMP或LAMP环境
* 初步的前后端分离，未完全实现前后端分离，但是已经达到便于维护和技术升级的目标。
* 极简代码结构，未使用任何后端框架，代码简单易懂、速度快。
* 重要数据加密，用户登录信息、通讯录数据完全加密，不怕泄露。
* 支持多语言，语言种类可轻松扩展。
* 不限制条目，每个联系人可以任意增加自定义条目，如增加：QQ号、副邮箱、副手机号、工号等
* 模糊搜索，经过精心设计的实时模糊搜索，可以通过任意字段快速查找联系人

## 部署方式
#### 1、部署WAMP或LAMP环境
    PHP版本5.6及以上，需要 php_mysqli 扩展。
    网站路由配置在.htaccess文件中，因此Apache需要开启对.htaccess的支持。
#### 2、新建mysql数据库
    数据库名任意。
    例：mysql -e 'CREATE DATABASE gabs;'
#### 3、导入数据库基础环境
    在新建的数据库运行 sql\db.sql 文件，导入表结构和基础数据
    例：mysql -e 'use gabs; set names utf8; source sql/db.sql;'
#### 4、配置数据库链接
    修改数据库连接配置文件：src\common\db.php
    默认数据库名称为'gabs'，数据库用户名和密码都为'root'，可根据实际情况修改
#### 5、网页可以访问，使用下面的管理用账户登录测试
>>|管理员用户名|密码|
>>|---|---
>>|admin|admin
#### 6、完成，点个赞支持我吧~

## 常见问题
#### 权限规则
    用户可以编辑自己的每条通讯录的权限，有以下3种权限：
    1、私有：仅自己可见。
    2、分享给组 + 只读：选定组织内的所有用户可见(包含组织下属层级，如：分享给1001时1001001也可见)，但是不可编辑。
    3、分享给组 + 编辑：同上，但是可以编辑、删除，慎重选择。
    
#### 组织结构编辑规则
    通讯录为0级，不可修改。
    1级为公司，1001为公司下属部门，1001001为公司下属部门的下属部门，以此类推。
    多部门情况下按1001、1002、1003规则添加。
    
#### 批量导入通讯录时未完全导入，只导入了一部分
    由于php限制处理上传文件的最大值，解决方法：
    将php.ini中的 upload_max_filesize 和 post_max_size 的值同时调高，满足上传需要即可。


## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fmanier13579%2FGABS-AddressBookSystem.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fmanier13579%2FGABS-AddressBookSystem?ref=badge_large)
