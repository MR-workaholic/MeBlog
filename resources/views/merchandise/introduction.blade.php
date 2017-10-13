<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>商铺信息</title>
	<link rel="stylesheet" href="/assets/introduction/css/docs.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/introduction/css/htmleaf-demo.css">

	<link rel="stylesheet" href="/assets/introduction/theme/css/t-scroll.min.css">
	<link rel="stylesheet" href="/assets/introduction/theme/css/style.css">
</head>
<body>
  <div class="htmleaf-container">
	<header class="htmleaf-header">
	  <h1>开心购物，尽在这里 <span>长按二维码识别添加微信</span></h1>
	</header>
	<section class="section section-banner">
	  <div class="section-content">
		<h1 class="title">
		  <span class="slideDown t_animated" t_show="1">小</span>
		  <span class="slideDown t_animated" t_show="2">妹</span>
		  <span class="slideDown t_animated" t_show="3">代</span>
		  <span class="slideDown t_animated" t_show="4">购</span>
		  <span class="slideDown t_animated" t_show="5">g</span>
		  <span class="slideDown t_animated" t_show="6">o</span>
		  <span class="slideDown t_animated" t_show="7">g</span>
		  <span class="slideDown t_animated" t_show="8">o</span>
		  <span class="slideDown t_animated" t_show="9">g</span>
		  <span class="slideDown t_animated" t_show="10">o</span>
		</h1>
        <div class="btn btn-main btn-lg slideLeft t_animated" target="_blank">
          <img src="{{ $img }}" width="300" alt="微信二维码"/>
        </div>
		<p>
		  开心购物，尽在这里，往下拉获取更多内容
		</p>
	  </div>
	  <button class="btn btn-animation">
		<span class="dot"></span>
	  </button>
	</section>

	<section class="section section-function">
	  <h2 class="section-title">Why Choose t-scroll</h2>
	  <div class="container">
		<div class="row">
		  <div class="col-sm-6 col-md-4 slideDown" t_show="1">
		    <div class="box">
		      <div class="box-head">
		        <h3 class="title">
		          Fully Customisable
		        </h3>
		      </div>
		      <div class="box-body">
		        Over 45 options. Easy for novice users and even more powerful for advanced developers.
		      </div>
		    </div>
		  </div>
		  <div class="col-sm-6 col-md-4 slideDown" t_show="2">
		    <div class="box box-es6">
		      <div class="box-head">
		        <h3 class="title">
		          ES6 / Bable
		        </h3>
		      </div>
		      <div class="box-body">
		        t-scroll do not used jQuery. It's used ES6
		      </div>
		    </div>
		  </div>
		  <div class="col-sm-6 col-md-4 slideDown" t_show="3">
		    <div class="box box-sass">
		      <div class="box-head">
		        <h3 class="title">
		          SASS / CSS3
		        </h3>
		      </div>
		      <div class="box-body">
		        t-scroll ships with vanilla Sass. Quickly get started with precompiled CSS or build on the source.
		      </div>
		    </div>
		  </div>

		  <div class="col-sm-6 col-md-4 slideUp" t_show="1">
		    <div class="box box-gulp">
		      <div class="box-head">
		        <h3 class="title">
		          Gulp
		        </h3>
		      </div>
		      <div class="box-body">
		        t-scroll had is built by gulp
		      </div>
		    </div>
		  </div>
		  <div class="col-sm-6 col-md-4 slideUp" t_show="2">
		    <div class="box box-browser">
		      <div class="box-head">
		        <h3 class="title">
		          Browser support
		        </h3>
		      </div>
		      <div class="box-body">
		        Cross browser compatible ( Internet Explorer 10+, Firefox, Safari, Opera, Chrome etc. )
		      </div>
		    </div>
		  </div>
		  <div class="col-sm-6 col-md-4 slideUp" t_show="3">
		    <div class="box box-npm">
		      <div class="box-head">
		        <h3 class="title">
		          npm
		        </h3>
		      </div>
		      <div class="box-body">
		        Setup t-scroll easily with node.js
		      </div>
		    </div>
		  </div>
		</div>
	  </div>
	</section>
  </div>
  
  <script>window.jQuery || document.write('<script src="/assets/introduction/js/jquery-1.11.0.min.js"><\/script>')</script>
  <script type="text/javascript" src="/assets/introduction/theme/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/assets/introduction/theme/js/t-scroll.min.js"></script>
    	<script type="text/javascript">
	    Tu.t_scroll({
	        't_element': '.title .slideDown',
	        't_duration': 0.1,
	        't_delay': 0.5
	    })
	    Tu.t_scroll({
	        't_element': '.section-function .slideDown',
	        't_duration': 0.5,
	    })
	    Tu.t_scroll({
	        't_element': '.section-function .slideUp',
	        't_duration': 0.5,
	    })

	    Tu.t_scroll({
	        't_element': '.slideRight'
	    })
	    Tu.t_scroll({
	        't_element': '.slideLeft'
	    })


	</script>
</body>
</html>
