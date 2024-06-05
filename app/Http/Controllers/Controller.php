<?php

namespace App\Http\Controllers;


use App\Models\Account;

abstract class Controller
{
    public function messageResponseError($message, array $data = [], $isError = false): array
    {
        return [
            'success' => $isError,
            'message' => $message,
            'data' => $data
        ];
    }

    public function generetorNumberAgency(int $len = 4): string
    {
        $agency = "";

        for ($i = 0; $i < $len; $i++) {
            $agency .= rand(0, 9);
        }

        $verifyingDigit = $this->calculeteVerifyingDigit($agency);

        return $agency . '-' . $verifyingDigit;
    }

    public function generetorNumberAccount(int $len = 6): string
    {
        $numberAccount = "";
        for ($i = 0; $i < $len; $i++) {
            $numberAccount .= rand(0, 9);
        }
        $verifyingDigit = $this->calculeteVerifyingDigit($numberAccount);

        return $numberAccount . "-" . $verifyingDigit;
    }

    public function validateNumberAccountExist($number)
    {
        if(Account::all()->where("number_account", $number)->first() !== null){
            $number = $this->validateNumberAccountExist($this->generetorNumberAccount());
        }
        return $number;
    }

    private function calculeteVerifyingDigit(string $number): int|string
    {
        $sum = 0;
        $weight = 0;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $sum += $number[$i] * $weight;
            $weight++;
        }

        $rest = $sum % 11;
        $verifyingDigit = 11 - $rest;

        if ($verifyingDigit == 10) {
            $verifyingDigit = 'X';
        } elseif ($verifyingDigit == 1) {
            $verifyingDigit = 0;
        }

        return $verifyingDigit;
    }
}
