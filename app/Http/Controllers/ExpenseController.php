<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use App\Models\Expense;
//use Illuminate\Http\Request;
use App\Http\Requests\CreateRequest;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::query()->where('email', $validated['email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ]);
            } else {
                $expense = Expense::create([
//                    'email' => $validated['email'],
                    'description' => $validated['description'],
                    'amount' => $validated['amount'],
                    'date' => $validated['date'],
                    'category' => $validated['category'],
                    'user_id' => $user->id,

                ]);

                return response()->json([
                    'message' => 'Expense Created Successfully',

                ]);
            }
        }catch(\Exception $exception){
                Log::error('FULL ERROR: ' . $exception->getMessage());
                return response()->json([
                    'message' => 'Failed to create expense',
                    'error' => $exception->getMessage()
                ]);
            }

//        $validated = $request->validate([
//            'description' => 'required',
//            'amount' => 'required|numeric',
//            'date' => 'required|date',
//            'category' => 'required'
//        ]);
//
//        // Expense::create($request->all());
//        Expense::create($validated);
//
//        return redirect()->route('expenses.index')
//                        ->with('success', 'Expense added successfully.');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(UpdateRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::query()->where('email', $validated['email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ]);
            }
            $expense = Expense::query()->where('id', $validated['expense_id'])
                ->where('user_id', $user->id)
                ->first();

            if (!$expense) {
                return response()->json([
                    'message' => 'Expense not found'
                ]);
            }

              $expense->update([
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category' => $validated['category'],
            ]);
            return response()->json([
                'message' => 'Expense Updated Successfully',
            ]);
        } catch (\Exception $exception) {
            Log::error('FULL ERROR: ' . $exception->getMessage());
            return response()->json([
                'message' => 'Something went wrong. Please try again later',
                'error' => $exception->getMessage()
            ]);
        }

    }



//        $request->validate([
//            'description' => 'required',
//            'amount' => 'required|numeric',
//            'date' => 'required|date',
//            'category' => 'required'
//        ]);
//
//        $expense->update($request->all());
//
//        return redirect()->route('expenses.index')
////                        ->with('success', 'Expense updated successfully.');
//    }

    public function destroy(DeleteRequest $request)
    {
        $validated = $request->validated();
        try{
            $user = User::query()->where('email',$validated['email'])->first();
            if (!$user) {
                return response()->json([
                    'message'=>'User not found'
                ]);
            }
            $expense = Expense::query()->where('id', $validated['expense_id'])
                ->where('user_id', $user->id)
                ->first();
            if (!$expense) {
                return response()->json([
                    'message'=>'Expense not found'
                ]);
            }
            $expense->delete();
            return response()->json([
                'message' => 'Expense Deleted Successfully',
            ]);
        }catch(\Exception $exception){
            Log::error('FULL ERROR: ' . $exception->getMessage());
            return response()->json([
                'message' => 'Something went wrong. Please try again later',
            ]);
        }

//        $expense->delete();
//
//        return redirect()->route('expenses.index')
//                        ->with('success', 'Expense deleted successfully.');
    }

    public function read ()
    {
        $expenses=Expense::all();
        return response()->json(['expenses'=>$expenses,
        "message"=>"Expense Read"
        ]);

    }
}
