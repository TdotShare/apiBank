<?php

namespace App\Http\Controllers;

use App\Expenditure;
use App\Person;
use App\Revenue;
use App\Wallet;
use DateTime;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function actionIndex()
    {
        return $this->responseRequest(
            'success',
            'select * f wallet',
            Wallet::all()
        );

    }

    public function actionFind($id)
    {

        //$wallet = Wallet::where('idwallet', $id)->get();
        $wallet = Wallet::find($id);
        if ($wallet) {
            return $this->responseRequest(
                'success',
                'select * f person w id=' . $id . '',
                $wallet
            );
        } else {
            return $this->responseRequest('failure', 'None this id rows', );
        }

    }

    public function actionCreate(Request $request)
    {
        try {
            if (($wallet = Wallet::create($request->all())) && $request->isMethod('post')) {
                return $this->responseRequest('success', 'create wallet id = ' . $wallet->idwallet . '');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest('failure', $th);
        }

    }

    public function actionUpdate($id, Request $request)
    {

        $wallet = Wallet::find($id);

        if ($wallet !== null) {
            try {
                if ($wallet->update($request->all()) && $request->isMethod('post')) {
                    return $this->responseRequest('success', 'update wallet id = ' . $wallet->idwallet . ' ');
                }
            } catch (\PDOException $th) {
                return $this->responseRequest('failure', $th);
            }
        } else {
            return $this->responseRequest('failure', 'None this id rows');
        }

    }

    public function actionDelete($id)
    {
        try {
            if (Wallet::destroy($id)) {
                return $this->responseRequest('success', 'delete wallet id =' . $id . '');
            } else {
                return $this->responseRequest('failure', 'None this id rows');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest('failure', $th);
        }

    }

    public function actionJoin_P($id)
    {
        $wallet = Wallet::where('idwallet', $id)->get();

        foreach ($wallet as $key => $item) {
            $person = Person::find($item['idperson']);
            $item['Person'] = $person;
        }

        return $this->responseRequest(
            'success',
            'select w.* , p.* f wallet w , person p where w.idperson=p.idperson',
            $wallet
        );
    }

    public function actionJoin_PR($id , $search = null)
    {
        $wallet = Wallet::where('idwallet', $id)->get();

        foreach ($wallet as $key => $item) {
            $person = Person::find($item['idperson']);

            if($search){
                //$revenue = Revenue::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%____-'. $search . '%')->get();
                $revenue = Revenue::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%'. $search . '%')->get();
            }else{
                $revenue = Revenue::where('idwallet', $item['idwallet'])->get();
            }

            $item['Person'] = $person;
            $item['Revenue'] = $revenue;
        }

        foreach ($wallet as $key => $item) {
            foreach ($item['Revenue'] as $value) {
                $item['revenue_sum'] += $value['money'];
            }
            $item['balance'] = $item['money'] + $item['revenue_sum'];
        }

        return $this->responseRequest(
            'success',
            'select w.* , p.* , r.* f wallet w , person p , revenue r where w.idperson=p.idperson and r.idwallet=w.idwallet',
            $wallet
        );
    }

    public function actionJoin_PE($id , $search = null)
    {
        $wallet = Wallet::where('idwallet', $id)->get();

        foreach ($wallet as $key => $item) {
            $person = Person::find($item['idperson']);
            $expenditure = Expenditure::where('idwallet', $item['idwallet'])->get();

            if($search){
                //$expenditure = Expenditure::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%____-'. $search . '%')->get();
                $expenditure = Expenditure::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%'. $search . '%')->get();
            }else{
                $expenditure = Expenditure::where('idwallet', $item['idwallet'])->get();
            }

            $item['Person'] = $person;
            $item['Expenditure'] = $expenditure;
        }

        foreach ($wallet as $key => $item) {
            foreach ($item['Expenditure'] as $value) {
                $item['expenditure_sum'] += $value['money'];
            }
            $item['balance'] = $item['money'] - $item['expenditure_sum'];
        }

        return $this->responseRequest(
            'success',
            'select w.* , p.* , e.* f wallet w , person p , expenditure e where w.idperson=p.idperson and e.idwallet=w.idwallet',
            $wallet
        );
    }

    public function actionJoin_PRE($id , $search = null)
    {
        $wallet = Wallet::where('idwallet', $id)->get();

        foreach ($wallet as $key => $item) {
            $person = Person::find($item['idperson']);
            $item['Person'] = $person;
        }

        foreach ($wallet as $key => $item) {
            if($search){
                //$expenditure = Expenditure::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%____-'. $search . '%')->get();
                $expenditure = Expenditure::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%'. $search . '%')->get();
            }else{
                $expenditure = Expenditure::where('idwallet', $item['idwallet'])->get();
            }
            $item['Expenditure'] = $expenditure;

            if($search){
                $revenue = Revenue::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%'. $search . '%')->get();
                //$revenue = Revenue::where('idwallet', $item['idwallet'])->where('create_at' , 'like' , '%____-'. $search . '%')->get();
            }else{
                $revenue = Revenue::where('idwallet', $item['idwallet'])->get();
            }
            $item['Revenue'] = $revenue;
        }

        foreach ($wallet as $key => $item) {
            foreach ($item['Expenditure'] as $value) {
                $item['expenditure_sum'] += $value['money'];
            }

            foreach ($item['Revenue'] as $value) {
                $item['revenue_sum'] += $value['money'];
            }
            $item['balance'] = $item['money'];

            $item['balance'] -= $item['expenditure_sum'];
            $item['balance'] += $item['revenue_sum'];
        }


        return $this->responseRequest(
            'success',
            'select w.* , p.* , e.* f wallet w , person p , revenue r , expenditure e where w.idperson=p.idperson and e.idwallet=w.idwallet and r.idwallet=w.idwallet',
            $wallet
        );
    }

    public function responseRequest($status, $message, $data = null)
    {
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data]);
    }

}
