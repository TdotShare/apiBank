<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Person;

class PersonController extends Controller
{
    public function actionIndex()
    {

        return $this->responseRequest(
            'success',
            'select * f person',
            Person::all()
        ); 
        
    }

    public function actionFind($id){

        $person = Person::where('idperson', $id)->get();
        if (count($person) !== 0) {
            return $this->responseRequest(
                'success',
                'select * f person w id=' . $id . '',
                $person
            ); 
        }else{
            return $this->responseRequest('failure', 'None this id rows', );
        }

    }

    public function actionCreate(Request $request){
        try {
            if (($person = Person::create($request->all())) && $request->isMethod('post')) {
                return $this->responseRequest('success', 'create person id = ' . $person->idperson . '');
            }
        } catch (\PDOException $th) {
            return $this->responseRequest('failure', $th);
        }
    }

    public function actionUpdate($id , Request $request){

        $person = Person::find($id);

        if ($person !== null) {
            try {
                if ($person->update($request->all()) && $request->isMethod('post')) {
                    return $this->responseRequest('success', 'update person id = ' . $person->idperson . ' ');
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
            if (Person::destroy($id)) {
                return $this->responseRequest('success', 'delete book id =' . $id . '');
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
