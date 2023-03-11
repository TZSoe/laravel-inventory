<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Propaganistas\LaravelPhone\PhoneNumber;

class SupplierController extends Controller
{
    public function allSupplier()
    {
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all', compact('suppliers'));
    }

    public function createSupplier()
    {
        return view('backend.supplier.supplier_create');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'mobile_no' => 'phone:MM'
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'mobile_no' => (string) new PhoneNumber($request->mobile_no, 'MM'),
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => auth()->user()->id
        ]);

        $notification = array(
            'message' => 'Supplier created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }


    public function editSupplier(Supplier $supplier)
    {
        return view('backend.supplier.supplier_edit', compact('supplier')); 
    }

    public function updateSupplier(Request $request, Supplier $supplier)
    {
        $request->validate([
            'mobile_no' => 'phone:MM'
        ]);

        $supplier = $supplier->update([
            'name' => $request->name,
            'mobile_no' => (string) new PhoneNumber($request->mobile_no, 'MM'),
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => auth()->user()->id
        ]);

        $notification = array(
            'message' => 'Supplier updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }


    public function deleteSupplier(Supplier $supplier)
    {
        $supplier->delete();

        $notification = array(
            'message' => 'Supplier deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
