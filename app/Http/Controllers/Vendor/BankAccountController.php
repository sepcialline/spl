<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\CompanyBanks;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function show_accounts($company_id)
    {
        $data['banks'] = CompanyBanks::where('company_id', $company_id)->get();
        return view('vendor.bank_accounts.index', $data);
    }
    public function edit($id)
    {
        $data['bank_account'] = CompanyBanks::where('id', $id)->first();
        $data['banks'] = Bank::select('id', 'name_bank')->get();
        return view('vendor.bank_accounts.edit', $data);
    }

    public function update(Request $request)
    {
        $bank_account = CompanyBanks::where('id', $request->id)->first();
        if ($bank_account) {
            $bank_account->bank_id = $request->bank_id;
            $bank_account->iban_number = $request->iban_number;
            $bank_account->name_owner = $request->name_owner;
            $bank_account->save();
            return redirect()->route('vendor.bank_accounts', $bank_account->company_id)->with('success', 'Account updated successfully');
        }
    }

    public function update_to_default($id)
    {
        $bank_account = CompanyBanks::where('id', $id)->first();
        $other_banks = CompanyBanks::where('is_default', 1)->where('company_id',$bank_account->company_id)->update(['is_default' => 0]);
        $bank_account->update(['is_default' => 1]);
        return redirect()->route('vendor.bank_accounts', $bank_account->company_id)->with('success', 'Default account updated successfully');
    }


    public function stop_it($id){
        $bank_account = CompanyBanks::where('id', $id)->first();
        $bank_account->status = 0;
        $bank_account->save();
        return redirect()->route('vendor.bank_accounts', $bank_account->company_id)->with('success', 'Account stopped successfully');
    }
    public function active_it($id){
        $bank_account = CompanyBanks::where('id', $id)->first();
        $bank_account->status = 1;
        $bank_account->save();
        return redirect()->route('vendor.bank_accounts', $bank_account->company_id)->with('success', 'Account activeted successfully');
    }


}
