<?php

namespace App\Http\Controllers;

use App\Models\CustomerReport;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class CustomerReportController extends Controller
{

    public function index()
    {
        $reports = CustomerReport::where('ctype', 'followUp')->get();
        // dd($reports->all());
        return view('admin.report.index', compact('reports'));
    }


    public function create()
    {
        return view('admin.report.create');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'cname' => 'required',
        ]);
        $report = new CustomerReport();
        $report->fill($request->all());
        if ($request->visiting_card != null) {
            $fileName = time() . '.' . $request->visiting_card->extension();
            $request->visiting_card->move(storage_path('app/public/visitingCard'), $fileName);
            $report->visiting_card = $fileName;
        }
        $report->save();


        Toastr::success('Information Added Successful!.', '', ["progressbar" => true]);
        return redirect()->route('pendingList');
    }


    public function show(CustomerReport $customerReport)
    {
        //
    }


    public function edit(CustomerReport $customerReport)
    {
        //
    }


    public function update(Request $request, CustomerReport $customerReport)
    {
        $report = CustomerReport::find($customerReport);
        $report->fill($request->all());
        $report->update();
        return redirect()->route('report.index');
    }


    public function destroy(CustomerReport $customerReport)
    {
        $report = CustomerReport::find($customerReport);
        $report->delete();
        Toastr::success('Information Deleted Successful!.', '', ["progressbar" => true]);
        return redirect()->route('report.index');
    }

    public function pendingList()
    {
        $pendingList = CustomerReport::where('ctype', 'new')->get();
        return view('admin.report.pending', [
            'pendingList' => $pendingList,
        ]);
    }


    public function approve($id)
    {
        $report = CustomerReport::find($id);
        $report->ctype = 'followup';
        $report->save();
        return redirect()->route('report.index')->with('message', 'report unpublished successfully');
    }

    public function cancel($id)
    {
        $report = CustomerReport::find($id);
        $report->delete();
        Toastr::success('Information Canceled Successful!.', '', ["progressbar" => true]);
        return redirect()->route('report.index');
    }

    
}