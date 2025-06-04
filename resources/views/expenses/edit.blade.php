@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Expense</h1>
    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $expense->description }}" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" step="1" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $expense->date }}" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category" required>
                <option value="Food" {{ $expense->category == 'Food' ? 'selected' : '' }}>Food</option>
                <option value="Transport" {{ $expense->category == 'Transport' ? 'selected' : '' }}>Transport</option>
                <option value="Entertainment" {{ $expense->category == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                <option value="Bills" {{ $expense->category == 'Bills' ? 'selected' : '' }}>Bills</option>
                <option value="Other" {{ $expense->category == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection