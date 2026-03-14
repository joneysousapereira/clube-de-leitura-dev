# 🧭 Guia Visual de Design Smells em PHP

### Exemplos **Antes → Depois (Refatoração)**

Este guia mostra alguns dos **Design Smells mais comuns** em projetos reais e como refatorá-los.

A ideia é simples:

```
Código com smell  →  Refatoração  →  Código mais limpo
```

Isso ajuda a treinar o olhar para identificar problemas de design no dia a dia.

---

# 1. 🧨 God Class

## ❌ Antes (classe fazendo tudo)

```php
class SistemaFinanceiro
{
    public function calcularImposto($valor)
    {
        return $valor * 0.2;
    }

    public function gerarRelatorio()
    {
        echo "Gerando relatório...";
    }

    public function enviarEmail($mensagem)
    {
        echo "Enviando email: $mensagem";
    }

    public function salvarNoBanco($dados)
    {
        echo "Salvando no banco";
    }
}
```

Problemas:

* Muitas responsabilidades
* Difícil de testar
* Difícil de evoluir

---

## ✅ Depois (separação de responsabilidades)

```php
class CalculadoraImposto
{
    public function calcular(float $valor): float
    {
        return $valor * 0.2;
    }
}

class GeradorRelatorio
{
    public function gerar(): void
    {
        echo "Gerando relatório";
    }
}

class EmailService
{
    public function enviar(string $mensagem): void
    {
        echo "Enviando email";
    }
}

class RepositorioFinanceiro
{
    public function salvar(array $dados): void
    {
        echo "Salvando no banco";
    }
}
```

✔ Classes menores
✔ Alta coesão
✔ Mais fácil de testar

---

# 2. 💔 Feature Envy

Quando um método usa **mais dados de outra classe do que da própria classe**.

---

## ❌ Antes

```php
class PedidoService
{
    public function calcularDesconto(Pedido $pedido): float
    {
        if ($pedido->valorTotal() > 1000) {
            return $pedido->valorTotal() * 0.1;
        }

        return 0;
    }
}
```

Problema:

* O comportamento pertence ao **Pedido**, não ao serviço.

---

## ✅ Depois

```php
class Pedido
{
    private float $valorTotal;

    public function calcularDesconto(): float
    {
        if ($this->valorTotal > 1000) {
            return $this->valorTotal * 0.1;
        }

        return 0;
    }
}
```

Regra importante:

> **Comportamentos devem ficar próximos dos dados que usam.**

---

# 3. 🚫 Refused Bequest

Ocorre quando uma classe **herda algo que não deveria usar**.

---

## ❌ Antes

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
        throw new Exception("Pinguim não voa");
    }
}
```

Problema:

* herança incorreta
* quebra do LSP

---

## ✅ Depois (composição)

```php
interface ComportamentoVoo
{
    public function voar();
}

class VooNormal implements ComportamentoVoo
{
    public function voar()
    {
        echo "Voando";
    }
}

class SemVoo implements ComportamentoVoo
{
    public function voar()
    {
        echo "Não pode voar";
    }
}

class Ave
{
    private ComportamentoVoo $comportamento;

    public function __construct(ComportamentoVoo $comportamento)
    {
        $this->comportamento = $comportamento;
    }

    public function voar()
    {
        $this->comportamento->voar();
    }
}
```

✔ composição > herança

---

# 4. 🤝 Intimidade Inapropriada

Quando classes **conhecem detalhes internos umas das outras**.

---

## ❌ Antes

```php
class Cliente
{
    public $nome;
}

class Pedido
{
    public $cliente;
}

$pedido->cliente->nome = "João";
```

Problemas:

* quebra de encapsulamento
* estrutura interna exposta

---

## ✅ Depois

```php
class Cliente
{
    private string $nome;

    public function alterarNome(string $nome)
    {
        $this->nome = $nome;
    }

    public function nome(): string
    {
        return $this->nome;
    }
}
```

✔ acesso controlado
✔ domínio protegido

---

# 5. 🔫 Shotgun Surgery

Mudanças pequenas exigem **alterações em várias classes**.

---

## ❌ Antes

Regra de imposto espalhada:

```php
class Pedido
{
    public function imposto($valor)
    {
        return $valor * 0.2;
    }
}

class NotaFiscal
{
    public function imposto($valor)
    {
        return $valor * 0.2;
    }
}
```

Se a regra mudar → alterar vários lugares.

---

## ✅ Depois

Centralizar regra:

```php
class CalculadoraImposto
{
    public function calcular(float $valor): float
    {
        return $valor * 0.2;
    }
}
```

Agora todos usam:

```php
$calculadora->calcular($valor);
```

✔ mudança em apenas um lugar

---

# 6. 🔀 Divergent Change

Uma classe sofre mudanças **por motivos diferentes**.

---

## ❌ Antes

```php
class Relatorio
{
    public function gerarPDF() {}
    public function gerarCSV() {}
    public function enviarEmail() {}
}
```

Problemas:

* responsabilidades diferentes
* mudanças constantes

---

## ✅ Depois

```php
class GeradorRelatorio
{
    public function gerar() {}
}

class ExportadorPDF
{
    public function exportar() {}
}

class ExportadorCSV
{
    public function exportar() {}
}

class EmailService
{
    public function enviar() {}
}
```

✔ cada classe tem **uma responsabilidade**

---

# 📊 Resumo Visual

| Smell                   | Problema                         | Solução                   |
| ----------------------- | -------------------------------- | ------------------------- |
| God Class               | Classe faz tudo                  | Dividir responsabilidades |
| Feature Envy            | Método usa dados de outra classe | Mover comportamento       |
| Refused Bequest         | Herança incorreta                | Preferir composição       |
| Intimidade Inapropriada | Classes expõem internals         | Encapsular                |
| Shotgun Surgery         | Mudança espalhada                | Centralizar regra         |
| Divergent Change        | Classe muda por vários motivos   | Separar responsabilidades |

---

# 🧠 Regra de Ouro

Se algo parecer:

* **grande demais**
* **espalhado demais**
* **acoplado demais**

provavelmente existe um **design smell**.

Identificar esses sinais cedo evita:

* código frágil
* sistemas difíceis de evoluir
* refatorações caras no futuro.

---

✅ **Bons desenvolvedores aprendem duas coisas:**

1. Boas práticas
2. Como identificar **maus cheiros de design**