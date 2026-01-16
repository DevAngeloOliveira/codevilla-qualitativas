<?php

namespace App\Domains\Usuarios\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Domains\Alunos\Models\Turma;
use App\Domains\Avaliacoes\Models\Avaliacao;
use App\Domains\Disciplinas\Models\Disciplina;
use Database\Factories\UserFactory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    // Relacionamentos
    public function disciplinas(): BelongsToMany
    {
        return $this->belongsToMany(Disciplina::class, 'professor_turma', 'user_id', 'disciplina_id')
            ->withPivot(['turma_id', 'ano_letivo'])
            ->distinct();
    }

    public function turmas(): BelongsToMany
    {
        return $this->belongsToMany(Turma::class, 'professor_turma', 'user_id', 'turma_id')
            ->withPivot(['disciplina_id', 'ano_letivo']);
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'professor_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeProfessores($query)
    {
        return $query->where('role', 'professor');
    }

    public function scopeCoordenacao($query)
    {
        return $query->where('role', 'coordenacao');
    }

    public function scopeDesenvolvedor($query)
    {
        return $query->where('role', 'desenvolvedor');
    }

    // Helpers
    public function isProfessor(): bool
    {
        return $this->role === 'professor';
    }

    public function isCoordenacao(): bool
    {
        return $this->role === 'coordenacao';
    }

    public function isDesenvolvedor(): bool
    {
        return $this->role === 'desenvolvedor';
    }
}
