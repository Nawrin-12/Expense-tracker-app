@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Expense Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $expense->description }}</h5>
            <p class="card-text"><strong>Amount:</strong> ${{ number_format($expense->amount, 2) }}</p>
            <p class="card-text"><strong>Date:</strong> {{ $expense->date }}</p>
            <p class="card-text"><strong>Category:</strong> {{ $expense->category }}</p>
            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection