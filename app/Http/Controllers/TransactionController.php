<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $title = 'Transactions';

        $transactions = Transaction::orderBy('created_at', 'desc')->get();

        return view('admin.transactions.index', compact('title','transactions'));
    }

    public function show(Transaction $transaction)
    {
        $title = 'Transaction Details';

        return view('admin.transactions.show', compact('title','transaction'));
    }

    public function payment(Transaction $transaction)
    {
        // Update the transaction status to 'paid'
        $transaction->update(['status' => 'paid']);

        // Find the related table and update its status to 'available'
        $table = Table::findOrFail($transaction->table_id);
        $table->update(['status' => 'available']);

        // Redirect to the transactions index page with a success message
        return redirect()->route('transactions.index')->with('success', 'Transaction paid successfully.');
    }

}
