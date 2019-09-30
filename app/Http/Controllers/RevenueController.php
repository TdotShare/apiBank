<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Revenue;

class RevenueController extends Controller
{
    public function actionIndex()
    {
        return $this->responseRequest(
            'success',
            'select * f revenue',
            Revenue::all()
        );
    }

    public function actionFind($id){

        $revenue = Revenue::where('idrevenue', $id)->get();
        if (count($revenue) !== 0) {
            return $this->responseRequest(
                'success',
                'select * f revenue w id=' . $id . '',
                $revenue
            );
        } else {
            return $this->responseRequest('failure', 'None this id rows', );
        }

    }

    public function actionCreate(Request $request){
        try {
            if (($revenue = Revenue::create($request->all())) && $request->isMethod('post')) {
                return $this->responseRequest('success', 'create revenue id = ' . $revenue->idrevenue . '');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest('failure', $th);
        }
    }

    public function actionUpdate($id , Request $request){

        $revenue = Revenue::find($id);

        if ($revenue !== null) {
            try {
                if ($revenue->update($request->all()) && $request->isMethod('post')) {
                    return $this->responseRequest('success', 'update wallet id = ' . $revenue->idrevenue . ' ');
                }
            } catch (\PDOException $th) {
                return $this->responseRequest('failure', $th);
            }
        } else {
            return $this->responseRequest('failure', 'None this id rows');
        }

    }

    public function actionDelete($id){

        try {
            if (Revenue::destroy($id)) {
                return $this->responseRequest('success', 'delete revenue id =' . $id . '');
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
