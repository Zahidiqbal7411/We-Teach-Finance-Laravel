<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Excel; // old 1.x syntax
use PDF;

class ExportController extends Controller
{
    // Export Excel
    public function exportExcel(Request $request)
    {
        $sessionId = $request->session_id;

        $transactions = Transaction::query();
        if ($sessionId) {
            $transactions->where('session_id', $sessionId);
        }
        $transactions = $transactions->get();

        $data = [];
        // Header row
        $data[] = ['ID','Teacher','Course','Session','Student','Parent','Total','Paid Amount'];

        foreach ($transactions as $t) {
            $data[] = [
                $t->id,
                $t->teacher_id,
                $t->course_id,
                $t->session_id,
                $t->student_name,
                $t->parent_name,
                $t->total,
                $t->paid_amount,
            ];
        }

        // Excel 1.x syntax
        return Excel::create('transactions', function($excel) use ($data) {
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    // Export PDF
    public function exportPDF(Request $request)
    {
        $sessionId = $request->session_id;

        $transactions = Transaction::query();
        if ($sessionId) {
            $transactions->where('session_id', $sessionId);
        }
        $transactions = $transactions->get();

        // Make sure the view exists: resources/views/pdf/transactions.blade.php
        return PDF::loadView('pdf.transactions', compact('transactions'))
            ->setPaper('a4', 'landscape')
            ->download('transactions.pdf');
    }
}
