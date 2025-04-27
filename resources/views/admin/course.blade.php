@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <title>Admin Course</title>
    <h1>Welcome To course</h1>
    <div class="container">
        <?php
        $titleVal=$descriptionVal=$image_labelVal=$image_descVal='';
        if(isset($editPage)){
        if($editPage[0]->title){
            $titleVal = $editPage[0]->title;
            $titleVal = 'value='.$titleVal.'';
        }
        if($editPage[0]->description){
            $descriptionVal = $editPage[0]->description;
        }
        if($editPage[0]->image_label){
            $image_labelVal = $editPage[0]->image_label;
        }
        if($editPage[0]->image_desc){
            $image_descVal = $editPage[0]->image_desc;
        }
    }
        ?>
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        @if(!isset($_REQUEST['flag']))
         <?php $_REQUEST['flag']=''; ?>
        @endif
        @if(isset($_REQUEST['flag']) && $_REQUEST['flag'] == 'add' || $_REQUEST['flag'] == 'edit')
            @if (count($errors) > 0)
                <div class = "alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <form action="add-course" method="post" enctype="multipart/form-data">
                @csrf                
                <input type="hidden" name="flag" value="{{$_REQUEST['flag']}}">
                @if(isset($_REQUEST['id']))
                    <input type="hidden" name="id" value="{{$_REQUEST['id']}}">
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <label for="course_title">Title</label>
                        <input type="text" class="form-control" name="course_title" id="course_title" {{$titleVal}}>
                    </div>
                    <div class="col-md-4">
                        <label for="course_desc">Course Description</label>                        
                            <textarea class="form-control" name="course_desc" id="course_desc">{{$descriptionVal}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="image_label">Label Image</label>
                        <input class="form-control" id="image_label" type="file" name="course_label_image">
                        @if($image_labelVal)
                            <img src="{{asset('storage')}}/{{$image_labelVal}}" alt="Title Image" width="50%" height="50%" style="border-radius: 10px; padding-top:20px;">
                            <input id="image_label_already" type="hidden" name="course_label_image_already" value="{{$image_labelVal}}"> 
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="image_desc">Description Image</label>
                        <input class="form-control" id="image_desc" type="file" name="course_desc_image">
                        @if($image_descVal)
                            <img src="{{asset('storage')}}/{{$image_descVal}}" alt="Title Image" width="50%" height="50%" style="border-radius: 10px; padding-top:20px;">
                            <input id="image_desc_already" type="hidden" name="course_desc_image_already" value="{{$image_descVal}}">
                        @endif
                    </div>
                </div>
                <div class="row" style="padding-top:20px;">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        @else
            <a href="?flag=add" class="btn btn-primary">Add Course</a>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Title Image</th>
                    <th scope="col">Descrition Image</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data))
                    <?php $count=1; ?>
                        @foreach($data as $courseVal)
                        <tr>
                            <th scope="row">{{$count}}</th>
                            <td>{{$courseVal->title}}</td>
                            <td>{{$courseVal->description}}</td>
                            <td><a target="_blank" href="{{ asset('storage/') }}/{{$courseVal->image_label}}">
                                @if($courseVal->image_label)                                                                         
                                    <?php echo substr($courseVal->image_label,0,10) ?>   
                                @endif</a></td>
                            <td><a target="_blank" href="{{ asset('storage/') }}/{{$courseVal->image_desc}}">
                            @if($courseVal->image_desc)
                                <?php echo substr($courseVal->image_desc,0,10) ?>                                 
                            @endif    
                            </a></td>
                            <td scope="col">
                            <div class="row">
                                <div class="col-md-2">
                                <a class="btn btn-info" href="?flag=edit&id={{$courseVal->id}}">Edit</a>
                                </div>
                                <div class="col-md-2" style="padding-left: 36px">
                                
                                <a class="btn btn-danger" onclick="deleteCourse({{$courseVal->id}});">Delete</a>
                                </div>
                            </div>
                        </td>
                        </tr>
                        <?php $count++; ?>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endif
    </div>
    <!-- /.content -->
</div>
<script>
    function deleteCourse(id){
        if(confirm("Are you sure you want to delete this course")){
            window.location.href="?flag=delete&id="+id+"";
        }else{
            return false;
        }
    }
</script>
@endsection