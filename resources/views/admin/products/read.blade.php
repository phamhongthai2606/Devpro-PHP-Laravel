<!-- import file layout.blade.php vao day -->
@extends("admin.layout")
<!-- do du lieu ben duoi vao tag append-du-lieu-view-vao-day cua file layout.blade.php -->
@section("append-du-lieu-view")
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"></div>

  <ul class="app-menu">
    <li>
      <a class="app-menu__item" href="{{ asset('admin/home') }}">
        <i class='app-menu__icon bx bx-tachometer'></i>
        <span class="app-menu__label">Quản lý chung</span>
      </a>
    </li>
    @if(Auth::user()->permission == "admin")
    <li>
      <a class="app-menu__item" href="{{ asset('admin/customers') }}">
        <i class='app-menu__icon bx bx-id-card'></i> 
        <span class="app-menu__label">Danh sách khách hàng</span>
      </a>
    </li>
    <li>
      <a class="app-menu__item" href="{{ asset('admin/users') }}">
        <i class='app-menu__icon bx bx-user-voice'></i>
        <span class="app-menu__label">Danh sách nhân viên</span>
      </a>
    </li>
      <a class="app-menu__item" href="{{ asset('admin/categories') }}">
        <i class='app-menu__icon bx bx-task'></i>
        <span class="app-menu__label">Danh mục sản phẩm</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->permission == "admin" || Auth::user()->permission == "user")
    <li>
      <a class="app-menu__item active" href="{{ asset('admin/products') }}">
        <i class='app-menu__icon bx bx-purchase-tag-alt'></i>
        <span class="app-menu__label">Danh sách sản phẩm</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->permission == "admin" || Auth::user()->permission == "order")
    <li>
      <a class="app-menu__item" href="{{ asset('admin/orders') }}">
        <i class='app-menu__icon bx bxs-shopping-bags'></i>
        <span class="app-menu__label">Danh sách đơn hàng</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->permission == "admin" || Auth::user()->permission == "user")
    <li>
      <a class="app-menu__item" href="{{ asset('admin/news') }}">
        <i class='app-menu__icon bx bxs-user-account'></i>
        <span class="app-menu__label">Danh sách tin tức</span>
      </a>
    </li>
    @endif
  </ul>
</aside>

<main class="app-content">
  <div class="app-title">
    <ul class="app-breadcrumb breadcrumb side">
      <li class="breadcrumb-item active">
        <b>Danh sách sản phẩm</b>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12" style="margin-bottom:5px;">
      <input type="text" id="key"> <input type="button" onclick="location.href='{{ url('admin/products') }}?key='+document.getElementById('key').value;" value="Search">
    </div>  

    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="row element-button">
            <div class="col-sm-2">
              <a class="btn btn-add btn-sm" href="{{ url('admin/products/create') }}">
                <i class="fas fa-plus"></i>Tạo mới sản phẩm
              </a>
            </div>
          </div>
          <table class="table table-hover table-bordered js-copytextarea" cellpadding="0" cellspacing="0" border="0" id="sampleTable">
            <tr>
              <th style="text-align: center;">Mã sản phẩm</th>
              <th style="text-align: center;">Tên sản phẩm</th>
              <th style="text-align: center;">Ảnh</th>
              <th style="text-align: center;">Danh mục</th>
              <th style="text-align: center;">Số lượng</th>
              <th style="text-align: center;">Giá</th>
              <th style="text-align: center;">Giảm giá</th>
              <th style="text-align: center;">Hot</th>
              <th style="text-align: center;">Tính năng</th>
            </tr>
            @foreach($data as $row)
            <tr>
              <td style="text-align: center;">{{ $row->id }}</td>
              <td style="text-align: center;">{{ $row->name }}</td>
              <td style="text-align:center;">
                @if($row->image != null && file_exists("upload/products/".$row->image))
                  <img src="{{ asset('upload/products/'.$row->image) }}" style="width:100px;">
                @endif
              </td>
              <td style="text-align:center;">
                <!-- có thể truy vấn trực tiếp csdl tại view (sử dụng Query Builder hoặc Eloquent đều được) -->
                @php
                  //->get() lấy toàn bộ kết quả trả về
                  $category = DB::table("categories")->where("id","=",$row->category_id)->first();
                @endphp
                {{ isset($category->name) ? $category->name : "" }}
              </td>
              <td style="text-align:center;">{{ $row->quantity }}</td>
              <td style="text-align:center;">{{ number_format($row->price) }}</td>
              <td style="text-align:center;">{{ $row->discount }} %</td>
              <td style="text-align:center;">
                @if($row->hot == 1)
                  <span class="glyphicon glyphicon-check"></span>
                @endif
              </td>
              <td style="text-align:center;">
                <a href="{{ url('admin/products/update/'.$row->id) }}">
                  <i class="fas fa-edit"></i>
                </a>&nbsp;
                <a href="{{ url('admin/products/delete/'.$row->id) }}" onclick="return window.confirm('Are you sure?');">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </table>
          <!-- gọi hàm phân trang -->
          {{ $data->render() }}
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
