@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Expense Tracker</h1>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add New Expense</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->description }}</td>
                <td>${{ number_format($expense->amount, 2) }}</td>
                <td>{{ $expense->date }}</td>
                <td>{{ $expense->category }}</td>
                <td>
                    <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection