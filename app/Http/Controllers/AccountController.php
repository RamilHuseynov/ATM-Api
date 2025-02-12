<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return Account::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|unique:accounts',
            'balance' => 'required|numeric',
        ]);

        return Account::create($request->all());
    }

    public function show(Account $account)
    {
        return $account;
    }
}
