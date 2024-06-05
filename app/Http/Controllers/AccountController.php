<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\User;
use Database\Factories\AccountFactory;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request, Response $response): Response
    {

        $userId = $request->get('user_id');
        $user = User::all();
        $account = AccountFactory::new();
        if (!$user->where("id", $userId)->first()) {
            $response->setStatusCode(404);
            return $response->setContent($this->messageResponseError("User does not exist in the database"));
        }
        $numberAccount = "184505-7";// $this->generetorNumberAccount();
        $numberAccountValidate = $this->validateNumberAccountExist($numberAccount);
        $dataAccount = [
            'number_account' => $numberAccountValidate,
            'agency' => $this->generetorNumberAgency(),
            'amount' => 0,
            'user_id' => $userId
        ];

        $account->create($dataAccount);
        $response->setStatusCode(201);
        return $response->setContent(
            $this->messageResponseError("Account created successfully", $dataAccount, true)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
       return Account::all()->where("user_id", $user_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
