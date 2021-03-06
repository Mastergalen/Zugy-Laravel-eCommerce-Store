<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Services\CreateOrUpdateAddress;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Zugy\Facades\Checkout;


class AddressController extends Controller
{
    public function index()
    {
        return auth()->user()->addresses()->get();
    }

    public function show($id)
    {
        $address = Address::findOrFail($id);

        if(Gate::denies('show', $address)) {
            abort(403);
        }

        return $address;
    }

    public function update(Request $request, CreateOrUpdateAddress $addressService, $id)
    {
        $address = Address::findOrFail($id);

        if(Gate::denies('update', $address)) {
            abort(403);
        }

        $result = $addressService->delivery($request->all(), $address);

        if( ! $result instanceof Address) {
            return response()->json(['status' => 'error', 'message' => trans('address.api.error.invalid'), 'errors' => $result->errors()], 422);
        }

        return ['status' => 'success', 'message' => trans('address.api.update.success')];
    }

    public function destroy($id)
    {
        try {
            $address = Address::findOrFail($id);
        } catch(ModelNotFoundException $e) {
            return response()->json(['status' => 'failure', 'message' => trans('address.api.error.404')], 404);
        }

        //Unset session addresses
        if(Checkout::getBillingAddress()->id == $id) Checkout::forgetBillingAddress();
        if(Checkout::getShippingAddress()->id == $id) Checkout::forgetShippingAddress();

        $address->delete();

        return ['status' => 'success', 'message' => trans('address.api.destroy.success')];
    }
}