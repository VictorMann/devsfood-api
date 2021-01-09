<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cupom(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        $address = $request->user()->address;

        if ($address)
        {
            return response()->json([
                'error'  => '',
                'result' => $address
            ]);
        }

        return response()->json([
            'error' => 'nenhum endereco encotrado'
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'  => 'string|required',
            'city'     => 'string|required',
            'uf'       => 'string|required',
            'cep'      => 'string|required',
        ]);

        try
        {
            $address = $request->user()->address;

            if (!$address) {
                $address = new Address();
                $address->user_id = $request->user()->id;
            }

            $address->fill($request->all());
            $address->save();

            return response()->json([
                'error'  => '',
                'result' => $address
            ]);
        }
        catch (\Exception $ex)
        {
            return response()->json([
                'error' => 'ERROR: ' .$ex->getMessage()
            ]);
        }
    }

    public function frete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cep'   => 'numeric|required',
            'peso'  => 'numeric|required',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => json_encode($validator->errors())
            ]);
        }

        try
        {
            $frete = DB::table('fretes')
            ->whereRaw("{$request->cep} BETWEEN cep_ini AND cep_fim")
            ->whereRaw("{$request->peso} BETWEEN peso_ini AND peso_fim")
            ->first();

            if (!$frete)
            {
                return response()->json([
                    'error' => 'frete não encontrado'
                ]);
            }

            return response()->json([
                'error'  => '',
                'result' => $frete
            ]);
        }
        catch (\Exception $ex)
        {
            return response()->json([
                'error' => 'ERROR: ' .$ex->getMessage()
            ]);
        }
    }
}
