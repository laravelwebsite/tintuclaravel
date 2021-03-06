@extends('layout.index')
@section('title')
Trang chủ
@endsection
@section('content')
<!-- Page Content -->
<div class="container">

	@include('layout.slide')

	<div class="space20"></div>


	<div class="row main-left">
		@include('layout.menu')

		<div class="col-md-9">
			<div class="panel panel-default">            
				<div class="panel-heading" style="background-color:#337AB7; color:white;" >
					<h2 style="margin-top:0px; margin-bottom:0px;">Laravel Tin Tức</h2>
				</div>

				<div class="panel-body">
				@foreach($theloai as $tl)
					<!-- item -->
					@if(count($tl->loaitin)>0)
					<div class="row-item row">
						<h3>
							<a href="">{{$tl->Ten}}</a> | 
							@foreach($tl->loaitin as $lt)
							<small><a href="loaitin/{{$lt->id}}/{{$lt->TenKhongDau}}.html"><i>{{$lt->Ten}}</i></a>/</small>
							@endforeach
						</h3>
						<?php 
							//lay ra 5 tin noi bat va sap xep theo ngay moi nhat
							$data=$tl->tintuc->where('NoiBat',1)->sortByDESC('created_at')->take(5);
							//lay ra 1 tin trong data,dong thoi data bi tru bot di 1 tin nay
							$tin1=$data->shift();
						?>
						<div class="col-md-8 border-right">
							<div class="col-md-5">
								<a href="chitiet/{{$tin1->id}}/{{$tin1->TieuDeKhongDau}}.html">
									<img class="img-responsive" height="50px;" src="upload/tintuc/{{$tin1->Hinh}}" alt="" >
								</a>
							</div>

							<div class="col-md-7">
								<h3>{{$tin1->TieuDe}}</h3>
								<p>{{$tin1->TomTat}}</p>
								<a class="btn btn-primary" href="chitiet/{{$tin1->id}}/{{$tin1->TieuDeKhongDau}}.html">Chi tiết <span class="glyphicon glyphicon-chevron-right"></span></a>
							</div>

						</div>
						

						<div class="col-md-4">
						@foreach($data as $dt)
							<a href="chitiet/{{$dt->id}}/{{$dt->TieuDeKhongDau}}.html">
								<h4>
									<span class="glyphicon glyphicon-list-alt"></span>
									{{$dt->TieuDe}}
								</h4>
							</a>
							@endforeach
						</div>
						
						<div class="break"></div>
					</div>
					@endif
					<!-- end item -->
					@endforeach

				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
</div>
<!-- end Page Content -->
@endsection