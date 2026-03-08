# 🏗️ Herança em Clean Architecture / Hexagonal

Arquiteturas modernas como **Clean Architecture** e **Arquitetura Hexagonal** não proíbem herança. Porém, elas naturalmente incentivam **composição, interfaces e inversão de dependência** em vez de grandes hierarquias.

Isso acontece porque essas arquiteturas são orientadas a **políticas de negócio e fronteiras de dependência**, não a árvores de classes.

---

# 1. Onde herança aparece nessas arquiteturas

Herança costuma aparecer em três lugares principais:

## 1️⃣ Classes de infraestrutura

Exemplo comum: frameworks.

```php
abstract class TesteComSelenium
{
    protected WebDriver $driver;

    public function __construct(WebDriver $driver)
    {
        $this->driver = $driver;
    }

    protected function preencher(string $id, string $valor)
    {
        $this->driver->findElement($id)->sendKeys($valor);
    }
}
```

Aqui a herança serve para **reutilização de infraestrutura**, não para modelar domínio.

---

## 2️⃣ Pequenas hierarquias de domínio bem definidas

Exemplo:

```php
abstract class MeioDePagamento
{
    abstract public function pagar(float $valor): void;
}

class CartaoCredito extends MeioDePagamento
{
    public function pagar(float $valor): void
    {
        // lógica
    }
}

class Boleto extends MeioDePagamento
{
    public function pagar(float $valor): void
    {
        // lógica
    }
}
```

Aqui existe uma relação clara:

```
CartaoCredito é um MeioDePagamento
Boleto é um MeioDePagamento
```

Se o **LSP for respeitado**, essa herança é saudável.

---

## 3️⃣ Adaptadores de framework

Em Hexagonal Architecture é comum adaptar APIs externas.

```php
class PedidoController extends BaseController
{
    public function criar()
    {
        // chama use case
    }
}
```

Mas note:

👉 Isso fica **na borda do sistema**, não no domínio.

---

# 2. Onde herança NÃO deve aparecer

No **domínio central** geralmente evitamos herança profunda.

Domínio costuma usar:

- composição
- interfaces
- estratégias
- policies

Exemplo típico:

```php
class CalculadoraDeFrete
{
    public function __construct(private CalculadoraDistancia $distancia) {}

    public function calcular(Pedido $pedido)
    {
        return $this->distancia->entre(
            $pedido->origem(),
            $pedido->destino()
        );
    }
}
```

Aqui usamos **composição**, o que facilita:

- testes
- troca de implementação
- isolamento de regras

---

# 3. Por que composição domina essas arquiteturas

Herança cria **acoplamento vertical**.

```
ClasseFilha
     ↓
ClassePai
```

Composição cria **acoplamento horizontal mais flexível**.

```
Classe A → Interface B
Classe C → Interface B
```

Isso se encaixa perfeitamente com **DIP**.

---

# ⚠️ Anti-patterns de herança comuns em projetos reais

Existem alguns padrões ruins que aparecem frequentemente.

---

# 1. God Base Class

Uma classe base gigante usada por todo o sistema.

```php
abstract class BaseService
{
    protected Logger $logger;
    protected Database $db;
    protected Cache $cache;

    protected function log(string $msg) {}
    protected function salvar() {}
    protected function limparCache() {}
}
```

Todas as classes passam a herdar dela.

Problemas:

- acoplamento massivo
- difícil de testar
- mudanças quebram muitas classes

---

# 2. Herança apenas para reutilizar código

Exemplo ruim:

```php
class CalculadoraDeImposto extends Matematica
{
}
```

Aqui não existe relação conceitual.

A classe só herda para usar métodos utilitários.

Correto seria:

```php
class CalculadoraDeImposto
{
    public function __construct(private Matematica $matematica) {}
}
```

---

# 3. Hierarquias profundas

Exemplo real que aparece muito:

```
Entity
 ↓
Pessoa
 ↓
Funcionario
 ↓
Gerente
 ↓
Diretor
```

Cada nível adiciona comportamento.

Problema:

- mudanças no topo impactam tudo
- difícil entender responsabilidades

Arquiteturas modernas preferem:

```
Funcionario
 + Cargo
 + PoliticaDeBonus
```

Usando composição.

---

# 4. Subclasses que quebram comportamento

Violação clássica de LSP.

Exemplo:

```php
class ContaComum
{
    public function rende() {}
}

class ContaEstudante extends ContaComum
{
    public function rende()
    {
        throw new Exception();
    }
}
```

Isso quebra qualquer código que espera o comportamento da classe base.

---

# 5. Template Method mal usado

Template Method é um padrão válido, mas frequentemente vira um problema.

```php
abstract class Relatorio
{
    public function gerar()
    {
        $this->coletarDados();
        $this->formatar();
        $this->exportar();
    }

    abstract protected function coletarDados();
}
```

Se muitas subclasses precisarem alterar o fluxo, o design quebra.

Nesse caso **Strategy** ou **Composition** seria melhor.

---

# 6. BaseController / BaseService gigantes

Frameworks incentivam isso.

```php
class PedidoController extends BaseController
```

Com o tempo o BaseController vira um depósito de funcionalidades.

Resultado:

- dependências invisíveis
- código difícil de evoluir

---

# 🧠 Regra prática moderna

Hoje muitas equipes seguem uma regra simples:

> Prefira composição. Use herança apenas quando o modelo conceitual exigir.

Ou ainda:

```
Favor Composition over Inheritance
```

---

# 📌 Checklist rápido para decidir

Pergunte:

1️⃣ Existe realmente relação "é um"?

2️⃣ A subclasse respeita completamente o comportamento da classe pai?

3️⃣ O sistema funcionaria se eu substituir o pai pelo filho?

4️⃣ A herança está modelando domínio ou apenas reutilizando código?

Se a resposta da última pergunta for **reutilização**, use composição.

---

# Conclusão

Herança continua sendo uma ferramenta importante da orientação a objetos.

Mas arquiteturas modernas usam ela **com muito mais cuidado**.

A regra geral hoje é:

- domínio → composição
- infraestrutura → herança ocasional

Isso reduz acoplamento, facilita testes e torna o sistema mais evolutivo.

