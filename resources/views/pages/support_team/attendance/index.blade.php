@extends('layouts.master')
@section('page_title', 'Manage Attendance')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Manage Attendance</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#all-attendance" class="nav-link active" data-toggle="tab">All Attendance</a></li>
            <li class="nav-item"><a href="#new-attendance" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Mark Attendance</a></li>
        </ul>

        <div class="tab-content">
            {{-- List of Attendance --}}
            <div class="tab-pane fade show active" id="all-attendance">
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Teacher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendance as $record)
                            <tr>
                                <td>{{ $record->date }}</td>
                                <td>{{ $record->student->name ?? '-' }}</td>
                                <td>{{ $record->class->name ?? '-' }}</td>
                                <td>{{ ucfirst($record->status) }}</td>
                                <td>{{ $record->teacher->name ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left">
                                                <a href="{{ route('attendance.edit', $record->id) }}" class="dropdown-item">
                                                    <i class="icon-pencil"></i> Edit
                                                </a>
                                                <a id="{{ $record->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item">
                                                    <i class="icon-trash"></i> Delete
                                                </a>
                                                <form method="POST" id="item-delete-{{ $record->id }}" action="{{ route('attendance.destroy', $record->id) }}" class="hidden">
                                                    @csrf @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mark Attendance --}}
            <div class="tab-pane fade" id="new-attendance">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info border-0 alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span>Fill out the form below to mark today's attendance.</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <form class="ajax-store" method="post" action="{{ route('attendance.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="date" class="col-lg-3 col-form-label font-weight-semibold">Date</label>
                                <div class="col-lg-9">
                                    <input type="date" class="form-control" name="date" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="class_id" class="col-lg-3 col-form-label font-weight-semibold">Class</label>
                                <div class="col-lg-9">
                                    <select required class="form-control select" name="class_id" id="class_id">
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="student_id" class="col-lg-3 col-form-label font-weight-semibold">Student</label>
                                <div class="col-lg-9">
                                    <select required class="form-control select" name="student_id" id="student_id">
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-lg-3 col-form-label font-weight-semibold">Status</label>
                                <div class="col-lg-9">
                                    <select required class="form-control" name="status" id="status">
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- End mark attendance tab --}}
        </div>
    </div>
</div>

@endsection
