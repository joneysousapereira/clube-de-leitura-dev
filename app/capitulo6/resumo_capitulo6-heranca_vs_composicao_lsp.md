# 📘 Capítulo VI — Herança vs Composição e o Princípio de Substituição de Liskov (LSP)

Nos primeiros anos da programação orientada a objetos, **herança era a grande estrela**. Muitas linguagens vendiam OO como a capacidade de criar hierarquias de classes.

Com o tempo, ficou claro que **herança mal utilizada cria sistemas frágeis e fortemente acoplados**.

Esse capítulo apresenta dois conceitos centrais:

- Princípio de Substituição de Liskov (LSP)
- Preferir composição em vez de herança

---

# 1. O Princípio de Substituição de Liskov (LSP)

O LSP diz:

> Objetos de uma classe filha devem poder substituir objetos da classe pai sem quebrar o comportamento esperado do sistema.

Em outras palavras:

Se uma função espera um objeto do tipo **A**, ela também deve funcionar corretamente se receber um objeto do tipo **B**, onde **B herda de A**.

Se isso não for verdade, a herança está incorreta.

---

# 2. Pré‑condições e Pós‑condições

Toda função possui:

### Pré‑condições
Condições que devem ser verdadeiras **antes** da execução.

Exemplo:

```php
public function depositar(float $valor)
{
    if ($valor <= 0) {
        throw new ValorInvalidoException();
    }
}
```

A pré‑condição é: **o valor precisa ser positivo**.

### Pós‑condições
Condições que devem ser verdadeiras **depois** da execução.

Exemplo:

```php
$this->saldo += $valor;
```

Após executar, o saldo precisa ter aumentado.

---

# 3. Regras do LSP

Quando uma classe filha sobrescreve comportamento:

### Pré‑condições
A classe filha **só pode afrouxar a pré‑condição**.

Ou seja, aceitar mais casos.

Nunca exigir mais do que o pai.

---

### Pós‑condições
A classe filha **só pode apertar a pós‑condição**.

Ou seja, garantir pelo menos o que o pai garantia.

---

# 4. Exemplo problemático (Conta que não rende)

Exemplo adaptado do código enviado do livro.

## ❌ Violação de LSP

```php
class ContaComum
{
    protected float $saldo = 0;

    public function deposita(float $valor): void
    {
        if ($valor <= 0) {
            throw new Exception("Valor inválido");
        }

        $this->saldo += $valor;
    }

    public function rende(): void
    {
        $this->saldo *= 1.1;
    }

    public function saldo(): float
    {
        return $this->saldo;
    }
}

class ContaDeEstudante extends ContaComum
{
    public function rende(): void
    {
        throw new Exception("Conta de estudante não rende");
    }
}
```

Agora imagine um código que usa a conta:

```php
function processa(array $contas)
{
    foreach ($contas as $conta) {
        $conta->rende();
    }
}
```

Se um objeto `ContaDeEstudante` aparecer ali, o sistema quebra.

👉 Isso viola o **LSP**.

A classe filha não respeitou o contrato da classe pai.

---

# 5. Outro exemplo clássico: Quadrado vs Retângulo

Esse é um dos exemplos mais famosos de LSP.

## ❌ Herança problemática

```php
class Retangulo
{
    protected int $largura;
    protected int $altura;

    public function setLargura(int $largura)
    {
        $this->largura = $largura;
    }

    public function setAltura(int $altura)
    {
        $this->altura = $altura;
    }

    public function area(): int
    {
        return $this->largura * $this->altura;
    }
}

class Quadrado extends Retangulo
{
    public function setLargura(int $valor)
    {
        $this->largura = $valor;
        $this->altura = $valor;
    }

    public function setAltura(int $valor)
    {
        $this->altura = $valor;
        $this->largura = $valor;
    }
}
```

O problema:

Um algoritmo que espera um retângulo pode mudar largura e altura separadamente.

Isso quebra a lógica do quadrado.

👉 Logo, **Quadrado não deveria herdar de Retângulo**.

---

# 6. Herança gera acoplamento

Sempre que uma classe herda de outra:

- ela depende da implementação do pai
- mudanças no pai afetam o filho

Isso cria **acoplamento forte**.

Por isso devemos usar herança apenas quando existe realmente a relação:

> **X é um Y**

Exemplo correto:

```
Cachorro é um Animal
```

Exemplo errado:

```
CalculadoraDeImposto é uma Matemática
```

---

# 7. Composição em vez de herança

Quando a relação for:

> **X tem um Y**

ou

> **X usa Y**

Devemos usar composição.

---

## Exemplo usando composição

Em vez de contas herdarem comportamento de saldo, podemos extrair uma classe responsável por isso.

```php
class ManipuladorDeSaldo
{
    private float $saldo = 0;

    public function adicionar(float $valor)
    {
        $this->saldo += $valor;
    }

    public function aplicarJuros(float $taxa)
    {
        $this->saldo *= (1 + $taxa);
    }

    public function saldo(): float
    {
        return $this->saldo;
    }
}
```

Agora as contas **usam** esse comportamento.

```php
class ContaComum
{
    private ManipuladorDeSaldo $saldo;

    public function __construct()
    {
        $this->saldo = new ManipuladorDeSaldo();
    }

    public function deposita(float $valor)
    {
        $this->saldo->adicionar($valor);
    }

    public function rende()
    {
        $this->saldo->aplicarJuros(0.1);
    }
}
```

Conta de estudante:

```php
class ContaDeEstudante
{
    private ManipuladorDeSaldo $saldo;

    public function __construct()
    {
        $this->saldo = new ManipuladorDeSaldo();
    }

    public function deposita(float $valor)
    {
        $this->saldo->adicionar($valor);
    }
}
```

Agora não existe herança problemática.

---

# 8. Herança e testes

Composição facilita testes automatizados.

Podemos substituir dependências facilmente.

Exemplo:

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

Nos testes podemos usar um mock.

Com herança isso é muito mais difícil.

---

# 9. Quando herança faz sentido

Herança é válida quando:

- existe relação conceitual clara
- comportamento base é realmente compartilhado
- subclasses respeitam contratos
- não quebram LSP

Exemplo simples:

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

Classe de teste específica:

```php
class TesteDeCadastro extends TesteComSelenium
{
    public function testaCadastro()
    {
        $this->preencher("nome", "Mauricio");
    }
}
```

Aqui a herança serve apenas para reutilização de infraestrutura.

---

# 10. Organização em pacotes

Outro ponto do capítulo:

> Deixe perto coisas que mudam juntas.

Pacotes (ou namespaces) servem para:

- agrupar classes relacionadas
- reduzir dependências desnecessárias
- facilitar manutenção

---

# Conclusão

Herança não é ruim.

Mas é **perigosa quando usada sem cuidado**.

Regras principais:

- respeite o LSP
- pense em pré e pós‑condições
- use herança apenas para relações "é um"
- prefira composição para flexibilidade

Regra prática:

> **Não descarte herança. Apenas favoreça composição.**

