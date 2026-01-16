<?php

namespace App\Http\Controllers\Desenvolvedor;

use App\Http\Controllers\Controller;
use App\Domains\Usuarios\Models\User;
use App\Domains\Usuarios\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index(Request $request)
    {
        $query = $this->userService->query();

        // Filtro por role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Busca
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('name')->paginate(15);

        return Inertia::render('Desenvolvedor/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['role', 'search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Desenvolvedor/Users/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['professor', 'coordenacao', 'desenvolvedor'])],
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $validated['is_active'] ?? true;

        $this->userService->create($validated);

        return redirect()->route('desenvolvedor.users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        return Inertia::render('Desenvolvedor/Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['professor', 'coordenacao', 'desenvolvedor'])],
            'is_active' => 'boolean',
        ]);

        // Atualizar senha apenas se fornecida
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('desenvolvedor.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        // Não permitir deletar o próprio usuário
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Você não pode deletar sua própria conta!');
        }

        $user->delete();

        return redirect()->route('desenvolvedor.users.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }
}
