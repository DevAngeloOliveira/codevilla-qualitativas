<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Usuarios\Models\User;
use App\Domains\Usuarios\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfessorController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->userService->query()->where('role', 'professor');

        // Busca
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $professores = $query->orderBy('name')->paginate(15);

        return Inertia::render('Admin/Professores/Index', [
            'professores' => $professores,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Professores/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['role'] = 'professor';

        $this->userService->create($validated);

        return redirect()->route('admin.professores.index')
            ->with('success', 'Professor criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $professore)
    {
        return Inertia::render('Admin/Professores/Show', [
            'professor' => $professore,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $professore)
    {
        return Inertia::render('Admin/Professores/Edit', [
            'professor' => $professore,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $professore)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($professore->id)],
            'is_active' => 'boolean',
        ]);

        // Atualizar senha apenas se fornecida
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $professore->update($validated);

        return redirect()->route('admin.professores.index')
            ->with('success', 'Professor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $professore)
    {
        $professore->delete();

        return redirect()->route('admin.professores.index')
            ->with('success', 'Professor removido com sucesso!');
    }
}
