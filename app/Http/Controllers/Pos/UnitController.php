<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function allUnits()
    {
        $units = Unit::latest()->get();
        return view('backend.unit.unit_all', compact('units'));
    }

    public function createUnit()
    {
        return view('backend.unit.unit_create');
    }

    public function storeUnit(Request $request)
    {
        Unit::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id
        ]);

        $notification = array(
            'message' => 'Unit created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('unit.all')->with($notification);
    }

    public function editUnit(Unit $unit)
    {
        return view('backend.unit.unit_edit', compact('unit')); 
    }

    public function updateUnit(Request $request, Unit $unit)
    {
        $unit->update([
            'name' => $request->name,
            'updated_by' => auth()->user()->id
        ]);

        $notification = array(
            'message' => 'Unit updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('unit.all')->with($notification);
    }


    public function deleteUnit(Unit $unit)
    {
        $unit->delete();

        $notification = array(
            'message' => 'Unit deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
