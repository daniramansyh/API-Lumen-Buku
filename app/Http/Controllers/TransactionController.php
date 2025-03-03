<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $transactions = Transaction::all();
            return $this->respondResource($transactions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function detail($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            return $this->respondResource($transaction);
        } catch (\Exception) {
            return response()->json(['error' => "Data not found!"], 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_id' => 'required|string|exists:books,id',
                'user_id' => 'required|string|exists:users,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $book = Book::findOrFail($request->book_id);
            if ($book->status !== 'available') {
                return response()->json(['error' => 'Book is not available for borrowing.'], 400);
            }

            $transaction = new Transaction([
                'id' => Uuid::uuid4()->toString(),
                'book_id' => $request->book_id,
                'user_id' => $request->user_id,
                'borrow_date' => Date::now(),
                'status' => 'borrowed'
            ]);
            $transaction->save();
            $book->update(['status' => 'not_available']);
            return $this->respondResource($transaction);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'book_id' => 'required|string',
                'user_id' => 'required|string',
                'borrow_date' => 'required|date',
                'return_date' => 'nullable|date',
                'status' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $transaction->update($request->all());
            return $this->respondResource($transaction);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted successfully']);
        } catch (\Exception) {
            return response()->json(['error' => "Data not found!"], 404);
        }
    }

    public function returnBook(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'transaction_id' => 'required|string|exists:transactions,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $transaction = Transaction::where('id', $request->transaction_id)
                ->where('status', 'borrowed')
                ->firstOrFail();
            $transaction->update([
                'return_date' => Date::now(),
                'status' => 'returned'
            ]);
            $transaction->book->update(['status' => 'available']);
            return response()->json(['message' => 'Book returned successfully!', 'transaction' => $transaction]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
