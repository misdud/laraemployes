<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\EmployeResource;
use App\Http\Resources\HeadDepartResource;
use App\Http\Resources\PositionResource;
use App\Employe;
use App\Position;
use App\Department;


class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $positionHeadDepartament = Position::select('id')
        // ->where('name_position', 'Начальник отдела')->first();

        $employes = Employe::with('position', 'department')
            // ->where('id_positione','!=',$positionHeadDepartament->id)
            ->orderBy('full_name')
            ->paginate(5);

        return  EmployeResource::collection($employes);
    }

    public function sortFio()
    {

        $positionHeadDepartament = Position::select('id')
            ->where('name_position', 'Начальник отдела')->first();

        return  EmployeResource::collection(
            Employe::with('position', 'department')
                ->where('id_positione', '<>', $positionHeadDepartament->id)
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

        // $employe = Employe::with('position', 'department')
        //  ->where('id', $id)->get();

        // return  EmployeResource::collection($employe);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //  $employe = Employe::with('position', 'department')
        //  ->where('id', $id)->first();
        EmployeResource::withoutWrapping();
        return new EmployeResource(Employe::with('position', 'department')->findOrFail($id));
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
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'employment' => 'required|date',
            'ratio' => 'required|numeric',
            'name_head_depart' => 'required|string',
        ]);


        //for search id departament
        $nameHeadDepart = $request->name_head_depart;
        $departamentId = Department::select('id')->where('name_head_depart', $nameHeadDepart)->first();

        //for search id position
        $namePosition = $request->position;
        $positionId = Position::select('id')->where('name_position', $namePosition)->first();

        //for prepare date
        $date = $request->employment;
        $myDate = date('Y-m-d H:i:s', strtotime($date));

        $employe = Employe::find($id);
        $employe->full_name = $request->name;
        $employe->employment = $myDate;
        $employe->ratio = $request->ratio;
        $employe->id_departament = $departamentId->id;
        $employe->id_positione = $positionId->id;
        $employe->save();

        EmployeResource::withoutWrapping();
        return new EmployeResource(Employe::with('position', 'department')->find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employees = Employe::findOrFail($id);
        $employees->delete();
        return response()->json(['message' => 'Сотрудник удалён']);
    }

    public function getHeadDepart()
    {

        $headDeparts = Department::select('id', 'name', 'name_head_depart')
            ->orderBy('name_head_depart')->get();

        EmployeResource::withoutWrapping();
        return HeadDepartResource::collection($headDeparts);
    }

    public function getPosition()
    {

        $positions = Position::select('id', 'name_position', 'salary_position')
            ->where('id', '>', 9)
            ->orderBy('name_position')->get();

        PositionResource::withoutWrapping();
        return PositionResource::collection($positions);
    }



    public function storPhoto(Request $request)
    {

        //$path = $request->file('file')->store('/public/photos');

        $path = Storage::putFile('/public/photos', $request->file('file'));
        return $path;
    }

    public function search(Request $request)
    {
        //----search --fio and position
        if (!empty($request->keywords) && !empty($request->selectedPosit)) {
            $keyword = $request->keywords;
            $namePosition = $request->selectedPosit;
            $positionId = Position::select('id')
                ->where('name_position', $namePosition)->first();
            $employes = Employe::with('position', 'department')
                ->where('full_name', 'like',  $keyword . '%')
                ->where('id_positione', $positionId->id)
                // ->orderBy($order)
                ->paginate(10);

            return  EmployeResource::collection($employes);

            //------search ----- only------fio
        } elseif (!empty($request->keywords)) {
            $keyword = $request->keywords;
            $employes = Employe::with('position', 'department')
                ->where('full_name', 'like',  $keyword . '%')

                // ->orderBy($order)
                ->paginate(10);

            return  EmployeResource::collection($employes);

            //-------search----only--position
        } elseif (!empty($request->selectedPosit)) {
            $namePosition = $request->selectedPosit;
            $positionId = Position::select('id')
                ->where('name_position', $namePosition)->first();

            $employes = Employe::with('position', 'department')
                ->where('id_positione', $positionId->id)
                //->orderBy('full_name')
                ->paginate(10);

            return  EmployeResource::collection($employes);
            //--------search ---only----date
        } elseif (!empty($request->saerchDate)) {
            $dateMy = date("Y-m-d", strtotime($request->saerchDate));
            $employes = Employe::with('position', 'department')
                ->where('employment', ">=",  $dateMy)
                ->orderBy('employment')
                ->paginate(10);
            return  EmployeResource::collection($employes);

            //----------search -----only----Salary
        } elseif (!empty($request->saerchSalary)) {
            $salaryPosition = (int) $request->saerchSalary;
            $searhSalaryId = Position::where('salary_position', ">=", $salaryPosition)
                ->where('salary_position', "<", 2500)
                ->pluck("id")
                ->toArray();

            $employes = Employe::with('position', 'department')
                ->whereIn('id_positione', $searhSalaryId)
                ->orderBy('id_positione', 'desc', 'ratio')
                ->paginate(10);
            return  EmployeResource::collection($employes);

            //------search only-----headDepart.....
        } elseif (!empty($request->selectedDepart)) {
            $nameDepart = $request->selectedDepart;
            $departId = Department::select('id')
                ->where('name_head_depart', $nameDepart)->first();

            $employes = Employe::with('position', 'department')
                ->where('id_departament', $departId->id)
                ->orderBy('full_name')
                ->paginate(10);
            return  EmployeResource::collection($employes);
            //----------default-------

        } else {

            $employes = Employe::with('position', 'department')
                ->orderBy('full_name')
                ->paginate(10);

            return  EmployeResource::collection($employes);
            //return response()->json($employes);
        }
    }
}
