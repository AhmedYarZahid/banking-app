<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Get transactions.
     *
     */
    public function getTransactions() {
        $userId = Auth::id();

        // Retrieve transactions where user_id, sender_id, or receiver_id matches the authenticated user's ID
        return Transaction::with(['sender', 'receiver'])
            ->where('user_id', $userId)
            ->orWhere('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(5 );
    }

    /**
     * Deposit amount.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric||min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $amount = $request->input('amount');

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'deposit',
            'sender_balance' => $user->balance + $amount,
        ]);

        // Update user balance
        $user->balance += $amount;
        $user->save();

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }


    /**
     * Withdraw amount.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function withdraw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric||min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $amount = $request->input('amount');

        // Check if withdrawal amount is greater than the user's available balance
        if ($amount > $user->balance) {
            return response()->json(['error' => 'Withdrawal amount exceeds available balance.'], 400);
        }

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'withdrawal',
            'sender_balance' => $user->balance - $amount,
        ]);

        // Update user balance
        $user->balance -= $amount;
        $user->save();

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }


    /**
     * Transfer amount.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function transfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric||min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $amount = $request->input('amount');
        $recipientEmail = $request->input('email');

        // Retrieve recipient's details
        $recipientUser = User::where('email', $recipientEmail)->first();

        // Check if transfer amount is greater than the user's available balance
        if ($amount > $user->balance) {
            return response()->json(['error' => 'Transfer amount exceeds available balance.'], 400);
        }

        // Check if receiver is the current user
        if ($recipientEmail === $user->email) {
            return response()->json(['error' => 'You cannot transfer money to your own email address.'], 400);
        }

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'transfer',
            'sender_id' => $user->id,
            'receiver_id' => $recipientUser->id,
            'sender_balance' => $user->balance - $amount,
            'receiver_balance' => $recipientUser->balance + $amount
        ]);

        // Update user balance
        $user->balance -= $amount;
        $user->save();

        // Update recipient balance
        $recipientUser->balance += $amount;
        $recipientUser->save();

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }
}

