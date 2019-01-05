<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title','weibo app') - 新浪微博</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>

  	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="/">Weibo App</a>
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li>
          <li class="nav-item" ><a class="nav-link" href="#">登录</a></li>
        </ul>
      </div>
    </nav>
  	<!-- @yield('content') 表示 该区域将用于显示content区块的内容
  	而 content区块 的内容 （由default子视图定义） 将由继承自 default视图的子视图定义 -->
  	<div class="container">
		@yield('content') 
  	</div>
    
  </body>
</html>