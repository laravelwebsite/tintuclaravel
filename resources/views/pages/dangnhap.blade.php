  @extends('layout.index')
  @section('title')
  Đăng nhập
  @endsection
  @section('content')
  <!-- Page Content -->
  <div class="container">

  	<!-- slider -->
  	<div class="row carousel-holder">
  		<div class="col-md-4"></div>
  		<div class="col-md-4">
  			<div class="panel panel-default">
  				<div class="panel-heading">Đăng nhập</div>
  				<div class="panel-body">
  					<form action="dangnhap" method="POST">
  						@if(count($errors)>0)
  						<div class="alert alert-danger">
  							<strong>Whoops!</strong>There were some problems with your input! <br><br>
  							<ul>
  								@foreach($errors->all() as $error)
  								<li>{{$error}}</li>
  								@endforeach
  							</ul> 
  						</div>
  						@endif
                                    

                                    <!-- thong bao sai tai khoan mat khau-->
  						@if(session('thongbao'))
  						<div class="alert alert-danger">
  							<strong>{{session('thongbao')}}</strong>
  						</div>
  						@endif
                                    <!-- thong bao dang ky tai khoan thanh cong-->
                                    @if(session('dangky'))
                                    <div class="alert alert-success">
                                      <strong>{{session('dangky')}}</strong>
                                    </div>
                                    @endif
  						<input type="hidden" name="_token" value="{{csrf_token()}}">
  						<div>
  							<label>Email</label>
  							<input type="email" class="form-control" placeholder="Enter your Email" name="email" 
  							>
  						</div>
  						<br>	
  						<div>
  							<label>Mật khẩu</label>
  							<input type="password" class="form-control" placeholder="Enter your password" name="password">
  						</div>
  						<br>
  						<button type="submit" class="btn btn-default">Đăng nhập
  						</button>
  					</form>
  				</div>
  			</div>
  		</div>
  		<div class="col-md-4"></div>
  	</div>
  	<!-- end slide -->
  </div>
  <!-- end Page Content -->
  @endsection