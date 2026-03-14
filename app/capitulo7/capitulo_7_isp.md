# 📘 Capítulo VII — Interfaces Magras e o Princípio da Segregação de Interfaces (ISP)

Neste capítulo o foco sai das classes e vai para algo igualmente importante em sistemas OO: **interfaces**.

A ideia central é simples:

> Interfaces também precisam ser **coesas**.

Assim como classes podem ficar grandes e confusas, interfaces também podem se tornar **"gordas" (fat interfaces)**.

Quando isso acontece, surgem diversos problemas de acoplamento e manutenção.

---

# 1. O que é uma "Fat Interface"

Uma **fat interface** é uma interface que possui muitos métodos, normalmente relacionados a responsabilidades diferentes.

Exemplo ruim em PHP:

```php
interface RepositorioDeUsuarios
{
    public function salvar(Usuario $usuario);

    public function remover(Usuario $usuario);

    public function buscarPorId(int $id);

    public function enviarEmailBoasVindas(Usuario $usuario);

    public function gerarRelatorioDeUsuarios();
}
```

Problemas:

- Mistura **persistência**, **notificação** e **relatórios**
- Clientes dependem de métodos que **não usam**
- Mudanças em uma responsabilidade impactam outras

Isso reduz **coesão**.

---

# 2. Consequências de interfaces gordas

Quando uma interface cresce demais:

- implementações ficam inchadas
- classes são obrigadas a implementar métodos inúteis
- mudanças propagam mais
- testes ficam mais difíceis

Exemplo comum:

```php
class UsuarioRepositorioMySQL implements RepositorioDeUsuarios
{
    public function salvar(Usuario $usuario) {}

    public function remover(Usuario $usuario) {}

    public function buscarPorId(int $id) {}

    public function enviarEmailBoasVindas(Usuario $usuario)
    {
        throw new Exception("Não suportado");
    }

    public function gerarRelatorioDeUsuarios()
    {
        throw new Exception("Não suportado");
    }
}
```

Se você precisa lançar exceção porque não usa um método, **a interface provavelmente está errada**.

---

# 3. O Princípio da Segregação de Interfaces (ISP)

O ISP diz:

> Nenhum cliente deve ser forçado a depender de métodos que ele não usa.

Ou seja:

Interfaces devem ser **pequenas, específicas e coesas**.

---

# 4. Refatorando para interfaces menores

Em vez de uma interface grande, podemos dividir responsabilidades.

```php
interface UsuarioRepositorio
{
    public function salvar(Usuario $usuario);

    public function buscarPorId(int $id);
}
```

```php
interface EnvioDeEmailBoasVindas
{
    public function enviarEmailBoasVindas(Usuario $usuario);
}
```

```php
interface RelatorioDeUsuarios
{
    public function gerarRelatorio();
}
```

Agora cada cliente depende apenas do que precisa.

---

# 5. Benefícios das interfaces magras

Quando aplicamos ISP:

- diminuímos acoplamento
- aumentamos coesão
- facilitamos testes
- reduzimos propagação de mudanças

Isso também melhora muito a **flexibilidade do sistema**.

---

# 6. Exemplo prático em arquitetura

Imagine um caso de uso que apenas cria usuários.

```php
class CriadorDeUsuarios
{
    public function __construct(private UsuarioRepositorio $repositorio) {}

    public function executar(Usuario $usuario)
    {
        $this->repositorio->salvar($usuario);
    }
}
```

Esse caso de uso não precisa saber nada sobre:

- relatórios
- envio de email

Graças ao ISP, ele depende apenas da interface necessária.

---

# 7. ISP e testes automatizados

Interfaces menores facilitam muito testes.

Exemplo:

```php
class FakeUsuarioRepositorio implements UsuarioRepositorio
{
    private array $usuarios = [];

    public function salvar(Usuario $usuario)
    {
        $this->usuarios[] = $usuario;
    }

    public function buscarPorId(int $id)
    {
        return $this->usuarios[$id] ?? null;
    }
}
```

Como a interface é pequena, criar fakes ou mocks fica simples.

---

# 8. ISP e Clean Architecture

Arquiteturas modernas dependem fortemente de **interfaces pequenas**.

Exemplo de caso de uso:

```php
class ProcessadorDePedidos
{
    public function __construct(
        private RepositorioDePedidos $repositorio,
        private CalculadoraDeFrete $frete
    ) {}
}
```

Cada dependência representa **uma única responsabilidade**.

Isso reduz acoplamento entre módulos.

---

# 9. Separando infraestrutura

Outro ponto importante do capítulo:

> Lembre-se de separar infraestrutura do resto.

Interfaces ajudam muito nisso.

Exemplo:

```
Dominio
 └── UsuarioRepositorio (interface)

Infraestrutura
 └── UsuarioRepositorioMySQL
```

O domínio depende apenas da **abstração**, não do banco de dados.

---

# 10. Relação com outros princípios

O ISP se conecta diretamente com princípios vistos antes:

- **SRP** → interfaces têm uma responsabilidade
- **DIP** → dependemos de abstrações
- **OCP** → novas implementações podem surgir

Todos trabalham juntos.

---

# 11. Regra prática

Quando criar uma interface, pergunte:

1. Quem são os clientes dessa interface?
2. Todos eles usam todos os métodos?
3. Existe mais de uma responsabilidade aqui?

Se a resposta for sim para a última pergunta:

👉 divida a interface.

---

# Conclusão

Interfaces são fundamentais para construir sistemas flexíveis.

Mas elas também precisam seguir os mesmos princípios de design que aplicamos às classes:

- coesão
- baixo acoplamento
- simplicidade
- encapsulamento

A ideia central do ISP pode ser resumida assim:

> **Interfaces pequenas, específicas e coesas produzem sistemas mais estáveis e evolutivos.**

Quanto mais simples a interface, menores os problemas no futuro.

