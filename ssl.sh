#!/bin/sh
dir_xls2xml=${1}
svn_exec="sudo /usr/bin/svn "
cd ${dir_xls2xml}
export LANG="zh_CN.UTF-8"
case $2 in 
	'svn')
		echo "svn操作"
		${svn_exec} $3 $4 $5 $6
		echo "操作结束!"
	;;
	*)
		echo '非指定参数'
		$2 $3 $4 $5 $6
		echo "操作结束!"
	;;
esac
