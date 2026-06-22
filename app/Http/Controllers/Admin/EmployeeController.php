<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Unit;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of employees.
     */
    public function index(Unit $unit): View
    {
        $employees = $unit->employees()
            ->orderBy('order_number')
            ->orderBy('nama')
            ->paginate(15);

        return view('admin.employees.index', compact('unit', 'employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create(Unit $unit): View
    {
        return view('admin.employees.create', compact('unit'));
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:255'],
            'jabatan'      => ['required', 'string', 'max:255'],
            'order_number' => ['required', 'integer', 'min:0', 'max:9999'],
            'photo'        => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['photo', '_token']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->fileUploadService->uploadImage(
                $request->file('photo'),
                $unit->id,
                'employees'
            );
        }

        $unit->employees()->create($data);

        return redirect()->route('admin.employees.index', $unit)
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Unit $unit, Employee $employee): View
    {
        if ($employee->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.employees.edit', compact('unit', 'employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Unit $unit, Employee $employee): RedirectResponse
    {
        if ($employee->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:255'],
            'jabatan'      => ['required', 'string', 'max:255'],
            'order_number' => ['required', 'integer', 'min:0', 'max:9999'],
            'photo'        => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['photo', '_token', '_method']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->fileUploadService->uploadImage(
                $request->file('photo'),
                $unit->id,
                'employees',
                $employee->photo
            );
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index', $unit)
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Unit $unit, Employee $employee): RedirectResponse
    {
        if ($employee->unit_id !== $unit->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $this->fileUploadService->deleteFile($employee->photo);

        $employee->delete();

        return redirect()->route('admin.employees.index', $unit)
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}
