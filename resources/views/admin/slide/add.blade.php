 @extends('admin.layout.index')

 @section('content')
 <div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Slide
                    <small>Add</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="admin/slide/them" method="POST" enctype="multipart/form-data">
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
                    @if(session('loi'))
                    <div class="alert alert-danger">
                    <strong>{{session('loi')}}</strong>
                </div>
            @endif
                    <div class="form-group">
                        <label>Tên</label>
                        <input class="form-control" name="Ten" placeholder="Nhập tên slide" />
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <input class="form-control" name="NoiDung" placeholder="Nhập nội dung" />
                    </div>
                    <div class="form-group">
                        <label>Hình</label>
                        <input type="file" class="form-control" name="Hinh"  />
                    </div>
                    <button type="submit" class="btn btn-default">Add</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    @endsection