<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title','weibo app') - 新浪微博</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>

  	@include('layouts._header')
  	<!-- @yield('content') 表示 该区域将用于显示content区块的内容
  	而 content区块 的内容 （由default子视图定义） 将由继承自 default视图的子视图定义 -->
  	<div class="container">
		@yield('content')
		@include('layouts._footer')
  	</div>
    
  </body>
</html>