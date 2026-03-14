# 📘 Capítulo IX — Maus Cheiros de Design (Design Smells)

Este capítulo apresenta um conceito muito importante em engenharia de software: **Design Smells**, ou **maus cheiros de design**.

A ideia vem do livro *Refactoring* de Martin Fowler.

> Um *smell* não significa necessariamente um erro no código,
> mas **um indício de que algo pode estar errado no design**.

Ou seja, são **sinais de alerta** que indicam que o código pode precisar de **refatoração**.

---

# O que são Design Smells

Design smells são padrões de código que geralmente indicam:

* baixo encapsulamento
* baixa coesão
* alto acoplamento
* responsabilidades mal distribuídas

Eles tornam o sistema:

* difícil de manter
* difícil de evoluir
* difícil de testar

Por isso, bons desenvolvedores não estudam apenas boas práticas, mas também **reconhecem maus cheiros no código**.

---

# 1. Refused Bequest

Esse smell acontece quando uma classe **herda comportamentos que ela não quer ou não deveria usar**.

Isso normalmente indica **uso incorreto de herança**.

Exemplo em PHP:

```php
class Ave
{
    public function voar()
    {
        echo "Voando";
    }
}

class Pinguim extends Ave
{
    public function voar()
    {
        throw new Exception("Pinguins não voam");
    }
}
```

Problema:

* `Pinguim` herdou algo que **não faz sentido para ele**.

Isso viola o **LSP (Liskov Substitution Principle)**.

Solução comum:

👉 usar **composição em vez de herança**.

---

# 2. Feature Envy

Esse smell ocorre quando **um método usa mais dados de outra classe do que da própria classe**.

Ou seja:

> o comportamento está no lugar errado.

Exemplo ruim:

```php
class PedidoService
{
    public function calcularDesconto(Pedido $pedido)
    {
        if ($pedido->valorTotal() > 1000) {
            return $pedido->valorTotal() * 0.1;
        }

        return 0;
    }
}
```

Esse método depende totalmente de `Pedido`.

Ele deveria estar **dentro da classe Pedido**.

Melhor solução:

```php
class Pedido
{
    public function calcularDesconto(): float
    {
        if ($this->valorTotal > 1000) {
            return $this->valorTotal * 0.1;
        }

        return 0;
    }
}
```

Regra prática:

> **Comportamentos devem ficar próximos dos dados que eles usam.**

---

# 3. Intimidade Inapropriada

Esse smell acontece quando **duas classes conhecem detalhes demais uma da outra**.

Exemplo ruim:

```php
class Pedido
{
    public Cliente $cliente;
}

class Cliente
{
    public string $nome;
}
```

Outro objeto pode fazer:

```php
$pedido->cliente->nome = "João";
```

Problema:

* violação de encapsulamento
* estrutura interna exposta

Solução:

* encapsular atributos
* expor apenas comportamentos

Exemplo melhor:

```php
class Cliente
{
    private string $nome;

    public function alterarNome(string $nome)
    {
        $this->nome = $nome;
    }
}
```

---

# 4. God Class

Uma **God Class** é uma classe que faz **coisas demais**.

Ela:

* controla muitos objetos
* possui muitas responsabilidades
* cresce continuamente

Exemplo:

```php
class SistemaFinanceiro
{
    public function calcularImposto() {}
    public function gerarRelatorio() {}
    public function enviarEmail() {}
    public function salvarNoBanco() {}
}
```

Problemas:

* baixa coesão
* difícil de testar
* difícil de manter

Solução:

👉 dividir responsabilidades em classes menores.

Isso segue o **SRP (Single Responsibility Principle)**.

---

# 5. Divergent Change

Esse smell ocorre quando **uma classe sofre alterações frequentes por motivos diferentes**.

Exemplo:

```php
class Relatorio
{
    public function gerarPDF() {}
    public function gerarCSV() {}
    public function enviarEmail() {}
}
```

Se mudar:

* formato de exportação
* envio de email
* estrutura de relatório

a mesma classe precisa ser modificada.

Problema:

* baixa coesão

Solução:

separar responsabilidades.

Exemplo:

```
GeradorDeRelatorio
ExportadorPDF
ExportadorCSV
ServicoDeEmail
```

---

# 6. Shotgun Surgery

Esse smell acontece quando **uma mudança simples exige alterar várias classes diferentes**.

Exemplo:

Mudança na regra de imposto exige alterar:

```
Pedido
NotaFiscal
CalculadoraDeImpostos
RelatorioFinanceiro
```

Problema:

* regra espalhada pelo sistema

Esse é o oposto do **encapsulamento**.

Solução:

centralizar comportamento.

---

# Relação com capítulos anteriores

Todos os princípios discutidos no livro ajudam a **evitar esses smells**:

| Princípio      | Evita                        |
| -------------- | ---------------------------- |
| SRP            | God Class / Divergent Change |
| OCP            | Shotgun Surgery              |
| LSP            | Refused Bequest              |
| ISP            | Interfaces gordas            |
| Encapsulamento | Intimidade Inapropriada      |

Ou seja:

> **SOLID é, em grande parte, um conjunto de ferramentas para evitar design smells.**

---

# Conclusão

Design smells são **sinais de alerta no código**.

Eles não significam necessariamente que o sistema está errado, mas indicam que:

* o design pode ser melhorado
* uma refatoração pode ser necessária
* responsabilidades podem estar mal distribuídas

Os principais smells discutidos no capítulo são:

* Refused Bequest
* Feature Envy
* Intimidade Inapropriada
* God Class
* Divergent Change
* Shotgun Surgery

Aprender a **identificar esses sinais no código** é uma habilidade essencial para qualquer desenvolvedor.

> Bons desenvolvedores não estudam apenas boas práticas —
> eles também aprendem a reconhecer **maus cheiros de design**.