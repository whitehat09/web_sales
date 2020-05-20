@extends('admin_layout')
@section('admin_content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhập danh mục sản phẩm
                        </header>
                        

                            <?php 
        $message = Session::get('message');
        if($message) {/*nếu tồn tại*/
             echo '<span class="text-alert" style=" color:red;font-sive:17px;width:100%;text-align:center;font-weight:bold;" >'.$message.'</span>';
            
            Session::put('message',null);/*không cho trống*/
        }
    ?>
    <div class="panel-body">
        @foreach($edit_category_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update_category_product/'.$edit_value->category_id)}}" method="post" >
                                    <!-- sửa bằng id nên phải dựa vào biến id -->
                                	{{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" value="{{$edit_value->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                        
                                       
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả danh mục</label>
                                    <textarea style="resize: none; " value="{{$edit_value->category_desc}}" rows="8" class="form-control" name="category_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                        
                                        {{$edit_value->category_desc}}
                                    </textarea>
                                </div>
                              
                                
                                <button type="submit" name="update_category_product" class="btn btn-info">Cập nhập  danh mục</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
           
        </div>
@endsection        

