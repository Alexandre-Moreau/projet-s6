<?php

// fichier de langues en chinois

// Index
define("_ACCUEIL","主页");
define("_BIENVENUE","欢迎访问BTG (Better Than Google), 基于概念引用(非单词引用)的多语种语义搜索引擎。");
define("_PROMOTION","在未来几周里，这将成为在互联网上使用最多的革命性搜索引擎");
define("_MORE_INFO","更多信息");
define("_IMPORT_TITLE","请导入本体术语");
define("_IMPORT_TEXT","为了使用我们的网站，首先需要添加一个本体术语库，您可以根据需求导入您自己的本体术语库。");
define("_ADD_TITLE","添加文章");
define("_ADD_TEXT","只需要几次简单的点击, 就可以添加您的文章到网站, 它们将会根据选择的语言被当前的本体术语自动引用。");
define("_SEARCH_TITLE","搜索一个概念");
define("_SEARCH_TEXT","当您完成导入本体术语库和添加文章, 您就可以开始搜索!这些搜索是基于概念而不是关键字, 这将使搜索结果更加精确。");

// Shared
define("_NAME","名字");
define("_FILE","文件");
define("_DATABASE","数据库");
define("_BACKBUTTON","返回");

// Shared (forms)
define("_FORMSUBMIT","提交");
define("_FORMRESET","重置");
define("_FORMCANCEL","取消");
define("_FORMREQUESTED","请求失败");
define("_FORMERROR","错位来自");

// Shared (errors)
define("_ERROR","错误");
define("_ERRORFORMHANDLING","表单处理错误");
define("_WATCHLOGS","请查看记录获得更多信息");
define("_NOFILEERROR","文件未选择");
define("_PARSEERROR","解析时出错 (文件不正确)");
define("_ENCODINGERROR","编码错误 (必须是 UTF-8)");
define("_UNKNOWNERROR","未知错误");
define("_MISSINGINFORM1","不存在 ");
define("_MISSINGINFORM2","被指定的");
function _composeMisingError($m){return _MISSINGINFORM1.strtolower($m)._MISSINGINFORM2;}
define("_ERRORLANGUAGES","数据库里没有找到语言");
define("_IMPORTONTO","尝试导入本体解决这个问题");

// Header
define("_RECHERCHER","搜索");
define("_ARTICLES","文章");
define("_ARTICLES_NEW","新文章");
define("_ONTO_NEW","新的本体术语");
define("_MAINTENANCE","维护");

// Footer
define("_WHY","BTG由萨瓦大学三年级计算机系实现");
define("_FULL_CODE_1","你可以通过以下链接在GitHub上获取全部代码");
define("_FULL_CODE_2","链接");
define("_ICON","图标提供者");
define("_FROM","来源");
define("_VECTOR","矢量图提供者");

// Search
define("_SEARCH","搜索");
define("_CONCEPTS","概念");
define("_TERMS","术语");
define("_LISTARTICLES","找到的文章");
define("_LISTREFERENCES","引用");

// Create article
define("_CREATEARTICLE","创建一个新的文章");
define("_CHOOSENAME","选择一个名字");
define("_CHOOSEFILE","选择文件");
define("_LANGUAGE","语言");
define("_OTHERLANGUAGE","其它 (内容将不会被引用)");
define("_CREATESUCCES","文章已成功创建");
define("_LINKARTICLE","访问该文章");

// Create onto
define("_CREATEONTO","创建一个新的本体术语");
define("_ASKREPLACE","您确定要创建一个新的本体术语库吗？因为这将导致之前的本体术语库将会被删除！");
define("_CONFIRM","确定");

// Show Article
define("_REFERENCE","引用");
define("_EDIT","编辑");
define("_DELETE","删除");
define("_NO_PDF","该浏览器不允许预览PDF文件：");
define("_PDF_DL","下载pdf文件");
define("_FILE_NOT_FOUND","未在磁盘找到该文件。");
define("_WHY_ERROR"," 请转到维护板块获得更多信息。");

// Edit articles
define("_EDITARTICLE","编辑文章");
define("_EDITSUCCES","该文章被成功编辑");

// Maintenance
define("_STATUS","状态");
define("_DATABASE_MANAGEMENT","数据库管理");
define("_ONTO","本体术语");
define("_ADVANCED","高级");
define("_SYSTEM", "系统");
define("_SERVUSER", "服务拥有者");
define("_NETWORK", "网络");
define("_SERVERIP", "服务器 IP 地址");
define("_CLIENTIP", "用户 IP 地址");
define("_ARTICLES_ALL","总体文章: ");
define("_ARTICLES_NO_REF","文章没有被引用: ");
define("_LOCATION","位置: ");
define("_ERROR_DISK_FILE","连接磁盘文件出错: ");
define("_ROOT_NUMBERS","根号码: ");
define("_ERROR_BUILD","构建错误: ");
define("_MISSING_FILES","磁盘上缺少文件:");
define("_EXCESS_FILES","磁盘文件过多:");
define("_SERVER_CONNECTION","连接服务器");

?>