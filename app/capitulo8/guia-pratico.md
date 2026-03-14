# Onde validar dados em Clean Architecture / Hexagonal

## Guia prático

Uma dúvida muito comum quando estudamos **DDD, Clean Architecture ou Arquitetura Hexagonal** é:

> **Onde exatamente devem ficar as validações?**

Se colocarmos validação em qualquer lugar, surgem problemas como:

* regras duplicadas
* domínio recebendo dados inválidos
* acoplamento entre camadas
* lógica de negócio espalhada

A boa prática é **separar os tipos de validação por responsabilidade arquitetural**.

---

# 1. Os dois tipos de validação

Primeiro precisamos entender que **nem toda validação é igual**.

Existem **dois tipos principais**:

## 1️⃣ Validação de formato (input validation)

Verifica se **os dados recebidos fazem sentido estruturalmente**.

Exemplos:

* campo obrigatório
* email válido
* CPF com formato correto
* número positivo
* string não vazia

Essas validações **não são regras de negócio**, apenas garantem que o sistema recebeu dados utilizáveis.

Exemplo:

```
email inválido
telefone vazio
campo obrigatório
```

---

## 2️⃣ Validação de regra de negócio

Essas sim são **regras do domínio**.

Exemplos:

* cliente menor de idade precisa responsável
* imposto mínimo de 1%
* pedido precisa ter pelo menos um item
* cliente não pode comprar se estiver bloqueado

Essas regras fazem parte da **lógica do sistema**.

---

# 2. Onde cada validação deve ficar

A separação ideal costuma ser:

```
Interface / Controller
      │
      ▼
Validação de formato (input)
      │
      ▼
Application / Use Case
      │
      ▼
Domínio
Validação de regras de negócio
```

---

# 3. Validação na camada de Interface (Controller / Adapter)

Essa camada recebe dados de fora:

* HTTP
* API
* CLI
* fila
* formulário

Aqui devemos **limpar e validar o input**.

Exemplo em PHP:

```php
class CriarUsuarioController
{
    public function executar(array $request)
    {
        if (empty($request['email'])) {
            throw new InvalidArgumentException("Email obrigatório");
        }

        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido");
        }

        $dto = new CriarUsuarioDTO(
            $request['nome'],
            $request['email']
        );

        return $this->useCase->executar($dto);
    }
}
```

Responsabilidade aqui:

* validar formato
* converter dados
* criar DTOs

**Não colocar regra de negócio aqui.**

---

# 4. Validação na camada de Application (Use Cases)

A camada de **Application** coordena o fluxo do sistema.

Ela pode validar **regras de processo**, como:

* verificar se entidade existe
* verificar permissões
* orquestrar serviços

Exemplo:

```php
class CriarPedidoUseCase
{
    public function executar(CriarPedidoDTO $dto)
    {
        $cliente = $this->clienteRepositorio->buscar($dto->clienteId);

        if (!$cliente) {
            throw new Exception("Cliente não encontrado");
        }

        $pedido = new Pedido($cliente);

        // delega regra ao domínio
        $pedido->adicionarItem($dto->item);

        $this->pedidoRepositorio->salvar($pedido);
    }
}
```

Aqui o **use case coordena**, mas **não carrega regras profundas**.

---

# 5. Validação no Domínio (a mais importante)

O domínio deve garantir **consistência do modelo**.

Ou seja:

> Um objeto de domínio nunca deve existir em estado inválido.

Exemplo:

```php
class CPF
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        if (!self::valido($cpf)) {
            throw new InvalidArgumentException("CPF inválido");
        }

        $this->cpf = $cpf;
    }

    private static function valido(string $cpf): bool
    {
        return strlen($cpf) === 11;
    }
}
```

Outro exemplo:

```php
class Pedido
{
    private array $itens = [];

    public function adicionarItem(Item $item): void
    {
        if ($item->quantidade() <= 0) {
            throw new DomainException("Quantidade inválida");
        }

        $this->itens[] = $item;
    }
}
```

Aqui o **domínio protege suas regras**.

---

# 6. Validação com Value Objects (tiny types)

Uma estratégia muito usada é **encapsular validação em Value Objects**.

Exemplo:

```php
class Email
{
    public function __construct(private string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido");
        }
    }

    public function valor(): string
    {
        return $this->email;
    }
}
```

Agora qualquer lugar que usar `Email` **já recebe um valor válido**.

---

# 7. Fluxo completo de validação

Um fluxo típico fica assim:

```
HTTP Request
     │
     ▼
Controller
(validação de formato)
     │
     ▼
DTO
     │
     ▼
Use Case
(validação de processo)
     │
     ▼
Domínio
(validação de regras de negócio)
     │
     ▼
Repository
```

Esse fluxo garante que:

* dados inválidos **não entram no domínio**
* regras de negócio **ficam no domínio**
* arquitetura **permanece desacoplada**

---

# 8. Erros comuns em projetos reais

## ❌ Colocar todas validações no Controller

Problema:

* lógica duplicada
* domínio frágil

---

## ❌ Colocar validação apenas no banco

Exemplo:

```
NOT NULL
CHECK
```

Problema:

* regra fica fora do código
* difícil testar

---

## ❌ Domínio aceitar estado inválido

Exemplo ruim:

```php
class Usuario
{
    public string $email;
}
```

Qualquer valor pode entrar.

---

# 9. Regra prática

Uma regra simples usada em muitos projetos:

| Tipo de validação  | Onde fica            |
| ------------------ | -------------------- |
| Formato de input   | Controller / Adapter |
| Conversão de dados | DTO                  |
| Fluxo da aplicação | Use Case             |
| Regras de negócio  | Domínio              |

---

# Conclusão

Em arquiteturas como **Clean Architecture e Hexagonal**, a separação de validações segue uma ideia central:

> **O domínio deve proteger suas regras, mas não limpar dados externos.**

Resumo:

* **Adapters / Controllers** → validam dados externos
* **Use Cases** → coordenam o fluxo
* **Domínio** → garante regras de negócio

Quando isso é seguido, o sistema ganha:

* maior segurança
* melhor testabilidade
* domínio mais consistente
* menor acoplamento entre camadas
