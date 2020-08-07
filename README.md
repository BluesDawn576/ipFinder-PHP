# ipFinder（ip查询接口）

ipv4和ipv6数据及核心文件来自以下两家（民间收集）

本项目将ipv4与ipv6数据整合为一个接口

纯真ipv4数据库：https://github.com/itbdw/ip-database （本项目数据版本为20200805）<br>ZX ipv6数据库：https://ip.zxinc.org （本项目数据版本为20200506）

> 纯真ip数据库每5天更新一次，尽量定期更新ip数据库

## 环境要求

PHP(64位) 5.6.3以上的版本

## 目录结构

```
├─ipdata
|   └─ src
|       |─ ipdbv6.func.php （ZX ipv6核心文件）
|       |─ IpLocation.php （纯真ipv4核心文件）
|       |─ ipv6wry.db （ipv6数据库）
|       |─ ipv6wry-country.db （ipv6数据库）
|       └─ qqwry.dat （ipv4数据库）
└ip.php
```

## 使用

放进网站目录即可使用，返回json格式

直接访问`ip.php`将返回本机ip信息(例)

`https://example.com/ip.php`

```json
{
  "code": 0,
  "data": {
    "ip": "2408:8756:3af0:10::169",
    "range": {
      "start": "2408:8756:3a00::",
      "end": "2408:8756:3bff:ffff::"
    },
    "country": "中国广东省深圳市坪山区",
    "isp": "中国联通IDC",
    "area": "中国广东省深圳市坪山区 中国联通IDC"
  }
}
```

----

支持指定ip查询，只需携带ip参数即可（ipv4与ipv6均可）

`https://example.com/ip.php?ip=119.75.217.109`

```json
{
  "code": 0,
  "data": {
    "ip": "119.75.217.109",
    "range": {
      "start": "119.75.208.0",
      "end": "119.75.223.255"
    },
    "country": "中国北京",
    "isp": "",
    "area": "中国北京北京百度网讯科技有限公司BGP节点"
  }
}
```

----

异常返回

```json
{
  "code": -400,
  "data": {
    "ip": "",
    "range": {
      "start": "",
      "end": ""
    },
    "country": "",
    "isp": "",
    "area": "错误或不完整的IP地址: "
  }
}
```