@extends('admin_layout')
@section('admin_content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhập thương hiệu sản phẩm
                        </header>
                        

                            <?php 
        $message = Session::get('message');
        if($message) {/*nếu tồn tại*/
             echo '<span class="text-alert" style=" color:red;font-sive:17px;width:100%;text-align:center;font-weight:bold;" >'.$message.'</span>';
            
            Session::put('message',null);/*không cho trống*/
        }
    ?>
    <div class="panel-body">
        @foreach($edit_brand_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update_brand_product/'.$edit_value->brand_id)}}" method="post" >
                                    <!-- sửa bằng id nên phải dựa vào biến id -->
                                	{{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" value="{{$edit_value->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                        
                                       
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                    <textarea style="resize: none; " value="{{$edit_value->brand_desc}}" rows="8" class="form-control" name="brand_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                        
                                        {{$edit_value->brand_desc}}
                                    </textarea>
                                </div>
                              
                                
                                <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhập  thương hiệu</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
           
        </div>
@endsection        

