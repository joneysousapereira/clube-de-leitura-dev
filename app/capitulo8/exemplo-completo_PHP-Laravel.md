# Exemplo Completo de Validação em Clean Architecture com PHP (estilo Laravel)

Este exemplo mostra um **fluxo realista** de validação em um sistema PHP usando conceitos de **Clean Architecture / Hexagonal**, inspirado em como projetos modernos com **Laravel** costumam ser organizados.

Fluxo que vamos implementar:

```
Controller
   ↓
Request Validation
   ↓
DTO
   ↓
Use Case
   ↓
Domain (Entity / Value Object)
   ↓
Repository
```

Objetivo: **criar um usuário no sistema**.

---

# Estrutura de diretórios

Um projeto organizado poderia ter algo assim:

```
app
 ├── Http
 │   ├── Controllers
 │   │    └── CriarUsuarioController.php
 │   └── Requests
 │        └── CriarUsuarioRequest.php
 │
 ├── Application
 │   ├── DTO
 │   │    └── CriarUsuarioDTO.php
 │   └── UseCases
 │        └── CriarUsuarioUseCase.php
 │
 ├── Domain
 │   ├── Entities
 │   │    └── Usuario.php
 │   ├── ValueObjects
 │   │    └── Email.php
 │   └── Repositories
 │        └── UsuarioRepository.php
 │
 └── Infrastructure
      └── Persistence
           └── UsuarioRepositoryMySQL.php
```

---

# 1. Controller (Adapter)

Responsável por **receber a requisição HTTP**.

```php
class CriarUsuarioController
{
    public function __construct(
        private CriarUsuarioUseCase $useCase
    ) {}

    public function __invoke(CriarUsuarioRequest $request)
    {
        $dto = new CriarUsuarioDTO(
            $request->nome,
            $request->email
        );

        $usuario = $this->useCase->executar($dto);

        return response()->json([
            'id' => $usuario->id(),
            'nome' => $usuario->nome()
        ]);
    }
}
```

Responsabilidade:

✔ receber request
✔ transformar em DTO
✔ chamar o use case

---

# 2. Request Validation (Laravel)

Aqui acontece **validação de formato**.

```php
class CriarUsuarioRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nome' => ['required', 'string'],
            'email' => ['required', 'email']
        ];
    }
}
```

Aqui validamos:

* campo obrigatório
* formato de email
* tipo de dado

Essas **não são regras de negócio**, apenas validação de input.

---

# 3. DTO

Transporta dados entre camadas.

```php
class CriarUsuarioDTO
{
    public function __construct(
        public string $nome,
        public string $email
    ) {}
}
```

DTOs **não possuem lógica**.

---

# 4. Use Case (Application Layer)

Coordena o fluxo da aplicação.

```php
class CriarUsuarioUseCase
{
    public function __construct(
        private UsuarioRepository $repositorio
    ) {}

    public function executar(CriarUsuarioDTO $dto): Usuario
    {
        $email = new Email($dto->email);

        $usuario = new Usuario(
            nome: $dto->nome,
            email: $email
        );

        $this->repositorio->salvar($usuario);

        return $usuario;
    }
}
```

Responsabilidade:

✔ orquestrar fluxo
✔ criar entidades do domínio
✔ chamar repository

---

# 5. Value Object (Domínio)

Aqui protegemos **regras de consistência**.

```php
class Email
{
    private string $valor;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido");
        }

        $this->valor = $email;
    }

    public function valor(): string
    {
        return $this->valor;
    }
}
```

Agora **não existe Email inválido no domínio**.

---

# 6. Entity de Domínio

```php
class Usuario
{
    private int $id;

    public function __construct(
        private string $nome,
        private Email $email
    ) {}

    public function nome(): string
    {
        return $this->nome;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function id(): int
    {
        return $this->id;
    }
}
```

---

# 7. Repository Interface (Domínio)

O domínio define **apenas a abstração**.

```php
interface UsuarioRepository
{
    public function salvar(Usuario $usuario): void;
}
```

Isso segue o **DIP (Dependency Inversion Principle)**.

---

# 8. Implementação de Infraestrutura

```php
class UsuarioRepositoryMySQL implements UsuarioRepository
{
    public function salvar(Usuario $usuario): void
    {
        DB::table('usuarios')->insert([
            'nome' => $usuario->nome(),
            'email' => $usuario->email()->valor()
        ]);
    }
}
```

---

# Fluxo completo

```
HTTP Request
     │
     ▼
Laravel Request Validation
     │
     ▼
Controller
     │
     ▼
DTO
     │
     ▼
Use Case
     │
     ▼
Domain (Entity + Value Object)
     │
     ▼
Repository
     │
     ▼
Banco de Dados
```

---

# Onde cada validação acontece

| Camada     | Tipo de validação      |
| ---------- | ---------------------- |
| Request    | formato de dados       |
| Controller | transformação de dados |
| DTO        | transporte             |
| Use Case   | fluxo da aplicação     |
| Domain     | regras de negócio      |
| Repository | persistência           |

---

# Benefícios desse modelo

✔ domínio protegido
✔ código mais testável
✔ baixo acoplamento
✔ regras centralizadas
✔ fácil evolução do sistema

---

# Relação com o Capítulo VIII

Esse capítulo do livro enfatiza:

* consistência dos objetos
* uso de construtores
* validação no domínio
* tiny types (value objects)

Nesse exemplo:

* `Email` é um **Tiny Type**
* `Usuario` garante **consistência do domínio**
* `Request` limpa dados externos
* `UseCase` orquestra o processo

Ou seja, **o domínio nunca recebe dados sujos**.

---

# Conclusão

Uma boa separação de validações em **Clean Architecture / Hexagonal** segue esta regra:

> **Dados externos são validados na borda do sistema.
> Regras de negócio são protegidas no domínio.**

Quando isso é respeitado, o sistema fica:

* mais robusto
* mais testável
* mais fácil de evoluir
* mais alinhado ao domínio.