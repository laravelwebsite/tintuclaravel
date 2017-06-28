@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại tin
                    <small>Edit</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="admin/loaitin/sua/{{$loaitin->id}}" method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
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

                    @if(session('thongbao'))
                    <div class="alert alert-success">
                        <strong>{{session('thongbao')}}</strong>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Thể loại</label>
                        <select class="form-control" name="TheLoai">
                        <!--Chon cho đúng vị trí khi load lên-->
                            @foreach($theloai as $tl)
                            <option value="{{$tl->id}}"
                                    @if ($loaitin->idTheLoai==$tl->id) 
                                        {{"selected"}}
                                    @endif 
                                > {{$tl->Ten}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tên loại tin</label>
                        <input class="form-control" value="{{$loaitin->Ten}}" name="Ten" placeholder="Nhập vào tên loại tin" />
                    </div>
                    <button type="submit" class="btn btn-default">Update</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        @endsection