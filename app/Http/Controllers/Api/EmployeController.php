<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\EmployeResoutse;
use App\Employe;
use App\Position;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positionHeadDepartament = Position::select('id')
            ->where('name_position', 'Начальник отдела')->get();

         return  EmployeResoutse::collection(
                 Employe::with('position', 'department')
                     ->where('id_positione','<>',$positionHeadDepartament)
                     ->orderBy('full_name')
                     ->paginate(5)
         );


    }

    public function sortFio(){

        $positionHeadDepartament = Position::select('id')
            ->where('name_position', 'Начальник отдела')->get();

        return  EmployeResoutse::collection(
            Employe::with('position', 'department')
                ->where('id_positione','<>',$positionHeadDepartament)
                ->orderBy('full_name', 'desc')
                ->paginate(5)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
