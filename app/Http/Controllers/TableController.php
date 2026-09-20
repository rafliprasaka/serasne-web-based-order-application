<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        $title = 'Tables';
        $tables = Table::all();

        return view('admin.table.index', compact('title', 'tables'));
    }

    public function create()
    {
        $title = 'Add Table';

        return view('admin.table.form', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_name' => 'required|string|max:255',
        ]);

        Table::create($request->all());

        return redirect()->route('tables.index')->with('success', 'Table created successfully.');
    }

    public function edit(Table $table)
    {
        $title = 'Edit Table';

        return view('admin.table.form', compact('title', 'table'));
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'table_name' => 'required|string|max:255',
        ]);

        $table->update($request->all());

        return redirect()->route('tables.index')->with('success', 'Table updated successfully.');
    }

    public function destroy(Table $table)
    {
        // if ($table->products()->count() > 0) {
        //     // Return a message or handle the alert in your frontend
        //     return back()->with('error', 'Cannot delete this table because it contains products.');
        // }

        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Table deleted successfully.');
    }

    public function generateQrCode($tableId)
    {
        $title = 'Table '.$tableId;
        $url = route('menu', ['table' => $tableId]);
        $qrCode = QrCode::size(200)->generate($url);

        $table = Table::findOrFail($tableId);
        $table->update(['status' => 'open']);

        return view('admin.table.qr', compact('qrCode', 'title', 'url'));
    }
}
