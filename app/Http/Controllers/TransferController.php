<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Account;
use App\Models\Transfer;
use Database\Factories\TransferFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Transfer::all();
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
    public function store(StoreTransferRequest $request, Response $response): Response
    {
        $transfer = TransferFactory::new();

        $account = Account::all();

        $payerNumberAccount = $request->get('payer_number_account');
        $payerNumberAgenct = $request->get('payer_number_agency');

        $payeeNumberAccount = $request->get('payee_number_account');
        $payeeNumberAgenct = $request->get('payee_number_agency');

        $acountPayerFirst = $account
            ->where('number_account', $payerNumberAccount)
            ->where('agency', $payerNumberAgenct)
            ->first();

        $acountPayeeFirst = $account
            ->where('number_account', $payeeNumberAccount)
            ->where('agency', $payeeNumberAgenct)
            ->first();

        if (!$acountPayerFirst) {
            $response->setStatusCode(404);
            return $response->setContent($this->messageResponseError("There is no account for the payer in the database"));
        }


        if (!$acountPayeeFirst) {
            $response->setStatusCode(404);
            return $response->setContent($this->messageResponseError("There is no account for the payee in the database"));
        }

        $payer = $acountPayerFirst->getAttribute('user_id');
        $payee = $acountPayeeFirst->getAttribute('user_id');

        $amountPayer = $acountPayerFirst->getAttribute('amount');
        $value = $request->get('value');

        if ($amountPayer < $value) {
            $response->setStatusCode(400);
            return $response->setContent($this->messageResponseError("Insufficient funds"));
        }

        $data = ['payer' => $payer, 'payee' => $payee, 'value' => $value];
        $transfer->create($data);

        $acountPayerFirst->update(['amount' => $amountPayer - $value]);
        $acountPayeeFirst->update(['amount' => $acountPayeeFirst->getAttribute('amount') + $value]);


        return $response->setContent($this->messageResponseError("Transfer completed successfully", isError: true));

    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
