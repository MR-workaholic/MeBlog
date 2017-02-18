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
	        @if (count($first_level_tags)>0)
	        	@foreach($first_level_tags as $first_level_tag)
		        <li class="dropdown">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
		                    aria-expanded="false">
		                <span class="{{ $first_level_tags_icons[$first_level_tag] }}"></span> {{ $first_level_tag }}                
		                <span class="caret"></span>
		            </a>		            
		            <ul class="dropdown-menu" role="menu">
		            	<li><a href="{{ url('blog?tag='.$first_level_tag) }}" style="color:black"> {{ $first_level_tag."总览" }}</a></li>
		            	@foreach($second_level_tags[$first_level_tag] as $second_level_tag)
		                <li><a href="{{ url('blog?tag='.$second_level_tag) }}" style="color:black"> {{ $second_level_tag }}</a></li>
		            	@endforeach
		            </ul>		        
	        	</li>
	        	@endforeach
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