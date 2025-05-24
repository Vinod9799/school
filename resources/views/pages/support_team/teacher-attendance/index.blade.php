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
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendance as $record)
                            <tr>
                                <td>{{ $record->date }}</td>
                                <td>{{ $record->check_in ?? '-' }}</td>
                                <td>{{ $record->check_out ?? '-' }}</td>
                                <td>{{ $record->status }}</td>
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
                        <form method="post" action="{{ route('teacher-presents.mark') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="date" class="col-lg-3 col-form-label font-weight-semibold">Date</label>
                                <div class="col-lg-9">
                                    <input type="date" class="form-control" name="date" required value="{{ date('Y-m-d') }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="teacher_id" class="col-lg-3 col-form-label font-weight-semibold">Teacher</label>
                                <div class="col-lg-9">
                                    <select required class="form-control select" name="teacher_id" id="teacher_id">
                                        @foreach($teacher as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Mark Attendance <i class="icon-check ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- End mark attendance tab --}}
        </div>
    </div>
</div>

@endsection
