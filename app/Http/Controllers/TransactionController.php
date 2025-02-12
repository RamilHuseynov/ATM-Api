<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function withdraw(Request $request, Account $account)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = $request->amount;

        if ($account->balance < $amount) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        $bills = Bill::orderBy('denomination', 'desc')->get();
        $withdrawalBills = [];
        $remainingAmount = $amount;

        foreach ($bills as $bill) {
            if ($remainingAmount >= $bill->denomination && $bill->quantity > 0) {
                $count = min(intdiv($remainingAmount, $bill->denomination), $bill->quantity);
                $withdrawalBills[$bill->denomination] = $count;
                $remainingAmount -= $count * $bill->denomination;
                $bill->decrement('quantity', $count);
            }
        }

        if ($remainingAmount > 0) {
            return response()->json(['message' => 'Not enough bills to dispense'], 400);
        }

        $account->decrement('balance', $amount);
        $transaction = Transaction::create([
            'account_id' => $account->id,
            'amount' => $amount,
            'type' => 'withdraw',
        ]);

        return response()->json([
            'message' => 'Withdrawal successful',
            'transaction' => $transaction,
            'bills' => $withdrawalBills,
        ]);
    }

    public function history(Account $account)
    {
        return $account->transactions;
    }

    public function deleteTransaction(Transaction $transaction)
    {
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted']);
    }
}
