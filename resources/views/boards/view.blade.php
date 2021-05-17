@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Board view</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('boards.all')}}">Boards</a></li>
                        <li class="breadcrumb-item active">Board</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$board->name}}</h3>
            </div>

            <div class="card-body">
                <select class="custom-select rounded-0" id="changeBoard">
                    @foreach($boards as $selectBoard)
                        <option @if ($selectBoard->id === $board->id) selected="selected"
                                @endif value="{{$selectBoard->id}}">{{$selectBoard->name}}</option>
                    @endforeach
                </select>

                <table>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Assignment</th>
                        <th>Status</th>
                        <th>Creation date</th>
                    </tr>

                    @foreach($board->tasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->user->name ?? 'Unknown (' . ($task->assignment ?? 'null')  . ')' }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>


        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection