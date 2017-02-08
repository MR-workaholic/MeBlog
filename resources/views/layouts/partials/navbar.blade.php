<ul class="nav navbar-nav">
    <li><a href="/"><span class="glyphicon glyphicon-home"></span> Blog Home</a></li>
    @if (Auth::check())
        <li @if (Request::is('admin/post*')) class="active" @endif>
            <a href="/admin/post"><span class="glyphicon glyphicon-share"></span> Posts</a>
        </li>
        <li @if (Request::is('admin/tag*')) class="active" @endif>            
            <a href="/admin/tag"><span class="glyphicon glyphicon-paperclip"></span> Tags</a>
        </li>
        <li @if (Request::is('admin/upload*')) class="active" @endif>
            <a href="/admin/upload"><span class="glyphicon glyphicon-cloud-upload"></span> Uploads</a>
        </li>
    @endif
</ul>

<ul class="nav navbar-nav navbar-right">
    @if (Auth::guest())
        <li>
        	<a href="/auth/login"><i class="fa fa-btn fa-sign-in"></i> Login</a>
        </li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
                    aria-expanded="false">
                <span class="glyphicon glyphicon-user"></span>
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/auth/logout"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
            	<li><a href="/setting"><span class="glyphicon glyphicon-cog"></span> Setting</a></li>
            </ul>
        </li>
    @endif
</ul>