{{-- Navigation --}}
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
  <div class="container-fluid">
    {{-- Brand and toggle get grouped for better mobile display --}}
    <div class="navbar-header page-scroll">
      <button type="button" class="navbar-toggle" data-toggle="collapse"
              data-target="#navbar-main">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">{{ config('meblog.name') }}</a>
    </div>
    
	{{-- Collect the nav links, forms, and other content for toggling --}}
	<div class="collapse navbar-collapse" id="navbar-main">
	    <ul class="nav navbar-nav">
	        <li>
	            <a href="/"><span class="glyphicon glyphicon-home"></span> Home</a>
	        </li>
	        @if (count($tags)>0)
	        <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
	                    aria-expanded="false">
	                <span class="glyphicon glyphicon-paperclip"></span> Tags                
	                <span class="caret"></span>
	            </a>
	            <ul class="dropdown-menu" role="menu">
	            	@foreach($tags as $tag)
	                <li><a href="{{ url('blog?tag='.$tag->tag) }}" style="color:black"> {{ $tag->title }}</a></li>
	            	@endforeach
	            </ul>
        	</li>
        	@endif	        
	    </ul>
	    <ul class="nav navbar-nav navbar-right">
	        <li>
	            <a href="/contact"><span class="glyphicon glyphicon-envelope"></span> Contact</a>
	        </li>
	    </ul>
	</div>
  </div>
</nav>