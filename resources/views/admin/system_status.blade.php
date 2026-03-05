@extends('layouts.main_template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    System Status Monitor
                    <div class="btn-actions-pane-right">
                        <button class="btn btn-primary" onclick="location.reload()">Refresh Status</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Response Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuses as $status)
                                <tr>
                                    <td>{{ $status['name'] }}</td>
                                    <td><a href="{{ $status['url'] }}" target="_blank">{{ $status['url'] }}</a></td>
                                    <td>
                                        @if ($status['is_up'])
                                            <span class="badge bg-success">UP</span>
                                        @else
                                            <span class="badge bg-danger">{{ $status['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $status['time'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
