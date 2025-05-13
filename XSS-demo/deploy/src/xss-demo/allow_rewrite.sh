#!/bin/bash

sudo a2enmod rewrite
# 原始配置文件路径
original_config="/etc/apache2/apache2.conf"

# 临时配置文件路径
temp_config="/etc/apache2/apache2.conf.bak"

# 创建一个临时文件以保存原始文件
cp $original_config $temp_config

# 使用sed命令进行替换
sed -i '170s/<Directory \/var\/www\//<Directory \/var\/www\/html\//g' $original_config
sed -i '172s/AllowOverride None/AllowOverride All/g' $original_config

service apache2 restart