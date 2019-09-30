<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Expenditure;



class ExpenditureController extends Controller
{
    public function actionIndex()
    {
        return $this->responseRequest(
            'success',
            'select * f expenditure',
            Expenditure::all()
        );
    }

    public function actionFind($id)
    {
        $expenditure = Expenditure::where('idexpenditure', $id)->get();
        if (count($expenditure) !== 0) {
            return $this->responseRequest(
                'success',
                'select * f expenditure w id=' . $id . '',
                $expenditure
            );
        } else {
            return $this->responseRequest('failure', 'None this id rows', );
        }

    }

    public function actionCreate(Request $request)
    {
        try {
            if (($expenditure = Expenditure::create($request->all())) && $request->isMethod('post')) {
                return $this->responseRequest('success', 'create expenditure id = ' . $expenditure->idexpenditure . '');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest('failure', $th);
        }

        

    }

    public function actionUpdate($id , Request $request)
    {
        $expenditure = Expenditure::find($id);

        if ($expenditure !== null) {
            try {
                if ($expenditure->update($request->all()) && $request->isMethod('post')) {
                    return $this->responseRequest('success', 'update expenditure id = ' . $expenditure->idexpenditure . ' ');
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
            if (Expenditure::destroy($id)) {
                return $this->responseRequest('success', 'delete expenditure id =' . $id . '');
            } else {
                return $this->responseRequest('failure', 'None this id rows');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest('failure', $th);
        }

    }

    public function responseRequest($status, $message, $data = null)
    {
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data]);
    }
}
