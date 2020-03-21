@extends('layouts.backend.app')


@section('title', 'Post')

@push('css')
    <!-- Custom Css -->
    <link href="{{asset('assets/backend/css/style.css')}}" rel="stylesheet">
@endpush


@section('content')


    <div class="container-fluid">
      <div class="block-header">
          <a href="{{route('admin.post.create')}}" class="btn btn-primary waves-effect">

              <i class="material-icons">add</i>
              <span>ADD post</span>

          </a>


      </div>

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                       All Posts
                      <span class="badge bg-green">{{$posts->count()}}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th><i class="material-icons">visibility</i></th>
                                    <th>Is Approved</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th><i class="material-icons">visibility</i></th>
                                    <th>Is Approvec</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>

                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($posts as $post)
                                 <tr>
                                    <td>{{$post->id}}</td>
                                    <td>{{str_limit($post->title, '10')}}</td>
                                     <td>{{$post->user->name}}</td>
                                     <td>{{$post->view_count}}</td>
                                     <td>
                                         @if($post->is_approved)

                                         <span class="badge bg-blue">Approved</span>


                                          @else
                                         <span class="badge bg-yellow">Pending</span>


                                         @endif

                                     </td>
                                     <td>
                                         @if($post->status)

                                         <span class="badge bg-blue">Published</span>

                                         @else
                                         <span class="badge bg-yellow">Pending</span>


                                         @endif

                                     </td>
                                    <td>{{$post->created_at}}</td>
                                    <td>{{$post->updated_at}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.post.edit',$post->id) }}" class="btn btn-primary waves-effect">
                                            <i class="material-icons">edit</i>

                                        </a>
                                        <button type="button" class="btn btn-danger waves-effect" method="POST" onclick="deletePost({{$post->id}})">
                                            <i class="material-icons">delete</i>

                                        </button>
                                        <form id="delete-form-{{$post->id}}" action="{{route('admin.post.destroy',$post->id)}}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')

                                        </form>
                                    </td>

                                 </tr>
                                @endforeach


                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>

@endsection


@push('js')

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">

        function deletePost(id) {

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                       event.preventDefault();
                       document.getElementById('delete-form-'+id).submit();

                        swal("Poof! Your data has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });

        }


    </script>



@endpush