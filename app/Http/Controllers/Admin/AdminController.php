<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\System\Parsers\TransactionParser\Transaction;
use App\System\Parsers\TransactionParser\Parsers\Swedbank;
Use App\System\Utils\CurrencyConverter;
use App\User\User;

class AdminController extends Controller
{
    // Make sure auth user is admin in controller...

    public function users(Request $request)
    {
        $users = User::orderBy('active', 'created_at')->get()->reverse();

        return view('account.admin.users', [
            'users' => $users,
            'breadcrumbs' => [
                'Admin' => '',
                'Users' => ''
            ]
        ]);
    }

    public function activateUser(Request $request, $userId)
    {
        $user = User::find($userId);
        $user->active = true;
        $user->save();

        return redirect()->back();
    }

    public function transactions(Request $request)
    {
        return view('account.admin.transactions', [
            'breadcrumbs' => [
                'Admin' => '',
                'Economy' => '',
                'Transactions' => ''
            ]
        ]);
    }

    /**
     * Get all transaction categories.
     *
     * @param  Request $request
     * @return Collection
     */
    public function transactionCategories(Request $request)
    {
        return $this->categories;
    }

    /**
     * Upload transaction file.
     *
     * @param  Request $request
     * @return
     */
    public function uploadTransactionsFile(Request $request)
    {
        if ($request->has('file')) {
            $currencyConverter = new CurrencyConverter();
            $swedbankParser = new Swedbank($request->file('file'));

            $swedbankParser->parse(function($validTransaction) use ($currencyConverter) {
                if ($validTransaction['ref'] === 'STRIPE') {
                    $validTransaction['category'] = 2;
                }

                // Convert currency from SEK to EUR
                $validTransaction['amount'] = $currencyConverter->convert($validTransaction['amount'], 'SEK');

                // Remove swish numbers with regexp here
                $validTransaction['description'] = preg_replace('/(?:[+0-9]?){6,14}[0-9]/', '', $validTransaction['description']);

                $transaction = new Transaction();
                $errors = $transaction->validate($validTransaction);

                if ($errors->isEmpty()) {
                    Transaction::create($validTransaction);
                }
            });
        }
    }

    /**
     * Update a transaction
     *
     * @param Request $request
     * @return Transaction
     */
    public function updateTransaction(Request $request)
    {
        try {
            $transaction = Transaction::find($request->input('id'));
            $transaction->category = $request->input('category');
            $transaction->save();

            return $transaction;
        } catch(\Exception $e) {
            return response($e, 400);
        }
    }
}
