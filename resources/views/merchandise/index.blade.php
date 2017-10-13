<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8" />
    
    <title>{{ $title }}</title>
    
    <!-- Our CSS stylesheet file -->
    <link rel="stylesheet" href="/assets/css/merchandise.css" />
    
    <!--[if lt IE 9]>
      <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <header>
      <h1>{{ $header }}</h1>
    </header>
    <nav id="filter"></nav>

    <section id="container">
      <p class="center">更多精彩内容请关注：<a href="{{ url('merchandise/wxcode') }}" target="_blank">{{ $WXname }}</a>商铺简介</p>
      <ul id="stage">
        @foreach($merchandises as $merchandise)
          <li data-tags="{{ $merchandise->data_tags }}">
            <img src="{{ "/uploads/merchandises/$merchandise->src.jpg" }}" alt="{{ $merchandise->alt }}" />
            <div><strong>{{ $merchandise->alt }}</strong></div>
          </li>
        @endforeach

        <!-- <li data-tags="Print Design"><img src="assets/img/shots/1.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design,Print Design"><img src="assets/img/shots/2.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Logo Design"><img src="assets/img/shots/3.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Print Design"><img src="assets/img/shots/4.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design"><img src="assets/img/shots/5.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Logo Design,Print Design"><img src="assets/img/shots/6.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design,Print Design"><img src="assets/img/shots/7.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design"><img src="assets/img/shots/8.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Logo Design"><img src="assets/img/shots/9.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design"><img src="assets/img/shots/10.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design,Print Design"><img src="assets/img/shots/11.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design,Print Design"><img src="assets/img/shots/12.jpg" alt="Illustration" /></li>
             <li data-tags="Print Design"><img src="assets/img/shots/13.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Logo Design"><img src="assets/img/shots/14.jpg" alt="Illustration" /></li>
             <li data-tags="Print Design"><img src="assets/img/shots/15.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design"><img src="assets/img/shots/16.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Logo Design,Print Design"><img src="assets/img/shots/17.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design"><img src="assets/img/shots/18.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Print Design"><img src="assets/img/shots/19.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design,Print Design"><img src="assets/img/shots/20.jpg" alt="Illustration" /></li>
             <li data-tags="Web Design,Logo Design"><img src="assets/img/shots/21.jpg" alt="Illustration" /></li>
             <li data-tags="Print Design"><img src="assets/img/shots/22.jpg" alt="Illustration" /></li>
             <li data-tags="Logo Design,Print Design"><img src="assets/img/shots/23.jpg" alt="Illustration" /></li>
             <li data-tags="My Design"><img src="assets/img/shots/timg.jpg" alt="Illustration" /></li>
             <li data-tags="My Design"><img src="assets/img/shots/timgg.jpg" alt="Illustration" /></li> -->
      </ul>
    </section>
    
    <script src="assets/merchandisejs/jquery-1.7.2.min.js"></script>
    <script src="assets/merchandisejs/jquery.quicksand.js"></script>
    <script src="assets/merchandisejs/script.js"></script>
    
  </body>
</html>
