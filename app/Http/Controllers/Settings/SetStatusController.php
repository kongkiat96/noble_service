<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\getAccessToMenu;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\AllValidator;
use App\Models\Master\getDataMasterModel;
use App\Models\Settings\SetStatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetStatusController extends Controller
{
    private $setStatusModel;
    private $getMaster;
    private $funcValidator;

    public function __construct()
    {
        $this->setStatusModel   = new SetStatusModel;
        $this->getMaster        = new getDataMasterModel;
        $this->funcValidator    = new AllValidator;
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url        = request()->segments();
        $urlName    = "ตั้งค่าสถานะงาน";
        $urlSubLink = "work-status";
        
        if (!getAccessToMenu::hasAccessToMenu($urlSubLink)) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงเมนู');
        }
        $getAccessMenus = getAccessToMenu::getAccessMenus();

        return view('app.settings.work-status.setStatus', [
            'url'           => $url,
            'urlName'       => $urlName,
            'urlSubLink'    => $urlSubLink,
            'listMenus'     => $getAccessMenus
        ]);
    }

    public function showStatusModal()
    {
        if (request()->ajax()) {
            $getDataGroupStatus = $this->getMaster->getDataGroupStatus();
            // dd($getDataGroupStatus);
            return view('app.settings.work-status.dialog.save.addStatus', [
                'dataGroupStatus'        => $getDataGroupStatus,
            ]);
        }
        return abort(404);
    }

    public function showFlagTypeModal()
    {
        if (request()->ajax()) {
            return view('app.settings.work-status.dialog.save.addFlagType');
        }
        return abort(404);
    }

    public function showGroupStatusModal()
    {
        if (request()->ajax()) {
            return view('app.settings.work-status.dialog.save.addGroupStatus');
        }
        return abort(404);
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

    public function saveDataStatus(Request $request)
    {
        $validator = $this->funcValidator->validateSettingWorkStatus($request->input(), 'funcAddStatus');

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()], 400);
        }

        $saveData = $this->setStatusModel->saveDataStatus($request->input());
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function showEditStatus($statusID)
    {
        if (request()->ajax()) {
            $getFlagType     = $this->getMaster->getDataFlagType();
            $returnData = $this->setStatusModel->showEditStatus($statusID);
            return view('app.settings.work-status.dialog.edit.editStatus', [
                'getFlagType'        => $getFlagType,
                'dataStatus'     => $returnData
            ]);
        }
        return abort(404);
    }

    public function editStatus(Request $request, $statusID)
    {
        $validator = $this->funcValidator->validateSettingWorkStatus($request->input(), 'funcEditStatus');
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()], 400);
        }

        $saveData = $this->setStatusModel->editStatus($request->input(), $statusID);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function deleteStatus($statusID)
    {
        $deleteData = $this->setStatusModel->deleteStatus($statusID);
        return response()->json(['status' => $deleteData['status'], 'message' => $deleteData['message']]);
    }

    public function saveDataFlagType(Request $request)
    {
        $validator = $this->funcValidator->validateSettingWorkStatus($request->input(), 'funcAddFlagType');
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()], 400);
        }

        $saveData = $this->setStatusModel->saveDataFlagType($request->input());
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function showEditFlagType($flagTypeID)
    {
        if (request()->ajax()) {
            $returnData = $this->setStatusModel->showEditFlagType($flagTypeID);
            // dd($returnData);
            return view('app.settings.work-status.dialog.edit.editFlagType', [
                'dataFlagType'     => $returnData
            ]);
        }
        return abort(404);
    }

    public function editFlagType(Request $request, $flagTypeID)
    {
        $validator = $this->funcValidator->validateSettingWorkStatus($request->input(), 'funcEditFlagType');
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()], 400);
        }

        $saveData = $this->setStatusModel->editFlagType($request->input(), $flagTypeID);
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function deleteFlagType($flagTypeID)
    {
        $deleteData = $this->setStatusModel->deleteFlagType($flagTypeID);
        return response()->json(['status' => $deleteData['status'], 'message' => $deleteData['message']]);
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

    public function showDataStatus(Request $request)
    {
        $getDataToTable = $this->setStatusModel->gatDataStatus($request);
        return response()->json($getDataToTable);
    }

    public function showDataFlagType(Request $request)
    {
        $getDataToTable = $this->setStatusModel->gatDataFlagType($request);
        return response()->json($getDataToTable);
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

    public function saveDataGroupStatus(Request $request)
    {
        $saveData = $this->setStatusModel->saveDataGroupStatus($request->input());
        return response()->json(['status' => $saveData['status'], 'message' => $saveData['message']]);
    }

    public function showDataGroupStatus(Request $request)
    {
        $getDataToTable = $this->setStatusModel->gatDataGroupStatus($request);
        return response()->json($getDataToTable);
    }

    public function showEditGroupStatus($groupStatusID)
    {
        if (request()->ajax()) {
            // dd($groupStatusID);
            $getDataGroupStatus = $this->setStatusModel->getDataGroupStatusByID($groupStatusID);

            return view('app.settings.work-status.dialog.edit.editGroupStatus', [
                'dataGroupStatus' => $getDataGroupStatus,
                'id'    => encrypt($groupStatusID)
            ]);
        }
        return abort(404);
    }

    public function editGroupStatus(Request $request, $groupStatusID)
    {
        $editData = $this->setStatusModel->editGroupStatus($request->input(), $groupStatusID);
        return response()->json(['status' => $editData['status'], 'message' => $editData['message']]);
    }

    public function deleteGroupStatus($groupStatusID)
    {
        $deleteData = $this->setStatusModel->deleteGroupStatus($groupStatusID);
        // dd($deleteData);
        return response()->json(['status' => $deleteData['status'], 'message' => $deleteData['message']]);
    }
        
}
