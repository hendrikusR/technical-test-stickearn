@extends('layouts')
@section('content')
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Status</th>
                <th>Score</th>
                <th>Final Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $key => $history)
                <tr>
                    <td>{{ $key+1  }}</td>
                    <td>{{ $history->name }}</td>
                    <td>{{ $history->question }}</td>
                    <td>{{ $history->answer }}</td>
                    <td>{{ $history->status }}</td>
                    <td>{{ $history->score }}</td>
                    <td>{{ $history->final_score }}</td>    
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $histories->links() }}
@endsection