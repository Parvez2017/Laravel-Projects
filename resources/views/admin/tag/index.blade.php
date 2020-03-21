@extends('layouts.backend.app')


@section('title', 'Tag')

@push('css')
    <!-- Custom Css -->
    <link href="{{asset('assets/backend/css/style.css')}}" rel="stylesheet">
@endpush


@section('content')


    <div class="container-fluid">
      <div class="block-header">
          <a href="{{route('admin.tag.create')}}" class="btn btn-primary waves-effect">

              <i class="material-icons">add</i>
              <span>ADD TAG</span>

          </a>


      </div>

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                       All Tags
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Post Count</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Post Count</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>

                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($tags as $tag)
                                 <tr>
                                    <td>{{$tag->id}}</td>
                                    <td>{{$tag->name}}</td>
                                     <td>{{$tag->posts->count()}}</td>
                                    <td>{{$tag->created_at}}</td>
                                    <td>{{$tag->updated_at}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.tag.edit',$tag->id) }}" class="btn btn-primary waves-effect">
                                            <i class="material-icons">edit</i>

                                        </a>
                                        <button type="button" class="btn btn-danger waves-effect" method="POST" onclick="deleteTag({{$tag->id}})">
                                            <i class="material-icons">delete</i>

                                        </button>
                                        <form id="delete-form-{{$tag->id}}" action="{{route('admin.tag.destroy',$tag->id)}}" method="POST" style="display: none;">
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

        function deleteTag(id) {

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