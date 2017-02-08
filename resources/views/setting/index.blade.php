@extends('layouts.layout')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					User Information Modification
				</div>
				<!-- Display Validation Errors -->
				@include('layouts.partials.success')
				
				<div class="panel-body">
					<!-- New Task Form -->
					<form action="{{ url('/setting/userinfo') }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- UserName -->
						<div class="form-group">
							<label for="username" class="col-sm-3 control-label">User Name</label>

							<div class="col-sm-6">
								<input type="text" name="name" class="form-control" value="{{ $name }}">
							</div>							
						</div>
						@if ( $errors->has('name') )
							<div class="alert alert-danger">
								<span class="glyphicon glyphicon-arrow-up"></span>
					        	<ul>
						        @foreach ($errors->all() as $error)
						            <li>{{ $error }}</li>
						        @endforeach
							    </ul>
						    </div>
						@endif						

						<!-- Email -->
						<div class="form-group">
							<label for="email" class="col-sm-3 control-label">Email</label>

							<div class="col-sm-6">
								<input type="email" name="email" class="form-control" value="{{ $email }}">
							</div>
						</div>
						@if ( $errors->has('email') )
							<div class="alert alert-danger">
								<span class="glyphicon glyphicon-arrow-up"></span>
					        	<ul>
						        @foreach ($errors->all() as $error)
						            <li>{{ $error }}</li>
						        @endforeach
							    </ul>
						    </div>
						@endif						
						
						<!-- Confirm Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<span class="glyphicon glyphicon-question-sign"></span> Confirm
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- 密码修改 -->
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Password Modification
				</div>

				<div class="panel-body">
					<!-- New Task Form -->
					<form action="{{ url('/setting/passwordinfo') }}" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- OldPassword -->
						<div class="form-group">
							<label for="oldpassword" class="col-sm-3 control-label">Old Password</label>

							<div class="col-sm-6">
								<input type="password" name="oldpassword" class="form-control" placeholder="Old Password">
							</div>
						</div>
						@if ( $errors->has('oldpassword') )
							<div class="alert alert-danger">
								<span class="glyphicon glyphicon-arrow-up"></span>
					        	<ul>
						        @foreach ($errors->all() as $error)
						            <li>{{ $error }}</li>
						        @endforeach
							    </ul>
						    </div>
						@endif	
						
						<!-- NewPassword -->
						<div class="form-group">
							<label for="newpassword" class="col-sm-3 control-label">New Password</label>

							<div class="col-sm-6">
								<input type="password" name="newpassword" class="form-control" placeholder="New Password">
							</div>
						</div>
						@if ( $errors->has('newpassword') )
							<div class="alert alert-danger">
								<span class="glyphicon glyphicon-arrow-up"></span>
					        	<ul>
						        @foreach ($errors->all() as $error)
						            <li>{{ $error }}</li>
						        @endforeach
							    </ul>
						    </div>
						@endif
						
						<!-- Confirm Password -->
						<div class="form-group">
							<label for="password_confirmation" class="col-sm-3 control-label">Confirm New Password</label>

							<div class="col-sm-6">
								<input type="password" name="newpassword_confirmation" class="form-control" placeholder="Repeat New Password">
							</div>
						</div>

						<!-- Confim Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<span class="glyphicon glyphicon-question-sign"></span> Confirm
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop